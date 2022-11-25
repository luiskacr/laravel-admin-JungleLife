@extends('admin.template')

@php
    $title = "Tipo de Cliente";
    $breadcrumbs = ['Inicio'=> route('admin.home'),'Guias'=> route('guides.index'), 'Ver' => false];
@endphp

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>Ver un Guia</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">Nombre</label>
                        <input type="text" id="name" value="{{ $guide->name }}" class="form-control "  name="name" disabled>

                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="rate">Apellido</label>
                        <input type="text" id="rate" value="{{ $guide->lastName }}" class="form-control"  name="rate" disabled>
                    </div>
                </div>

                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="rate">Tipo de Guia</label>
                        <input type="text" id="rate" value="{{ $guide->guidesType->name }}" class="form-control"  name="rate" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <a href="{{ route('guides.index') }}"> Volver a la Lista</a>
                </div>

            </div>

        </div>
    </div>


@endsection
