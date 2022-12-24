@extends('admin.template')

@php
    $title =  __('app.customer');
    $breadcrumbs = [__('app.home')=> route('admin.home'),__('app.customer')=> route('clients.index'), __('app.create') => false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.create_tittle',['object' =>  __('app.customer_single')]) }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('clients.store')  }}" method="post" >
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
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="email">{{ __('app.email') }}</label>
                        <input type="text" id="email" value="{{ old('email') }}" class="form-control "  name="email">
                        @error('email')
                            <div class="text-danger">
                                <div data-field="name">* {{$message}}</div>
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="telephone">{{ __('app.telephone') }}</label>
                        <input type="text" id="telephone" value="{{ old('telephone') }}" class="form-control "  name="telephone">
                        @error('telephone')
                            <div class="text-danger">
                                <div data-field="name">* {{$message}}</div>
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="clientType">{{ __('app.type_client_singular') }}</label>
                        <select id="clientType"  class="form-select" name="clientType" >
                            <option value="0">{{ __('app.select_client_type') }}</option>
                            @foreach($clientTypes as $clientType)
                                <option value="{{ $clientType->id }}">{{$clientType->name}}</option>
                            @endforeach
                        </select>
                        @error('clientType')
                            <div class="text-danger">
                                <div data-field="name">* {{$message}}</div>
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div data-field="rate">{{ session('message') }}</div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary" >{{ __('app.create') }}</button>
                </div>
                <div class="col-12">
                    <a href="{{ route('clients.index') }}">{{ __('app.go_index')}}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
