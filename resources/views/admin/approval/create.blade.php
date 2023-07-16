@extends('admin.template')

@php
    $title = __('app.increase_request');
    $breadcrumbs = [ __('app.home') => route('admin.home'),__('app.tour_type') => route('approvals.index'), __('app.create') => false];
@endphp

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.create_tittle',['object' =>  __('app.increase_request')]) }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="row">
                    <input id="tour" hidden="true">
                <div class="col-md-6 ">
                    <label class="form-label" for="date">{{ __('app.date') }}</label>
                    <input type="date" id="date" value="{{ old('date') }}" class="form-control flatpickr-input active" placeholder="{{ __('app.select_date') }}" data-date-format="mm/dd/yyyy" name="date">

                    <div id="tour-date-error" class="text-danger">
                        <div data-field="name"></div>
                    </div>
                </div>

                <div class="col-md-6 ">
                    <label class="form-label" for="searchTour">{{ __('app.select_tour') }}</label>
                    <select  onchange="hasSelectTour(this.value)" class="select2-tour form-select form-select-lg" id='searchTour' style="width: 100%"  ></select>
                    <div id="searchClientError" class="text-danger">
                        <div id="typeError" data-field="type">
                            <div id="searchClientError" data-field="type"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6 ">
                    <label class="form-label" for="original">{{ __('app.approve_guide_qty') }}</label>
                    <input type="text" id="original" value="" class="form-control "  name="original" disabled>
                </div>

                <div class="col-md-6 ">
                    <label class="form-label" for="booking">{{ __('app.approve_booking') }}</label>
                    <input type="text" id="booking" value="" class="form-control "  name="booking" disabled>
                </div>

                <div class="col-md-6 mt-3">
                    <label class="form-label" for="available">{{ __('app.approve_space') }}</label>
                    <input type="text" id="available" value="" class="form-control "  name="available" disabled>
                </div>

                <div class="col-md-6 mt-3">
                    <label class="form-label" for="new">{{ __('app.approve_new') }}</label>
                    <input type="number" min="1" id="new" value="" class="form-control "  name="new" >
                </div>

            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <button id="approvalBTN" onclick="sendApproval()" class="btn btn-primary" >{{ __('app.btn_request') }}</button>
                </div>
            </div>


        </div>
    </div>
@endsection

@push('page-scripts')
    <script>
        let selectDate;
        let selectTourId;
        let availableSpaceOnTour;
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        $(".select2-tour").select2({
            theme: "bootstrap4",
            placeholder: "{{ __('app.select_tour') }}",
        });

        function hasDate(){
            const dateSelector = document.getElementById('date');

            dateSelector.addEventListener('change',function (){
                if(dateSelector.value !== '' ){

                    $('.select2-tour').select2({
                        language:{
                            "noResults": function(){
                                return "{{ __('app.no_tour') }} " + dateSelector.value;
                            }
                        },
                        ajax: {
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': token
                            },
                            url: '{{ route('booking.Tour') }}',
                            data: {date: dateSelector.value },
                            dataType: 'json',
                            processResults: function (data) {
                                selectDate = data;
                                return {
                                    results: $.map(data, function (item){
                                        return {
                                            text: item.title,
                                            id : item.id,
                                        }
                                    })
                                };
                            }
                        }
                    });
                    hasSelectTour()
                    document.getElementById('searchTour').disabled = false;

                }else{
                    $('.select2-tour').val(null).trigger('change');
                    document.getElementById('searchTour').disabled = true;
                }
            })
        }

        async function hasSelectTour(value) {
            if (value !== undefined) {
                availableSpaceOnTour =  await getAvailable(value);
                selectTourId = value;
                document.getElementById('tour').value = value;

                document.getElementById('original').value = availableSpaceOnTour.original;
                document.getElementById('booking').value = availableSpaceOnTour.booking;
                document.getElementById('available').value = availableSpaceOnTour.old_total;
                const newValue = document.getElementById('new').value = availableSpaceOnTour.original;


                document.querySelector('#approvalBTN').disabled = false;
            } else {
                hideFields()
            }
        }


        async  function getAvailable(value){
            let route = '{{ route('approvals.tour-values') }}'
            const  data = {
                tour: value
            }
            const response = await fetch(route, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token
                },
                credentials: "same-origin",
                body: JSON.stringify(data)
            }).then(result => {
                return result;
            })
            return await response.json();
        }

        function sendApproval(){
            let route = '{{ route('approvals.store') }}'
            let data = {
                tour: Number(selectTourId),
                new : Number(document.getElementById('new').value)
            }
            fetch(route, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token
                },
                credentials: "same-origin",
                body: JSON.stringify(data)
            }).then(result => result.status === 200 ?

                result.json().then( data => {

                Swal.fire(
                    '{{ __('app.success') }}',
                    data.message,
                    'success'
                ).then(()=>{
                    let callBack = '{{ route('approvals.create') }}';
                    window.location.href = callBack;
                })

            })
            : sleep(500).then(() => {
                    Swal.fire(
                        '{{ __('app.delete_error') }}',
                        '{{ __('app.booking_error') }}',
                        'error'
                    )
                })
            ).catch(error =>{
                sleep(500).then(() => {
                    Swal.fire(
                        '{{ __('app.delete_error') }}',
                        '{{ __('app.booking_error') }}',
                        'error'
                    )
                });
            });
        }


        function hideFields(){
            document.getElementById('searchTour').disabled = true;
            document.querySelector('#approvalBTN').disabled = true;
            document.getElementById('original').value = '';
            document.getElementById('booking').value = '';
            document.getElementById('available').value = '';
            document.getElementById('new').value = '';
        }


        hasDate()
        hideFields()
    </script>
@endpush

