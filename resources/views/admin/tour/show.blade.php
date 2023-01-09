@extends('admin.template')

@php
    $title = __('app.tour');
    $breadcrumbs = [__('app.home')=> route('admin.home'),'Tour'=> route('tours.index'), __('app.crud_show') => false];
@endphp

@section('content')
    {{ $tour }}
@endsection
