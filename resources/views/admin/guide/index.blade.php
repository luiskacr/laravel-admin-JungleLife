@extends('admin.template')

@php
    $title = __('app.guide');
    $breadcrumbs = [__('app.home')=> route('admin.home'),__('app.guide') => false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.guide') }}</h4>
                </div>
                <div class="float-end">
                    <a class="text-white" href="{{ route('guides.create') }}">
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
                    <th>{{ __('app.lastname') }}</th>
                    <th>{{ __('app.type_guides_singular') }}</th>
                    <th>{{ __('app.crud_action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($guides as $guide)
                    <tr>
                        <th>{{ $guide->id }}</th>
                        <th>{{ $guide->name }}</th>
                        <th>{{ $guide->lastName }}</th>
                        <th>{{ $guide->guidesType->name }}</th>
                        <th>
                            <div class="justify-content-between">
                                <a class="m-2" href="{{ route('guides.show',$guide->id) }}"><i class="bx bxs-show me-1"></i> {{ __('app.crud_show') }}</a>
                                <a class="m-2" href="{{ route('guides.edit',$guide->id) }}"><i class="bx bx-edit-alt me-1"></i> {{ __('app.crud_edit') }}</a>
                                <a class="m-2" href="#" onclick="deleteItem({{ $guide->id}},{{ json_encode($guide->name) }})">
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
            let route = '{{ route('guides.destroy',0) }}';
            const f_route = route.slice(0,-1);

            Swal.fire({
                title: '{{ __('app.delete_title') }}',
                text: '{{ __('app.delete_text' ,['object'=> __('app.guide_singular')]) }}  ' + name ,
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
