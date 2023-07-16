@extends('admin.template')

@php
    $title = __('app.home');
    $breadcrumbs = [__('app.home')=> false ];
    $view = __('app.home');
@endphp


@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>

        .loader {
            border: 16px solid #f3f3f3;
            border-top: 16px solid #3A554A;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

    </style>
    <div class="row">
        <div class="col-lg-8 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h3 class="card-title text-primary">{{ __('app.welcome_home') }} {{ auth()->user()->name }}! 🎉</h3>
                            <p class="mb-4">{{ $values['message'] }}</p>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('assets/images/man-with-laptop-light.png') }}" alt="View Badge User"  height="140">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                     <span class="badge bg-label-info rounded p-2">
                                        <i class='bx bx-dollar-circle  bx-sm' ></i>
                                    </span>
                                </div>
                            </div>
                            <span>{{ __('app.exchange_buy') }}</span>
                            <h3 class="card-title text-nowrap mb-1">₡{{ $values['buy'] }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                     <span class="badge bg-label-info rounded p-2">
                                        <i class='bx bxs-dollar-circle  bx-sm' ></i>
                                    </span>
                                </div>
                            </div>
                            <span>{{ __('app.exchange_sell') }}</span>
                            <h3 class="card-title text-nowrap mb-1">₡{{ $values['sell'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">{{ __('app.customer') }}</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="card-title mb-0 me-2">{{ $values['clients'] }}</h4>
                            </div>
                            <small>{{ __('app.data_all') }}</small>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-success rounded p-2">
                              <i class="bx bx-user bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">{{ __('app.tour') }}</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="card-title mb-0 me-2">{{ $values['tours'] }}</h4>
                            </div>
                            <small>{{ __('app.data_daily') }}</small>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-primary rounded p-2">
                              <i class="bx bx-trending-up bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">{{ __('app.welcome_invoice') }}</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="card-title mb-0 me-2">{{ $values['invoices'] }}</h4>
                            </div>
                            <small>{{ __('app.data_monthly') }}</small>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-warning rounded p-2">
                                <i class='bx bx-dollar bx-sm'></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">{{ __('app.welcome_web') }}</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="card-title mb-0 me-2">{{ $values['web'] }}</h4>
                            </div>
                            <small>{{ __('app.data_monthly') }}</small>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-secondary rounded p-2">
                                <i class='bx bx-world bx-sm' ></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6 col-lg-8 mb-4 mb-md-0">
            <div class="card">
                <div  class="table-responsive text-nowrap">
                    <table id="reportTable" class="table text-nowrap table-borderless">
                        <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Disponibles</th>
                            <th>Reservas</th>
                            <th>Guias asignados</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <tr class="m-5">
                                <th rowspan="4" colspan="4" >
                                    <div class="d-flex  justify-content-center">
                                        <div class="loader"></div>
                                    </div>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Total Balance</h5>
                </div>
                <div class="card-body" style="position: relative;">
                    <div class="d-flex justify-content-start">
                        <div class="d-flex pe-4">
                            <div class="me-3">
                                <span class="badge bg-label-warning p-2"><i class="bx bx-wallet text-warning"></i></span>
                            </div>
                            <div>
                                <h6 class="mb-0">$2.54k</h6>
                                <small>Wallet</small>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="me-3">
                                <span class="badge bg-label-secondary p-2"><i class="bx bx-dollar text-secondary"></i></span>
                            </div>
                            <div>
                                <h6 class="mb-0">$4.2k</h6>
                                <small>Paypal</small>
                            </div>
                        </div>
                    </div>
                    <div id="totalBalanceChart" class="border-bottom mb-3" style="min-height: 250px;"><div id="apexchartsavemdkael" class="apexcharts-canvas apexchartsavemdkael apexcharts-theme-light" style="width: 397px; height: 250px;"><svg id="SvgjsSvg4661" width="397" height="250" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg apexcharts-zoomable" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG4663" class="apexcharts-inner apexcharts-graphical" transform="translate(10, 20)"><defs id="SvgjsDefs4662"><clipPath id="gridRectMaskavemdkael"><rect id="SvgjsRect4668" width="383.0166664123535" height="187.157" x="-4" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskavemdkael"></clipPath><clipPath id="nonForecastMaskavemdkael"></clipPath><clipPath id="gridRectMarkerMaskavemdkael"><rect id="SvgjsRect4669" width="403.0166664123535" height="211.157" x="-14" y="-14" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><filter id="SvgjsFilter4686" filterUnits="userSpaceOnUse" width="200%" height="200%" x="-50%" y="-50%"><feFlood id="SvgjsFeFlood4687" flood-color="#ffab00" flood-opacity="0.15" result="SvgjsFeFlood4687Out" in="SourceGraphic"></feFlood><feComposite id="SvgjsFeComposite4688" in="SvgjsFeFlood4687Out" in2="SourceAlpha" operator="in" result="SvgjsFeComposite4688Out"></feComposite><feOffset id="SvgjsFeOffset4689" dx="5" dy="10" result="SvgjsFeOffset4689Out" in="SvgjsFeComposite4688Out"></feOffset><feGaussianBlur id="SvgjsFeGaussianBlur4690" stdDeviation="3 " result="SvgjsFeGaussianBlur4690Out" in="SvgjsFeOffset4689Out"></feGaussianBlur><feBlend id="SvgjsFeBlend4691" in="SourceGraphic" in2="SvgjsFeGaussianBlur4690Out" mode="normal" result="SvgjsFeBlend4691Out"></feBlend></filter></defs><line id="SvgjsLine4667" x1="0" y1="0" x2="0" y2="183.157" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="183.157" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><g id="SvgjsG4692" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG4693" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"><text id="SvgjsText4695" font-family="Helvetica, Arial, sans-serif" x="0" y="212.157" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a1acb8" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan4696">Jan</tspan><title>Jan</title></text><text id="SvgjsText4698" font-family="Helvetica, Arial, sans-serif" x="75.00333328247072" y="212.157" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a1acb8" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan4699">Feb</tspan><title>Feb</title></text><text id="SvgjsText4701" font-family="Helvetica, Arial, sans-serif" x="150.0066665649414" y="212.157" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a1acb8" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan4702">Mar</tspan><title>Mar</title></text><text id="SvgjsText4704" font-family="Helvetica, Arial, sans-serif" x="225.0099998474121" y="212.157" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a1acb8" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan4705">Apr</tspan><title>Apr</title></text><text id="SvgjsText4707" font-family="Helvetica, Arial, sans-serif" x="300.01333312988277" y="212.157" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a1acb8" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan4708">May</tspan><title>May</title></text><text id="SvgjsText4710" font-family="Helvetica, Arial, sans-serif" x="375.01666641235346" y="212.157" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a1acb8" class="apexcharts-text apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;"><tspan id="SvgjsTspan4711">Jun</tspan><title>Jun</title></text></g></g><g id="SvgjsG4714" class="apexcharts-grid"><g id="SvgjsG4715" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine4717" x1="0" y1="0" x2="375.0166664123535" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine4718" x1="0" y1="36.6314" x2="375.0166664123535" y2="36.6314" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine4719" x1="0" y1="73.2628" x2="375.0166664123535" y2="73.2628" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine4720" x1="0" y1="109.8942" x2="375.0166664123535" y2="109.8942" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine4721" x1="0" y1="146.5256" x2="375.0166664123535" y2="146.5256" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine4722" x1="0" y1="183.15699999999998" x2="375.0166664123535" y2="183.15699999999998" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG4716" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine4724" x1="0" y1="183.157" x2="375.0166664123535" y2="183.157" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine4723" x1="0" y1="1" x2="0" y2="183.157" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG4670" class="apexcharts-line-series apexcharts-plot-series"><g id="SvgjsG4671" class="apexcharts-series" seriesName="seriesx1" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath4685" d="M 0 156.049764C 26.251166648864746 156.049764 48.75216663360596 102.56792000000002 75.0033332824707 102.56792000000002C 101.25449993133546 102.56792000000002 123.75549991607667 139.19932 150.0066665649414 139.19932C 176.25783321380615 139.19932 198.75883319854736 54.947100000000006 225.0099998474121 54.947100000000006C 251.26116649627684 54.947100000000006 273.7621664810181 106.23106000000001 300.0133331298828 106.23106000000001C 326.26449977874756 106.23106000000001 348.7654997634888 25.641980000000018 375.0166664123535 25.641980000000018" fill="none" fill-opacity="1" stroke="rgba(255,171,0,0.85)" stroke-opacity="1" stroke-linecap="butt" stroke-width="4" stroke-dasharray="0" class="apexcharts-line" index="0" clip-path="url(#gridRectMaskavemdkael)" filter="url(#SvgjsFilter4686)" pathTo="M 0 156.049764C 26.251166648864746 156.049764 48.75216663360596 102.56792000000002 75.0033332824707 102.56792000000002C 101.25449993133546 102.56792000000002 123.75549991607667 139.19932 150.0066665649414 139.19932C 176.25783321380615 139.19932 198.75883319854736 54.947100000000006 225.0099998474121 54.947100000000006C 251.26116649627684 54.947100000000006 273.7621664810181 106.23106000000001 300.0133331298828 106.23106000000001C 326.26449977874756 106.23106000000001 348.7654997634888 25.641980000000018 375.0166664123535 25.641980000000018" pathFrom="M -1 256.4198L -1 256.4198L 75.0033332824707 256.4198L 150.0066665649414 256.4198L 225.0099998474121 256.4198L 300.0133331298828 256.4198L 375.0166664123535 256.4198"></path><g id="SvgjsG4672" class="apexcharts-series-markers-wrap" data:realIndex="0"><g id="SvgjsG4674" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskavemdkael)"><circle id="SvgjsCircle4675" r="6" cx="0" cy="156.049764" class="apexcharts-marker no-pointer-events w9p91ggov" stroke="transparent" fill="transparent" fill-opacity="1" stroke-width="4" stroke-opacity="0.9" rel="0" j="0" index="0" default-marker-size="6"></circle><circle id="SvgjsCircle4676" r="6" cx="75.0033332824707" cy="102.56792000000002" class="apexcharts-marker no-pointer-events wfrlgiyic" stroke="transparent" fill="transparent" fill-opacity="1" stroke-width="4" stroke-opacity="0.9" rel="1" j="1" index="0" default-marker-size="6"></circle></g><g id="SvgjsG4677" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskavemdkael)"><circle id="SvgjsCircle4678" r="6" cx="150.0066665649414" cy="139.19932" class="apexcharts-marker no-pointer-events wg5vilpzp" stroke="transparent" fill="transparent" fill-opacity="1" stroke-width="4" stroke-opacity="0.9" rel="2" j="2" index="0" default-marker-size="6"></circle></g><g id="SvgjsG4679" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskavemdkael)"><circle id="SvgjsCircle4680" r="6" cx="225.0099998474121" cy="54.947100000000006" class="apexcharts-marker no-pointer-events wbk9c0kbr" stroke="transparent" fill="transparent" fill-opacity="1" stroke-width="4" stroke-opacity="0.9" rel="3" j="3" index="0" default-marker-size="6"></circle></g><g id="SvgjsG4681" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskavemdkael)"><circle id="SvgjsCircle4682" r="6" cx="300.0133331298828" cy="106.23106000000001" class="apexcharts-marker no-pointer-events wdkve44o1f" stroke="transparent" fill="transparent" fill-opacity="1" stroke-width="4" stroke-opacity="0.9" rel="4" j="4" index="0" default-marker-size="6"></circle></g><g id="SvgjsG4683" class="apexcharts-series-markers" clip-path="url(#gridRectMarkerMaskavemdkael)"><circle id="SvgjsCircle4684" r="6" cx="375.0166664123535" cy="25.641980000000018" class="apexcharts-marker no-pointer-events w33ac16gn" stroke="#ffab00" fill="#ffffff" fill-opacity="1" stroke-width="4" stroke-opacity="0.9" rel="5" j="5" index="0" default-marker-size="6"></circle></g></g></g><g id="SvgjsG4673" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine4725" x1="0" y1="0" x2="375.0166664123535" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine4726" x1="0" y1="0" x2="375.0166664123535" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG4727" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG4728" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG4729" class="apexcharts-point-annotations"></g><rect id="SvgjsRect4730" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-zoom-rect"></rect><rect id="SvgjsRect4731" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe" class="apexcharts-selection-rect"></rect></g><rect id="SvgjsRect4666" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect><g id="SvgjsG4712" class="apexcharts-yaxis" rel="0" transform="translate(-8, 0)"><g id="SvgjsG4713" class="apexcharts-yaxis-texts-g"></g></g><g id="SvgjsG4664" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 125px;"></div><div class="apexcharts-tooltip apexcharts-theme-light"><div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div><div class="apexcharts-tooltip-series-group" style="order: 1;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 171, 0);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label"></span><span class="apexcharts-tooltip-text-y-value"></span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-xaxistooltip apexcharts-xaxistooltip-bottom apexcharts-theme-light"><div class="apexcharts-xaxistooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">You have done <span class="fw-bold">57.6%</span> more sales.<br>Check your new badge in your profile.</small>
                        <div>
                            <span class="badge bg-label-warning p-2"><i class="bx bx-chevron-right text-warning"></i></span>
                        </div>
                    </div>
                    <div class="resize-triggers"><div class="expand-trigger"><div style="width: 446px; height: 380px;"></div></div><div class="contract-trigger"></div></div></div>
            </div>
            -->
        </div>
    </div>
@endsection

@push('page-scripts')
    <script>

        async function SetTable() {
            const data = await getTableData();
            const reportTable = document.getElementById('reportTable');

            const tbody = document.querySelector('#reportTable tbody');
            tbody.innerHTML = "";

            for (const value  of Object.entries(data)) {

                let newRow = reportTable.querySelector('tbody').insertRow();
                let cell0 = newRow.insertCell(0)
                let cell1 = newRow.insertCell(1)
                let cell2 = newRow.insertCell(2)
                let cell3 = newRow.insertCell(3)

                cell0.innerHTML = value[1].name
                cell1.innerHTML = value[1].available
                cell2.innerHTML = value[1].reservations
                cell3.innerHTML = value[1].guides

            }
        }

        async function getTableData() {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const route = '{{ route('admin.tableReport') }}';

            const response = await fetch(route, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token
                },
                credentials: "same-origin"
            });
            return await response.json();
        }

        SetTable()
    </script>
@endpush

