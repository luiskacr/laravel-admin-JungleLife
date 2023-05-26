@extends('admin.template')

@php
    $title = __('app.invoice');
    $breadcrumbs = [ __('app.home')=> route('admin.home'),__('app.invoice') =>false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.invoice') }}</h4>
                </div>
                <div class="float-end">
                    <a class="text-white" href="{{ route('invoice.create') }}">
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
                        <th>{{ __('app.customer_single') }}</th>
                        <th>{{ __('app.date') }}</th>
                        <th>{{ __('app.type') }}</th>
                        <th>{{ __('app.state') }}</th>
                        <th>{{ __('app.quantity2') }}</th>
                        <th>{{ __('app.money_type') }}</th>
                        <th>{{ __('app.total') }}</th>
                        <th>{{ __('app.crud_action') }}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($invoices as $invoice)
                    <tr>
                        <th>{{ $invoice->id }}</th>
                        <th>{{ $invoice->getClient->name  }}</th>
                        <th>{{  \Carbon\Carbon::make($invoice->date)->format('d-m-y') }}</th>
                        <th>{{ $invoice->getType->name }}</th>
                        <th>{{ $invoice->getState->name }}</th>
                        <th>{{ $invoice->getProductsCount() }}</th>
                        <th>{{ $invoice->getMoney->name }}</th>
                        <th>{{ $invoice->getMoney->symbol . $invoice->total }}</th>
                        <th>
                            <div class="justify-content-between">
                                <a class="m-2" href="{{ route('invoice.show',$invoice->id) }}"><i class="bx bxs-show me-1"></i>{{ __('app.crud_show') }}</a>
                                <a class="m-2" href="{{ route('invoice.edit',$invoice->id) }}"><i class="bx bx-edit-alt me-1"></i>{{ __('app.crud_edit') }}</a>
                                <a class="m-2" href="#" onclick="deleteItem({{ $invoice->id}},{{ json_encode($invoice->id)}},
                                {{json_encode(csrf_token()) }},{{ json_encode(route('invoice.destroy',0)) }} )">
                                    <i class="bx bx-trash me-1"></i>{{ __('app.crud_delete') }}</a>
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
