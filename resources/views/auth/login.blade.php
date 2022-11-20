@extends('auth.auth_template')

@php
    $title = "Login"
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
                            <a href="index.html" class="app-brand-link gap-2">
                                <img src="{{ asset('assets/images/logo.jpg') }}"  width="80" height="80">
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Bienvenido a Jungle Life 👋</h4>
                        <p class="mb-4">Inicie sesión en su cuenta y comience la aventura</p>

                        <form action="/login" method="post">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Correo</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="Correo"
                                    autofocus
                                />

                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Contraseña</label>
                                    <a href="#">
                                        <small>Olvido la Contraseña?</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="password"
                                        id="password"
                                        class="form-control"
                                        name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password"
                                    />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>

                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember"  value="true" />
                                    <label class="form-check-label" for="remember-me"> Recordarme </label>
                                </div>
                            </div>

                            @if(Session::has('error'))
                                <div class="mb-3">
                                    <div class="alert alert-danger" role="alert">
                                        {{Session::get('error')}}
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
                                <button class="btn btn-primary d-grid w-100" type="submit">Ingresar</button>
                            </div>
                        </form>

                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>


@endsection
