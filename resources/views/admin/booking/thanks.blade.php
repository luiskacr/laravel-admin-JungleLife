@extends('admin.template')

@php
    $title = __('app.tours_book');
    $breadcrumbs = [__('app.home') => route('admin.home'),__('app.tours_book') => route('booking.index'), __('app.thanks')=>false   ];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.thanks') }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="row g-3">
                <div class="col-md-6 ">
                    <label class="form-label" for="name">{{ __('app.name') }}</label>
                    <input  id="name" value="{{ $invoice->getClient->name }}" class="form-control flatpickr-input active" disabled>
                </div>

                <div class="col-md-6 ">
                    <label class="form-label" for="email">{{ __('app.email') }}</label>
                    <input  id="email" value="{{ $invoice->getClient->email }}" class="form-control flatpickr-input active" disabled>
                </div>

                <div class="col-md-6 ">
                    <label class="form-label" for="telephone">{{ __('app.telephone') }}</label>
                    <input  id="telephone" value="{{ $invoice->getClient->telephone }}" class="form-control flatpickr-input active" disabled>
                </div>

                <div class="col-md-6 ">
                    <label class="form-label" for="date">{{ __('app.date') }}</label>
                    <input  id="date" value="{{ \Carbon\Carbon::make($invoice->date)->format('d-m-y') }}" class="form-control flatpickr-input active" disabled>
                </div>

                <div class="col-md-6 ">
                    <label class="form-label" for="state">{{ __('app.invoice_state') }}</label>
                    <input  id="state" value="{{ $invoice->getState->name }}" class="form-control flatpickr-input active" disabled>
                </div>

                <div class="col-md-6 ">
                    <label class="form-label" for="type">{{ __('app.invoice_type') }}</label>
                    <input  id="type" value="{{ $invoice->getType->name }}" class="form-control flatpickr-input active" disabled>
                </div>
            </div>
            <div class="row mt-4">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Producto</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $counter = 1;
                        @endphp
                        @foreach($details as $product)
                            <tr>
                                <th scope="col">{{ $counter }}</th>
                                <th scope="col">{{ $product->getProduct->name }}</th>
                                <th scope="col">{{  $product->getProduct->moneyType->symbol . $product->getProduct->price }}</th>
                                <th scope="col">{{ $product->quantity }}</th>
                                <th scope="col">{{ $product->getProduct->moneyType->symbol . $product->total }}</th>
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
                                    Total: {{ $invoice->getMoney->symbol . $invoice->total}}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>


        </div>
    </div>
@endsection
