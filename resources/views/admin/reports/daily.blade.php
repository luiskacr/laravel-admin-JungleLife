@extends('admin.template')

@php
    $title = __('app.report');
    $breadcrumbs = [__('app.home') => route('admin.home'),__('app.report') => route('reports.index'), __('app.report_daily_profit_tittle') => false];
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
                    <h4>{{__('app.report_daily_profit_tittle')}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="row">
                <div class="col-md-6 ">
                    <label class="form-label" for="reportDate">{{ __('app.date') }}</label>
                    <input type="date" id="reportDate" value="" class="form-control flatpickr-input active" placeholder="{{ __('app.reports_date_placeHolder') }}" data-date-format="mm/dd/yyyy" name="reportDate">

                </div>
            </div>
            <div class="row mt-5" id="card-loader">
                <div class="table-responsive">
                    <table id="dailyTable" class="table">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('app.tour_singular') }}</th>
                            <th scope="col">{{ __('app.report_daily_col_total') }}</th>
                            <th scope="col">{{ __('app.report_daily_dol_total') }}</th>
                            <th scope="col">{{ __('app.guides_cost') }}</th>
                            <th scope="col">{{ __('app.reports_total') }}</th>
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
                <div class="col-12" >
                    <div class="row mt-3 " id="profit">
                        <div class="container-fluid">
                            <div class="float-end pr-5">
                                <span class="d-block fw-medium">{{ __('app.profits') }}</span>
                                <h2 class="card-title mb-2" id="showTotal"></h2>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

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
        let date;
        let url = '{{ route('reports.daily.values', '')  }}'
        let urlDownload = '{{ route('reports.daily.download.excel', '')  }}'
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let initialTableValue = document.getElementById('tableBody').innerHTML;

        document.getElementById('profit').style.display='none'

        /**
         * Add a listener for a date change and get a report
         *
         * @type {HTMLElement}
         */
        const dateSelector = document.getElementById('reportDate');
        dateSelector.addEventListener('change', ()=> {
            let loader
            if(dateSelector.value !== ''){
                loader = showLoader();
                date = dateSelector.value;

                fetch(url+'/'+date,{
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": token
                    },
                    credentials: "same-origin",
                }).then(result => result.json().then( data => {
                    if(data.length === 0){
                        hideLoader(loader)
                        disableExcelBtn()
                        initTable()
                        hideProfitValue()
                        setEmptyResponseMessage()
                    }else{
                        hideLoader(loader)
                        fillTableValues(data)
                        activateExcelBtn()
                    }
                }));

            }else{
                initTable()
                hideProfitValue()
                disableExcelBtn()
            }

        })

        /**
         * Set a flatpickr Configuration
         *
         */
        $("#reportDate").flatpickr({
            "dateFormat": "d-m-Y",
            "maxDate": "today",
            "locale": "es"
        });

        /**
         * Fill a Table with a Json response
         *
         * @param data
         */
        function fillTableValues(data){
            let count = 1
            let total = 0
            const reportTable = document.getElementById('dailyTable');
            const tbody = document.querySelector('#dailyTable tbody');

            tbody.innerHTML = "";

            data.forEach(element => {
                let newRow = reportTable.querySelector('tbody').insertRow();
                let cell0 = newRow.insertCell(0)
                let cell1 = newRow.insertCell(1)
                let cell2 = newRow.insertCell(2)
                let cell3 = newRow.insertCell(3)
                let cell4 = newRow.insertCell(4)
                let cell5 = newRow.insertCell(5)

                cell0.innerHTML = count.toString()
                cell1.innerHTML = element["{{ __('app.tour_singular') }}"];
                cell2.innerHTML = '₡' + element['{{ __('app.report_daily_col_total') }}'];
                cell3.innerHTML = '$' + element["{{ __('app.report_daily_dol_total') }}"];
                cell4.innerHTML = '$' + element["{{ __('app.guides_cost') }}"];
                cell5.innerHTML = '$' + element["{{ __('app.reports_total') }}"];

                total = total +  element["{{ __('app.reports_total') }}"];

                count++
            });
            showProfitValue('$'+total.toString())
        }

        /**
         * Request a Excel File
         *
         */
        function getExcelReport(){

            fetch(urlDownload+'/'+date,{
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token
                },
                credentials: "same-origin",
            }).then(response => response.blob())
                .then(blob => {
                    let name = '{{ __('app.report_daily_file_tittle') }}'+date+'.xlsx'
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

        /**
         * Show a Profit Value div
         *
         * @param value
         */
        function showProfitValue(value){
            document.getElementById('showTotal').innerHTML = value;
            document.getElementById('profit').style.display= ''
        }

        /**
         * Hide a Profit Value Div
         *
         */
        function hideProfitValue(){
            document.getElementById('showTotal').innerHTML = '';
            document.getElementById('profit').style.display= 'none'
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
