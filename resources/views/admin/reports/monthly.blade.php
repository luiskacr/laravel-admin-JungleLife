@extends('admin.template')

@php
    $title = __('app.report');
    $breadcrumbs = [__('app.home') => route('admin.home'),__('app.report') => route('reports.index'), __('app.report_monthly_tittle') => false];
    $months = [
        1 => __('app.january'),
        2=> __('app.february'),
        3 => __('app.march'),
        4 => __('app.april'),
        5 => __('app.may'),
        6 => __('app.june'),
        7 => __('app.july'),
        8 => __('app.august'),
        9 => __('app.september'),
        10 => __('app.october'),
        11 => __('app.november'),
        12 => __('app.december')
    ]
@endphp

@section('content')
    <style>
        .table .thead-light th {
            background-color: var(--main-color);
            color: white !important;
        }

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
                    <h4>{{__('app.report_monthly_tittle')}}</h4>
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
                <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                    <label class="form-label" for="month">{{ __('app.report_monthly_value') }}</label>
                    <select id="month" class="form-select" name="month">
                        <option value="0">{{ __('app.report_monthly_select_value')  }}</option>
                        @foreach($months as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-4" id="card-loader">
                <div class="col-12 mt-3">
                    <div class="table-responsive">
                        <table id="dailyTable" class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('app.tour_type_singular') }}</th>
                                    <th scope="col">{{ __('app.tours_book_plural') }}</th>
                                    <th scope="col">{{ __('app.invoice') }}</th>
                                    <th scope="col">{{ __('app.guides_cost') }}</th>
                                    <th scope="col">{{ __('app.total') }}</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <tr>
                                    <th colspan="6" class="text-center" id="defaultMessage">
                                        {{__('app.report_daily_table_message')}}
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-4 justify-content-center" id="totals">

                </div>
            </div>
        </div>
    </div>
@endsection
@push('page-scripts')
    <script>
        let url = '{{ route('reports.monthly.report')  }}'
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        let initialTableValue = document.getElementById('tableBody').innerHTML;


        const year = document.getElementById('year');
        year.addEventListener('change', ()=> {
            getMostlyReport()
        });

        const month = document.getElementById('month');
        month.addEventListener('change', ()=> {
            getMostlyReport()
        });


        function getMostlyReport(){
            let year = Number(document.getElementById('year').value)
            let month = Number(document.getElementById('month').value)

            if(year !== 0 && month !== 0){
                let loader = showLoader()

                let data ={
                    'year' : year,
                    'month' : month
                }

                fetch(url,{
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": token
                    },
                    credentials: "same-origin",
                    body:JSON.stringify(data)
                }).then(result => result.json().then( data => {
                    if(data.length === 0){
                        initTable()
                        emptyReport()
                    }else{
                        hideDefaultMessage()
                        fillTableValues(data)
                    }
                    hideLoader(loader)
                }));

            }else{
                initTable()
            }
        }

        function hideDefaultMessage(){
            let element = document.getElementById('defaultMessage');
            if (element) {
                element.style.display = 'none';
            }
        }

        function fillTableValues(data){
            let totalBooking =0;
            let totalProfit = 0;
            let totalTotal = 0;
            let totalCost = 0;
            let totalDiv = document.getElementById('totals');

            totalDiv.innerHTML = '';

            const reportTable = document.getElementById('dailyTable');
            const tbody = document.querySelector('#dailyTable tbody');

            data = Object.keys(data)
                .sort((a, b) => parseInt(a) - parseInt(b))
                .reduce((acc, key) => {
                    acc[key] = data[key];
                    return acc;
                }, {});

            tbody.innerHTML = "";


            Object.keys(data).forEach(key =>{
                let newRow = reportTable.querySelector('tbody').insertRow();
                let cell0 = newRow.insertCell(0)
                let cell1 = newRow.insertCell(1)
                let cell2 = newRow.insertCell(2)
                let cell3 = newRow.insertCell(3)
                let cell4 = newRow.insertCell(4)
                let cell5 = newRow.insertCell(5)

                cell0.innerHTML = key
                cell1.innerHTML = data[key]['type'];
                cell2.innerHTML = data[key]['booking'];
                cell3.innerHTML = '$' + data[key]['total'];
                cell4.innerHTML = '$' + data[key]['cost'];
                cell5.innerHTML = '$' + data[key]['profit'];

                totalBooking = totalBooking + Number(data[key]['booking']);
                totalTotal = totalTotal + Number(data[key]['total']);
                totalProfit = totalProfit + Number(data[key]['profit']);
                totalCost = totalCost + Number(data[key]['cost']);
            })

            let booking = '<div class="col-xl-2 col-lg-3 col-sm-4 col-6 mb-4"><div class="card shadow-none bg-transparent border border-success mb-3"><div class="card-body"><span class="fw-medium d-block mb-1">Total de Reservas</span><h4 class="card-title mb-2">$'+ totalBooking +'</h4></div></div></div>'
            let total = '<div class="col-xl-2 col-lg-3 col-sm-4 col-6 mb-4"><div class="card shadow-none bg-transparent border border-success mb-3"><div class="card-body"><span class="fw-medium d-block mb-1">Total de Generado</span><h4 class="card-title mb-2">$'+ totalTotal +'</h4></div></div></div>'
            let cost = '<div class="col-xl-2 col-lg-3 col-sm-4 col-6 mb-4"><div class="card shadow-none bg-transparent border border-success mb-3"><div class="card-body"><span class="fw-medium d-block mb-1">Total de Guias</span><h4 class="card-title mb-2">$'+ totalCost +'</h4></div></div></div>'
            let profit = '<div class="col-xl-2 col-lg-3 col-sm-4 col-6 mb-4"><div class="card shadow-none bg-transparent border border-success mb-3"><div class="card-body"><span class="fw-medium d-block mb-1">Total de Ganancias</span><h4 class="card-title mb-2">$'+ totalProfit +'</h4></div></div></div>'

            totalDiv.insertAdjacentHTML('beforeend', booking);
            totalDiv.insertAdjacentHTML('beforeend', total);
            totalDiv.insertAdjacentHTML('beforeend', cost);
            totalDiv.insertAdjacentHTML('beforeend', profit);

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

        function emptyReport(){
            document.getElementById('defaultMessage').innerText = '{{ __('app.report_daily_empty_message') }}'
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

        /**
         * Return a Table on his initial message
         *
         */
        function initTable(){
            document.getElementById('tableBody').innerHTML = initialTableValue;
            document.getElementById('totals').innerHTML = '';
        }

    </script>
@endpush
