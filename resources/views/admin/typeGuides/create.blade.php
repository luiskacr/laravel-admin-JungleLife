@extends('admin.template')

@php
    $title = __('app.type_guides');
    $breadcrumbs = [__('app.home')=> route('admin.home'),__('app.type_guides')=> route('type-guides.index'), __('app.create') => false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.create_tittle',['object' =>  __('app.type_guides_singular')]) }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('type-guides.store')  }}" method="post" >
                @csrf
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">{{__('app.name')}}</label>
                        <input type="text" id="name" value="{{ old('name') }}" class="form-control "  name="name">
                        @error('name')
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
                    <button type="submit" class="btn btn-primary">{{ __('app.create') }}</button>
                </div>
                <div class="col-12">
                    <a href="{{ route('type-guides.index') }}">{{ __('app.go_index')}}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
