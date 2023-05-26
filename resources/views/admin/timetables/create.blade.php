@extends('admin.template')

@php
    $title = __('app.timetables');
    $breadcrumbs = [__('app.home')=> route('admin.home'),__('app.timetables') => route('timetable.index'), __('app.create') => false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.create_tittle',['object' =>  __('app.timetables_singular') ]) }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('timetable.store')  }}" method="post" >
                @csrf

                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="start">{{ __('app.star') }}</label>
                        <select type="text" id="start" class="form-control "  name="start">
                            <option value="0"> {{ __('app.select_star')}}</option>
                            @for($i = 8; $i <= 12; $i++)
                                @if($i <10)
                                    <option value="{{ '0'.$i . ":00:00"}}"> {{ $i . ":00 AM"}}</option>
                                @else
                                    <option value="{{ $i . ":00:00"}}"> {{ $i . ":00 AM"}}</option>
                                @endif
                            @endfor
                            @for($i = 1; $i <= 11; $i++)
                                <option value="{{ (12+ $i) . ":00:00"}}"> {{ $i . ":00 PM"}}</option>
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
                            <option value="0"> {{ __('app.select_end')}}</option>
                            @for($i = 8; $i <= 12; $i++)
                                @if($i <10)
                                    <option value="{{ '0'.$i . ":00:00"}}"> {{ $i . ":00 AM"}}</option>
                                @else
                                    <option value="{{ $i . ":00:00"}}"> {{ $i . ":00 AM"}}</option>
                                @endif
                            @endfor
                            @for($i = 1; $i <= 11; $i++)
                                <option value="{{ (12+ $i) . ":00:00"}}"> {{ $i . ":00 PM"}}</option>
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
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="tourType">{{ __('app.tour_type_singular') }}</label>
                        <select id="tourType" class="form-select" name="tourType">
                            <option value="0" selected>{{ __('app.select_tour_type') }}</option>
                            @foreach($tourTypes as $tourType)
                                <option value="{{ $tourType->id }}">{{ $tourType->name }}</option>
                            @endforeach
                        </select>
                        @error('type')
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
                        <input class="form-check-input" name="auto" type="checkbox" id="auto" >
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
                    <button type="submit" class="btn btn-primary" >{{ __('app.create') }}</button>
                </div>
                <div class="col-12">
                    <a href="{{ route('timetable.index') }}">{{ __('app.go_index')}}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
