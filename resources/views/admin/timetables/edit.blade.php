@extends('admin.template')

@php
    $title = __('app.timetables');
    $breadcrumbs = [__('app.home')=> route('admin.home'),__('app.timetables') => route('timetable.index'), __('app.crud_edit') => false];
@endphp


@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.edit_tittle',['object' =>  __('app.timetables_singular') ]) }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('timetable.update',$timetable->id )  }}" method="post" >
                @csrf
                @method('PUT')
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="start">{{ __('app.star') }}</label>
                        <select type="text" id="start" class="form-control "  name="start">
                            @for($i = 8; $i <= 12; $i++)
                                @if($i <10)
                                    @if( (Carbon\Carbon::parse($timetable->start)->format('g:i A') == $i.":00 AM") )
                                        <option value="{{ '0'.$i . ":00:00"}}" selected> {{ $i . ":00 AM"}}</option>
                                    @else
                                        <option value="{{ '0'.$i . ":00:00"}}"> {{ $i . ":00 AM"}}</option>
                                    @endif
                                @else
                                    @if( (Carbon\Carbon::parse($timetable->start)->format('g:i A') == $i . ":00 AM" ) )
                                        <option value="{{ $i . ":00:00"}}" selected> {{ $i . ":00 AM"}}</option>
                                    @else
                                        <option value="{{ $i . ":00:00"}}"> {{ $i . ":00 AM"}}</option>
                                    @endif
                                @endif
                            @endfor
                            @for($i = 1; $i <= 11; $i++)
                                    @if( (Carbon\Carbon::parse($timetable->start)->format('g:i A') == $i . ":00 PM" ) )
                                        <option value="{{ (12+ $i) . ":00:00"}}" selected> {{ $i . ":00 PM"}}</option>
                                    @else
                                        <option value="{{ (12+ $i) . ":00:00"}}"> {{ $i . ":00 PM"}}</option>
                                    @endif
                            @endfor
                        </select >
                        @error('start')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="end">{{ __('app.end') }}</label>
                        <select type="text" id="start" class="form-control "  name="end">
                            @for($i = 8; $i <= 12; $i++)
                                @if($i <10)
                                    @if( (Carbon\Carbon::parse($timetable->end)->format('g:i A') == $i.":00 AM") )
                                        <option value="{{ '0'.$i . ":00:00"}}" selected> {{ $i . ":00 AM"}}</option>
                                    @else
                                        <option value="{{ '0'.$i . ":00:00"}}"> {{ $i . ":00 AM"}}</option>
                                    @endif
                                @else
                                    @if( (Carbon\Carbon::parse($timetable->end)->format('g:i A') == $i . ":00 AM" ) )
                                        <option value="{{ $i . ":00:00"}}" selected> {{ $i . ":00 AM"}}</option>
                                    @else
                                        <option value="{{ $i . ":00:00"}}"> {{ $i . ":00 AM"}}</option>
                                    @endif
                                @endif
                            @endfor
                            @for($i = 1; $i <= 11; $i++)
                                @if( (Carbon\Carbon::parse($timetable->end)->format('g:i A') == $i . ":00 PM" ) )
                                    <option value="{{ (12+ $i) . ":00:00"}}" selected> {{ $i . ":00 PM"}}</option>
                                @else
                                    <option value="{{ (12+ $i) . ":00:00"}}"> {{ $i . ":00 PM"}}</option>
                                @endif
                            @endfor
                        </select >
                        @error('end')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="text-primary">{{ __('app.auto_message') }}</div>
                </div>

                <div class="col-12">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" name="auto" type="checkbox" id="auto"  {{ $timetable->auto ? 'checked' : ''}}>
                        <label class="form-label" for="auto">{{ __('app.auto') }}</label>
                        @error('auto')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div data-field="rate">{{ session('message') }}</div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary" >{{ __('app.edit_btn') }}</button>
                </div>
                <div class="col-12">
                    <a href="{{ route('timetable.index') }}">{{ __('app.go_index')}}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
