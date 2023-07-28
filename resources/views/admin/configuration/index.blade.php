@extends('admin.template')

@php
    $title = __('app.config');
    $breadcrumbs = [__('app.home') => route('admin.home'),__('app.config') =>false];
@endphp

@section('content')
    <style>
        #table {
            width: inherit !important;
        }
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
                    <h4>Basica</h4>
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
                    <div class="container-fluid">
                        <div class="float-start">
                            <h4>{{ __('app.tokens') }}</h4>
                        </div>
                        <div class="float-end">
                            <a class="text-white" href="#">
                                <button type="button" id="createToken" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTokenModal" > {{ __('app.create') }}</button>
                            </a>
                        </div>
                    </div>

                    <div class="card-datatable  table-responsive">
                        <table id="table" class="datatables-basic table border-top dataTable no-footer dtr-column">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>User</th>
                                <th>Nombre</th>
                                <th class="text-center">Abilities</th>
                                <th>expires_at</th>
                                <th>Ultimo Uso</th>
                                <th>Creado</th>
                                <th>{{ __('app.crud_action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tokens as $token)
                                <tr>
                                    <th>{{ $token->id }}</th>
                                    <th>{{ $token->tokenable->name }}</th>
                                    <th>{{ $token->name }}</th>
                                    <th class="text-center">
                                        @foreach($token->abilities as $abilitie)
                                            {{ $abilitie }}
                                        @endforeach
                                    </th>
                                    <th>
                                        @if($token->expires_at == null)
                                            {{ __('app.never_expired') }}
                                        @else
                                            {{ \Illuminate\Support\Carbon::parse($token->expires_at )->format('d-m-Y')  }}
                                        @endif
                                    </th>
                                    <th>
                                        @if($token->last_used_at == null)
                                            {{ __('app.never_expired') }}
                                        @else
                                            {{  \Illuminate\Support\Carbon::parse($token->last_used_at )->format('d-m-Y') }}
                                        @endif
                                    </th>
                                    <th>{{  \Illuminate\Support\Carbon::parse($token->created_at )->format('d-m-Y')  }}</th>
                                    <th>
                                        <div class="justify-content-between">
                                            <a class="m-2" href="#" onclick="deleteItem(
                                                {{$token->id}},'{{ $token->name }}', {{ json_encode(csrf_token()) }},{{ json_encode(route('configurations.delete-token',0)) }},
                                                {{ json_encode(__('app.token')) }}
                                            )"><i class="bx bx-trash me-1"></i>{{ __('app.crud_delete') }}</a>
                                        </div>
                                    </th>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <!-- Create Token Modal -->
        <div class="modal fade" id="createTokenModal"  style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="modal-title" >{{ __('app.token_create') }}</h3>
                        <button type="button" class="btn-close" id="guidesClose" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <div class="col-md-12 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                    <label class="form-label" for="name">{{ __('app.name') }}</label>
                                    <input type="text" id="name" value="" class="form-control "  name="name">
                                    <div class="text-danger">
                                        <div id="nameError" data-field="name">* {{ __('validation.required', ['attribute'=> __('app.name') ]) }}</div>
                                    </div>
                                </div>
                                <div class="col-md-12 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid mt-2">
                                    <label class="form-label" for="name">{{ __('app.user') }}</label>
                                    <select id="user"  class="form-select" name="user" >
                                        <option value="0">{{ __('app.select_client_type') }}</option>
                                        @foreach( $users as $user)
                                            @if( auth()->user()->id == $user->id)
                                                <option value="{{ $user->id }}" selected>{{$user->name}}</option>
                                            @else
                                                <option value="{{ $user->id }}">{{$user->name}}</option>
                                            @endif

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="closeCreateToken" type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('app.close') }}</button>
                        <button type="button" class="btn btn-primary"  onclick="createUserToken()">{{ __('app.add_token') }}</button>
                    </div>
                </div>
            </div>
        </div>

@endsection

@push('page-scripts')
            @include('admin.partials.delete')
    <script>
        //Global Token Value
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Hides a Name error message
        document.getElementById('nameError').style.display = 'none'

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
         * @param e this event
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
         * @returns NodeListOf<Element>
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

        /**
         * Fetch call to create a new Token
         *
         * @returns void
         */
        function createUserToken(){

            if(validateTokenForm()){
                const route = '{{ route('configurations.create-token') }}';
                let body = {
                    name :  document.getElementById('name').value,
                    user : Number( document.getElementById('user').value)
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
                    document.getElementById('closeCreateToken').click();
                    if(result.status === 500){
                        Swal.fire(
                            '{{ __('app.error_delete') }}',
                            '{{ __('app.config_error') }}',
                            'error'
                        );
                    }else{
                        result.json().then(messaje =>{
                            Swal.fire({
                                title: '{{ __('app.success') }}',
                                text: '{{ __('app.token_create_message') }}' ,
                                html: '<p class="text-center">{{ __('app.token_create_message') }}</p> <input type="text"  value="'+ messaje.token +'" class="form-control "  name="name" disabled>',
                                icon: 'success',
                                confirmButtonColor: '#3B574B',
                            }).then((result) => {
                                document.getElementById('name').value = '';
                                document.getElementById('user').value = '{{ auth()->user()->id }}';
                                location.reload();
                            })
                        })
                    }
                }).catch(error => {
                    Swal.fire(
                        '{{ __('app.error_delete') }}',
                        '{{ __('app.config_error') }}',
                        'error'
                    );
                })
            }
        }

        /**
         * Validate Create Token Form
         *
         * @returns {boolean}
         */
        function validateTokenForm(){
            let name = document.getElementById('name');
            if(name.value === '' ){
                document.getElementById('nameError').style.display = ''
                return false
            }else{
                document.getElementById('nameError').style.display = 'none'
                return true
            }
        }



    </script>
@endpush
