@extends('admin.template')

@php
    $title = __('app.report');
    $breadcrumbs = [__('app.home') => route('admin.home'),__('app.report') => route('reports.index'), __('app.report_yearly_tittle') => false];
@endphp

@section('content')
    <style>
        .loader {
            border: 16px solid #3B574B;
            border-top: 16px solid #4F7363;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 2s linear infinite;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{__('app.report_yearly_tittle')}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body" >
            <div class="row">
                <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                    <label class="form-label" for="year">{{ __('app.report_yearly_value') }}</label>
                    <select id="year" class="form-select" name="year">
                        <option value="0">{{ __('app.report_yearly_select_value')  }}</option>
                        @php($startYear = \Carbon\Carbon::parse('01-01-2023')->year)
                        @php($actualYear = \Carbon\Carbon::now()->year)
                        @for($i = $startYear; $i <= ($actualYear + 1) ; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="row mt-5" id="card-loader">
                <canvas id="report"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let url = '{{ route('reports.yearly.report')  }}'
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const report = document.getElementById('report');
        const initialValues = {
            labels: ['{{__('app.january')}}', '{{ __('app.february') }}', '{{ __('app.march') }}', '{{ __('app.april') }}'
                , '{{__('app.may')}}', '{{__('app.june')}}', '{{__('app.july')}}', '{{__('app.august')}}', '{{__('app.september')}}'
                , '{{__('app.october')}}', '{{__('app.november')}}','{{__('app.december')}}' ],
            datasets: [{
                label: '{{ __('app.report_yearly_tittle') }}',
                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                borderWidth: 1
            }]
        }

        const lineReport = new Chart(report, {
            type: 'line',
            data: initialValues,
        });

        const year = document.getElementById('year');
        year.addEventListener('change', ()=> {
            getYearReport()
        });

        function getYearReport(){
            let selectYear = document.getElementById('year').value

            if(Number(selectYear) !== 0){
                let loader = showLoader();
                fetch(url,{
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": token
                    },
                    credentials: "same-origin",
                    body:JSON.stringify({
                        'year' : selectYear
                    })
                }).then(result => result.json().then( data => {
                    hideLoader(loader)
                    lineReport.data.datasets  = [
                        {
                            label: 'Total',
                            data:  Object.values(data).map(item => item.total),
                            fill: false,
                            borderColor: 'rgb(79, 115, 99)',
                            tension: 0.1
                        },
                        {
                            label: 'Costo',
                            data:  Object.values(data).map(item => item.cost),
                            fill: false,
                            borderColor: 'rgb(230,0,0)',
                            tension: 0.1
                        },
                        {
                            label: 'Ganancia',
                            data:  Object.values(data).map(item => item.profit),
                            fill: false,
                            borderColor: 'rgb(0,0,220)',
                            tension: 0.1
                        }
                    ]
                    lineReport.update();
                }));

            }else{
                lineReport.data = initialValues
                lineReport.update();
            }
        }

        /**
         * Show a loader
         *
         * @return {HTMLDivElement}
         */
        function showLoader(){
            let card = document.getElementById('card-loader');

            let loader = document.createElement('div');
            loader.className = 'loader';
            loader.style.borderTopColor = 'green';
            loader.style.borderLeftColor = 'green';

            card.style.position = 'relative';
            card.style.opacity = '0.5';
            card.appendChild(loader);

            loader.style.position = 'absolute';
            loader.style.top = '50%';
            loader.style.left = '50%';
            loader.style.transform = 'translate(-50%, -50%)';
            loader.style.display = 'block';

            return loader;
        }

        /**
         * Hide a Loader
         *
         * @param loader
         */
        function hideLoader(loader){
            let card = document.getElementById('card-loader');
            card.style.opacity = '1';
            card.removeChild(loader);
        }

    </script>
@endpush
