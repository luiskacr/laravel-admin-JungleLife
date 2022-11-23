@extends('admin.template')

@php
    $title = "Tipo de Cliente";
    $breadcrumbs = ['Inicio'=> route('admin.home'),'Tipo de Clientes'=> route('type-client.index'), 'Crear' => false];
@endphp

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>Crear un tipos de Cliente</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('type-client.store')  }}" method="post" >
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
                        <label class="form-label" for="rate">Precio</label>
                        <input type="number" id="rate" value="{{ old('rate',0) }}" class="form-control" min="0" max="100"  name="rate">
                        @error('rate')
                        <div class="text-danger">
                            <div data-field="rate">* {{$message}}</div>
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
                    <a href="{{ route('type-client.index') }}"> Volver a la Lista</a>
                </div>

            </form>
        </div>
    </div>


@endsection
