@extends('admin.template')

@php
    $title = __('app.profile');
    $breadcrumbs = [ __('app.home') => route('admin.home'),__('app.profile') =>  false];
@endphp

@section('content')
    <div class="row">

        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <div class="container-fluid">
                        <div class="float-start">
                            <h4>{{ __('app.profile') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="#" method="post" >
                        @csrf
                        @method('PUT')
                        <div class="col-12">
                            <div class="col-md-8 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="name">{{ __('app.name') }}</label>
                                <input type="text" id="name" value="{{ $user->name }}" class="form-control "  name="name" >
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="col-md-8 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="email">{{ __('app.email') }}</label>
                                <input type="text" id="email" value="{{ $user->email }}" class="form-control "  name="email" >
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" >{{ __('app.edit_btn') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <div class="container-fluid">
                        <div class="float-start">
                            <h4>{{ __('app.avatar') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="d-flex justify-content-center">
                        <div class="row">
                            <div class="col-12">
                                <div class="avatar avatar-lg me-2">
                                    @php
                                        if(auth()->user()->avatar == null){
                                            $image = 'https://ui-avatars.com/api/?background=3B574B&color=fff&bold=true&name='.auth()->user()->name ;
                                        }else{
                                            $image = auth()->user()->avatar;
                                        }
                                    @endphp
                                    <img src="{{$image}}" alt="Avatar" class="rounded-circle">
                                </div>
                            </div>
                        </div>
                        <div class="row">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <div class="container-fluid">
                        <div class="float-start">
                            <h4>{{ __('app.passwords') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="#" method="post" >
                        @csrf
                        @method('PUT')
                        <div class="col-12">
                            <div class="col-md-8 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="oldpassword">{{ __('app.old_passwords') }}</label>
                                <input type="password" id="oldpassword" value="{{ old('password') }}" class="form-control "  name="oldpassword" >
                            </div>
                            @error('oldpassword')
                            <div class="text-danger">
                                <div data-field="name">* {{$message}}</div>
                            </div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <div class="col-md-8 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="newpassword">{{ __('app.new_passwords') }}</label>
                                <input type="password" id="newpassword" value="{{ old('password') }}" class="form-control "  name="newpassword" >
                            </div>
                            @error('newpassword')
                            <div class="text-danger">
                                <div data-field="name">* {{$message}}</div>
                            </div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <div class="col-md-8 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="confpass">{{ __('app.confirm_passwords') }}</label>
                                <input type="password" id="confpass" value="{{ old('confpass') }}" class="form-control "  name="confpass" >
                            </div>
                            @error('confpass')
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
