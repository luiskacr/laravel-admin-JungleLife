@extends('admin.template')

@php
    $title = __('app.type_client');
    $breadcrumbs = [__('app.home')=> route('admin.home'),__('app.type_client')  => false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.type_client')  }}</h4>
                </div>
                <div class="float-end">
                    <a class="text-white" href="{{ route('type-client.create') }}">
                        <button class="btn btn-primary" type="button">
                            {{ __('app.create') }}
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-datatable  table-responsive">
            <table id="table"  class="datatables-basic table border-top dataTable no-footer dtr-column">
                <thead>
                    <tr>
                        <th>{{ __('app.id') }}</th>
                        <th>{{ __('app.name') }}</th>
                        <th>{{ __('app.crud_action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientTypes as $clientType)
                        <tr>
                            <th>{{ $clientType->id }}</th>
                            <th>{{ $clientType->name }}</th>
                            <th>
                                <div class="justify-content-between">
                                    <a class="m-2" href="{{ route('type-client.show',$clientType->id) }}"><i class="bx bxs-show me-1"></i> {{ __('app.crud_show') }}</a>
                                    <a class="m-2" href="{{ route('type-client.edit',$clientType->id) }}"><i class="bx bx-edit-alt me-1"></i> {{ __('app.crud_edit') }}</a>
                                    <a class="m-2" href="#" onclick="deleteItem({{ $clientType->id}}
                                    ,{{ json_encode($clientType->name) }}
                                    ,{{ json_encode(csrf_token()) }}
                                    ,{{ json_encode(route('type-client.destroy',0)) }}
                                    , {{ json_encode(__('app.type_client_singular')) }}
                                    )">
                                        <i class="bx bx-trash me-1"></i> {{ __('app.crud_delete') }}</a>
                                </div>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('page-scripts')
    @include('admin.partials.delete')
@endpush
