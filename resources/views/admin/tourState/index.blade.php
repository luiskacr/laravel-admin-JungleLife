@extends('admin.template')

@php
    $title = __('app.tour_states');
    $breadcrumbs = [ __('app.home')=> route('admin.home'),__('app.tour_states') =>false];
@endphp

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.tour_states') }}</h4>
                </div>
                <div class="float-end">
                    <a class="text-white" href="{{ route('tour-state.create') }}">
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
                    <th>{{ __('app.crud_action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($stateTours as $stateTour)
                    <tr>
                        <th>{{ $stateTour->id }}</th>
                        <th>{{ $stateTour->name }}</th>
                        <th>
                            <div class="justify-content-between">
                                <a class="m-2" href="{{ route('tour-state.show',$stateTour->id) }}"><i class="bx bxs-show me-1"></i>{{ __('app.crud_show') }}</a>
                                <a class="m-2" href="{{ route('tour-state.edit',$stateTour->id) }}"><i class="bx bx-edit-alt me-1"></i>{{ __('app.crud_edit') }}</a>
                                <a class="m-2" href="#" onclick="deleteItem({{ $stateTour->id}},{{ json_encode($stateTour->name) }})">
                                    <i class="bx bx-trash me-1"></i>{{ __('app.crud_delete') }}</a>
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
            let route = '{{ route('tour-state.destroy',0) }}';
            const f_route = route.slice(0,-1);

            Swal.fire({
                title: '{{ __('app.delete_title') }}',
                text: '{{ __('app.delete_text' ,['object'=> __('app.tour_states_singular')]) }}  ' + name ,
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
