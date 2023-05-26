@extends('admin.template')

@php
    $title = __('app.tour_type');
    $breadcrumbs = [ __('app.home') => route('admin.home'),__('app.tour_type') => route('tour-type.index'), __('app.crud_show') => false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.show_tittle',['object' =>  __('app.tour_type_singular')]) }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">{{ __('app.name') }}</label>
                        <input type="text" id="name" value="{{ $tourType->name }}" class="form-control "  name="name" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="money">{{ __('app.money_type') }}</label>
                        <input type="text" id="money" value="{{ $tourType->moneyType->name }}" class="form-control "  name="money" disabled>
                    </div>
                </div>
                <h5 class="mb-0 mt-4">{{ __('app.fee') }}</h5>

                @php($symbol = $tourType->moneyType->symbol)

                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="fee1">{{ __('app.fee_1') }}</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon11">{{$symbol}}</span>
                            <input type="number" id="fee1" value="{{ $tourType->fee1 }}" class="form-control "  name="fee1" disabled>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="fee2">{{ __('app.fee_2') }}</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon11">{{$symbol}}</span>
                            <input type="number" id="fee2" value="{{ $tourType->fee2 }}" class="form-control "  name="fee2" disabled>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="fee3">{{ __('app.fee_3') }}</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon11">{{$symbol}}</span>
                            <input type="number" id="fee3" value="{{ $tourType->fee3 }}" class="form-control "  name="fee3" disabled>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="fee4">{{ __('app.fee_4') }}</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon11">{{$symbol}}</span>
                            <input type="number" id="fee4" value="{{ $tourType->fee4 }}" class="form-control "  name="fee4" disabled>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <a href="{{ route('tour-type.index') }}">{{ __('app.go_index')}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
