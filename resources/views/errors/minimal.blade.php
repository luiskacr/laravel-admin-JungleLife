<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}"/>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com"/>
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"/>

        <!-- Icons. Uncomment required icon fonts -->
        <link rel="stylesheet" href="{{asset('assets/icons/boxicons.css')}}"/>

        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ asset('css/core.css' )}}"/>
        <link rel="stylesheet" href="{{ asset('css/theme-default.css') }}" class="template-customizer-theme-css"/>
        <link rel="stylesheet" href="{{ asset('css/demo.css') }}"/>
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}"/>

        <style>
            .misc-wrapper {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                min-height: calc(100vh - (1.625rem * 2));
                text-align: center;
            }
            img{
                filter: brightness(1.1);
                mix-blend-mode: multiply;
            }
        </style>
    </head>
    <body >
        <div class="container-xxl container-p-y">
            <div class="misc-wrapper">
                <h2 class="mb-2 mx-2">@yield('code') | @yield('message')</h2>
                <div class="mt-3">
                    <img
                        src="{{ asset('assets/images/error.jpg') }}"
                        alt="page-misc-error-light"
                        width="500"
                        class="img-fluid"
                        data-app-dark-img="illustrations/page-misc-error-dark.png"
                        data-app-light-img="illustrations/page-misc-error-light.png"
                    />
                </div>
                <a href="{{ url('/') }}" class="btn btn-primary">Back to home</a>
            </div>
        </div>
    </body>
</html>
