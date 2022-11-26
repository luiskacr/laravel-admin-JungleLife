@extends('admin.template')

@php
    $title = "Cliente";
    $breadcrumbs = ['Inicio'=> route('admin.home'),'Guias'=> route('clients.index'), 'Ver' => false];
@endphp

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>Ver un Cliente</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">Nombre</label>
                        <input type="text" id="name" value="{{ $client->name }}" class="form-control "  name="name" disabled>

                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="email">Email</label>
                        <input type="text" id="email" value="{{ $client->email }}" class="form-control "  name="email" disabled>

                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="telephone">Telefono</label>
                        <input type="text" id="telephone" value="{{ $client->telephone }}" class="form-control "  name="telephone" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="clientType">Tipo de Ciente</label>
                        <input type="text" id="clientType" value="{{ $client->clientTypes->name }}" class="form-control "  name="clientType" disabled>
                    </div>
                </div>


                <div class="col-12">
                    <a href="{{ route('clients.index') }}"> Volver a la Lista</a>
                </div>

            </div>

        </div>
    </div>


@endsection
