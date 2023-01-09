@extends('admin.template')

@php
    $title = __('app.timetables');
    $breadcrumbs = [__('app.home')=> route('admin.home'),__('app.timetables') => route('timetable.index'), __('app.timetables') => false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.show_tittle',['object' =>  __('app.timetables_singular') ]) }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="start">{{ __('app.star') }}</label>
                        <input type="text" id="start" value="{{ Carbon\Carbon::parse($timetable->start)->format('g:i A')  }}" class="form-control "  name="start" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="end">{{ __('app.end') }}</label>
                        <input type="text" id="end" value="{{ Carbon\Carbon::parse($timetable->end)->format('g:i A')  }}" class="form-control"  name="end" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="rate">{{ __('app.auto') }}</label>
                        <br>
                        @if($timetable->auto)
                            <span class="badge bg-label-success">{{ __('app.status_values2.true') }}</span>
                        @else
                            <span class="badge bg-label-info">{{ __('app.status_values2.false') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-12">
                    <a href="{{ route('timetable.index') }}">{{ __('app.go_index')}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
