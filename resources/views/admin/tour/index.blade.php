@extends('admin.template')

@php
    $title = __('app.tours_active');
    $breadcrumbs = [__('app.home')=> route('admin.home'),'Tours'=>false];
@endphp

@section('content')
    <style>
        #tours-table_wrapper {
            padding: 22px;
        }
    </style>
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>Tours</h4>
                </div>
                <div class="float-end">
                    <a class="text-white" href="{{ route('tours.create') }}">
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
    @include('admin.partials.delete')
@endpush
