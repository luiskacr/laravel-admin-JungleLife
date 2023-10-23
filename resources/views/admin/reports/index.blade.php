@extends('admin.template')

@php
    $title = __('app.report');
    $breadcrumbs = [__('app.home') => route('admin.home'),__('app.report') =>false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{__('app.report_tittle')}}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 mt-5">
        <div class="col-12 col-sm-6 col-lg-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="mb-3 bx bx-md bx-bar-chart-alt-2"></i>
                    <h5>{{ __('app.report_daily_profit_tittle') }}</h5>
                    <p> {{ __('app.report_daily_profit_message') }}</p>
                    <a href="{{ route('reports.daily') }}">
                        <button type="button" class="btn btn-primary" > {{ __('app.reports_btn') }} </button>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="mb-3 bx bx-md bx-dollar"></i>
                    <h5>{{ __('app.report_guides_tittle') }}</h5>
                    <p> {{ __('app.report_guides_message') }}</p>
                    <a href="{{ route('reports.guides') }}">
                        <button type="button" class="btn btn-primary" > {{ __('app.reports_btn') }} </button>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="mb-3 bx bx-md bx-spreadsheet"></i>
                    <h5>{{ __('app.report_credit_tittle') }}</h5>
                    <p> {{ __('app.report_credit_message') }}</p>
                    <a href="{{ route('reports.credit') }}">
                        <button type="button" class="btn btn-primary" > {{ __('app.reports_btn') }} </button>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="mb-3 bx bx-md bx-bar-chart"></i>
                    <h5>{{ __('app.report_monthly_tittle') }}</h5>
                    <p> {{ __('app.report_monthly_message') }}</p>
                    <a href="{{ route('reports.monthly') }}">
                        <button type="button" class="btn btn-primary" > {{ __('app.reports_btn') }} </button>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="mb-3 bx bx-md bx-bar-chart-alt"></i>
                    <h5>{{ __('app.report_yearly_tittle') }}</h5>
                    <p> {{ __('app.report_yearly_message') }}</p>
                    <a href="{{ route('reports.yearly') }}">
                        <button type="button" class="btn btn-primary" > {{ __('app.reports_btn') }} </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection


