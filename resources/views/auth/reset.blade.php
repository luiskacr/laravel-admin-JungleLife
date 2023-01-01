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
                        <form action="{{ route('password.request') }}" method="post">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}" />
                            <input type="hidden" name="email" value="{{ $email }}" />

                            <div class="mb-3">
                                <label for="email"  class="form-label">{{ __('app.login_mail') }}</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="email"
                                    value="{{ $email }}"
                                    disabled
                                />
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">{{ __('app.login_pass') }}</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="password"
                                        id="password"
                                        class="form-control"
                                        name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password"
                                        autofocus
                                    />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>

                                </div>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">{{ __('app.login_pass.confirm') }}</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="password"
                                        id="password_confirmation"
                                        class="form-control"
                                        name="password_confirmation"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password"
                                    />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>

                                </div>
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
                                <button class="btn btn-primary d-grid w-100" type="submit">{{ __('app.confirm.reset.btn') }}</button>
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
{{-- -- }}
@push('page-scripts')
    <script>
        var myParam = location.search.split('email=')[1]
        var email = unescape(myParam).replace(/[+]/g, " ");
        document.getElementById('email').value=email;
        document.getElementById('email').disabled = true
    </script>
@endpush
--}}
