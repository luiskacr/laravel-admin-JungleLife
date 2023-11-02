@extends('admin.template')

@php
    $title = __('app.customer');
    $breadcrumbs = [__('app.home') => route('admin.home'),__('app.customer') =>false];
@endphp

@section('content')
    <style>
        #customer-table_wrapper {
            padding: 22px;
        }
    </style>
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.customer') }}</h4>
                </div>
                <div class="float-end">
                    <a class="text-white" href="{{ route('clients.create') }}">
                        <button class="btn btn-primary" type="button">
                            {{ __('app.create') }}
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-datatable  table-responsive">
            {{ $dataTable->table() }}
        </div>

    </div>
@endsection

@push('page-scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @if(auth()->user()->hasRole('Administrador'))
    @include('admin.partials.delete')
    @endif
@endpush
