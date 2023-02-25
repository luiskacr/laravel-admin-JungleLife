@extends('admin.template')

@php
    $title = __('app.products');
    $breadcrumbs = [ __('app.home')=> route('admin.home'),__('app.products') => route('product.index'), __('app.crud_show') => false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.show_tittle',['object' =>  __('app.products_singular')]) }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">

                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">{{ __('app.name') }}</label>
                        <input type="text" id="name" value="{{ $product->name }}" class="form-control "  name="name" disabled>
                    </div>
                </div>

                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="price">{{ __('app.price') }}</label>
                        <input type="number" id="price" value="{{ $product->price }}" class="form-control "  name="price" disabled>
                    </div>
                </div>

                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="type">{{ __('app.product_type_singular') }}</label>
                        <input type="text" id="type" value="{{ $product->productType->name }}" class="form-control "  name="type" disabled>
                    </div>
                </div>

                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="money">{{ __('app.money_type') }}</label>
                        <input type="text" id="money" value="{{ $product->moneyType->name }}" class="form-control "  name="money" disabled>
                    </div>
                </div>

                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="description">{{ __('app.money_type') }}</label>
                        <input type="text" id="description" value="{{ $product->description}}" class="form-control "  name="description" disabled>
                    </div>
                </div>

                <div class="col-12">
                    <a href="{{ route('product.index') }}">{{ __('app.go_index')}}</a>
                </div>

            </div>
        </div>
    </div>
@endsection
