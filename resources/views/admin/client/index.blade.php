@extends('admin.template')

@php
    $title = __('app.customer');
    $breadcrumbs = [__('app.home') => route('admin.home'),__('app.customer') =>false];
@endphp

@section('content')
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
            <table id="table" class="datatables-basic table border-top dataTable no-footer dtr-column">
                <thead>
                <tr>
                    <th>{{ __('app.id') }}</th>
                    <th>{{ __('app.name') }}</th>
                    <th>{{ __('app.email') }}</th>
                    <th>{{ __('app.telephone') }}</th>
                    <th>{{ __('app.type_client_singular') }}</th>
                    <th>{{ __('app.crud_action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($clients as $client)
                    <tr>
                        <th>{{ $client->id }}</th>
                        <th>{{ $client->name }}</th>
                        <th>{{ $client->email }}</th>
                        <th>{{ $client->telephone }}</th>
                        <th>{{ $client->clientTypes->name }}</th>
                        <th>
                            <div class="justify-content-between">
                                <a class="m-2" href="{{ route('clients.show',$client->id) }}"><i class="bx bxs-show me-1"></i> {{ __('app.crud_show') }}</a>
                                <a class="m-2" href="{{ route('clients.edit',$client->id) }}"><i class="bx bx-edit-alt me-1"></i> {{ __('app.crud_edit') }}</a>
                                <a class="m-2" href="#" onclick="deleteItem({{ $client->id}},{{ json_encode($client->name) }},
                                {{ json_encode(csrf_token()) }}, {{ json_encode(route('clients.destroy',0)) }} )">
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
