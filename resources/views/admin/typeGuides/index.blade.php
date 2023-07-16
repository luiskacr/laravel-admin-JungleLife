@extends('admin.template')

@php
    $title = __('app.type_guides');
    $breadcrumbs = [__('app.home') => route('admin.home'),__('app.type_guides') =>false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{__('app.type_guides')}}</h4>
                </div>
                <div class="float-end">
                    <a class="text-white" href="{{ route('type-guides.create') }}">
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
                    <th>{{__('app.id')}}</th>
                    <th>{{__('app.name')}}</th>
                    <th>{{__('app.crud_action')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($typesGuides as $typesGuide)
                    <tr>
                        <th>{{ $typesGuide->id }}</th>
                        <th>{{ $typesGuide->name }}</th>
                        <th>
                            <div class="justify-content-between">
                                <a class="m-2" href="{{ route('type-guides.show',$typesGuide->id) }}"><i class="bx bxs-show me-1"></i> {{ __('app.crud_show')}}</a>
                                <a class="m-2" href="{{ route('type-guides.edit',$typesGuide->id) }}"><i class="bx bx-edit-alt me-1"></i> {{ __('app.crud_edit')}}</a>
                                <a class="m-2" href="#" onclick="deleteItem(
                                    {{ $typesGuide->id}},
                                    {{ json_encode($typesGuide->name) }},
                                    {{ json_encode(csrf_token())  }},
                                    {{ json_encode(route('type-guides.destroy',0)) }},
                                    '{{ __('app.type_guides_singular') }}'
                                    )">
                                    <i class="bx bx-trash me-1"></i>{{ __('app.crud_delete')}}</a>
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
