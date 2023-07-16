@extends('admin.template')

@php
    $title = __('app.config');
    $breadcrumbs = [__('app.home') => route('admin.home'),__('app.config') =>false];
@endphp

@section('content')
    <style>
        .card-body {
            padding: 0 0 !important;
            margin-top: 1.25rem;
        }
    </style>
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{__('app.tittle_config')}}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="nav-align-left mb-4">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-left-home" aria-controls="navs-left-home" aria-selected="true">{{ __('app.config_basic') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-left-profile" aria-controls="navs-left-profile" aria-selected="false" tabindex="-1">{{ __('app.config_email') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-left-messages" aria-controls="navs-left-messages" aria-selected="false" tabindex="-1">{{ __('app.config_api') }}</button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active show" id="navs-left-home" role="tabpanel">
                    <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" id="configForm"  >
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <div class="col-12">
                            <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="conf1">{{ $configurations[0]->name  }}</label>
                                <input type="number" id="conf1" value="{{ $configurations[0]->data['value'] }}" class="form-control "  name="conf1" >
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" name="conf2" type="checkbox" id="conf2" {{ $configurations[1]->data['value'] ? 'checked' : ''}} >
                                <label class="form-label" for="conf2">{{  $configurations[1]->name }}</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" name="conf3" type="checkbox" id="conf3" {{ $configurations[2]->data['value'] ? 'checked' : ''}} >
                                <label class="form-label" for="conf3">{{  $configurations[2]->name }}</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="conf4">{{ $configurations[3]->name  }}</label>
                                <input type="text" id="conf4" value="{{ $configurations[3]->data['value'] }}" class="form-control "  name="conf4" >
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="conf5">{{ $configurations[4]->name  }}</label>
                                <textarea class="form-control" id="conf5" rows="3">{{ $configurations[4]->data['value'] }}</textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" >{{ __('app.edit_btn') }}</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="navs-left-profile" role="tabpanel">
                    <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" id="configFormEmail"  >
                        <meta name="csrf-token" content="{{ csrf_token() }}">

                        <h4>{{ __('app.config_tittle_mail_thanks') }} </h4>

                        <div class="col-12">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" name="conf6" type="checkbox" id="conf6" {{ $configurations[5]->data['value'] ? 'checked' : ''}} >
                                <label class="form-label" for="conf6">{{  $configurations[5]->name }} </label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="col-md-12 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid" id="paymentTypes">
                                <label class="form-label" for="conf7">{{ $configurations[6]->name  }}</label>
                                <br>
                                @php($value = 1)
                                @php( $data = $configurations[6]->data['value'] )
                                @foreach($paymentTypes as $paymentType)
                                    <div class="form-check form-check-inline mt-3">
                                        <input class="form-check-input" type="checkbox" id="{{$value}}" {{ $data[$value] ? 'checked' : '' }} >
                                        <label class="form-check-label" for="defaultCheck1">{{ $paymentType->name }}</label>
                                    </div>
                                    @php(++$value)
                                @endforeach
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="conf8">{{ $configurations[7]->name  }}</label>
                                <textarea class="form-control" id="conf8" rows="3">{{ $configurations[7]->data['value'] }}</textarea>
                            </div>
                        </div>




                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" >{{ __('app.edit_btn') }}</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="navs-left-messages" role="tabpanel">
                    <p>
                        Oat cake chupa chups dragée donut toffee. Sweet cotton candy jelly beans macaroon gummies cupcake gummi
                        bears
                        cake chocolate.
                    </p>
                    <p class="mb-0">
                        Cake chocolate bar cotton candy apple pie tootsie roll ice cream apple pie brownie cake. Sweet roll icing
                        sesame snaps caramels danish toffee. Brownie biscuit dessert dessert. Pudding jelly jelly-o tart brownie
                        jelly.
                    </p>
                </div>
            </div>
        </div>

@endsection

@push('page-scripts')
    <script>
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Set a basic form new Submit Function
        let configForm = document.getElementById("configForm");
        configForm.addEventListener("submit", (e) => {
            sendConfiguration(e)
        });

        // Set an Email form new Submit Function
        let configFormEmail = document.getElementById("configFormEmail");
        configFormEmail.addEventListener("submit", (e) => {
            sendConfiguration(e)
        });

        /**
         *  Fetch call to send all Config values
         *
         * @param e
         */
        function sendConfiguration(e){
            e.preventDefault();

            const route = '{{ route('configurations.update')}}';

            let conf1 = document.getElementById('conf1').value
            let conf2 = document.getElementById('conf2').checked
            let conf3 = document.getElementById('conf3').checked
            let conf4 = document.getElementById('conf4').value
            let conf5 = document.getElementById('conf5').value
            let conf6 = document.getElementById('conf6').checked
            let conf8 = document.getElementById('conf8').value

            let body = {
                configuration1 : Number(conf1),
                configuration2 : conf2,
                configuration3 : conf3,
                configuration4 : conf4,
                configuration5 : conf5,
                configuration6 : conf6,
                configuration7 : getCheckValues(),
                configuration8 : conf8,
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
                body: JSON.stringify(body)
            }).then(result => {
                if(result.status === 500){
                    Swal.fire(
                        '{{ __('app.error_delete') }}',
                        '{{ __('app.config_error') }}',
                        'error'
                    );
                }else{
                    successToast( '{{ __('app.config_success') }}' )
                }
            }).catch(error => {
                Swal.fire(
                    '{{ __('app.error_delete') }}',
                    '{{ __('app.config_error') }}',
                    'error'
                );
            })
        }

        /**
         * Create an Object for Payment check selection
         *
         * @returns {{}}
        */
        function getCheckValues(){
            const mainComponent = document.querySelector('#paymentTypes');
            const checkboxes = mainComponent.querySelectorAll('.form-check-input');
            const checkBox = {};

            checkboxes.forEach((checkbox) => {
                const id = checkbox.id;
                checkBox[id] = checkbox.checked;
            });

            return checkBox;
        }

    </script>
@endpush
