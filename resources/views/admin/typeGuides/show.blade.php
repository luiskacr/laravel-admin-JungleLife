@extends('admin.template')

@php
    $title = "Tipo de Guia";
    $breadcrumbs = ['Inicio'=> route('admin.home'),'Tipo de Guia'=> route('type-guides.index'), 'Ver' => false];
@endphp

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>Ver un tipos de Guia</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">Nombre</label>
                        <input type="text" id="name" value="{{ $typesGuide->name }}" class="form-control "  name="name" disabled>
                    </div>
                </div>

                <div class="col-12">
                    <a href="{{ route('type-guides.index') }}"> Volver a la Lista</a>
                </div>
            </div>

        </div>
    </div>


@endsection
