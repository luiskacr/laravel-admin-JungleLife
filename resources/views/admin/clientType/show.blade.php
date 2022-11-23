@extends('admin.template')

@php
    $title = "Tipo de Cliente";
    $breadcrumbs = ['Inicio'=> route('admin.home'),'Tipo de Clientes'=> route('type-client.index'), 'Ver' => false];
@endphp

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>Ver un tipos de Cliente</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">Nombre</label>
                        <input type="text" id="name" value="{{ $clientType->name }}" class="form-control "  name="name" disabled>

                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="rate">Precio</label>
                        <input type="number" id="rate" value="{{ $clientType->rate }}" class="form-control"  name="rate" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <a href="{{ route('type-client.index') }}"> Volver a la Lista</a>
                </div>

            </div>

        </div>
    </div>


@endsection
