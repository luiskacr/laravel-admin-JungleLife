@extends('admin.template')

@php
    $title = __('app.products');
    $breadcrumbs = [ __('app.home')=> route('admin.home'),__('app.products') => route('product.index'), __('app.crud_edit') => false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.create_tittle',['object' =>  __('app.products_singular')]) }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('product.update',$product->id)  }}" method="post" >
                @csrf
                @method('PUT')

                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">{{ __('app.name') }}</label>
                        <input type="text" id="name" value="{{ $product->name }}" class="form-control "  name="name">
                        @error('name')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>


                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="price">{{ __('app.price') }}</label>
                        <input  id="price" value="{{ $product->price }}" class="form-control " min="0" name="price"  >
                        @error('price')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="type">{{ __('app.product_type_singular') }}</label>
                        <select id="type"  class="form-select" name="type"  onchange="typeTourValidation()">
                            @foreach($types as $type)
                                @if($type->id == $product->type)
                                    <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                                @else
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('type')
                        <div class="text-danger">
                            <div data-field="name">* {{ $message }}</div>
                        </div>
                        @enderror
                    </div>

                    <div id="tourTypeSection" >
                        <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                            <label class="form-label" for="tourType">{{ __('app.tour_type_singular') }}</label>
                            <select id="tourType"  class="form-select" name="tourType" >
                                <option value="0">{{ __('app.select_tour_type') }}</option>
                                @foreach($tourTypes as $tourType)
                                    @if( $product->tourType == $tourType->id)
                                        <option value="{{ $tourType->id }}" selected>{{ $tourType->name }}</option>
                                    @else
                                        <option value="{{ $tourType->id }}">{{ $tourType->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('tourType')
                            <div class="text-danger">
                                <div data-field="name">* {{ $message }}</div>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="money">{{ __('app.money_type') }}</label>
                        <select id="money"  class="form-select" name="money" >
                            @foreach($moneyTypes as $moneyType)
                                @if($moneyType->id == $product->money )
                                    <option value="{{ $moneyType->id }}" selected>{{ $moneyType->name }}</option>
                                @else
                                    <option value="{{ $moneyType->id }}">{{ $moneyType->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('money')
                        <div class="text-danger">
                            <div data-field="name">* {{ $message }}</div>
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="description">{{ __('app.description') }}</label>
                        <input type="text" id="description" value="{{ $product->description }}" class="form-control "  name="description">
                        @error('description')
                        <div class="text-danger">
                            <div data-field="name">* {{$message}}</div>
                        </div>
                        @enderror
                    </div>

                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">{{ __('app.edit_btn') }}</button>
                </div>
                <div class="col-12">
                    <a href="{{ route('product.index') }}">{{ __('app.go_index')}}</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('page-scripts')
    <script>
        function typeTourValidation(){
            let select = document.getElementById('type').value;
            if(select === 1 || select === "1"){
                document.getElementById('tourTypeSection').style.display = ''
            }else{
                document.getElementById('tourTypeSection').style.display = 'none'
            }
        }

        typeTourValidation()

    </script>
@endpush

