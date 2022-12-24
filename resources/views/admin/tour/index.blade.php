@extends('admin.template')

@php
    $title = "Guia";
    $breadcrumbs = ['Inicio'=> route('admin.home'),'Tours'=>false];
@endphp

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>Tours</h4>
                </div>
                <div class="float-end">
                    <a class="text-white" href="{{ route('tours.create') }}">
                        <button class="btn btn-primary" type="button">
                            {{ __('app.create') }}
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
                @foreach($tours as $tour)
                    <tr>
                        <th>{{ $tour->id }}</th>
                        <th>{{ $tour->name }}</th>

                        <th>
                            <div class="justify-content-between">
                                <a class="m-2" href="{{ route('guides.show',$tour->id) }}"><i class="bx bxs-show me-1"></i> Ver</a>
                                <a class="m-2" href="{{ route('guides.edit',$tour->id) }}"><i class="bx bx-edit-alt me-1"></i> Editar</a>
                                <a class="m-2" href="#" onclick="deleteItem({{ $tour->id}},
                                {{ json_encode($tour->name) }})">
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
            let route = '{{ route('tours.destroy',0) }}';
            const f_route = route.slice(0,-1);

            Swal.fire({
                title: 'Esta seguro?',
                text: "Que desea eliminar el Tour " + name ,
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
                                text: 'El Guia ' + name + ' fue eliminado',
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
