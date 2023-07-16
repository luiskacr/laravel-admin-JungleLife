@extends('admin.template')

@php
    $title = __('app.requests_for_increases');
    $breadcrumbs = [ __('app.home')=> route('admin.home'),__('app.requests_for_increases') => route('approvals.create'),  __('app.crud_edit') => false];
@endphp


@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.requests_for_increases_singular') }} # {{ $approval->id }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">

                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                            <label class="form-label" for="name">{{__('app.tour')}}</label>
                            <input type="text" id="name" value="{{ $approval->getTour->title }}" class="form-control "  name="name" disabled>
                        </div>

                        <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                            <label class="form-label" for="name"> {{ __('app.approve_booking') }}</label>
                            <input type="text" id="name" value="{{ $spaces['booking'] }}" class="form-control "  name="name" disabled>
                        </div>
                    </div>
                </div>


                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                            <label class="form-label" for="name">{{ __('app.approve_user') }}</label>
                            <input type="text" id="name" value="{{ $approval->getUser->name }}" class="form-control "  name="name" disabled>
                        </div>

                        <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                            <label class="form-label" for="name"> {{ __('app.approve_date') }} </label>
                            <input type="text" id="name" value="{{ \Illuminate\Support\Carbon::parse($approval->created_at)->format('d-m-Y')  }}" class="form-control "  name="name" disabled>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                            <label class="form-label" for="name"> {{ __('app.approve_guide_qty') }} </label>
                            <input type="text" id="name" value="{{ $approval->old }}" class="form-control "  name="name" disabled>
                        </div>

                        <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                            <label class="form-label" for="name"> {{ __('app.approve_new') }} </label>
                            <input type="text" id="name" value="{{  $approval->new  }}" class="form-control "  name="name" disabled>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="row mt-3">
                        <div class="d-grid gap-2 col-lg-6 mx-auto">
                            <button  onclick="sendApproval(true)" class="btn btn-primary btn-lg" type="button">{{ __('app.btn_approved') }}</button>
                            <button  onclick="sendApproval(false)" class="btn btn-primary btn-lg" type="button">{{ __('app.btn_rejected') }}</button>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <a href="{{ route('approvals.index') }}">{{ __('app.go_index')}}</a>
                </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    <script>
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


        /**
         * Send the process approval answer to the backend
         *
         * @param value
         */
        function sendApproval(value){
            let route = '{{ route('approvals.update', $approval->id) }}'
            const  data = {
                state: value
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
                        window.location.href = '{{ route('approvals.index') }}';
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

    </script>
@endpush
