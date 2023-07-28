<!DOCTYPE html>

<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="light-style"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free"
>
<head>
    <meta charset="utf-8"/>
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>{{ config('app.name') }} | {{ $title }}</title>

    <meta name="description" content=""/>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"/>

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{asset('assets/icons/boxicons.css')}}"/>
    <!-- Vendors CSS-->
    <link rel="stylesheet" href=" {{ asset('vendor/dataTables@1.13.5/datatables.css') }}"/>
    <link rel="stylesheet" href=" {{ asset('vendor/perfect-scrollbar/perfect-scrollbar.css') }}"/>
    <link rel="stylesheet" href=" {{ asset('vendor/flatpick@4.6.13/flatpickr.min.css') }}"/>
    <link rel="stylesheet" href=" {{ asset('vendor/select2@4.1.0/dist/css/select2.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/toastify/toastify.min.css') }}">
    <script type="text/javascript" src="{{ asset('vendor/toastify/toastify-js.js') }}"></script>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('css/core.css' )}}"/>
    <link rel="stylesheet" href="{{ asset('css/theme-default.css') }}" class="template-customizer-theme-css"/>
    <link rel="stylesheet" href="{{ asset('css/demo.css') }}"/>

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}"/>
    @stack('page-css')
    <!-- Helpers -->
    <script src="{{ asset('js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('js/config.js') }}"></script>
</head>

<body>
<div class="layout-wrapper layout-content-navbar ">
    @include('admin.partials.sidebar')
    <div class="layout-page">
        @include('admin.partials.navbar')
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                @include('admin.partials.breadcrumbs')
                @yield('content')
            </div>
        </div>
    </div>
</div>
@include('admin.partials.toast')

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('vendor/jquery/jquery.js')}}"></script>
<script src="{{ asset('vendor/popper/popper.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.js' ) }}"></script>
<script src="{{ asset('vendor/sweetAlert2/dist/sweetalert2.all.min.js' ) }}"></script>
<script src="{{ asset('js/menu.js') }}"></script>
<!-- end-build -->

<!-- Vendors JS -->
<script src="{{ asset('vendor/dataTables@1.13.5/datatables.min.js') }}"></script>
<script src="{{ asset('vendor/fullcalendar@6.0.2/dist/index.global.min.js') }}"></script>
<script src="{{ asset('vendor/fullcalendar@6.0.2/packages/core/locales-all.global.min.js') }}"></script>
<script src="{{ asset('vendor/fullcalendar@6.0.2/packages/bootstrap5/index.global.min.js') }}"></script>
<script src="{{ asset('vendor/flatpick@4.6.13/flatpickr.js') }}"></script>
<script src="{{ asset('vendor/flatpick@4.6.13/es.js') }}"></script>
<script src="{{ asset('vendor/select2@4.1.0/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('vendor/select2@4.1.0/dist/js/i18n/es.js') }}"></script>


<!-- Main JS -->
<script src="{{ asset('js/main.js') }}"></script>

<!-- Page JS -->
<script src="{{ asset('js/custom.js') }}"></script>
@stack('page-scripts')

</body>
</html>
