@extends('admin.template')

@php
    $title = __('app.user');
    $breadcrumbs = [__('app.home')=> route('admin.home'),__('app.user')=> route('users.index'), __('app.crud_edit') => false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.edit_tittle',['object' =>  __('app.user_singular')]) }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('users.update',$user->id )  }}" method="post" >
                @csrf
                @method('PUT')
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">{{__('app.name')}}</label>
                        <input type="text" id="name" value="{{ $user->name }}" class="form-control "  name="name">
                        @error('name')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="email">{{__('app.email')}}</label>
                        <input type="text" id="email" value="{{ $user->email }}" class="form-control "  name="email">
                        @error('email')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="role">{{ __('app.rol') }}</label>
                        <select id="role"  class="form-select" name="role" >
                            @foreach($roles as $role)
                                @if($user->hasRole($role->name))
                                    <option value="{{ $role->id }}" selected>{{$role->name}}</option>
                                @else
                                    <option value="{{ $role->id }}">{{$role->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('role')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" name="status" type="checkbox" id="status" {{ $user->active ? 'checked' : ''}} >
                        <label class="form-label" for="status">{{ __('app.status') }}</label>
                        @error('status')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">{{ __('app.edit_btn') }}</button>
                </div>
                <div class="col-12">
                    <a href="{{ route('users.index') }}">{{ __('app.go_index')}}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
