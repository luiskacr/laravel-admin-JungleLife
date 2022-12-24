@extends('admin.template')

@php
    $title = "Tour";
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
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">Nombre</label>
                        <input type="text" id="name" value="{{ old('name') }}" class="form-control "  name="name">
                        @error('name')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="user">Usuario</label>
                        <input type="text"  value="{{ Auth::user()->name }}" class="form-control "  disabled >
                        <input type="text" id="user" value="{{ Auth::id() }}" class="form-control "  name="user" hidden>
                    </div>

                </div>

                <div class="row g-3">
                    <div class="col-md-6 ">
                        <label class="form-label" for="name">Inicio</label>
                        <input type="date" id="start" value="{{ old('start') }}" class="form-control "  name="start">
                        @error('start')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 ">
                        <label class="form-label" for="name">Final</label>
                        <input type="date" id="end" value="{{ old('end') }}" class="form-control "  name="end">
                        @error('end')
                        <div class="text-danger">
                            <div data-field="end">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-12 ">
                        <label class="form-label" for="info">Informacion</label>
                        <textarea name="info" id="info" class="form-control"  placeholder="{{ __('app.info_tours') }}">{{ old('info') }}</textarea>
                        @error('info')
                        <div class="text-danger">
                            <div data-field="info">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary" >
                        Crear
                    </button>
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
