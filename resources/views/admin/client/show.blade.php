@extends('admin.template')

@php
    $title =  __('app.customer');
    $breadcrumbs = [__('app.home')=> route('admin.home'),__('app.customer')=> route('clients.index'), __('app.crud_show') => false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.show_tittle',['object' =>  __('app.customer_single')]) }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">{{ __('app.name') }}</label>
                        <input type="text" id="name" value="{{ $client->name }}" class="form-control "  name="name" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="email">{{ __('app.email') }}</label>
                        <input type="text" id="email" value="{{ $client->email }}" class="form-control "  name="email" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="telephone">{{ __('app.telephone') }}</label>
                        <input type="text" id="telephone" value="{{ $client->telephone }}" class="form-control "  name="telephone" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="clientType">{{ __('app.type_client_singular') }}</label>
                        <input type="text" id="clientType" value="{{ $client->clientTypes->name }}" class="form-control "  name="clientType" disabled>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <h5>
                    {{ __('app.tour') }}
                </h5>
                <table id="table" class="datatables-basic table border-top dataTable no-footer dtr-column mt-0">
                    <thead>
                    <tr>
                        <th>{{ __('app.id') }}</th>
                        <th>{{ __('app.tour') }}</th>
                        <th>{{ __('app.invoice') }}</th>
                        <th>{{ __('app.booking') }}</th>
                        <th>{{ __('app.present') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tourClients as $tour)
                        <tr>
                            <th> {{ $tour->id }} </th>
                            <th>
                                @if($tour->getTour->state == 1)
                                    <a href="{{ route('tours.show', $tour->tour ) }}">{{ $tour->getTour->title }} </a>
                                @else
                                    <a href="{{ route('tour-history.show', $tour->tour ) }}">{{ $tour->getTour->title }} </a>
                                @endif
                            </th>
                            <th>
                                @if($tour->getInvoice->trashed())
                                    <p>{{ $prefix. $tour->invoice }} </p>
                                @else
                                    <a href=" {{  $tour->invoice == null ? '#' : route('invoice.show', $tour->invoice) }} ">{{ $prefix. $tour->invoice }} </a>
                                @endif
                            </th>
                            <th> {{ $tour->bookings }} </th>
                            <th>
                                @if($tour->present)
                                    <span class="badge rounded-pill bg-success"> {{__('app.present_1')}} </span>
                                @else
                                    <span class="badge rounded-pill bg-danger"> {{__('app.no_present')}} </span>
                                @endif
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('clients.index') }}">{{ __('app.go_index')}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
