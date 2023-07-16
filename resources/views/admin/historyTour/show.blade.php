@extends('admin.template')

@php
    $title = __('app.tours_history');
    $breadcrumbs = [__('app.home')=> route('admin.home'), __('app.tours_history') =>false];
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
                                    @foreach( $account as $tc)
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
                                    <th>{{ __('app.present') }}</th>
                                    <th>{{ __('app.crud_action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($clients as $client)
                                    <tr>
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
                                            <div class="justify-content-between">
                                                <a class="m-2"
                                                   href="{{ route('clients.show',$client->getClient->id) }}"><i
                                                        class="bx bxs-show me-1"></i> {{ __('app.crud_show') }}</a><br>
                                            </div>
                                        </th>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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
