@extends('admin.template')

@php
    $title = __('app.tours_active');
    $breadcrumbs = [__('app.home')=> route('admin.home'),'Tours'=>false];
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
                    <th>{{ __('app.id') }}</th>
                    <th>{{ __('app.name') }}</th>
                    <th>{{ __('app.tour_states_singular') }}</th>
                    <th>{{ __('app.available_space') }}</th>
                    <th>{{ __('app.tour_type_singular') }}</th>
                    <th>{{ __('app.crud_action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tours as $tour)
                    <tr>
                        <th>{{ $tour->id }}</th>
                        <th>{{ $tour->title }}</th>
                        <th>{{ $tour->tourState->name }}</th>
                        <th>{{ $tour->availableSpace() }}</th>
                        <th>{{ $tour->tourType->name }}</th>

                        <th>
                            <div class="justify-content-between">
                                <a class="m-2" href="{{ route('tours.show',$tour->id) }}"><i class="bx bxs-show me-1"></i> {{ __('app.crud_show') }} </a>
                                <a class="m-2" href="{{ route('tours.edit',$tour->id) }}"><i class="bx bx-edit-alt me-1"></i> {{ __('app.crud_edit') }}</a>
                                <a class="m-2" href="#" onclick="deleteItem({{ $tour->id}},{{ json_encode($tour->title) }},
                                {{ json_encode(csrf_token())  }}, {{ json_encode(route('tours.destroy',0)) }})">
                                    <i class="bx bx-trash me-1"></i> {{ __('app.crud_delete') }}
                                </a>
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
