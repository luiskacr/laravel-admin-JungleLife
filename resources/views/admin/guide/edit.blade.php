@extends('admin.template')

@php
    $title = "Guias";
    $breadcrumbs = ['Inicio'=> route('admin.home'),'Guias'=> route('guides.index'), 'Editar' => false];
@endphp

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>Editar un Guia</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('guides.update',$guide->id) }}" method="post" >
                @csrf
                @method('PUT')
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">Nombre</label>
                        <input type="text" id="name" value="{{ $guide->name }}" class="form-control "  name="name" >
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
                        <input type="text" id="lastName" value="{{ $guide->lastName }}" class="form-control"  name="lastName" >
                        @error('lastName')
                        <div class="text-danger">
                            <div data-field="rate">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="type">Tipo de Guia</label>
                        <select id="type"  class="form-select" name="type" >
                            @foreach($typeGuides as $typeGuide)
                                @if($guide->type ==$typeGuide->id )
                                    <option value="{{ $typeGuide->id }}" selected>{{$typeGuide->name}}</option>
                                @else
                                    <option value="{{ $typeGuide->id }}">{{$typeGuide->name}}</option>
                                @endif
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
                    <button type="submit" class="btn btn-primary" >
                        Actualizar
                    </button>
                </div>
                <div class="col-12">
                    <a href="{{ route('guides.index') }}"> Volver a la Lista</a>
                </div>

            </form>
        </div>
    </div>


@endsection
