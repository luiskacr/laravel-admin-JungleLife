@extends('admin.template')

@php
    $title = __('app.invoice');
    $breadcrumbs = [ __('app.home')=> route('admin.home'),__('app.invoice') =>false];
@endphp

@section('content')
    <style>
        #invoice-table_wrapper{
            padding: 22px;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.invoice') }}</h4>
                </div>
            </div>
        </div>
        <div class="card-datatable  table-responsive">
            {{ $dataTable->table() }}
        </div>
    </div>
@endsection

@push('page-scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    @include('admin.partials.delete')

    <script>
        function sendInvoice(route){

            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(route, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token
                },
                credentials: "same-origin",
            }).then(result =>  {

                if(result.status !== 200){
                    Swal.fire(
                        '{{ __('app.delete_error') }}',
                        '{{ __('app.delete_error_text') }}',
                        'error'
                    )

                }else{
                    result.json().then(value => {
                        Swal.fire({
                            title: '{{ __('app.success') }}',
                            text: value.message,
                            icon: 'success',
                        })
                    })
                }

            }).catch(error =>{
                Swal.fire(
                    '{{ __('app.delete_error') }}',
                    '{{ __('app.delete_error_text') }}',
                    'error'
                )
                @if( app()->hasDebugModeEnabled() )
                    console.log(error)
                @endif
            })
        }

    </script>
@endpush

