@extends('admin.template')

@php
    $title = __('app.guide');
    $breadcrumbs = [__('app.home')=> route('admin.home'),__('app.guide') => false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.guide') }}</h4>
                </div>
                <div class="float-end">
                    <a class="text-white" href="{{ route('guides.create') }}">
                        <button class="btn btn-primary" type="button">
                            {{ __('app.create') }}
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-datatable table-responsive pt-0">
            <table id="table" class="datatables-basic table border-top">
                <thead>
                <tr>
                    <th>{{ __('app.id') }}</th>
                    <th>{{ __('app.name') }}</th>
                    <th>{{ __('app.lastname') }}</th>
                    <th>{{ __('app.type_guides_singular') }}</th>
                    <th>{{ __('app.crud_action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($guides as $guide)
                    <tr>
                        <th>{{ $guide->id }}</th>
                        <th>{{ $guide->name }}</th>
                        <th>{{ $guide->lastName }}</th>
                        <th>{{ $guide->guidesType->name }}</th>
                        <th>
                            <div class="justify-content-between">
                                <a class="m-2" href="{{ route('guides.show',$guide->id) }}"><i class="bx bxs-show me-1"></i> {{ __('app.crud_show') }}</a>
                                <a class="m-2" href="{{ route('guides.edit',$guide->id) }}"><i class="bx bx-edit-alt me-1"></i> {{ __('app.crud_edit') }}</a>
                                <a class="m-2" href="#" onclick="deleteItem({{ $guide->id}},{{ json_encode($guide->name) }},
                                {{ json_encode(csrf_token())  }}, {{ json_encode(route('guides.destroy',0)) }}, '{{ __('app.guide_singular') }}'  )">
                                    <i class="bx bx-trash me-1"></i> {{ __('app.crud_delete') }}
                                </a>
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
