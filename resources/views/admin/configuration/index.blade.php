@extends('admin.template')

@php
    $title = __('app.config');
    $breadcrumbs = [__('app.home') => route('admin.home'),__('app.config') =>false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{__('app.tittle_config')}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            @foreach($configurations as $configuration)
                {{ $configuration }}
                <br/>
            @endforeach
        </div>
    </div>
@endsection
