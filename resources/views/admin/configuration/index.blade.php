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
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-left-home" aria-controls="navs-left-home" aria-selected="true">Basic</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-left-profile" aria-controls="navs-left-profile" aria-selected="false" tabindex="-1">Api</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-left-messages" aria-controls="navs-left-messages" aria-selected="false" tabindex="-1">Messages</button>
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
                            <button type="submit" class="btn btn-primary" >{{ __('app.edit_btn') }}</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="navs-left-profile" role="tabpanel">
                    <p>
                        Donut dragée jelly pie halvah. Danish gingerbread bonbon cookie wafer candy oat cake ice cream. Gummies
                        halvah
                        tootsie roll muffin biscuit icing dessert gingerbread. Pastry ice cream cheesecake fruitcake.
                    </p>
                    <p class="mb-0">
                        Jelly-o jelly beans icing pastry cake cake lemon drops. Muffin muffin pie tiramisu halvah cotton candy
                        liquorice caramels.
                    </p>
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

        let configForm = document.getElementById("configForm");

        configForm.addEventListener("submit", (e) => {
            e.preventDefault();

            const route = '{{ route('configurations.update')}}';
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            let conf1 = document.getElementById('conf1').value
            let conf2 = document.getElementById('conf2').checked
            let conf3 = document.getElementById('conf3').checked

            let body = {
                configuration1 : Number(conf1),
                configuration2 : conf2,
                configuration3 : conf3,
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
        });

    </script>
@endpush
