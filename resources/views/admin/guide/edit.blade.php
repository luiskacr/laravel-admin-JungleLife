@extends('admin.template')

@php
    $title = __('app.guide');
    $breadcrumbs = [__('app.home')=> route('admin.home'),__('app.guide') => route('guides.index'), __('app.crud_edit') => false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.edit_tittle',['object' =>  __('app.guide_singular')]) }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('guides.update',$guide->id) }}" method="post" >
                @csrf
                @method('PUT')
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">{{ __('app.name') }}</label>
                        <input type="text" id="name" value="{{ $guide->name }}" class="form-control "  name="name" >
                        @error('name')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="lastName">{{ __('app.lastname') }}</label>
                        <input type="text" id="lastName" value="{{ $guide->lastName }}" class="form-control"  name="lastName" >
                        @error('lastName')
                        <div class="text-danger">
                            <div data-field="rate">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="type">{{ __('app.type_guides_singular') }}</label>
                        <select id="type"  class="form-select" name="type" >
                            @foreach($typeGuides as $typeGuide)
                                @if($guide->type ==$typeGuide->id )
                                    <option value="{{ $typeGuide->id }}" selected>{{$typeGuide->name}}</option>
                                @else
                                    <option value="{{ $typeGuide->id }}">{{$typeGuide->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('type')
                            <div class="text-danger">
                                <div data-field="name">* {{$message}}</div>
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary" >{{ __('app.edit_btn') }}</button>
                </div>
                <div class="col-12">
                    <a href="{{ route('guides.index') }}">{{ __('app.go_index')}}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
