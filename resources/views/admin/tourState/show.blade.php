@extends('admin.template')

@php
    $title = __('app.tour_states');
    $breadcrumbs = [ __('app.home') => route('admin.home'),__('app.tour_states') => route('tour-state.index'), __('app.crud_show') => false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.show_tittle',['object' =>  __('app.tour_states_singular')]) }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">{{ __('app.name') }}</label>
                        <input type="text" id="name" value="{{ $tourState->name }}" class="form-control "  name="name" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <a href="{{ route('tour-state.index') }}">{{ __('app.go_index')}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
