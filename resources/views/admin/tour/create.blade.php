@extends('admin.template')

@php
    $title = __('app.tour');
    $breadcrumbs = ['Inicio'=> route('admin.home'),'Tour'=> route('tours.index'), 'Crear' => false];
@endphp

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>Crear un Tour</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('tours.store')  }}" method="post" >
                @csrf

                <div class="row g-3">
                    <div class="col-md-6 ">
                        <label class="form-label" for="date">{{ __('app.date') }}</label>
                        <input type="date" id="date" value="{{ old('date') }}" class="form-control flatpickr-input active" placeholder="{{ __('app.select_date') }}" data-date-format="mm/dd/yyyy" name="date">
                        @error('date')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 ">
                        <label class="form-label" for="time">{{ __('app.schedule') }}</label>
                        <select id="time"  class="form-select" name="time" >
                            <option value="0">{{ __('app.select_schedule') }}</option>
                            @foreach($timetables as $timetable)
                                <option value="{{ $timetable->id }}">{{ __('app.from'). Carbon\Carbon::parse($timetable->start)->format('g:i A'). __('app.to') . Carbon\Carbon::parse($timetable->end)->format('g:i A')  }}</option>
                            @endforeach
                        </select>
                        @error('end')
                        <div class="text-danger">
                            <div data-field="end">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-12 ">
                        <label class="form-label" for="info">{{ __('app.information') }}</label>
                        <textarea name="info" id="info" class="form-control"  placeholder="{{ __('app.info_tours') }}">{{ old('info') }}</textarea>
                        @error('info')
                        <div class="text-danger">
                            <div data-field="info">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary" >{{ __('app.create') }}</button>
                </div>
                <div class="col-12">
                    <a href="{{ route('tours.index') }}">{{ __('app.go_index')}}</a>
                </div>

            </form>
        </div>
    </div>

@endsection

@push('page-scripts')
    <script>


    </script>
@endpush
