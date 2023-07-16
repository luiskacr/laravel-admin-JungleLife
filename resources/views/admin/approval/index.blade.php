@extends('admin.template')

@php
    $title = __('app.requests_for_increases');
    $breadcrumbs = [ __('app.home')=> route('admin.home'),__('app.requests_for_increases') =>false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.requests_for_increases') }}</h4>
                </div>
                <div class="float-end">
                    <a class="text-white" href="{{ route('approvals.create') }}">
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
                    <th>{{ __('app.tour') }}</th>
                    <th> {{ __('app.approve_user') }} </th>
                    <th> {{ __('app.approve_reviewer') }} </th>
                    <th> {{ __('app.status') }} </th>
                    <th>{{ __('app.crud_action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($approvals as $approval)
                    <tr>
                        <th>{{ $approval->id }}</th>
                        <th>{{ $approval->getTour->title }} </th>
                        <th>{{ $approval->getUser->name }} </th>
                        <th>{{ $approval->getApprover == null ? '' : $approval->getApprover->name }} </th>
                        <th>
                            @switch( $approval->state )
                                @case(1)
                                    <span class="badge rounded-pill bg-primary"> {{ $approval->getState->name }} </span>
                                    @break
                                @case(2)
                                    <span class="badge rounded-pill bg-danger"> {{ $approval->getState->name }} </span>
                                    @break
                                @case(3)
                                    <span class="badge rounded-pill bg-success"> {{ $approval->getState->name }} </span>
                                    @break
                                @case(4)
                                    <span class="badge rounded-pill bg-success"> {{ $approval->getState->name }} </span>
                                    @break
                                @default
                                    <span class="badge rounded-pill bg-secondary"> {{ $approval->getState->name }} </span>
                            @endswitch
                        </th>
                        <th>
                            <div class="justify-content-between">
                                <a class="m-2" href=""><i class="bx bxs-show me-1"></i>{{ __('app.crud_show') }}</a>
                                @if($approval->state == 1)
                                    <a class="m-2" href="{{ route('approvals.edit', $approval->id) }}"><i class="bx bx-edit-alt me-1"></i>{{ __('app.approval_edit') }}</a>
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
