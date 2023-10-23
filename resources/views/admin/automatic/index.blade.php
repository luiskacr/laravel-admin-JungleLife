@extends('admin.template')

@php
    $title = __('app.automatic_tour_tittle');
    $breadcrumbs = [ __('app.home')=> route('admin.home'),__('app.automatic_tour_tittle') =>false];
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

        </div>
        <div class="card-body" id="card-loader">
            <div class="row mt-2">
                <div class="col-md-6 mt-3">
                    <label class="form-label" for="start">{{ __('app.start_data') }}</label>
                    <input type="date" id="start" value="" class="form-control flatpickr-input active" onchange="validateActiveBtn()" placeholder="{{ __('app.reports_date_placeHolder') }}" data-date-format="mm/dd/yyyy" name="star">
                </div>
                <div class="col-md-6 mt-3">
                    <label class="form-label" for="end">{{ __('app.end_data') }}</label>
                    <input type="date" id="end" value="" class="form-control flatpickr-input active" onchange="validateActiveBtn()" placeholder="{{ __('app.reports_date_placeHolder') }}" data-date-format="mm/dd/yyyy" name="end">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label class="form-label" for="tourType">{{ __('app.tour_type_singular') }}</label>
                    <select id="tourType"  class="form-select" name="tourType" onchange="validateActiveBtn()">
                        <option value="0">{{ __('app.select_tour_type') }}</option>
                        @foreach($tourTypes as $tourType)
                            <option value="{{ $tourType->id }}">{{ $tourType->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 mt-3">
                    <div class="table-responsive">
                        <table id="dailyTable" class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th>{{ __('app.star') }}</th>
                                    <th>{{ __('app.end') }}</th>
                                    <th>{{ __('app.auto') }}</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <tr>
                                    <th colspan="5" class="text-center" id="defaultMessage">
                                        {{__('app.report_daily_table_message')}}
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <button id="createbtn" type="submit" class="btn btn-primary" onclick="sendAutomatic()" disabled >{{ __('app.create') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    <script>

        let url = '{{ route('automatic.timetable')  }}'
        let url2 = '{{ route('automatic.create')  }}'
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let initialTableValue = document.getElementById('tableBody').innerHTML;

        $("#start").flatpickr({
            "dateFormat": "d-m-Y",
            "minDate": "today",
            "locale": "es"
        });

        $("#end").flatpickr({
            "dateFormat": "d-m-Y",
            "minDate": "today",
            "locale": "es"
        });


        const tourType = document.getElementById('tourType');
        tourType.addEventListener('change', ()=> {
            getTourType()
        });

        function getTourType(){
            const tourType = Number(document.getElementById('tourType').value);
            if(tourType !== 0){

                let data ={
                    'id' : tourType,
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
                    }else{
                        fillTableValues(data)
                    }
                }));
            }else{
                initTable()
            }
        }

        function fillTableValues(data){

            const reportTable = document.getElementById('dailyTable');
            const tbody = document.querySelector('#dailyTable tbody');

            tbody.innerHTML = "";

            data.forEach(element =>{
                let newRow = reportTable.querySelector('tbody').insertRow();
                let cell0 = newRow.insertCell(0)
                let cell1 = newRow.insertCell(1)
                let cell2 = newRow.insertCell(2)
                let cell3 = newRow.insertCell(3)

                cell0.innerHTML = element['id'];
                cell1.innerHTML = element['start'];
                cell2.innerHTML = element['end'];
                cell3.innerHTML = element['auto'] === true
                    ? '<span class="badge bg-label-success">{{ __('app.status_values2.true') }}</span>'
                    : '<span class="badge bg-label-info">{{ __('app.status_values2.false') }}</span>';
            })
        }

        function validateActiveBtn(){
            const tourType = Number(document.getElementById('tourType').value)
            const start = Number(document.getElementById('start').value)
            const end = Number(document.getElementById('end').value)

            document.getElementById('createbtn').disabled = !(tourType !== 0 && start !== 0 && end !== 0);
        }

        function sendAutomatic(){
            const start = document.getElementById('start').value
            const end = document.getElementById('end').value
            const tourType = Number(document.getElementById('tourType').value);

            if(!validateDate(start, end)){
                let loader = showLoader()
                let data ={
                    tourType : tourType,
                    start : start,
                    end : end,
                }

                fetch(url2,{
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": token
                    },
                    credentials: "same-origin",
                    body:JSON.stringify(data)
                }).then((result) => {
                        hideLoader(loader);
                        if (result.status === 200){
                            return result.json().then((data) => {
                                Swal.fire({
                                    title: '{{ __('app.success_create', ['object'=> 'Tours automaticamente']) }}',
                                    text: data.message,
                                    icon: 'success',
                                })
                            });
                        }else{
                            return result.json().then((data) => {
                                Swal.fire({
                                    title: '{{ __('app.delete_error') }}',
                                    text: data.message,
                                    icon: 'error',
                                })
                            });
                        }
                    }
                );
            }else{
                Swal.fire({
                    title: '{{ __('app.delete_error') }}',
                    text: '{{ __('app.date_error_gt') }}',
                    icon: 'error',
                })
            }
        }

        function validateDate(start, end){
            const startDateParts = start.split('-');
            const endDateParts = end.split('-');
            const startDate = new Date(`${startDateParts[2]}-${startDateParts[1]}-${startDateParts[0]}`);
            const endDate = new Date(`${endDateParts[2]}-${endDateParts[1]}-${endDateParts[0]}`);

            return startDate > endDate
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
         * Return a Table on his initial message
         *
         */
        function initTable(){
            document.getElementById('tableBody').innerHTML = initialTableValue;
        }


    </script>
@endpush
