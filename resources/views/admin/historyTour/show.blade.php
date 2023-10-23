@extends('admin.template')

@php
    $title = __('app.tours_history');
    $breadcrumbs = [__('app.home')=> route('admin.home'), __('app.tours_history') => route('tour-history.index'), __('app.crud_show') => false];

    $guideIds = [];
    foreach ($account as $item) {
        if (array_key_exists('guide_id', $item)) {
            $guideIds[] = $item['guide_id'];
        }
    };

    $guideSelected = [];
    foreach ($tourGuides as $tourGuide){
        $guideSelected[] = [
            'id' => $tourGuide->guides,
            'name' => $tourGuide->getGuides->name,
            'lastName' => $tourGuide->getGuides->lastname,
        ];
    }

@endphp

@section('content')
    <style>

        .flatpickr-input {
            background-color: #eceef1 !important;
        }

        #table_wrapper {
            padding: 0px;
        }

        #table {
            width: inherit !important;
        }

        .disabled-link {
            pointer-events: none;
            color: darkgrey;
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
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true">Tour
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-profile" aria-controls="navs-top-profile" aria-selected="false">
                        Guias del Tour
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-top-messages" aria-controls="navs-top-messages" aria-selected="false">
                        Clientes del Tour
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-info"
                            aria-controls="navs-info" aria-selected="false">{{ __('app.invoice') }}</button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active show" id="navs-top-home" role="tabpanel">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="tourName">{{ __('app.name') }}</label>
                                <input type="text" id="tourName" value="{{ $tour->title }}" class="form-control "
                                       disabled>
                            </div>
                            <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="createBy">{{ __('app.create_by') }}</label>
                                <input type="text" id="createBy" value="{{ $tour->getUser->name }}"
                                       class="form-control " disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="date">{{ __('app.date') }}</label>
                                <input type="text" id="date"
                                       value="{{ Carbon\Carbon::parse($tour->start)->format('d-m-Y') }}"
                                       class="form-control " disabled>
                            </div>
                            <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="schedule">{{ __('app.timetables_singular') }}</label>
                                <input type="text" id="schedule"
                                       value="{{ __('app.from'). Carbon\Carbon::parse($tour->start)->format('g:i A'). __('app.to') . Carbon\Carbon::parse($tour->end)->format('g:i A')  }}"
                                       class="form-control " disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="tourState">{{ __('app.tour_states_singular') }}</label>
                                <input type="text" id="tourState" value="{{ $tour->tourState->name }}"
                                       class="form-control " disabled>
                            </div>
                            <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="tourType">{{ __('app.tour_type_singular') }}</label>
                                <input type="text" id="tourType" value="{{ $tour->tourType->name }}"
                                       class="form-control " disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-12 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="tourState">{{ __('app.tour_states_singular') }}</label>
                                <textarea type="text" id="tourState" class="form-control "
                                          disabled>{{ $tour->info }}</textarea>
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
                                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#insertGuide">
                                    {{ __('app.add_tour') }}
                                </button>
                            </div>
                        </div>
                        <div class="card-datatable  table-responsive mt-4">
                            <table class="datatables-basic table border-top dataTable no-footer dtr-column">
                                <thead>
                                <tr>
                                    <th>{{ __('app.name') }}</th>
                                    <th> {{ __('app.no_present') }} </th>
                                    <th> {{ __('app.present_1') }}</th>
                                    <th> {{ __('app.fee') }} </th>
                                    <th>{{ __('app.crud_action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($totalGuides = 0)
                                @if(count($account) == 0)
                                    <tr class="text-center">
                                        <th colspan="5"> {{ __('app.no_guide') }}</th>
                                    </tr>
                                @else
                                    @php($currencySymbol = $tour->tourType->moneyType->symbol )
                                    @foreach($account as $tc)
                                        <tr>
                                            <th>{{ $tc['guide'] }}</th>
                                            <th> {{ $tc['bookings_not_apply'] }}</th>
                                            <th> {{ $tc['bookings_apply'] }}</th>
                                            @php($payment = $tour->findGuideFee( $tc['bookings_apply']))
                                            @php($totalGuides = $totalGuides + $payment)
                                            <th> {{ $currencySymbol . $payment }} </th>
                                            <th>
                                                @if($tc['guide_id'] == 0)
                                                    <div class="justify-content-between">
                                                        <a class="m-2 disabled-link" href="#"><i
                                                                class="bx bxs-show me-1"></i> {{ __('app.crud_show') }}
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="justify-content-between">
                                                        <a class="m-2"
                                                           href="{{ route('guides.show',$tc['guide_id'] ) }}"><i
                                                                class="bx bxs-show me-1"></i> {{ __('app.crud_show') }}
                                                        </a>
                                                    </div>
                                                @endif
                                            </th>
                                        </tr>
                                    @endforeach
                                    @foreach($tourGuides as $tourGuide)
                                        @if(!in_array($tourGuide->guides, $guideIds))
                                            <tr>
                                                <th>{{ $tourGuide->getGuides->name }}</th>
                                                <th>0</th>
                                                <th>0</th>
                                                <th>$0</th>
                                                <th>
                                                    <div class="justify-content-between">
                                                        <a class="m-2"
                                                           href="{{ route('guides.show',$tc['guide_id'] ) }}"><i
                                                                class="bx bxs-show me-1"></i> {{ __('app.crud_show') }}
                                                        </a>
                                                    </div>
                                                </th>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                                </tbody>
                                @if(!count($account) == 0)
                                    <tfoot>
                                        <tr>
                                            <th colspan="4"></th>
                                            <th><b> {{ __('app.total') }} {{$currencySymbol . $totalGuides  }}  </b></th>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal fade " id="insertGuide" tabindex="-1" aria-labelledby="insertGuide" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="exampleModalLabel">{{ __('app.add_tour_guide_tittle') }}</h3>
                                        <button type="button" class="close" id="guidesClose" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @php($guidesInTour = $tourGuides->pluck('guides')->toArray())
                                        <label for="guides" class="form-label">{{ __('app.guide_singular') }}</label>
                                        <select id="guides"  class="form-select" name="guides">
                                            <option value="0">{{ __('app.select_guide') }}</option>
                                            @foreach($guides as $guide)
                                                @if(!in_array($guide->id, $guidesInTour))
                                                    <option value="{{ $guide->id }}">{{$guide->name}}  {{$guide->lastName}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="text-danger" id="errorDiv">
                                            <div data-field="end"><p id="errorMessage"></p></div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('app.close') }}</button>
                                        <button type="button" class="btn btn-primary" onclick="assignGuide('{{json_encode($tour->id)}}')">{{ __('app.add_tour') }}</button>
                                    </div>
                                </div>
                            </div>
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
                        <div class="card-datatable  table-responsive">
                            <table id="table" class="datatables-basic table border-top dataTable no-footer dtr-column">
                                <thead>
                                <tr>
                                    <th>{{ __('app.name') }}</th>
                                    <th>{{ __('app.email') }}</th>
                                    <th>{{ __('app.quantity2') }}</th>
                                    <th>{{ __('app.quantity_royalties') }}</th>
                                    <th>{{ __('app.present') }}</th>
                                    <th>{{ __('app.guide_singular') }}</th>
                                    <th>{{ __('app.crud_action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($clients as $client)
                                    <tr class="align-middle">
                                        <th>{{ $client->getClient->name }}</th>
                                        <th>{{ $client->getClient->email }}</th>
                                        <th>{{ $client->bookings }}</th>
                                        <th>{{ $client->royalties }}</th>
                                        <th>
                                            <div class="form-check ">
                                                @if($client->present )
                                                    <span
                                                        class="badge rounded-pill bg-success"> {{__('app.present_1')}} </span>
                                                @else
                                                    <span
                                                        class="badge rounded-pill bg-danger"> {{__('app.no_present')}} </span>
                                                @endif
                                            </div>
                                        </th>
                                        <th>{{ $client->getGuides == null ? __('app.no_guide'): $client->getGuides->name . $client->getGuides->lastName  }}</th>
                                        <th>
                                            <div >
                                                <a class="m-2" href="{{route('clients.show',$client->getClient->id) }}"><i class="bx bxs-show me-1"></i> {{ __('app.crud_show') }}</a> <br>
                                                <a class="m-2" href="javascript:void 0;"
                                                   onclick="modifyClient('{{ json_encode($client->id) }}', {{ json_encode($client->present) }}, '{{ json_encode($client->guides) }}')">
                                                    <i class="bx bx-edit-alt me-1"></i> {{ __('app.crud_edit') }}</a>
                                            </div>
                                        </th>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <button type="button"  id="clientModalBtn"   data-toggle="modal" data-target="#exampleModal" style="display: none">
                                Launch demo modal
                            </button>
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="exampleModalLabel">Modal title</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <input name="clientTour" id="clientTour" hidden>
                                                <div class="col-12 mt-3">
                                                    <div class="form-check form-switch mb-2">
                                                        <input class="form-check-input" type="checkbox" id="present"  >
                                                        <label class="form-check-label" for="present">Presente</label>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <label class="form-check-label" for="guide">{{ __('app.guide') }}</label>
                                                    <select id="guide" name="guide" class="form-select" >
                                                        @foreach($guides as $guide)
                                                            <option value="{{ $guide->id }}" selected>{{$guide->name}}  {{$guide->lastName}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="closeClientTourBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" onclick="updateTourClient()" >{{ __('app.add_tour') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="navs-info" role="tabpanel">
                    <div class="row">
                        <div class="col-12 mt-5">
                            <div class="container-fluid">
                                <div class="float-start">
                                    <h4>Info </h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-datatable  table-responsive">
                            <table class="datatables-basic table border-top dataTable no-footer dtr-column">
                                <thead>
                                <tr>
                                    <th>{{ __('app.id') }}</th>
                                    <th>{{ __('app.date') }}</th>
                                    <th>{{ __('app.type') }}</th>
                                    <th>{{ __('app.state') }}</th>
                                    <th>{{ __('app.quantity2') }}</th>
                                    <th>{{ __('app.total') }}</th>
                                    <th>{{ __('app.crud_action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($invoiceTotalDollars = 0)
                                @php($invoiceTotalColons = 0)
                                @php($invoiceTotalConverted = 0)
                                @foreach($clients as $invoice)
                                    <tr>
                                        <th>{{ $prefix . $invoice->invoice }}</th>
                                        <th>{{  \Carbon\Carbon::make($invoice->getInvoice->date)->format('d-m-y') }}</th>
                                        <th>{{ $invoice->getInvoice->getType->name }}</th>
                                        <th>{{ $invoice->getInvoice->getState->name }}</th>
                                        <th>{{ $invoice->getInvoice->getProductsCount() }}</th>
                                        @php( $invoice->getInvoice->money == 1
                                                ? $invoiceTotalColons = $invoiceTotalColons + $invoice->getInvoice->total
                                                : $invoiceTotalDollars = $invoiceTotalDollars + $invoice->getInvoice->total )

                                        @php($invoice->getInvoice->money == 1
                                                ? $invoiceTotalConverted = $invoiceTotalConverted + ( $invoice->getInvoice->total / $invoice->getInvoice->getExchange->sell )
                                                : $invoiceTotalConverted = $invoiceTotalConverted )

                                        <th>{{ $invoice->getInvoice->getMoney->symbol . $invoice->getInvoice->total }}</th>
                                        <th>
                                            @if( $invoice->getInvoice->trashed() )
                                                <a class="m-2 disabled-link" href="#"><i
                                                        class="bx bxs-show me-1"></i>{{ __('app.crud_show') }}</a>
                                            @else
                                                <a class="m-2" href="{{ route('invoice.show',$invoice->invoice) }}"><i
                                                        class="bx bxs-show me-1"></i>{{ __('app.crud_show') }}</a>
                                            @endif
                                        </th>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                                <div class="row mt-3">
                                    @if($invoiceTotalDollars != 0)
                                        <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                            <label class="form-label" for="tourName">{{ __('app.total') }} {{ $money[1]->name }}</label>
                                            <input type="text" id="tourName" value="${{ $invoiceTotalDollars }}"
                                                   class="form-control " disabled>
                                        </div>
                                    @endif
                                    @if($invoiceTotalColons != 0)
                                            <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                                <label class="form-label" for="tourName">{{ __('app.total') }} {{ $money[0]->name }}</label>
                                                <input type="text" id="tourName" value="₡{{ $invoiceTotalColons }}"
                                                       class="form-control " disabled>
                                            </div>
                                    @endif
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                        <label class="form-label" for="tourName">{{ __('app.total') }}</label>
                                        <input type="text" id="tourName" value="${{ $invoiceTotalDollars + $invoiceTotalConverted }}"
                                               class="form-control " disabled>
                                    </div>
                                    <div class="col-md-4 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                        <label class="form-label" for="tourName">{{ __('app.guides_cost') }}</label>
                                        <input type="text" id="tourName" value="${{ $totalGuides }}" class="form-control "
                                               disabled>
                                    </div>
                                    <div class="col-md-4 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                        <label class="form-label" for="tourName">{{ __('app.profits') }}</label>
                                        <input type="text" id="tourName" value="${{ ( $invoiceTotalDollars + $invoiceTotalConverted  ) -  $totalGuides}}"
                                               class="form-control " disabled>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Tabs -->
            <hr/>
            <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">

                <div class="row mt-4">
                    <div class="col-12">
                        <a href="{{ route('tour-history.index') }}">{{ __('app.go_index')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    <script>
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')


        function updateTourClient(){
            const route = '{{ route('tour-history.update.tour-client',$tour->id) }}';

            let present = document.getElementById('present').checked;
            let clientTour = document.getElementById('clientTour').value;
            let selectGuide = document.getElementById('guide').value;

            let body = {
                tourGuides:Number(clientTour) ,
                present: present,
                guides: Number(selectGuide)
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
            }).then(res => {
                const closeButton = document.getElementById('guidesClose');
                if (res.status === 500) {
                    closeButton.click();
                    sleep(500).then(() => {
                        Swal.fire(
                            '{{ __('app.delete_error') }}',
                            '{{ __('app.error_tour_exist_guide') }}',
                            'error'
                        )
                    });
                } else {
                    closeButton.click();
                    window.location.reload();
                }
            })
            document.getElementById('closeClientTourBtn').click();
        }

        function modifyClient(clientTour,clientStatus,clientGuide ){

            let guidesSelected = @json($guideSelected);
            let select = document.getElementById('guide');

            for (let i = 0; i < select.length; i++) {
                let opt = select[i];

                let foundObject = guidesSelected.find(function(item) {
                    return Number(item.id) === Number(opt.value);
                });

                if (foundObject) {
                    opt.style.display = ''
                    if(Number(opt.value) === Number(clientGuide)){
                        opt.selected = true
                    }
                } else {
                    opt.style.display = 'none'
                }
            }

            let existingDefaultOption = select.querySelector('option[value="0"]');

            if(clientGuide === 'null' && !existingDefaultOption){
                let defaultOption = document.createElement("option");
                defaultOption.value = 0;
                defaultOption.text = '{{__('app.select_guide')}}'
                defaultOption.selected = true
                select.insertBefore(defaultOption, select.firstElementChild);
            }else if (clientGuide !== 'null' && existingDefaultOption){
                existingDefaultOption.remove();
            }

            document.getElementById('present').checked = clientStatus;
            document.getElementById('clientTour').value = clientTour;

            document.getElementById('clientModalBtn').click()
        }

        function assignGuide(tourId){
            const route = '{{ route('tour.guide.create',$tour->id) }}'
            let newGuide = document.getElementById('guides').value

            if(Number(newGuide) !== 0){

                let data = { tour: tourId, guides: newGuide};

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
                }).then(res => {
                    const closeButton = document.getElementById('guidesClose');
                    if (res.status === 406) {
                        closeButton.click();
                        sleep(500).then(() => {
                            Swal.fire(
                                '{{ __('app.delete_error') }}',
                                '{{ __('app.error_tour_exist_guide') }}',
                                'error'
                            )
                        });
                    } else {
                        closeButton.onclick;
                        window.location.reload();
                    }
                })
            }else{
                errorSelectedGuide()
            }
        }

        function errorSelectedGuide(){
            let errorDiv = document.getElementById('errorDiv')
            let errorMessage = document.getElementById('errorMessage')

            errorMessage.innerText = '* {{ __('validation.not_in', ['attribute' => __('app.guide') ] ) }}';
            errorDiv.style.display = 'inline';

            sleep(10000).then(() => {
                errorMessage.innerText = '';
                errorDiv.style.display = 'none';
            });
        }

    </script>
@endpush

