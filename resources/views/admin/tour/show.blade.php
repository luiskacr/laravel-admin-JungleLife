@extends('admin.template')

@php
    $title = __('app.tours_active');
    $breadcrumbs = [__('app.home')=> route('admin.home'),'Tour'=> route('tours.index'), __('app.crud_show') => false];
@endphp

@section('content')
    <style>
        .flatpickr-input {
            background-color: #eceef1 !important;
        }

        #table_wrapper {
            padding: 0px;
        }
        #table{
            width: inherit !important;
        }
        #tableClients{
            width: inherit !important;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="card">
        <!--
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.show_tittle',['object' =>  __('app.tour_type_singular')]) }}</h4>
                </div>
            </div>
        </div>
        -->
        <div class="card-body ">
            <!-- Tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true">Tour</button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-profile" aria-controls="navs-top-profile" aria-selected="false">Guias del Tour</button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-messages" aria-controls="navs-top-messages" aria-selected="false">Clientes del Tour</button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active show" id="navs-top-home" role="tabpanel">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="tourName">{{ __('app.name') }}</label>
                                <input type="text" id="tourName" value="{{ $tour->title }}" class="form-control "   disabled>
                            </div>

                            <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="createBy">{{ __('app.create_by') }}</label>
                                <input type="text" id="createBy" value="{{ $tour->getUser->name }}" class="form-control "   disabled>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="date">{{ __('app.date') }}</label>
                                <input type="text" id="date" value="{{ Carbon\Carbon::parse($tour->start)->format('d-m-Y') }}" class="form-control "   disabled>
                            </div>

                            <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="schedule">{{ __('app.timetables_singular') }}</label>
                                <input type="text" id="schedule" value="{{ __('app.from'). Carbon\Carbon::parse($tour->start)->format('g:i A'). __('app.to') . Carbon\Carbon::parse($tour->end)->format('g:i A')  }}" class="form-control "   disabled>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="tourState">{{ __('app.tour_states_singular') }}</label>
                                <input type="text" id="tourState" value="{{ $tour->tourState->name }}" class="form-control "  disabled>
                            </div>

                            <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="tourType">{{ __('app.tour_type_singular') }}</label>
                                <input type="text" id="tourType" value="{{ $tour->tourType->name }}" class="form-control "   disabled>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-12 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="tourState">{{ __('app.tour_states_singular') }}</label>
                                <textarea type="text" id="tourState"  class="form-control "   disabled>{{ $tour->info }}</textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
                    <div class="row">
                        <div class="col-12 mt-5">
                            <div class="container-fluid">
                                <div class="float-start">
                                    <h4>{{ __('app.tittle_view_guide') }}</h4>
                                </div>
                            </div>
                            <div class="float-end">
                                <button class="btn btn-primary" type="button"  onclick="selectNewGuideModal()"  {{ $tour->state != 1 ? 'disabled' : '' }}>
                                    {{ __('app.add_tour') }}
                                </button>
                                <button class="btn btn-primary" type="button"  onclick="newGuideModal()" {{ $tour->state != 1 ? 'disabled' : '' }}>
                                    {{ __('app.create') }}
                                </button>
                            </div>
                        </div>

                        <div class="card-datatable  table-responsive mt-4">
                            <table id="tableClients" class="datatables-basic table border-top dataTable no-footer dtr-column">
                                <thead>
                                <tr>
                                    <th>{{ __('app.id') }}</th>
                                    <th>{{ __('app.name') }}</th>
                                    <th>{{ __('app.lastname') }}</th>
                                    <th>{{ __('app.type_guides_singular') }}</th>
                                    <th>{{ __('app.crud_action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tourGuides as $tourGuide )
                                    <tr>
                                        <th>{{ $tourGuide->id }}</th>
                                        <th>{{ $tourGuide->getGuides->name }}</th>
                                        <th>{{ $tourGuide->getGuides->lastName }}</th>
                                        <th>{{ $tourGuide->getGuides->guidesType->name }}</th>
                                        <th>
                                            <div class="justify-content-between">
                                                <a class="m-2" href="{{ route('guides.show',$tourGuide->getGuides->id) }}"><i class="bx bxs-show me-1"></i> {{ __('app.crud_show') }}</a>
                                                <a class="m-2" href="javascript:void('')" onclick="deleteGuide({{ json_encode($tourGuide->id) }},{{ json_encode(route('tour.guide.delete',$tourGuide->id)) }},{{ json_encode($tourGuide->getGuides->name)  }})">
                                                    <i class="bx bx-trash me-1"></i> {{ __('app.crud_delete') }} </a>
                                            </div>
                                        </th>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="navs-top-messages" role="tabpanel">
                    <div class="row">

                        <div class="col-12 mt-5">
                            <div class="container-fluid">
                                <div class="float-start">
                                    <h4>{{ __('app.tittle_view_clients') }}</h4>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-datatable table-responsive pt-0">
                        <table id="table" class="datatables-basic table border-top">
                            <thead>
                            <tr>
                                <th>{{ __('app.name') }}</th>
                                <th>{{ __('app.email') }}</th>
                                <th>{{ __('app.quantity2') }}</th>
                                <th>{{ __('app.quantity_royalties') }}</th>
                                <th>{{ __('app.present') }}</th>
                                <th>{{ __('app.guide') }}</th>
                                <th>{{ __('app.crud_action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($clients as $client)
                                <tr>
                                    <th>{{ $client->getClient->name }}</th>
                                    <th>{{ $client->getClient->email }}</th>
                                    <th>{{ $client->bookings }}</th>
                                    <th>{{ $client->royalties}}</th>
                                    <th>
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" id="present"  {{ $client->present ? 'checked' : ''}} onchange="isPresent( {{ $client->id }} )" >
                                            <label class="form-check-label" for="present">Presente</label>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="">
                                            <select  class="form-select" onchange="selectClientGuide(this, {{ json_encode($client->id) }})">
                                                @if( $client->guides == null)
                                                    <option value="0" selected>{{ __('app.select_guide') }}</option>
                                                @else
                                                    <option value="0">{{ __('app.select_guide') }}</option>
                                                @endif
                                                @foreach($selectedGuides as $guide)
                                                    @if($client->guides == $guide->id)
                                                        <option value="{{ $guide->id }}" selected>{{$guide->name}}  {{$guide->lastName}}</option>
                                                    @else
                                                        <option value="{{ $guide->id }}">{{$guide->name}}  {{$guide->lastName}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="justify-content-between">
                                            <a class="m-2" href="{{ route('clients.show',$client->getClient->id) }}"><i class="bx bxs-show me-1"></i> {{ __('app.crud_show') }}</a><br>
                                            <a class="m-2" href="#" onclick="deleteItem({{ $client->getClient->id}},{{ json_encode($client->getClient->name) }},
                                                {{ json_encode(csrf_token()) }}, {{ json_encode(route('clients.destroy',0)) }} )">
                                                <i class="bx bx-trash me-1"></i> {{ __('app.crud_delete') }}</a>
                                        </div>
                                    </th>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Tabs -->
            <hr/>
            <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">

                <div class="row mt-4">
                    <div class="col-12">
                        <a href="{{ route('tours.index') }}">{{ __('app.go_index')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modals -->
    <div class="Guides-Modals">
        <!-- search -->
        <button type="button" id="newGuides" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#guidesModal" hidden></button>
        <div class="modal fade" id="guidesModal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="modal-title" >{{ __('app.add_tour_guide_tittle') }}</h3>
                        <button type="button" class="btn-close" id="guidesClose" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="guides" class="form-label">{{ __('app.guide_singular') }}</label>
                                <select id="guides"  class="form-select" name="guides">
                                    <option value="0">{{ __('app.select_guide') }}</option>
                                    @foreach($guides as $guide)
                                        <option value="{{ $guide->id }}">{{$guide->name}}  {{$guide->lastName}}</option>
                                    @endforeach
                                </select>
                                <div id="guideError" class="text-danger">
                                    <div data-field="name">* {{ __('app.error_select') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('app.close') }}</button>
                        <button type="button" class="btn btn-primary"  onclick="selectNewGuide({{ json_encode($tour->id) }})">{{ __('app.add_tour') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- create Guides -->
        <button type="button" id="createGuides" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createGuidesModal" hidden></button>
        <div class="modal fade" id="createGuidesModal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="modal-title" >{{ __('app.create_tittle',['object' =>  __('app.guide_singular')])  }}</h3>
                        <button type="button" class="btn-close" id="guidesClose" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="col-md-12 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                    <label class="form-label" for="name">{{ __('app.name') }}</label>
                                    <input type="text" id="name" value="" class="form-control "  name="name">
                                    <div id="formName" class="text-danger">
                                        <div id="nameError" data-field="name"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="col-md-12 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                    <label class="form-label" for="lastName">{{ __('app.lastname') }}</label>
                                    <input type="text" id="lastName" value="" class="form-control "  name="lastName">
                                    <div id="formLastName" class="text-danger">
                                        <div id="lastNameError" data-field="lastName"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="col-md-12 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                    <label class="form-label" for="type">{{ __('app.type_guides_singular') }}</label>
                                    <select id="type"  class="form-select" name="type" >
                                        <option value="0">{{ __('app.select_type_guide') }}</option>
                                        @foreach($typeGuides as $typeGuide)
                                            <option value="{{ $typeGuide->id }}">{{$typeGuide->name}}</option>
                                        @endforeach
                                    </select>
                                    <div id="formType" class="text-danger">
                                        <div id="typeError" data-field="type"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" id="createGuideClose" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('app.close') }}</button>
                        <button type="button" class="btn btn-primary"  onclick="newGuide()">{{ __('app.create') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Client -->
        <button type="button" id="searchClient" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#searchClientModal" hidden></button>
        <div class="modal fade" id="searchClientModal"  style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="modal-title" >{{ __('app.add_tour_client_tittle') }}</h3>
                        <button type="button" class="btn-close" id="guidesClose" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <div class="col-md-12 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                    <label class="form-label" for="searchCostumer"> </label>
                                    <select class="select2 form-select form-select-lg" id='searchCostumer' style="width: 100%" name="costumer">
                                    </select>
                                    <div id="searchClientError" class="text-danger">
                                        <div id="typeError" data-field="type">
                                            <div id="searchClientError" data-field="type"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="serchClientCloseButton" type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('app.close') }}</button>
                        <button type="button" class="btn btn-primary"  onclick="selectNewClient({{ json_encode($tour->id) }})">{{ __('app.add_tour') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Create Client -->
        <button type="button" id="createClient" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createClientModal" hidden></button>
        <div class="modal fade" id="createClientModal"  style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="modal-title" >{{ __('app.create_tittle',['object' =>  __('app.customer_single')]) }}</h3>
                        <button type="button" class="btn-close" id="guidesClose" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label" for="customerName">{{ __('app.name') }}</label>
                                <input type="text" id="customerName" value="" class="form-control "  name="name">
                                <div id="formClientNameError" class="text-danger">
                                    <div id="clientNameError" data-field="name"></div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label" for="customerEmail">{{ __('app.email') }}</label>
                                <input type="text" id="customerEmail" value="" class="form-control "  name="email">
                                <div id="formCustomerEmailError" class="text-danger">
                                    <div id="customerEmailError" data-field="email"></div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label" for="customerTelephone">{{ __('app.telephone') }}</label>
                                <input type="text" id="customerTelephone" value="" class="form-control "  name="telephone">
                                <div id="formCustomerTelephoneError" class="text-danger">
                                    <div id="customerTelephoneError" data-field="name"></div>
                                </div>
                            </div>
                            <div class="col-12 bm-3">
                                <label class="form-label" for="clientType">{{ __('app.type_client_singular') }}</label>
                                <select id="clientType"  class="form-select" name="clientType" >
                                    <option value="0">{{ __('app.select_client_type') }}</option>
                                    @foreach($clientTypes as $clientType)
                                        <option value="{{ $clientType->id }}">{{$clientType->name}}</option>
                                    @endforeach
                                </select>
                                <div id="formCustomerTypeError" class="text-danger">
                                    <div id="customerTypeError" data-field="name"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button  type="button" id="createCustomerCloseButton" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('app.close') }}</button>
                        <button type="button" class="btn btn-primary"  onclick="createNewClient()">{{ __('app.add_tour') }}</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection


@push('page-scripts')
    <script>

        $(document).ready(function (){
            $('#tableClients').dataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "bSort": false,
                responsive: true,

            })
        });

        $("#searchCostumer").select2({
            placeholder: 'Buscar un cliente',
            dropdownParent: $("#searchCostumer").parent(),
            width: 'resolve',
            language: "es",
            ajax: {
                url: '{{ route('tour.costumer.search', $tour->id) }}',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },

        });

        function selectNewGuideModal(){
            document.getElementById('guideError').style.visibility = 'hidden'
            document.getElementById("newGuides").click();
        }

        function newGuideModal(){
            hideErrorForm()
            document.getElementById("createGuides").click();
        }

        function selectNewGuide(tourId){

            const selectOption = document.getElementById("guides");
            const value = selectOption.value;
            const route = '{{ route('tour.guide.create',$tour->id) }}'
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if(value === '0'){
                document.getElementById('guideError').style.visibility = 'visible'
            }else{
                let data = { tour: tourId, guides: value};

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
                }).then(res =>{
                    const closeButton = document.getElementById('guidesClose');
                    if(res.status === 406){
                        closeButton.click();
                        sleep(500).then(() => {
                            Swal.fire(
                                '{{ __('app.delete_error') }}',
                                '{{ __('app.error_tour_exist_guide') }}',
                                'error'
                            )
                        });
                    }else{
                        closeButton.onclick;
                        window.location.reload();
                    }
                }).catch(error =>{
                    closeButton.click();
                    sleep(500).then(() => {
                        Swal.fire(
                            '{{ __('app.delete_error') }}',
                            '{{ __('app.error_delete') }}',
                            'error'
                        )
                    });
                })
            }
        }

        function newGuide(){
            const  route = '{{ route('tour.guide.make',$tour->id) }}';
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if(validateNewGuideForm()){
                let data = {
                    name: document.getElementById('name').value,
                    lastName: document.getElementById('lastName').value,
                    type: Number(document.getElementById('type').value),
                }

                fetch(route,{
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": token
                    },
                    credentials: "same-origin",
                    body: JSON.stringify(data)
                }).then(result =>{
                    const closeButton = document.getElementById('createGuideClose')
                    if(result.status === 200){
                        closeButton.click()
                        window.location.reload();
                        successToast( '{{ __('app.success_create', ['object'=> __('app.guide_singular')] ) }}' )
                    }else{
                        closeButton.click()
                        dangerToast( '{{ __('app.error_create', ['object', __('app.guide_singular')] ) }}' )
                    }
                }).catch(error =>{
                    closeButton.click();
                    sleep(500).then(() => {
                        Swal.fire(
                            '{{ __('app.delete_error') }}',
                            '{{ __('app.error_delete') }}',
                            'error'
                        )
                    });
                })
            }
        }

        function validateNewGuideForm(){
            hideErrorForm()

            let validation = true;

            const errors = {
                name: {
                    required: '* {{ __('validation.required', ['attribute'=> __('app.name') ]) }}',
                    min: '* {{ __('validation.min.numeric', ['attribute' => __('app.name'),'min' => 2 ] ) }}',
                    max: '* {{ __('validation.max.numeric', ['attribute' => __('app.name'),'max' => 75] ) }}',
                },
                lastname: {
                    min: '* {{ __('validation.min.numeric', ['attribute' => __('app.lastname'),'min' => 2 ] ) }}',
                    max: '* {{ __('validation.max.numeric', ['attribute' => __('app.lastname'),'max' => 75] ) }}',
                },
                type: {
                    required: '* {{ __('validation.required', ['attribute'=> __('app.type_guides_singular') ]) }}',
                    not_in: '* {{ __('validation.not_in', ['attribute'=> __('app.type_guides_singular')]) }}'
                }
            }

            const nameField = document.getElementById('name')
            const lastNameField = document.getElementById('lastName')
            const typeField = document.getElementById('type')

            if( nameField.value.length === 0 ){
                document.getElementById('nameError').innerHTML =   errors.name.required;
                document.getElementById('formName').style.visibility = 'visible';

                validation = false;
            }else{

                if( nameField.value.length < 2 ){
                    document.getElementById('nameError').innerHTML =   errors.name.min;
                    document.getElementById('formName').style.visibility = 'visible';

                    validation = false;
                }

                if( nameField.value.length > 75 ){
                    document.getElementById('nameError').innerHTML =   errors.name.max;
                    document.getElementById('formName').style.visibility = 'visible';

                    validation = false;
                }
            }

            if( lastNameField.value.length !== 0 ){

                if( lastNameField.value.length < 2 ){
                    document.getElementById('lastNameError').innerHTML =   errors.lastname.min;
                    document.getElementById('formLastName').style.visibility = 'visible';

                    validation = false;
                }

                if( lastNameField.value.length > 75 ){
                    document.getElementById('lastNameError').innerHTML =   errors.lastname.max;
                    document.getElementById('formLastName').style.visibility = 'visible';

                    validation = false;
                }
            }

            if(typeField.value === '0'){
                document.getElementById('typeError').innerHTML =   errors.type.required;
                document.getElementById('formType').style.visibility = 'visible';

                validation = false;
            }
            return validation;
        }

        function hideErrorForm(){
            document.getElementById('formName').style.visibility = 'hidden'
            document.getElementById('formLastName').style.visibility = 'hidden'
            document.getElementById('formType').style.visibility = 'hidden'
        }

        function deleteGuide(id,route,name){
            const primaryElement = document.querySelector('.btn-primary')
            const primaryColor = getComputedStyle(primaryElement)

            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function errorMessage(){
                Swal.fire(
                    '{{ __('app.delete_error') }}',
                    '{{ __('app.error_delete') }}',
                    'error'
                )
            }

            Swal.fire({
                title: '{{ __('app.delete_title') }}',
                text: '{{ __('app.delete_text' ,['object'=> __('app.guide_singular')]) }}  ' + name,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: primaryColor.backgroundColor,
                cancelButtonColor: '#ff3e1d',
                cancelButtonText: '{{ __('app.delete_cancelButtonText') }}',
                confirmButtonText: '{{ __('app.delete_confirmButtonText') }}'
            }).then((result)=>{
                 if(result.isConfirmed){
                     fetch(route,{
                         method: "DELETE",
                         headers: {
                             "Content-Type": "application/json",
                             "Accept": "application/json, text-plain, */*",
                             "X-Requested-With": "XMLHttpRequest",
                             "X-CSRF-TOKEN": token
                         },
                         credentials: "same-origin",
                     }).then(result =>{
                         if(result.status === 200){
                             Swal.fire({
                                 title: '{{ __('app.delete_success_tittle') }}',
                                 text: '{{ __('app.delete_success') }}',
                                 icon: 'success',
                             }).then((result) => {
                                 location.reload();
                             })
                         }else{
                             errorMessage()
                         }
                     }).catch(error =>{
                         errorMessage()
                     })
                 }
            })
        }

        function showSearchClientModal(id){
            document.getElementById('searchClientError').style.visibility = 'hidden'
            document.getElementById("searchClient").click();
        }

        function selectNewClient(id){
            const selection = $('#searchCostumer :selected').val();
            const closeButton = document.getElementById('serchClientCloseButton');
            const  route = '{{ route('tour.costumer.create',$tour->id) }}';
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let data = {
                tour: id,
                client: Number(selection)
            }
            if(selection === undefined){
                //searchClientError
                document.getElementById('searchClientError').innerHTML =  '* {{ __('app.search_client_error1') }}';
                document.getElementById('searchClientError').style.visibility = 'visible'
            }else{
                fetch(route,{
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": token
                    },
                    credentials: "same-origin",
                    body: JSON.stringify(data)
                }).then(result  =>{
                    if(result.status === 200){
                        closeButton.click();
                        window.location.reload();
                        successToast( '{{ __('app.success_create', ['object'=> __('app.customer_single')] ) }}' )
                    }else if(result.status === 406){
                        closeButton.click();
                        sleep(500).then(() => {
                            Swal.fire(
                                '{{ __('app.delete_error') }}',
                                '{{ __('app.error_tour_exist_client') }}',
                                'error'
                            )
                        });
                    }else{
                        closeButton.click()
                        dangerToast( '{{ __('app.error_create', ['object', __('app.customer_single')] ) }}' )
                    }
                }).catch(error=>{
                    closeButton.click();
                    sleep(500).then(() => {
                        Swal.fire(
                            '{{ __('app.delete_error') }}',
                            '{{ __('app.error_delete') }}',
                            'error'
                        )
                    });
                })
            }

        }

        function showCreateClientModal(){
            hideErrorOnNewClient()
            document.getElementById("createClient").click();
        }

        function createNewClient(){
            if(newClientValidation()){
                const closeButton = document.getElementById('createCustomerCloseButton')

                const route = '{{ route('tour.costumer.make',$tour->id) }}';
                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let data = {
                    name : document.getElementById('customerName').value,
                    email : document.getElementById('customerEmail').value,
                    telephone : document.getElementById('customerTelephone').value,
                    clientType : Number(document.getElementById('clientType').value)
                }

                fetch(route,{
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

                    if(result.status === 200){
                        closeButton.click();
                        window.location.reload();
                        successToast( '{{ __('app.success_create ', ['object'=> __('app.customer_single')] ) }}' )
                    }else{
                        closeButton.click();
                        sleep(500).then(() => {
                            Swal.fire(
                                '{{ __('app.delete_error') }}',
                                '{{ __('app.error_delete') }}',
                                'error'
                            )
                        });
                    }
                }).catch(error => {
                    closeButton.click();
                    sleep(500).then(() => {
                        Swal.fire(
                            '{{ __('app.delete_error') }}',
                            '{{ __('app.error_delete') }}',
                            'error'
                        )
                    });
                })
            }
        }

        function hideErrorOnNewClient(){
            document.getElementById('clientNameError').style.visibility = 'hidden'
            document.getElementById('customerEmailError').style.visibility = 'hidden'
            document.getElementById('customerTelephoneError').style.visibility = 'hidden'
            document.getElementById('customerTypeError').style.visibility = 'hidden'
        }

        function newClientValidation(){
            hideErrorOnNewClient()

            let validation  = true;
            let validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

            const errors = {
                name:{
                    required: '* {{ __('validation.required', ['attribute'=> __('app.name') ]) }}',
                    min: '* {{ __('validation.min.numeric', ['attribute' => __('app.name'),'min' => 2 ] ) }}',
                    max: '* {{ __('validation.max.numeric', ['attribute' => __('app.name'),'max' => 75] ) }}',
                },
                email:{
                    required: '* {{ __('validation.required', ['attribute'=> __('app.email') ]) }}',
                    min: '* {{ __('validation.min.numeric', ['attribute' => __('app.email'),'min' => 2 ] ) }}',
                    max: '* {{ __('validation.max.numeric', ['attribute' => __('app.email'),'max' => 75] ) }}',
                    unique: '* {{ __('validation.unique', ['attribute'=> __('app.email')]) }}',
                    email: '* {{ __('validation.email', ['attribute' => __('app.email') ])}}'
                },
                telephone:{
                    max: '* {{ __('validation.max.numeric', ['attribute' => __('app.telephone'),'max' => 75] ) }}',
                },
                clientType:{
                    required: '* {{ __('validation.required', ['attribute'=> __('app.type_client_singular') ]) }}',
                    not_in: '* {{ __('validation.not_in', ['attribute'=> __('app.type_client_singular')]) }}'
                }
            }

            const nameField = document.getElementById('customerName')
            const emailField = document.getElementById('customerEmail')
            const telephoneField = document.getElementById('customerTelephone')
            const clientTypeField = document.getElementById('clientType')

            if(nameField.value.length === 0){
                document.getElementById('clientNameError').innerHTML = errors.name.required;
                document.getElementById('clientNameError').style.visibility = 'visible'

                validation = false
            }else{
                if(nameField.value.length < 2){
                    document.getElementById('clientNameError').innerHTML = errors.name.min;
                    document.getElementById('clientNameError').style.visibility = 'visible'

                    validation = false
                }
                if(nameField.value.length > 75){
                    document.getElementById('clientNameError').innerHTML = errors.name.max;
                    document.getElementById('clientNameError').style.visibility = 'visible'

                    validation = false
                }
            }

            if(emailField.value.length === 0){
                document.getElementById('customerEmailError').innerHTML = errors.email.required;
                document.getElementById('customerEmailError').style.visibility = 'visible'

                validation = false
            }else{

                if(emailField.value.length < 2){
                    document.getElementById('customerEmailError').innerHTML = errors.email.min;
                    document.getElementById('customerEmailError').style.visibility = 'visible'

                    validation = false
                }
                if(emailField.value.length > 75){
                    document.getElementById('customerEmailError').innerHTML = errors.email.max;
                    document.getElementById('customerEmailError').style.visibility = 'visible'

                    validation = false
                }
                if(emailField.value.match(validRegex)){

                    const url = '{{ route('tour.costumer.email') }}';
                    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const data = {
                        email: emailField.value
                    };
                    fetch(url,{
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json, text-plain, */*",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": token
                        },
                        credentials: "same-origin",
                        body: JSON.stringify(data)
                    }).then(result => result.json().then( data => {
                        if(data.validation){
                            document.getElementById('customerEmailError').innerHTML = errors.email.unique;
                            document.getElementById('customerEmailError').style.visibility = 'visible'
                        }
                    }))

                }else{
                    document.getElementById('customerEmailError').innerHTML = errors.email.email;
                    document.getElementById('customerEmailError').style.visibility = 'visible'

                    validation = false
                }
            }

             if(telephoneField.value.length > 75){
                 document.getElementById('customerTelephoneError').innerHTML = errors.telephone.max;
                 document.getElementById('customerTelephoneError').style.visibility = 'visible'

                 validation = false
             }

            if(clientTypeField.value === '0'){
                document.getElementById('customerTypeError').innerHTML = errors.clientType.required;
                document.getElementById('customerTypeError').style.visibility = 'visible'
            }

            return validation;
        }

        function isPresent(id){
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let route = '{{ route('tour.costumer.present') }}'
            let tour = {{ $tour->id }};
            let isCheck = document.getElementById('present')

            let data = {
                tour: tour,
                tourClients : id,
                value : isCheck.checked
            }

            fetch(route,{
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token
                },
                credentials: "same-origin",
                body: JSON.stringify(data)
            }).then(result => result.json().then( data => {
                Swal.fire(
                    '{{ __('app.success') }}',
                    data.message,
                    'success'
                )
            })).catch(error => {
                sleep(500).then(() => {
                    Swal.fire(
                        '{{ __('app.delete_error') }}',
                        '{{ __('app.error_delete') }}',
                        'error'
                    )
                });
            })
        }

        function selectClientGuide(value, tourClient){
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let route = '{{ route('tour.costumer.guide', $tour->id ) }}'
            let tour = {{ $tour->id }};

            let data = {
                tour: tour,
                tourClients : tourClient,
                value : Number(value.value)
            }

            fetch(route,{
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token
                },
                credentials: "same-origin",
                body: JSON.stringify(data)
            }).then(result => result.json().then( data => {
                Swal.fire(
                    '{{ __('app.success') }}',
                    data.message,
                    'success'
                )
            })).catch(error => {
                sleep(500).then(() => {
                    Swal.fire(
                        '{{ __('app.delete_error') }}',
                        '{{ __('app.error_delete') }}',
                        'error'
                    )
                });
            })
        }


    </script>
@endpush

