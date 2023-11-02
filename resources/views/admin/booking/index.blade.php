@extends('admin.template')

@php
    $title = __('app.tours_book');
    $breadcrumbs = [__('app.home') => route('admin.home'),__('app.tours_book') =>false];
@endphp

@push('page-scripts')
@endpush

@section('content')
    <style>
        #table-empty {
            text-align: center;
        }

        .loader {
            border: 16px solid #3B574B;
            border-top: 16px solid #4F7363;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div id="card-loader" class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{__('app.booking')}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="nav-align-top">
                <ul id="menu-tabs" class="nav nav-pills mb-3" role="tablist">
                    <li class="nav-item">
                        <button type="button" id="btn-nav-tour" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-tour" aria-controls="navs-pills-top-home" aria-selected="true">{{ __('app.tour_singular') }}</button>
                    </li>
                    <li class="nav-item">
                        <button type="button" id="btn-nav-customer" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-customer" aria-controls="navs-pills-top-customer" aria-selected="false">{{ __('app.customer_single') }}</button>
                    </li>
                    <li class="nav-item">
                        <button type="button" id="btn-nav-invoice" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-invoice" aria-controls="navs-pills-top-invoice" aria-selected="false">{{ __('app.invoice') }}</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- Tour -->
                    <div class="tab-pane fade show active" id="navs-pills-tour" role="tabpanel">
                        <h5>{{ __('app.tittle_tour') }}</h5>
                        <div class="row">
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

                        <input id="exchange_rates" type="hidden"  data-id="{{ $exchange_rates['id'] }}" data-sell="{{ $exchange_rates['sell'] }}"  data-buy="{{ $exchange_rates['buy']}}"   >

                        <div id="product-list" class="row product-list ">
                            <div class="card-header">
                                <div class="container-fluid">
                                    <div class="float-start">
                                        <h4 id="available"></h4>
                                    </div>
                                    <div class="float-end">
                                        <button id="btn-create-product"  class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#searchProductModal">
                                            {{ __('app.search_product') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-datatable  table-responsive mt-5">
                                <table id="productTable" class="datatables-basic table no-footer dtr-column">
                                    <thead>
                                    <tr>
                                        <th>SKU</th>
                                        <th>{{ __('app.products_singular') }}</th>
                                        <th>{{ __('app.quantity') }}</th>
                                        <th>{{ __('app.money_type') }}</th>
                                        <th>{{ __('app.price') }}</th>
                                        <th>{{ __('app.crud_action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr id="table-empty">
                                        <th colspan="6">
                                            {{ __('app.not_products') }}
                                        </th>
                                    </tr>
                                    <tr id="products">
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="float-end mt-4">
                            <div class="nav-item">
                                <button type="button" id="goClient" onclick="goClient()" class="btn btn-primary" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-customer" aria-controls="navs-pills-top-customer" aria-selected="false">{{ __('app.customer_single') }}</button>
                            </div>
                        </div>
                        <div class="" >
                            <div class="modal fade" id="searchProductModal"  style="display: none;" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="modal-title" >{{ __('app.search_product') }}</h3>
                                            <button type="button" class="btn-close" id="guidesClose" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col mb-3">
                                                    <div class="col-md-12 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                                        <label class="form-label" for="product">{{ __('app.products_singular') }}</label>
                                                        <select id="product"  class="form-select" name="product" >
                                                            <option value="0">{{ __('app.search_product') }}</option>
                                                            @foreach($products as $product)
                                                                <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-type="{{ $product->type }}"  data-tourType="{{ $product->tourType }}"  data-currency="{{ $product->moneyType->symbol }}">{{ $product->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div id="product-error" class="text-danger">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mt-3 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                                        <label class="form-label" for="quantity">{{ __('app.quantity') }}</label>
                                                        <input type="number" id="quantity" class="form-control " min="1" name="quantity">
                                                        <div id="quantity-error" class="text-danger">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="closeProductSearch" type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('app.close') }}</button>
                                            <button type="button" onclick="selectProduct()" class="btn btn-primary"  >{{ __('app.add_product') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer -->
                    <div class="tab-pane fade" id="navs-pills-top-customer" role="tabpanel">
                        <div class="mb-3">
                            <h5>{{ __('app.select_client') }}</h5>
                            <div class="float-end ">
                                <button id="btn-create-product"  class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#createClientModal"  >
                                    {{ __('app.create_tittle',['object'=> __('app.customer_single')] ) }}
                                </button>
                            </div>
                            <br/>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <div class="col-md-12 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                    <label class="form-label" for="searchCostumer">{{ __('app.customer_single') }} </label>
                                    <select class="select2  form-select form-select-lg" onchange="isSelectedClient(this)" id='searchCostumer' style="width: 100%" name="costumer"></select>
                                    <div id="searchClientError" class="text-danger">
                                        <div id="typeError" data-field="type">
                                            <div id="searchClientError" data-field="type"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="float-end mt-4">
                            <div class="nav-item">
                                <button type="button" onclick="goInvoice()" id="goInvoice" class="btn btn-primary" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-invoice" aria-controls="navs-pills-top-invoice" aria-selected="false">{{ __('app.invoice') }}</button>
                            </div>
                        </div>
                        <!--Modal -->
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
                                        <button type="button" class="btn btn-primary"  onclick="createNewClient()">{{ __('app.create') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Invoice -->
                    <div class="tab-pane fade" id="navs-pills-top-invoice" role="tabpanel">
                        <div class="">
                            <h5>{{ __('app.end_booking') }}</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-3 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="costumerName">{{ __('app.customer_single') }} </label>
                                <input id="costumerName" class="form-control"  disabled>
                                <input id="costumerId " type="hidden">
                            </div>
                            <div class="col-md-6 mt-3  fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="costumerEmail">{{ __('app.email') }} </label>
                                <input id="costumerEmail" class="form-control"  disabled>
                            </div>
                            <div class="col-md-6 mt-3  fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="invoiceDate">{{ __('app.date') }} </label>
                                <input id="invoiceDate" class="form-control"  disabled>
                                <input id="tourId" class="form-control" value="" type="hidden">
                            </div>
                            <div class="col-md-6 mt-3  fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="tour">{{ __('app.tour_singular') }} </label>
                                <input id="tour" class="form-control"  disabled>
                            </div>
                            <div class="col-md-6 mt-3  fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="payment_type">{{ __('app.payment_type') }}</label>
                                <select id="payment_type"  class="form-select"  >
                                    <option value="0">{{ __('app.select_payment_type') }}</option>
                                    @foreach($paymentTypes as $payment)
                                        <option value="{{ $payment->id }}" >{{ $payment->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mt-3  fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="currency">{{ __('app.payment_type') }}</label>
                                <select id="currency"  class="form-select" onchange="changeCurrency(this)" >
                                    @foreach($moneyTypes as $money)
                                        @if($money->id ==2)
                                            <option value="{{ $money->id }}" data-symbol="{{ $money->symbol }}" selected>{{ $money->name }}</option>
                                        @else
                                            <option value="{{ $money->id }}" data-symbol="{{ $money->symbol }}" >{{ $money->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mt-3  fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="info">{{ __('app.comments') }} </label>
                                <textarea class="form-control" id="info"></textarea>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12 mt-3">
                                <table id="invoice" class="datatables-basic table no-footer dtr-column">
                                    <thead>
                                    <tr>
                                        <th>sku</th>
                                        <th>{{ __('app.products_singular') }}</th>
                                        <th>{{ __('app.quantity') }}</th>
                                        <th>{{ __('app.price') }}</th>
                                        <th>{{ __('app.total') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="invoiceDetail">
                                        </tr>
                                    </tbody>
                                    <tfoot style="text-align:end">
                                        <tr>
                                            <th colspan="4">
                                                {{__('app.total')}}
                                            </th>
                                            <th id="invoiceTotal"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-3 mt-3  fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" value="" id="requiredInvoice">
                                    <label class="form-check-label" for="invoice">
                                        {{ __('app.send_invoice') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 mt-3  fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <div class="form-check mt-3">
                                    <input class="form-check-input"  type="checkbox" value="" id="requiredCredit">
                                    <label class="form-check-label" for="invoice">
                                        {{ __('app.required_credit') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 mt-3  fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                    <div class="form-check mt-3" >
                                        <input class="form-check-input" type="checkbox" value="" id="requiredElectronicInvoice" disabled>
                                        <label class="form-check-label" for="invoice">
                                            {{ __('app.send_electronic_invoice') }}
                                        </label>
                                    </div>
                            </div>
                            <div class="col-md-3 mt-3  fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <div>
                                    <button type="button" class="btn btn-primary"  onclick="finishBooking()">{{ __('app.final_step') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
    <script>
        const userRole = '{{auth()->user()->hasRole('Tour Operador')}}'
        let shoppingCar;
        let selectTour;
        let payment_Option;
        let availableSpaceOnTour = 0;
        let currency = 2;
        let exchangeRate = {
            'id' : {{ $exchange_rates['id'] }} ,
            'buy' : {{ $exchange_rates['buy'] }} ,
            'sell' : {{ $exchange_rates['sell'] }} ,
        }
        let jsonProducts = {!! json_encode($products) !!};
        let user = {!! json_encode(auth()) !!};


        document.getElementById('payment_type').addEventListener('change', ()=>{
            let selection = document.getElementById('payment_type').value
            if(Number(selection) === 4){
                document.getElementById("requiredCredit").checked = true;
                document.getElementById("requiredInvoice").checked = false;
                document.getElementById("payment_type").disabled = true;
            }
        })

        document.getElementById('requiredCredit').addEventListener('change', ()=> {
            let selection = document.getElementById('requiredCredit').checked
            if(selection === true){
                document.getElementById('payment_type').value = 4
                document.getElementById("payment_type").disabled = true;
                document.getElementById("requiredInvoice").disabled = true;
                document.getElementById("requiredInvoice").checked = false;
            }else{
                document.getElementById("payment_type").disabled = false;
                document.getElementById("requiredInvoice").disabled = false;
            }
        })

        $(".select2-tour").select2({
            theme: "bootstrap4",
            placeholder: "{{ __('app.select_tour') }}",
        });

        $("#searchCostumer").select2({
            placeholder: ' {{ __('app.search_client') }} ',
            width: 'resolve',
            language: "es",
            ajax: {
                url: '{{ route('tour.costumer.search', 0) }}',
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

        async function createNewClient(){
            if(newClientValidation()){
                const route = '{{ route('booking.createClient')}}';
                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const data = {
                    name: document.getElementById('customerName').value ,
                    email: document.getElementById('customerEmail').value ,
                    telephone: document.getElementById('customerTelephone').value,
                    clientType: Number(document.getElementById('clientType').options[document.getElementById('clientType').selectedIndex].value)
                }

                const response = await fetch(route,{
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
                    return  result
                })

                if(response.status === 200){
                    const data = await response.json();
                    const newOption = new Option(data.name, data.id, true, true);
                    $("#searchCostumer").append(newOption).trigger('change');
                }else{
                    document.getElementById('createCustomerCloseButton').click();
                    sleep(500).then(() => {
                        Swal.fire(
                            '{{ __('app.delete_error') }}',
                            '{{ __('app.error_delete') }}',
                            'error'
                        )
                    });
                }
                document.getElementById('createCustomerCloseButton').click();
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


        async  function getAvailable(value){
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let route = '{{ route('booking.availableSpace') }}'
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


        async function hasSelectTour(value) {
            if (value !== undefined) {
                filterTourTypes(value)
                availableSpaceOnTour = await getAvailable(value);
                document.getElementById('available').innerHTML = "{{ __('app.available_space') }}" + availableSpaceOnTour;
                document.getElementById('product-list').style.display = "initial";
            } else {
                document.getElementById('product-list').style.display = "none";
            }
        }


        function filterTourTypes(value){
            let tour = selectTour.filter(selectTour => {
                return   selectTour.id === Number(value);
            })

            let selectProduct = document.getElementById('product');
            for (let i = 0; i < selectProduct.options.length; i++) {
                let option = selectProduct.options[i];

                if(option.getAttribute('data-type') === '1'){
                    if(option.getAttribute('data-tourtype') ===  tour[0].type.toString() || option.getAttribute('data-price') === ''){
                        option.style.display = '';
                    }else{
                        option.style.display = 'none';
                    }
                }
            }

        }


        function hasDate(){
            const dateSelector = document.getElementById('date');
            const tourSelect = document.getElementById('tour-date-error')

            dateSelector.addEventListener('change',function (){
                if(dateSelector.value !== '' ){
                    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
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
                                selectTour = data;
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


        function deleteProduct(btn,quantity){
            availableSpaceOnTour = availableSpaceOnTour +quantity;
            document.getElementById('available').innerHTML = "{{ __('app.available_space') }}" + availableSpaceOnTour;
            let row = btn.parentNode.parentNode;
            row.parentNode.removeChild(row);
            const table = document.getElementById("productTable").rows.length;
            if(table === 3){
                document.getElementById('table-empty').style.display = ''
                document.getElementById('products').style.display = 'none'
                document.getElementById('btn-nav-customer').disabled = true;
                document.getElementById('goClient').style.display = 'none'
            }
        }

        function validateSelectProduct(){
            const product = document.getElementById('product').value;
            const quantity = document.getElementById('quantity').value;
            let validation = true

            const error = {
                product:{
                    required:  '* {{ __('validation.required', ['attribute'=> __('app.products_singular') ]) }}',
                },
                quantity:{
                    min: '* {{ __('validation.min.numeric', ['attribute' => __('app.quantity'),'min' => 1 ] ) }}',
                }
            }
            if(product === '0'){
                document.getElementById('product-error').innerHTML = error.product.required;
                document.getElementById('product-error').style.display = 'initial'
                validation = false;
            }
            if(quantity === 0 || quantity === ''){
                document.getElementById('quantity-error').innerHTML = error.quantity.min;
                document.getElementById('quantity-error').style.display = 'initial'
                validation = false;
            }
            if((availableSpaceOnTour - quantity) < 0){
                document.getElementById('quantity-error').innerHTML = '{{ __('app.not_space') }}';
                document.getElementById('quantity-error').style.display = 'initial'
                validation = false;
            }
            return validation;
        }


        function selectProduct(){
            if(validateSelectProduct()){
                const table = document.getElementById("productTable");
                const product = document.getElementById('product');
                const product_id = product.value;
                const product_name = product.options[product.selectedIndex].text;
                const product_price = product.options[product.selectedIndex].dataset.price;
                const product_currency = product.options[product.selectedIndex].dataset.currency;
                const quantity = document.getElementById('quantity').value;
                let jsonProduct = jsonProducts.filter(product => {
                    return Number(product.id) === Number(product_id)
                })

                addRow(product_id,product_name,quantity,product_currency,product_price)

                if(table.rows.length !== 0){
                    document.getElementById('table-empty').style.display = 'none'
                    document.getElementById('products').style.display = ''
                }
                document.getElementById('btn-nav-customer').disabled = false;
                document.getElementById('goClient').style.display = ''

                if(jsonProduct[0].type === 1){
                    availableSpaceOnTour = availableSpaceOnTour - quantity;
                }

                document.getElementById('available').innerHTML = "{{ __('app.available_space') }}" + availableSpaceOnTour;
                document.getElementById('closeProductSearch').click();

                document.getElementById('quantity').value = '';
                document.getElementById('product').value = 0

            }
        }

        function addRow(id,name,quantity,currency,price){
            const table = document.getElementById("productTable");
            let newRow = table.insertRow()
            let cell1 = newRow.insertCell(0);
            let cell2 = newRow.insertCell(1);
            let cell3 = newRow.insertCell(2);
            let cell4 = newRow.insertCell(3);
            let cell5 = newRow.insertCell(4);
            let cell6 = newRow.insertCell(5);

            cell1.innerHTML = id;
            cell2.innerHTML = name;
            cell3.innerHTML = quantity;
            cell4.innerHTML = currency;
            cell5.innerHTML = price === '' ? 0 : price;
            cell6.innerHTML = '<a class="m-2" href="#" onclick="deleteProduct(this,'+quantity+')" ><i class="bx bx-trash me-1"></i>{{ __('app.crud_delete') }}</a>'
        }

        function isSelectedClient(value){
            if(value.value >=1){
                document.getElementById('btn-nav-invoice').disabled = false;
                document.getElementById('goInvoice').style.display = ''
            }else{
                document.getElementById('btn-nav-invoice').disabled = true;
                document.getElementById('goInvoice').style.display = 'none'
            }
        }

        async function getCustomerInfo(id){
            const route = '{{ route('booking.getClient')}}';
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let data = {
                client:id
            }
            return await fetch(route, {
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
                return result.json();
            });

        }

        function fillInvoice(){
            const menu = document.getElementById('menu-tabs')
            menu.addEventListener('shown.bs.tab',async function (event) {
                const activeTab = event.target;
                if (activeTab.id === 'btn-nav-invoice') {
                    //Tour
                    document.getElementById('invoiceDate').value = document.getElementById('date').value
                    document.getElementById('tour').value = document.getElementById('searchTour').options[document.getElementById('searchTour').selectedIndex].text
                    document.getElementById('tourId').value = document.getElementById('searchTour').options[document.getElementById('searchTour').selectedIndex].value
                    //Customer
                    const id = document.getElementById('searchCostumer').options[document.getElementById('searchCostumer').selectedIndex].value;
                    const costumer = await getCustomerInfo(id)
                    document.getElementById('costumerName').value = costumer.name;
                    document.getElementById('costumerEmail').value = costumer.email;
                    document.getElementById('costumerId ').value = costumer.id;
                    //table
                    fillInvoiceDetail()

                    let tour = selectTour.find((t)=> t.id === Number(document.getElementById('searchTour').options[document.getElementById('searchTour').selectedIndex].value))

                    shoppingCar = {
                        costumer : costumer,
                        tour: tour,
                        ...shoppingCar
                    }
                }
            })
        }

        function fillInvoiceDetail(){
            let total = 0;
            const productTable = document.querySelector('#productTable tbody');
            const tbody = document.querySelector('#invoice tbody');
            tbody.innerHTML = "";
            const invoiceTable = document.getElementById('invoice');
            document.getElementById('currency').value = 2;
            let allProducts = [];

            productTable.querySelectorAll('tr').forEach(row => {

                if (row.id === 'table-empty' || row.id === 'products') {
                    //Do Nothing
                }else{

                    const id = row.querySelector('td:first-child').textContent;
                    const product = row.querySelector('td:nth-child(2)').textContent;
                    const quantity = Number(row.querySelector('td:nth-child(3)').textContent);
                    let price;
                    let subtotal;
                    let jsonProduct = jsonProducts.filter(product => {
                        return Number(product.id) === Number(id)
                    })

                    if(jsonProduct[0].money === 2){
                        price = row.querySelector('td:nth-child(5)').textContent;
                        subtotal = parseFloat(quantity) * parseFloat(price);
                        total = total + subtotal
                    }else{
                        price = Number(row.querySelector('td:nth-child(5)').textContent) / exchangeRate.buy
                        price = parseFloat(price.toFixed(2));
                        subtotal = parseFloat(quantity) * parseFloat(price);
                        subtotal = parseFloat(subtotal.toFixed(2));
                        total = total + subtotal
                        total = parseFloat(total.toFixed(2));
                    }

                    let newRow = invoiceTable.querySelector('tbody').insertRow();
                    let cell0 = newRow.insertCell(0)
                    let cell1 = newRow.insertCell(1)
                    let cell2 = newRow.insertCell(2)
                    let cell3 = newRow.insertCell(3)
                    let cell4 = newRow.insertCell(4)

                    cell0.innerHTML = id;
                    cell1.innerHTML = product;
                    cell2.innerHTML = quantity;
                    cell3.innerHTML = '$' + price;
                    cell4.innerHTML = '$' + subtotal;

                    let productInfo = {
                        id : id,
                        name: product,
                        quantity : quantity,
                        price : price,
                    }
                    allProducts.push(productInfo)
                }
            });

            shoppingCar = {
                ...shoppingCar,
                product: allProducts,
            }

            document.getElementById('invoiceTotal').innerHTML ='$'+ total;
        }

        function changeCurrency(select){
            let total = 0;
            const tbody = document.querySelector('#invoice tbody');
            let allProducts = [];
            let symbol = select.value === '2' ? '$': '₡';

            tbody.querySelectorAll('tr').forEach(row => {
                let id = row.querySelector('td:first-child').textContent;
                let quantity = row.querySelector('td:nth-child(3)').textContent;
                let newPrice;
                let subTotal;

                let jsonProduct = jsonProducts.filter(product => {
                    return Number(product.id) === Number(id)
                })

                if(select.value === '2'){
                    if(jsonProduct[0].money ===2){
                        newPrice = Number(jsonProduct[0].price)
                    }else{
                        newPrice = Number(jsonProduct[0].price) / exchangeRate.buy
                        newPrice = parseFloat(newPrice.toFixed(2));
                    }
                    subTotal = quantity * newPrice;
                    total = total + subTotal;
                }else{
                    if(jsonProduct[0].money ===2){
                        newPrice = Number(jsonProduct[0].price) * exchangeRate.sell
                        newPrice = parseFloat(newPrice.toFixed(2));
                    }else{
                        newPrice = Number(jsonProduct[0].price)
                    }
                    subTotal = quantity * newPrice;
                    total = total + subTotal;
                }

                let productInfo = {
                    id : id,
                    name: jsonProduct[0].name,
                    quantity : quantity,
                    price : newPrice,
                }

                allProducts.push(productInfo)
                row.querySelector('td:nth-child(4)').textContent = symbol + newPrice;
                row.querySelector('td:nth-child(5)').textContent = symbol +  subTotal

            });
            shoppingCar['product'] = allProducts
            currency = select.value === '2' ? 2 : 1;
            total = parseFloat(total.toFixed(2));
            document.getElementById('invoiceTotal').innerHTML =  symbol + total;
        }


        function validatePaymentMethod(){
            const selected = document.getElementById('payment_type').value;

            if(Number(selected) === 0){

                    Swal.fire({
                        title: '{{  __('app.delete_error') }}',
                        text: '{{ __('app.select_payment_type_error') }}',
                        icon: 'error',
                    });
                return false
            }else{
                payment_Option = selected

                return true
            }
        }

        function finishBooking(){
            if(validatePaymentMethod()){
                let loader = createLoader();

                const requiredInvoice = document.getElementById('requiredInvoice');
                const requiredElectronicInvoice = document.getElementById('requiredElectronicInvoice');
                const requiredCredit = document.getElementById('requiredCredit');
                const info = document.getElementById('info');
                let today = new Date().toISOString();

                shoppingCar = {
                    invoice :{
                        date:today,
                        invoice : requiredInvoice.checked,
                        electronic_invoice : requiredElectronicInvoice.checked,
                        credit: requiredCredit.checked,
                        currency : currency,
                        paymentType : Number(payment_Option),
                        total : Number(document.getElementById('invoiceTotal').textContent.slice(1)),
                        exchange : exchangeRate,
                        info : info.value ,
                    },
                    ...shoppingCar
                }
                let reservation = sendBooking(shoppingCar,loader);
            }
        }


        async function sendBooking(shoppingCar, loader) {
            const route = '{{ route('booking.tour')}}';
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            return await fetch(route, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token
                },
                credentials: "same-origin",
                body: JSON.stringify(shoppingCar)
            }).then(result => result.json().then( data => {
                let invoice = data.invoice;
                let route = '{{ route('booking.thanks',0) }}'
                const f_route = route.slice(0, -1);

                removeLoader(loader);
                window.location.href = f_route + invoice;
            })).catch(error =>{
                sleep(500).then(() => {
                    removeLoader(loader);
                    Swal.fire(
                        '{{ __('app.delete_error') }}',
                        '{{ __('app.booking_error') }}',
                        'error'
                    )
                });
            });
        }

        function createLoader(cardId) {
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

        function removeLoader(loader) {
            let card = document.getElementById('card-loader');
            card.style.opacity = '1';
            card.removeChild(loader);
        }

        function goClient(){
            document.getElementById('btn-nav-customer').click();
        }

        function goInvoice(){
            document.getElementById('btn-nav-invoice').click();
        }

        function run(){
            document.getElementById('btn-nav-customer').disabled = true;
            document.getElementById('btn-nav-invoice').disabled = true;
            document.getElementById('searchTour').disabled = true;
            document.getElementById('product-list').style.display = "none";
            document.getElementById('products').style.display = 'none'
            document.getElementById('goClient').style.display = 'none'
            document.getElementById('goInvoice').style.display = 'none'
            document.getElementById('product-error').style.display = 'none'
            hasDate()
            fillInvoice()
        }

        run()
    </script>
@endpush
