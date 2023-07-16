@extends('admin.template')

@php
    $title = __('app.exchange');
    $breadcrumbs = [__('app.home')=> route('admin.home'),__('app.exchange')  => false];
@endphp


@section('content')
    <style>
        #exchangerate-table_wrapper{
            padding: 22px;
        }
    </style>
    <div class="card">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.exchange') }}</h4>
                </div>
                <div class="float-end">
                    <a class="text-white"  href="javascript:void(0)" onclick="forceNewExchangeRate()">
                        <button class="btn btn-primary" type="button">
                            {{ __('app.exchange_rate_force') }}
                        </button>
                    </a>
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
    <script>
        function forceNewExchangeRate(){
            const route = '{{ route('exchange-rate.search')}}';
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
            }).then(result  => {
                if(result.ok){
                    result.json().then(data =>{
                        successToast(data.message)
                        sleep(800).then(() => {
                             window.location.reload();
                        });
                    })
                }else{
                    Swal.fire(
                        '{{ __('app.delete_error') }}',
                        '{{ __('app.booking_error') }}',
                        'error'
                    )
                }
            }).catch(error =>{
                sleep(500).then(() => {
                    Swal.fire(
                        '{{ __('app.delete_error') }}',
                        '{{ __('app.booking_error') }}',
                        'error'
                    )
                });
            });
        }
    </script>
@endpush
