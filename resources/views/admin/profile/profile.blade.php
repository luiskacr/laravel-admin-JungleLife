@extends('admin.template')

@php
    $title = __('app.profile');
    $breadcrumbs = [ __('app.home') => route('admin.home'),__('app.profile') =>  false];
@endphp

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="container-fluid">
                        <div class="float-start">
                            <h4>{{ __('app.profile') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('myProfile.update',$user->id) }}" method="post" >
                        @csrf
                        @method('PUT')
                        <div class="col-12">
                            <div class="col-md-8 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="name">{{ __('app.name') }}</label>
                                <input type="text" id="name" value="{{ $user->name }}" class="form-control "  name="name" >
                            </div>
                            @error('name')
                            <div class="text-danger">
                                <div data-field="name">* {{$message}}</div>
                            </div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <div class="col-md-8 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="email">{{ __('app.email') }}</label>
                                <input type="text" id="email" value="{{ $user->email }}" class="form-control "  name="email" >
                            </div>
                            @error('email')
                            <div class="text-danger">
                                <div data-field="name">* {{$message}}</div>
                            </div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" >{{ __('app.edit_btn') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card">
                <div class="card-header">
                    <div class="container-fluid">
                        <div class="float-start">
                            <h4>{{ __('app.avatars') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body ">

                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-center">
                                <div class="avatar avatar-lg me-2">
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
                        </div>
                    </div>
                    <div class="row mt-3">
                        <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('myProfile.avatars',$user->id) }}" enctype="multipart/form-data" method="post">
                            @csrf
                            @method('PUT')
                            <div class="col-12">
                                <input class="form-control" type="file" name="avatar" />
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" >{{ __('app.edit_btn') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="container-fluid">
                        <div class="float-start">
                            <h4>{{ __('app.passwords') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('myProfile.password',$user->id) }}" method="post" >
                        @csrf
                        @method('PUT')
                        <div class="col-12">
                            <div class="col-md-8 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="current_password">{{ __('app.old_passwords') }}</label>
                                <input type="password" id="current_password " value="{{ old('password') }}" class="form-control "  name="current_password" >
                            </div>
                            @error('current_password')
                            <div class="text-danger">
                                <div data-field="name">* {{$message}}</div>
                            </div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <div class="col-md-8 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="new_password">{{ __('app.new_passwords') }}</label>
                                <input type="password" id="new_password" value="{{ old('new_password') }}" class="form-control "  name="new_password" >
                            </div>
                            @error('new_password')
                            <div class="text-danger">
                                <div data-field="name">* {{$message}}</div>
                            </div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <div class="col-md-8 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="new_confirm_password">{{ __('app.confirm_passwords') }}</label>
                                <input type="password" id="new_confirm_password" value="{{ old('new_confirm_password ') }}" class="form-control "  name="new_confirm_password" >
                            </div>
                            @error('new_confirm_password')
                            <div class="text-danger">
                                <div data-field="name">* {{$message}}</div>
                            </div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" >{{ __('app.edit_btn') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
