@extends('admin.template')

@php
    $title = __('app.tour_type');
    $breadcrumbs = [ __('app.home') => route('admin.home'),__('app.tour_type') => route('tour-type.index'), __('app.create') => false];
@endphp

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.create_tittle',['object' =>  __('app.tour_type_singular')]) }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('tour-type.store')  }}" method="post" >
                @csrf
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">{{ __('app.name') }}</label>
                        <input type="text" id="name" value="{{ old('name') }}" class="form-control "  name="name">
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
                        <select id="money"  class="form-select" name="money" >
                            <option value="0">{{ __('app.select_money_type') }}</option>
                            @foreach($moneyTypes as $moneyType)
                                <option value="{{ $moneyType->id }}">{{ $moneyType->name }}</option>
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


                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="fee1">{{ __('app.fee_1') }}</label>
                        <input type="number" id="fee1" value="{{ old('fee1') }}" class="form-control " name="fee1" min="0">
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
                        <input type="number" id="fee2" value="{{ old('fee2') }}" class="form-control " name="fee2" min="0">
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
                        <input type="number" id="fee3" value="{{ old('fee3') }}" class="form-control " name="fee3" min="0">
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
                        <input type="number" id="fee4" value="{{ old('fee4') }}" class="form-control " name="fee4" min="0">
                        @error('fee4')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div data-field="rate">{{ session('message') }}</div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">{{ __('app.create') }}</button>
                </div>
                <div class="col-12">
                    <a href="{{ route('tour-type.index') }}">{{ __('app.go_index')}}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
