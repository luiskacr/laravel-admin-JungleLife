@extends('admin.template')

@php
    $title = __('app.tours_active');
    $breadcrumbs = [__('app.home')=> route('admin.home'),'Tours'=>false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>Tours</h4>
                </div>

            </div>
        </div>
        <div class="card-datatable  table-responsive">
            <table id="table" class="datatables-basic table border-top dataTable no-footer dtr-column">
                <thead>
                <tr>
                    <th>{{ __('app.id') }}</th>
                    <th>{{ __('app.name') }}</th>
                    <th>{{ __('app.tour_states_singular') }}</th>
                    <th>{{ __('app.available_space') }}</th>
                    <th>{{ __('app.tour_type_singular') }}</th>
                    <th>{{ __('app.crud_action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tours as $tour)
                    <tr>
                        <th>{{ $tour->id }}</th>
                        <th>{{ $tour->title }}</th>
                        <th>{{ $tour->tourState->name }}</th>
                        <th>{{ $tour->availableSpace() }}</th>
                        <th>{{ $tour->tourType->name }}</th>

                        <th>
                            <div class="justify-content-between">
                                <a class="m-2" href="{{ route('tour-history.show',$tour->id) }}"><i class="bx bxs-show me-1"></i> {{ __('app.crud_show') }} </a>
                            </div>
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


