@extends('admin.template')

@php
    $title = __('app.user');
    $breadcrumbs = [__('app.home') => route('admin.home'),__('app.user') =>false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{__('app.user')}}</h4>
                </div>
                <div class="float-end">
                    <a class="text-white" href="{{ route('users.create') }}">
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
                    <th>{{__('app.id')}}</th>
                    <th>{{__('app.name')}}</th>
                    <th>{{__('app.email')}}</th>
                    <th>{{__('app.rol')}}</th>
                    <th>{{__('app.status')}}</th>
                    <th>{{__('app.confirm.reset.btn')}}</th>
                    <th>{{__('app.crud_action')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <th>{{ $user->id }}</th>
                        <th>
                            <div class="d-flex justify-content-start align-items-center user-name">
                                <div class="avatar-wrapper">
                                    <div class="avatar avatar-sm me-3">
                                        @if($user->avatar == null)
                                            <img src="https://ui-avatars.com/api/?background=3B574B&color=fff&bold=true&name={{ $user->name }}" alt="Avatar" class="rounded-circle">
                                        @else
                                            <img src="{{ asset( $user->avatar ) }}" alt="Avatar" class="rounded-circle">
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="text-body text-truncate">
                                        {{ $user->name }}
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th>{{ $user->email }}</th>
                        <th>{{ $user->getRoleNames()[0] ?? '' }}</th>

                        <th>
                            @if($user->active )
                                <span class="badge bg-label-success">{{ __('app.status_values.true') }}</span>
                            @else
                                <span class="badge bg-label-info">{{ __('app.status_values.false') }}</span>
                            @endif
                        </th>
                        <th>
                            @if(!$user->active or auth()->user()->id == $user->id )
                                <button type="submit" class="btn btn-primary" disabled>{{ __('app.reset_msg1') }}</button>
                            @else
                                <button type="submit"
                                        onclick="resetPassword( {{ json_encode($user->id) }},{{ json_encode($user->name) }}, {{ json_encode(csrf_token())  }}, {{ json_encode( route('users.admin-reset',0) ) }} )"
                                        class="btn btn-primary">{{ __('app.reset_msg1') }}</button>
                            @endif
                        </th>
                        <th>
                            <div class="justify-content-between">
                                <a class="m-2" href="{{ route('users.show',$user->id) }}"><i class="bx bxs-show me-1"></i> {{ __('app.crud_show')}}</a>
                                <a class="m-2" href="{{ route('users.edit',$user->id) }}"><i class="bx bx-edit-alt me-1"></i> {{ __('app.crud_edit')}}</a>
                                @if( auth()->user()->id == $user->id )
                                    <a class="m-2 text-muted" href="javascript:void(0)" disabled="true"><i class="bx bx-trash me-1"></i>{{ __('app.crud_delete')}}</a>
                                @else
                                    <a class="m-2" href="#" onclick="deleteItem({{ $user->id}},{{ json_encode($user->name) }},
                                    {{ json_encode(csrf_token())  }},{{ json_encode(route('users.destroy',0)) }})">
                                        <i class="bx bx-trash me-1"></i>{{ __('app.crud_delete')}}</a>
                                @endif
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
    @include('admin.partials.delete')
    <script>
        function resetPassword(id, name, token, route){
            const f_route = route.slice(0, -1);
            Swal.fire({
                title: '{{ __('app.delete_title') }}',
                text: '{{ __('app.admin_reset_text' ) }}  ' + name,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: primaryColor.backgroundColor,
                cancelButtonColor: '#ff3e1d',
                cancelButtonText: '{{ __('app.delete_cancelButtonText') }}',
                confirmButtonText: '{{ __('app.delete_confirmButtonText') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: f_route + id,
                        type: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        data: {
                            "id": id,
                            "_token": token
                        },
                        success: function () {
                            Swal.fire({
                                title: '{{ __('app.admin_success_tittle') }}',
                                text: '{{ __('app.admin_success_message') }}',
                                icon: 'success',
                            }).then((result) => {
                               // location.reload();
                            })
                        },
                        error: function (xhr) {
                            Swal.fire(
                                '{{ __('app.delete_error') }}',
                                '{{ __('app.admin_error_message') }}',
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

