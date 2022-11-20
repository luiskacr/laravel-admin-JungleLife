<!DOCTYPE html>

<html
    lang="en"
    class="light-style"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free"
>
<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>{{ $title }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts
    <link rel="stylesheet" href="{{asset('assets/icons/boxicons.css')}}" />
    -->

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('css/core.css' )}}" />
    <link rel="stylesheet" href="{{ asset('css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href=" {{ asset('vendor/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('js/config.js') }}"></script>
</head>

<body>
<!-- Content -->
<body>
    @yield('content')
</body>

<!-- / Content -->


<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{asset('vendor/jquery/jquery.js')}}"></script>
<script src="{{ asset('vendor/popper/popper.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.js' ) }}"></script>
<script src="{{ asset('js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->

<!-- Main JS -->
<script src="{{ asset('js/main.js') }}"></script>

<!-- Page JS -->

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
</body>
</html>
