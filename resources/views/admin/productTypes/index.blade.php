@extends('admin.template')

@php
    $title = __('app.product_type');
    $breadcrumbs = [ __('app.home')=> route('admin.home'),__('app.product_type') =>false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.product_type') }}</h4>
                </div>
                <div class="float-end">
                    <a class="text-white" href="{{ route('product-type.create') }}">
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
                    <th>{{ __('app.crud_action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($productTypes as $productType)
                    <tr>
                        <th>{{ $productType->id }}</th>
                        <th>{{ $productType->name }}</th>
                        <th>
                            <div class="justify-content-between">
                                <a class="m-2" href="{{ route('product-type.show',$productType->id) }}"><i class="bx bxs-show me-1"></i>{{ __('app.crud_show') }}</a>
                                <a class="m-2" href="{{ route('product-type.edit',$productType->id) }}"><i class="bx bx-edit-alt me-1"></i>{{ __('app.crud_edit') }}</a>
                                @if($productType->id != 1)
                                    <a class="m-2" href="#" onclick="deleteItem(
                                    {{ $productType->id}},
                                    {{ json_encode($productType->name)}},
                                    {{json_encode(csrf_token()) }},
                                    {{ json_encode(route('product-type.destroy',0)) }} ,
                                    '{{ __('app.product_type_singular') }}'
                                    )">
                                        <i class="bx bx-trash me-1"></i>{{ __('app.crud_delete') }}</a>
                                @endif
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
