@extends('admin.template')

@php
    $title = __('app.tours_history');
    $breadcrumbs = [__('app.home')=> route('admin.home'),'Tours'=>false];
@endphp

@push('page-css')
    <style>
        #tourshistory-table_wrapper {
            padding: 22px;
        }
    </style>
@endpush

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>Tours</h4>
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
@endpush


