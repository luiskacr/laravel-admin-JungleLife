@extends('admin.template')

@php
    $title = __('app.invoice');
    $breadcrumbs = [ __('app.home')=> route('admin.home'),__('app.invoice') => route('invoice.index'),  __('app.crud_show') => false ];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body ">
            <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">

                <div class="col-md-12 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                    <div class="float-start">
                        <h4> Cliente </h4>
                    </div>
                </div>

                <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                    <label class="form-label" for="name">{{ __('app.name') }}</label>
                    <input type="text" id="name" value="{{ $invoice->getClient->name }}" class="form-control "  name="name" disabled>
                </div>

                <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                    <label class="form-label" for="name">{{ __('app.email') }}</label>
                    <input type="text" id="name" value="{{ $invoice->getClient->email }}" class="form-control "  name="name" disabled>
                </div>

                <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                    <label class="form-label" for="name">{{ __('app.telephone') }}</label>
                    <input type="text" id="name" value="{{ $invoice->getClient->telephone }}" class="form-control "  name="name" disabled>
                </div>

                <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                    <label class="form-label" for="name">{{ __('app.type_client_singular') }}</label>
                    <input type="text" id="name" value="{{ $invoice->getClient->clientTypes->name }}" class="form-control "  name="name" disabled>
                </div>

                <hr class="mt-5">

                <div class="col-md-12 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                    <div class="float-start">
                        <h4> Factura </h4>
                    </div>
                </div>

                <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                    <label class="form-label" for="name">{{ __('app.date') }}</label>
                        <input type="text" id="name" value="{{  \Carbon\Carbon::make($invoice->date)->format('d-m-Y') }}" class="form-control "  name="name" disabled>
                </div>

                <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                    <label class="form-label" for="name">{{ __('app.state') }}</label>
                    <input type="text" id="name" value="{{  $invoice->getState->name }}" class="form-control "  name="name" disabled>
                </div>

                <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                    <label class="form-label" for="name">{{ __('app.exchange') }}</label>
                    <input type="text" id="name" value="{{  $invoice->getExchange->getTextName() }}" class="form-control "  name="name" disabled>
                </div>

                <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                    <label class="form-label" for="name">{{ __('app.money_type') }}</label>
                    <input type="text" id="name" value="{{ $invoice->getMoney->name }}" class="form-control "  name="name" disabled>
                </div>

            </div>
            <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework mt-5">

                <div class="col-md-12 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                    <div class="float-start">
                        <h4> Detalle </h4>
                    </div>
                </div>

                <table  class="datatables-basic table border-top dataTable  no-footer  dtr-column mt-5">
                    <thead>
                        <tr>
                            <th>{{ __('app.id') }}</th>
                            <th>{{ __('app.products_singular') }}</th>
                            <th>{{ __('app.quantity') }}</th>
                            <th>{{ __('app.price') }}</th>
                            <th>{{ __('app.total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $counter = 1;
                        @endphp
                        @foreach( $invoiceDetails as $detail)
                            <tr>
                                <th> {{ $counter  }} </th>
                                <th> {{ $detail->getProduct->name }} </th>
                                <th> {{ $detail->quantity }} </th>
                                <th> {{ $detail->getMoney->symbol . $detail->getProduct->price  }} </th>
                                <th> {{  $detail->getMoney->symbol .  $detail->total }} </th>
                            </tr>
                            @php
                                $counter++;
                            @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4"></th>
                            <th>
                                <h4>
                                    <b>{{ __('app.total') . ' ' . $invoice->getMoney->symbol . $invoice->total }} </b>
                                </h4>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>


        </div>
    </div>
@endsection
