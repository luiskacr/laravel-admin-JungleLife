@extends('admin.template')

@php
    $title = "Tipo de Cliente";
    $breadcrumbs = ['Inicio'=> route('admin.home'),'Guias'=> route('guides.index'), 'Crear' => false];
@endphp

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>Crear un Guia</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('guides.store')  }}" method="post" >
                @csrf
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">Nombre</label>
                        <input type="text" id="name" value="{{ old('name') }}" class="form-control "  name="name">
                        @error('name')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="lastName">Apellido</label>
                        <input type="text" id="lastName" value="{{ old('name') }}" class="form-control "  name="lastName">
                        @error('lastName')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="type">Typo de Guia</label>
                        <select id="type"  class="form-select" name="type" >
                            <option value="0">Seleccione un tipo Guia</option>
                            @foreach($typeGuides as $typeGuide)
                                <option value="{{ $typeGuide->id }}">{{$typeGuide->name}}</option>
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
                    <div data-field="rate">{{ session('message') }}</div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary" >
                        Crear
                    </button>
                </div>
                <div class="col-12">
                    <a href="{{ route('guides.index') }}"> Volver a la Lista</a>
                </div>

            </form>
        </div>
    </div>


@endsection
