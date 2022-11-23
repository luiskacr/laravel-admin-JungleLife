@extends('admin.template')

@php
    $title = "Tipos de Guias";
    $breadcrumbs = ['Inicio'=> route('admin.home'),'Tipo de Guias'=>false];
@endphp

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>Tipos de Guias</h4>
                </div>
                <div class="float-end">
                    <a class="text-white" href="{{ route('type-guides.create') }}">
                        <button class="btn btn-primary" type="button">
                            Crear
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-datatable  table-responsive">
            <table id="table" class="datatables-basic table border-top dataTable no-footer dtr-column">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($typesGuides as $typesGuide)
                    <tr>
                        <th>{{ $typesGuide->id }}</th>
                        <th>{{ $typesGuide->name }}</th>
                        <th>
                            <div class="justify-content-between">
                                <a class="m-2" href="{{ route('type-guides.show',$typesGuide->id) }}"><i class="bx bxs-show me-1"></i> Ver</a>
                                <a class="m-2" href="{{ route('type-guides.edit',$typesGuide->id) }}"><i class="bx bx-edit-alt me-1"></i> Editar</a>
                                <a class="m-2" href="#" onclick="deleteItem({{ $typesGuide->id}},
                                {{ json_encode($typesGuide->name) }})">
                                    <i class="bx bx-trash me-1"></i> Eliminar</a>
                            </div>
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection

@push('page-scripts')
    <script>

        function deleteItem(id, name){
            let token = '{{ csrf_token()  }}';
            let route = '{{ route('type-guides.destroy',0) }}';
            const f_route = route.slice(0,-1);

            Swal.fire({
                title: 'Esta seguro?',
                text: "Que desea eliminar el Tipo de Guia " + name ,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#696cff',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: f_route + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        data: {
                            "id": id,
                            "_token" : token
                        },
                        success: function (){
                            Swal.fire({
                                title: 'Eliminado !',
                                text: 'El Item ' + name + ' fue eliminado',
                                icon: 'success',
                            }).then((result) => {
                                location.reload();
                            })
                        },
                        error: function (xhr){
                            Swal.fire(
                                'Eliminado !',
                                'Hubo un error al eliminar el item' + name ,
                                'error'
                            )
                            console.log(xhr.responseText)
                        },
                    });
                }
            })
        }
    </script>
@endpush
