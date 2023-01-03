@extends('admin.template')

@php
    $title = __('app.type_client');
    $breadcrumbs = [__('app.home')=> route('admin.home'),__('app.type_client') => route('type-client.index'), __('app.crud_show') => false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.show_tittle',['object' =>  __('app.type_client_singular') ]) }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">{{ __('app.name') }}</label>
                        <input type="text" id="name" value="{{ $clientType->name }}" class="form-control "  name="name" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="rate">{{ __('app.price') }}</label>
                        <input type="number" id="rate" value="{{ $clientType->rate }}" class="form-control"  name="rate" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="rate">{{ __('app.money_type') }}</label>
                        <input type="text" id="rate" value="{{ $clientType->moneyType->name }}" class="form-control"  name="rate" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <a href="{{ route('type-client.index') }}">{{ __('app.go_index')}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
