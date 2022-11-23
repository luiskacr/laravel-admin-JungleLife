@extends('admin.template')

@php
    $title = "Tipo de Guia";
    $breadcrumbs = ['Inicio'=> route('admin.home'),'Tipo de Guia'=> route('type-guides.index'), 'Editar' => false];
@endphp

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>Editar un Tipo de Guia</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('type-guides.update',$typesGuide->id) }}" method="post" >
                @csrf
                @method('PUT')
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">Nombre</label>
                        <input type="text" id="name" value="{{ $typesGuide->name }}" class="form-control "  name="name" >
                        @error('name')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary" >
                        Actualizar
                    </button>
                </div>
                <div class="col-12">
                    <a href="{{ route('type-guides.index') }}"> Volver a la Lista</a>
                </div>

            </form>
        </div>
    </div>


@endsection
