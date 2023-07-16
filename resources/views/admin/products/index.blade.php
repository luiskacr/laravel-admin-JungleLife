@extends('admin.template')

@php
    $title = __('app.products');
    $breadcrumbs = [ __('app.home')=> route('admin.home'),__('app.products') =>false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.products') }}</h4>
                </div>
                <div class="float-end">
                    <a class="text-white" href="{{ route('product.create') }}">
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
                    <th>{{ __('app.price') }}</th>
                    <th>{{ __('app.product_type_singular') }}</th>
                    <th>{{ __('app.crud_action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <th>{{ $product->id }}</th>
                        <th>{{ $product->name }}</th>
                        @if(is_null($product->price) or $product->price == 0)
                            <th>0</th>
                        @else
                            <th>{{ $product->moneyType->symbol }}{{ $product->price }}</th>
                        @endif
                        <th>{{ $product->productType->name }}</th>
                        <th>
                            <div class="justify-content-between">
                                <a class="m-2" href="{{ route('product.show',$product->id) }}"><i class="bx bxs-show me-1"></i>{{ __('app.crud_show') }}</a>
                                @if($product->price !=null)

                                    <a class="m-2" href="{{ route('product.edit',$product->id) }}"><i class="bx bx-edit-alt me-1"></i>{{ __('app.crud_edit') }}</a>
                                    <a class="m-2" href="#" onclick="deleteItem({{ $product->id}},{{ json_encode($product->name)}},
                                        {{json_encode(csrf_token()) }},{{ json_encode(route('product.destroy',0)) }} )">
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
