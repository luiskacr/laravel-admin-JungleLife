@extends('admin.template')

@php
    $title = __('app.user');
    $breadcrumbs = [__('app.home')=> route('admin.home'),__('app.user')=> route('users.index'), __('app.crud_show') => false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.show_tittle',['object' =>  __('app.user_singular')]) }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">{{__('app.avatars')}}</label>
                        <br>
                        @php
                            if(auth()->user()->avatar == null){
                                $image = 'https://ui-avatars.com/api/?background=3B574B&color=fff&bold=true&name='.auth()->user()->name ;
                            }else{
                                $image =  asset(auth()->user()->avatar );
                            }
                        @endphp
                        <img src="{{$image}}" alt="Avatar" class="rounded-circle">
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">{{__('app.name')}}</label>
                        <input type="text" id="name" value="{{ $user->name }}" class="form-control "  name="name" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">{{__('app.email')}}</label>
                        <input type="text" id="name" value="{{ $user->email }}" class="form-control "  name="name" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">{{__('app.rol')}}</label>
                        <input type="text" id="name" value="{{ $user->getRoleNames()[0] ?? '' }}" class="form-control "  name="name" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">{{__('app.status')}}</label>
                        <br>
                        @if($user->active )
                            <span class="badge bg-label-success">{{ __('app.status_values.true') }}</span>
                        @else
                            <span class="badge bg-label-info">{{ __('app.status_values.false') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-12">
                    <a href="{{ route('users.index') }}">{{ __('app.go_index')}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
