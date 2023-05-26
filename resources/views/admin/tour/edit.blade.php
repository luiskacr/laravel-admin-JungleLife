@extends('admin.template')

@php
    $title = __('app.tours_active');
    $breadcrumbs = [__('app.home')=> route('admin.home'),'Tour'=> route('tours.index'), __('app.crud_edit') => false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.edit_tittle',['object' =>  __('app.tour_singular')]) }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('tours.update',$tour->id) }}" method="post" >
                @csrf
                @method('PUT')
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">{{__('app.name')}}</label>
                        <input type="text" id="name" value="{{ $tour->title }}" class="form-control "  name="name" >
                        @error('name')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="date">{{ __('app.date') }}</label>
                        <input type="date" id="date" value="{{ Carbon\Carbon::parse($tour->start)->format('d-m-Y') }}" class="form-control flatpickr-input active"  data-date-format="mm/dd/yyyy" name="date">
                        @error('date')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-12 ">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="time">{{ __('app.schedule') }}</label>
                        <select id="time"  class="form-select" name="time" >
                            @php
                                //create a data parse and validation
                                $start = Carbon\Carbon::parse($tour->start)->format('g:i A');
                                $end = Carbon\Carbon::parse($tour->end)->format('g:i A');
                            @endphp
                            @foreach($timetables as $timetable)
                                @php
                                    //create a data parse and validation
                                     $timetableStart = Carbon\Carbon::parse($timetable->start)->format('g:i A');
                                     $timetableEnd = Carbon\Carbon::parse($timetable->end)->format('g:i A');
                                @endphp
                                @if($start == $timetableStart and $end == $timetableEnd)
                                    <option value="{{ $timetable->id }}" selected>{{ __('app.from'). Carbon\Carbon::parse($timetable->start)->format('g:i A'). __('app.to') . Carbon\Carbon::parse($timetable->end)->format('g:i A') . __('app.tours_of') . $timetable->tourType->name  }}</option>
                                @else
                                    <option value="{{ $timetable->id }}">{{ __('app.from'). Carbon\Carbon::parse($timetable->start)->format('g:i A'). __('app.to') . Carbon\Carbon::parse($timetable->end)->format('g:i A') . __('app.tours_of') . $timetable->tourType->name  }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('time')
                        <div class="text-danger">
                            <div data-field="end">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>


                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="tour-state">{{__('app.tour_states_singular')}}</label>
                        <select id="tour-state" class="form-select" name="tour-state">
                            @foreach($tourStates as $tourState)
                                @if($tourState->id == $tour->state)
                                    <option value="{{ $tourState->id }}" selected>{{ $tourState->name }}</option>
                                @else
                                    <option value="{{ $tourState->id }}">{{ $tourState->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('tour-state')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="info">{{__('app.info_tours')}}</label>
                        <textarea name="info" id="info" class="form-control">{{ $tour->info }}</textarea>
                        @error('info')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary" >{{ __('app.edit_btn') }}</button>
                </div>
                <div class="col-12">
                    <a href="{{ route('tours.index') }}">{{ __('app.go_index')}}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
