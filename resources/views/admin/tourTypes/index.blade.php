@extends('admin.template')

@php
    $title = __('app.tour_type');
    $breadcrumbs = [ __('app.home')=> route('admin.home'),__('app.tour_type') =>false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.tour_type') }}</h4>
                </div>
                <div class="float-end">
                    <a class="text-white" href="{{ route('tour-type.create') }}">
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
                @foreach($tourTypes as $tourType)
                    <tr>
                        <th>{{ $tourType->id }}</th>
                        <th>{{ $tourType->name }}</th>
                        <th>
                            <div class="justify-content-between">
                                <a class="m-2" href="{{ route('tour-type.show',$tourType->id) }}"><i class="bx bxs-show me-1"></i>{{ __('app.crud_show') }}</a>
                                <a class="m-2" href="{{ route('tour-type.edit',$tourType->id) }}"><i class="bx bx-edit-alt me-1"></i>{{ __('app.crud_edit') }}</a>
                                <a class="m-2" href="#" onclick="deleteItem(
                                    {{ $tourType->id}},
                                    {{ json_encode($tourType->name)}},
                                    {{json_encode(csrf_token()) }},
                                    {{ json_encode(route('tour-type.destroy',0)) }} ,
                                    '{{ __('app.tour_type_singular') }}'
                                    )">
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
