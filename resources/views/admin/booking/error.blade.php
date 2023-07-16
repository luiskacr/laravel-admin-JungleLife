@extends('admin.template')

@php
    $title = __('app.tours_book');
    $breadcrumbs = [__('app.home') => route('admin.home'),__('app.tours_book') =>false];
@endphp

@section('content')
    <style>
        .center-img{
            display: flex;
            justify-content: center;
        }
    </style>
    <div id="card-loader" class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{__('app.booking')}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="text-center">
                <h1><b>Error</b></h1>
                <h3>{!! __('app.error_exchange_rate_tittle') !!}</h3>
            </div>
            <div class="center-img">
                <img src="{{ asset('assets/images/exchange_error.jpg') }}" height="400px">
            </div>
        </div>
        <div class="row m-5">
            @hasrole('Administrador')
                <div class="col-12">
                    <a href="{{ route('exchange-rate.index') }}">{{ __('app.go_exchange')}}</a>
                </div>
            @else
                <div class="col-12">
                    <h5>{{ __('app.msg_contact_admin') }}</h5>
                </div>
            @endhasrole
        </div>

    </div>
@endsection
