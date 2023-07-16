@extends('admin.template')

@php
    $title = __('app.timetables');
    $breadcrumbs = [__('app.home')=> route('admin.home'),__('app.timetables')  => false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.timetables')  }}</h4>
                </div>
                <div class="float-end">
                    <a class="text-white" href="{{ route('timetable.create') }}">
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
                    <th>{{ __('app.star') }}</th>
                    <th>{{ __('app.end') }}</th>
                    <th>{{ __('app.tour_type_singular') }}</th>
                    <th>{{ __('app.auto') }}</th>
                    <th>{{ __('app.crud_action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($timetables as $timetable)
                    <tr>
                        <th>{{ $timetable->id }}</th>
                        <th>{{ Carbon\Carbon::parse($timetable->start)->format('g:i A') }}  </th>
                        <th>{{ Carbon\Carbon::parse($timetable->end)->format('g:i A')}} </th>
                        <th>{{ $timetable->tourType->name }} </th>
                        <th>
                            @if($timetable->auto)
                                <span class="badge bg-label-success">{{ __('app.status_values2.true') }}</span>
                            @else
                                <span class="badge bg-label-info">{{ __('app.status_values2.false') }}</span>
                            @endif
                        </th>
                        <th>
                            <div class="justify-content-between">
                                <a class="m-2" href="{{ route('timetable.show',$timetable->id) }}"><i class="bx bxs-show me-1"></i> {{ __('app.crud_show') }}</a>
                                <a class="m-2" href="{{ route('timetable.edit',$timetable->id) }}"><i class="bx bx-edit-alt me-1"></i> {{ __('app.crud_edit') }}</a>
                                <a class="m-2" href="#" onclick="deleteItem(
                                    {{ $timetable->id}},
                                    {{ json_encode($timetable->start) }},
                                    {{ json_encode(csrf_token()) }},
                                    {{ json_encode(route('timetable.destroy',0)) }} ,
                                    '{{ __('app.timetables_singular') }}'
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
