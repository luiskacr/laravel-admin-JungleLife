@extends('auth.auth_template')

@php
    $title = "Reset"
@endphp

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="{{ route('login') }}" class="app-brand-link gap-2">
                                <img src="{{ asset('assets/images/logo2.png') }}"  width="160" height="130">
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">{{ __('app.reset_msg1') }}</h4>
                        <form action="{{ route('password.email') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('app.login_mail') }}</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="{{ __('app.login_mail') }}"
                                    autofocus
                                />

                            </div>
                            @if(Session::has('error'))
                                <div class="mb-3">
                                    <div class="alert alert-danger" role="alert">
                                        {{Session::get('error')}}
                                    </div>
                                </div>
                            @endif
                            @if(Session::has('status'))
                                <div class="mb-3">
                                    <div class="alert alert-primary" role="alert">
                                        {{Session::get('status')}}
                                    </div>
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">{{ __('app.reset_btn') }}</button>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('login') }}">
                                        <small>{{ __('app.reset_go_Login') }}</small>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>
@endsection
