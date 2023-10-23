@extends('admin.template')

@php
    $title = __('app.report');
    $breadcrumbs = [__('app.home') => route('admin.home'),__('app.report') => route('reports.index'), __('app.report_credit_tittle') => false];
@endphp

@section('content')
    <style>
        .table .thead-light th {
            background-color: var(--main-color);
            color: white !important;
        }

        .loader {
            border: 16px solid #3B574B;
            border-top: 16px solid #4F7363;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 2s linear infinite;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{__('app.report_credit_tittle')}}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="row mt-5" id="card-loader">
                <div class="table-responsive">
                    <table id="dailyTable" class="table">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('app.invoice') }}</th>
                            <th scope="col">{{ __('app.date') }}</th>
                            <th scope="col">{{ __('app.money_type') }}</th>
                            <th scope="col">{{ __('app.total') }}</th>
                            <th scope="col">{{ __('app.customer_single') }}</th>
                        </tr>
                        </thead>
                        <tbody id="tableBody">
                        @if( empty($credits) )
                            <tr>
                                <th  colspan="6" >
                                    <div class="text-center" >
                                        {{ __('app.report_credit_empty_message') }}
                                    </div>
                                </th>
                            </tr>
                        @else
                            @php($count = 1)
                            @foreach($credits as $credit)
                                <tr>
                                    <th>{{ $count }}</th>
                                    <th> {{ $credit[ __('app.invoice') ] }}</th>
                                    <th> {{ $credit[ __('app.date') ] }}</th>
                                    <th> {{ $credit[ __('app.money_type') ] }}</th>
                                    <th> {{ $credit[ __('app.total') ] }}</th>
                                    <th> {{ $credit[ __('app.customer_single')] }}</th>
                                </tr>
                                @php($count++)
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="col-md-3 mt-3  fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                <div>
                    <button type="button" class="btn btn-primary" id="excelBtn"  onclick="getExcelReport()" disabled>{{ __('app.reports_export_excel') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    <script>
        let state = {{ is_null($credits) ? 'true' : 'false' }};
        let url = '{{ route('reports.credit.excel')  }}'
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function isDisableBtn(){
            if(!state){
                document.getElementById('excelBtn').disabled = false;
            }
        }

        function getExcelReport(){
            fetch(url,{
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token
                },
                credentials: "same-origin",
            }).then(response => response.blob())
                .then(blob => {
                    let name = '{{ __('app.report_credit_file') }}.xlsx'
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    a.download = name;
                    document.body.appendChild(a);

                    a.click();
                    URL.revokeObjectURL(url);
                })
                .catch(error =>{
                    Swal.fire(
                        '{{ __('app.delete_error') }}',
                        '{{ __('app.reports_file_error') }}',
                        'error'
                    )
                    @if( app()->hasDebugModeEnabled() )
                    console.log(error)
                    @endif
                });
        }


        isDisableBtn()

    </script>
@endpush
