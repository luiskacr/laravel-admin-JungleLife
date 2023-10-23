@extends('admin.template')

@php
    $title = __('app.report');
    $breadcrumbs = [__('app.home') => route('admin.home'),__('app.report') => route('reports.index'), __('app.report_guides_tittle') => false];
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

        .border-success {
            border-color: #3b574b !important;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{__('app.report_guides_tittle')}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="row mt-3" >
                <div class="col-md-6 mt-3">
                    <label class="form-label" for="start">{{ __('app.start_data') }}</label>
                    <input type="date" id="start" value="" class="form-control flatpickr-input active" placeholder="{{ __('app.reports_date_placeHolder') }}" data-date-format="mm/dd/yyyy" name="star">
                </div>
                <div class="col-md-6 mt-3">
                    <label class="form-label" for="end">{{ __('app.end_data') }}</label>
                    <input type="date" id="end" value="" class="form-control flatpickr-input active" placeholder="{{ __('app.reports_date_placeHolder') }}" data-date-format="mm/dd/yyyy" name="end">
                </div>
            </div>

            <div class="row mt-5" id="card-loader">
                <div class="table-responsive">
                    <table id="dailyTable" class="table">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('app.guide_singular') }}</th>
                            <th scope="col">{{ __('app.tour_singular') }}</th>
                            <th scope="col">{{ __('app.report_guides_commission') }}</th>
                        </tr>
                        </thead>
                        <tbody id="tableBody">
                        <tr id="report" >
                            <th  colspan="6" >
                                <div class="text-center" id="defaultMessage">
                                    {{ __('app.report_daily_table_message') }}
                                </div>
                            </th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mt-5"  id="totals">

            </div>
            <div class="row">
                <div class="col-md-3 mt-3  fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                    <div>
                        <button type="button" class="btn btn-primary" id="excelBtn"  onclick="getExcelReport()" disabled>{{ __('app.reports_export_excel') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('page-scripts')
    <script>

        let url = '{{ route('reports.guides.report')  }}'
        let urlDownload = '{{ route('reports.guides.report.excel') }}'
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let initialTableValue = document.getElementById('tableBody').innerHTML;

        $("#start").flatpickr({
            "dateFormat": "d-m-Y",
            "maxDate": "today",
            "locale": "es"
        });

        $("#end").flatpickr({
            "dateFormat": "d-m-Y",
            "maxDate": "today",
            "locale": "es"
        });

        const startDate = document.getElementById('start');
        startDate.addEventListener('change', ()=> {
            getGuidesReport()
        });

        const endDate = document.getElementById('end');
        endDate.addEventListener('change', ()=> {
            getGuidesReport()
        });

        function getGuidesReport(){
            let start = document.getElementById('start').value
            let end = document.getElementById('end').value

            if(start !== '' && end !== ''){
                const startDateParts = start.split('-');
                const endDateParts = end.split('-');
                const startDate = new Date(`${startDateParts[2]}-${startDateParts[1]}-${startDateParts[0]}`);
                const endDate = new Date(`${endDateParts[2]}-${endDateParts[1]}-${endDateParts[0]}`);

                if(endDate <= startDate){
                    Swal.fire({
                        title: '{{ __('app.delete_error') }}',
                        text: '{{ __('app.date_error_gt') }}',
                        icon: 'error',
                    })
                }else{
                    let spinner  = showLoader()
                    let data ={
                        'start' : start,
                        'end' : end
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
                            //ocultar todo
                            hideLoader(spinner)
                            disableExcelBtn()
                            initTable()
                            clearTotalDiv()
                            setEmptyResponseMessage()
                        }else{
                            initTable()
                            clearTotalDiv()
                            fillTableValues(data)
                            hideLoader(spinner)
                            activateExcelBtn()
                        }
                    }));
                }
            }else{
                disableExcelBtn()
                initTable()
                clearTotalDiv()
                setEmptyResponseMessage()
            }
        }

        function getExcelReport(){

            let start = document.getElementById('start').value
            let end = document.getElementById('end').value

            let data ={
                'start' : start,
                'end' : end
            }

            fetch(urlDownload,{
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token
                },
                credentials: "same-origin",
                body:JSON.stringify(data)
            }).then(response => response.blob())
                .then(blob => {
                    let name = '{{ __('app.report_guides_file_tittle') }}.xlsx'
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    a.download = name;
                    document.body.appendChild(a);

                    a.click();
                    URL.revokeObjectURL(url);
                })
                .catch(error =>{
                    Swal.fire(
                        '{{ __('app.delete_error') }}',
                        '{{ __('app.reports_file_error') }}',
                        'error'
                    )
                    @if( app()->hasDebugModeEnabled() )
                    console.log(error)
                    @endif
                });

        }

        /**
         * Fill a Table with a Json response
         *
         * @param data
         */
        function fillTableValues(data){
            let count = 1
            const reportTable = document.getElementById('dailyTable');
            const tbody = document.querySelector('#dailyTable tbody');

            tbody.innerHTML = "";

            Object.keys(data).forEach(key =>{
                let total = 0
                let guide = key;
                let tours = Object.entries(data[key]);

                if(key !== 'Guia no asignado'){
                    tours.forEach(element => {
                            let newRow = reportTable.querySelector('tbody').insertRow();
                            let cell0 = newRow.insertCell(0)
                            let cell1 = newRow.insertCell(1)
                            let cell2 = newRow.insertCell(2)
                            let cell3 = newRow.insertCell(3)

                            cell0.innerHTML = count.toString()
                            cell1.innerHTML = guide;
                            cell2.innerHTML = element[0];
                            cell3.innerHTML = '$' + element[1]['payment']

                            total = total + element[1]['payment'];
                    })
                    count++

                    let newTotal = '<div class="col-xl-2 col-lg-3 col-sm-4 col-6 mb-4"><div class="card shadow-none bg-transparent border border-success mb-3"><div class="card-body"><span class="fw-medium d-block mb-1">'+ key +'</span><h4 class="card-title mb-2">$'+ total+'</h4></div></div></div>'

                    let totalDiv = document.getElementById('totals');
                    totalDiv.insertAdjacentHTML('beforeend', newTotal);
                }

            })
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
         * Clear a Total div
         *
         */
        function clearTotalDiv(){
            document.getElementById('totals').innerHTML = ';'
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
         * Disable a Excel Button
         *
         */
        function disableExcelBtn(){
            document.getElementById('excelBtn').disabled = true
        }

        /**
         * Activate a Excel Button
         *
         */
        function activateExcelBtn(){
            document.getElementById('excelBtn').disabled = false
        }

        /**
         * Show a Message from Empty Response
         *
         */
        function setEmptyResponseMessage(){
            let messageDiv = document.getElementById('defaultMessage');
            messageDiv.innerHTML = '';
            messageDiv.innerHTML = "{{ __('app.report_daily_empty_message') }}";
        }

        /**
         * Return a Table on his initial message
         *
         */
        function initTable(){
            document.getElementById('tableBody').innerHTML = initialTableValue;
        }


    </script>
@endpush
