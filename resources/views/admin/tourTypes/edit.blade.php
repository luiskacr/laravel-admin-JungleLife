@extends('admin.template')

@php
    $title = __('app.tour_type');
    $breadcrumbs = [ __('app.home') => route('admin.home'),__('app.tour_type') => route('tour-type.index'), __('app.crud_edit') => false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.edit_tittle',['object' =>  __('app.tour_type_singular')]) }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('tour-type.update',$tourType->id) }}" method="post" >
                @csrf
                @method('PUT')
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">{{__('app.name')}}</label>
                        <input type="text" id="name" value="{{ $tourType->name }}" class="form-control "  name="name" >
                        @error('name')
                            <div class="text-danger">
                                <div data-field="name">* {{$message}}</div>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="money">{{ __('app.money_type') }}</label>
                        <select id="money"  class="form-select" name="money" onchange="validateSymbol(this)" >
                            @foreach($moneyTypes as $moneyType)
                                @if($moneyType->id == $tourType->money )
                                    <option value="{{ $moneyType->id }}" data-currency="{{ $moneyType->symbol }}"  selected>{{ $moneyType->name }}</option>
                                @else
                                    <option value="{{ $moneyType->id }}" data-currency="{{ $moneyType->symbol }}">{{ $moneyType->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('money')
                        <div class="text-danger">
                            <div data-field="name">* {{ $message }}</div>
                        </div>
                        @enderror
                    </div>
                </div>

                <h5 class="mb-0 mt-4">{{ __('app.fee') }}</h5>

                @php($symbol = $tourType->moneyType->symbol)

                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="fee1">{{ __('app.fee_1') }}</label>
                        <div class="input-group">
                            <span class="input-group-text" id="symbol-fee1">{{$symbol}}</span>
                            <input type="number" id="fee1" value="{{ $tourType->fee1 }}" class="form-control " name="fee1" min="0">
                        </div>
                        @error('fee1')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="fee2">{{ __('app.fee_2') }}</label>
                        <div class="input-group">
                            <span class="input-group-text" id="symbol-fee2">{{ $symbol }}</span>
                            <input type="number" id="fee2" value="{{ $tourType->fee2 }}" class="form-control " name="fee2" min="0">
                        </div>
                        @error('fee2')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="fee3">{{ __('app.fee_3') }}</label>
                        <div class="input-group">
                            <span class="input-group-text" id="symbol-fee3">{{ $symbol }}</span>
                            <input type="number" id="fee3" value="{{ $tourType->fee3 }}" class="form-control " name="fee3" min="0">
                        </div>
                        @error('fee3')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="fee4">{{ __('app.fee_4') }}</label>
                        <div class="input-group">
                            <span class="input-group-text" id="symbol-fee4">{{ $symbol }}</span>
                            <input type="number" id="fee4" value="{{ $tourType->fee3 }}" class="form-control " name="fee4" min="0">
                        </div>
                        @error('fee4')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary" >{{ __('app.edit_btn') }}</button>
                </div>
                <div class="col-12">
                    <a href="{{ route('tour-type.index') }}">{{ __('app.go_index')}}</a>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('page-scripts')
    <script>

        function validateSymbol(select){
            const symbol = select.options[select.selectedIndex].getAttribute("data-currency");
             document.getElementById('symbol-fee1').innerHTML = symbol;
             document.getElementById('symbol-fee2').innerHTML = symbol;
             document.getElementById('symbol-fee3').innerHTML = symbol;
             document.getElementById('symbol-fee4').innerHTML = symbol;
        }

    </script>
@endpush

