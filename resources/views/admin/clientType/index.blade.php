@extends('admin.template')

@php
    $title = __('app.type_client');
    $breadcrumbs = [__('app.home')=> route('admin.home'),__('app.type_client')  => false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.type_client')  }}</h4>
                </div>
                <div class="float-end">
                    <a class="text-white" href="{{ route('type-client.create') }}">
                        <button class="btn btn-primary" type="button">
                            {{ __('app.create') }}
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-datatable  table-responsive">
            <table id="table"  class="datatables-basic table border-top dataTable no-footer dtr-column">
                <thead>
                    <tr>
                        <th>{{ __('app.id') }}</th>
                        <th>{{ __('app.name') }}</th>
                        <th>{{ __('app.price') }}</th>
                        <th>{{ __('app.crud_action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientTypes as $clientType)
                        <tr>
                            <th>{{ $clientType->id }}</th>
                            <th>{{ $clientType->name }}</th>
                            <th>${{ $clientType->rate }}</th>
                            <th>
                                <div class="justify-content-between">
                                    <a class="m-2" href="{{ route('type-client.show',$clientType->id) }}"><i class="bx bxs-show me-1"></i> {{ __('app.crud_show') }}</a>
                                    <a class="m-2" href="{{ route('type-client.edit',$clientType->id) }}"><i class="bx bx-edit-alt me-1"></i> {{ __('app.crud_edit') }}</a>
                                    <a class="m-2" href="#" onclick="deleteItem({{ $clientType->id}},
                                    {{ json_encode($clientType->name) }})">
                                        <i class="bx bx-trash me-1"></i> {{ __('app.crud_delete') }}</a>
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
            let route = '{{ route('type-client.destroy',0) }}';
            const f_route = route.slice(0,-1);

            Swal.fire({
                title: '{{ __('app.delete_title') }}',
                text: '{{ __('app.delete_text' ,['object'=> __('app.type_client_singular')]) }}  ' + name ,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#696cff',
                cancelButtonColor: '#d33',
                cancelButtonText: '{{ __('app.delete_cancelButtonText') }}',
                confirmButtonText: '{{ __('app.delete_confirmButtonText') }}'
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
                                title: '{{ __('app.delete_success_tittle') }}',
                                text: '{{ __('app.delete_success') }}',
                                icon: 'success',
                            }).then((result) => {
                                location.reload();
                            })
                        },
                        error: function (xhr){
                            Swal.fire(
                                '{{ __('app.delete_error') }}',
                                '{{ __('app.delete_error_text') }}',
                                'error'
                            )
                            @if(app()->hasDebugModeEnabled())
                                console.log(xhr.responseText)
                            @endif
                        },
                    });
                }
            })
        }
    </script>
@endpush
