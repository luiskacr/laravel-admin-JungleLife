@extends('admin.template')

@php
    $title = __('app.home');
    $breadcrumbs = [__('app.home')=> false ];
    $view = __('app.home');
@endphp


@section('content')

        <h1>
            Welcome Home
        </h1>

@endsection
