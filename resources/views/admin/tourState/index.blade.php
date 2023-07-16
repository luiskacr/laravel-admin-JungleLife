@extends('admin.template')

@php
    $title = __('app.tour_states');
    $breadcrumbs = [ __('app.home')=> route('admin.home'),__('app.tour_states') =>false];
@endphp

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.tour_states') }}</h4>
                </div>
                <div class="float-end">
                    <a class="text-white" href="{{ route('tour-state.create') }}">
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
                @foreach($stateTours as $stateTour)
                    <tr>
                        <th>{{ $stateTour->id }}</th>
                        <th>{{ $stateTour->name }}</th>
                        <th>
                            <div class="justify-content-between">
                                <a class="m-2" href="{{ route('tour-state.show',$stateTour->id) }}"><i class="bx bxs-show me-1"></i>{{ __('app.crud_show') }}</a>
                                <a class="m-2" href="{{ route('tour-state.edit',$stateTour->id) }}"><i class="bx bx-edit-alt me-1"></i>{{ __('app.crud_edit') }}</a>
                                <a class="m-2" href="#" onclick="deleteItem(
                                    {{ $stateTour->id}},
                                    {{ json_encode($stateTour->name) }},
                                    {{ json_encode(csrf_token())  }},
                                    {{ json_encode(route('tour-state.destroy',0))}} ,
                                    '{{ __('app.tour_states_singular') }}'
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
