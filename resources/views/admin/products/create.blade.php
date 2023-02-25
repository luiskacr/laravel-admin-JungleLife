@extends('admin.template')

@php
    $title = __('app.products');
    $breadcrumbs = [ __('app.home')=> route('admin.home'),__('app.products') => route('product.index'), __('app.create') => false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.create_tittle',['object' =>  __('app.products_singular')]) }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('product.store')  }}" method="post" >
                @csrf
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">{{ __('app.name') }}</label>
                        <input type="text" id="name" value="{{ old('name') }}" class="form-control "  name="name">
                        @error('name')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>


                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="price">{{ __('app.price') }}</label>
                        <input type="number" id="price" value="{{ old('price') }}" class="form-control " min="0" name="price">
                        @error('price')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                            <label class="form-label" for="type">{{ __('app.product_type_singular') }}</label>
                            <select id="type"  class="form-select" name="type" >
                                <option value="0">{{ __('app.product_type_select') }}</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('type')
                            <div class="text-danger">
                                <div data-field="name">* {{ $message }}</div>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                            <label class="form-label" for="money">{{ __('app.money_type') }}</label>
                            <select id="money"  class="form-select" name="money" >
                                <option value="0">{{ __('app.select_money_type') }}</option>
                                @foreach($moneyTypes as $moneyType)
                                    <option value="{{ $moneyType->id }}">{{ $moneyType->name }}</option>
                                @endforeach
                            </select>
                            @error('money')
                            <div class="text-danger">
                                <div data-field="name">* {{ $message }}</div>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="description">{{ __('app.description') }}</label>
                        <input type="text" id="description" value="{{ old('description') }}" class="form-control "  name="description">
                        @error('description')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>

                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">{{ __('app.create') }}</button>
                </div>
                <div class="col-12">
                    <a href="{{ route('tour-type.index') }}">{{ __('app.go_index')}}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
