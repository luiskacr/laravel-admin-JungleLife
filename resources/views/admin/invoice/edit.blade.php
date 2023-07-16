@extends('admin.template')

@php
    $title = __('app.invoice');
    $breadcrumbs = [ __('app.home')=> route('admin.home'),__('app.invoice') => route('invoice.index'),  __('app.crud_edit') => false ];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body ">
            <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('invoice.update', $invoice->id) }}" method="post" >
                @csrf
                @method('PUT')
                <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">

                    <div class="col-md-12 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <div class="float-start">
                            <h4> {{ __('app.customer_single') }} </h4>
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
                            <h4> {{__('app.invoice')}} # {{ $prefix . $invoice->id }}</h4>
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

                    <div class="col-md-6 mt-3  fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="paymentType">{{ __('app.payment_type') }}</label>
                        <select id="paymentType"  name="paymentType" class="form-select"  >

                            @foreach($paymentTypes as $paymentType)
                                @if( $invoice->type == $paymentType->id  )
                                    <option value="{{ $paymentType->id }}" selected >{{ $paymentType->name }}</option>
                                @else
                                    <option value="{{ $paymentType->id }}"> {{ $paymentType->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mt-3  fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="state">{{ __('app.state') }}</label>
                        <select id="state"  name="state" class="form-select"  >
                            @foreach( $invoiceStates as $state)
                                @if( $invoice->state  == $state->id  )
                                    <option value="{{ $state->id }}" selected >{{ $state->name }}</option>
                                @else
                                    <option value="{{ $state->id }}" > {{ $state->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="info">{{ __('app.comments') }}</label>
                        <textarea class="form-control" name="info" id="info">{{ $invoice->info }}</textarea>
                    </div>

                    <div class="col-md-12 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <button type="submit" class="btn btn-primary">{{ __('app.edit_btn') }}</button>
                    </div>

                </div>
                <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework mt-5">

                    <div class="col-md-12 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <div class="float-start">
                            <h4> {{ __('app.detail') }} </h4>
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
                                <th> {{ $detail->getMoney->symbol . $detail->price  }} </th>
                                <th> {{ $detail->getMoney->symbol .  $detail->total }} </th>
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
            </form>



        </div>
    </div>
@endsection
