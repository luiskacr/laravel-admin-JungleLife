@extends('admin.template')

@php
    $title = __('app.customer');
    $breadcrumbs = [__('app.home')=> route('admin.home'),__('app.customer')=> route('clients.index'), __('app.crud_edit') => false];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="container-fluid">
                <div class="float-start">
                    <h4>{{ __('app.edit_tittle',['object' =>  __('app.customer_single')]) }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('clients.update',$client->id) }}" method="post" >
                @csrf
                @method('PUT')
                <input name="id" value="{{ $client->id }}" hidden>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="name">{{__('app.name')}}</label>
                        <input type="text" id="name" value="{{ $client->name }}" class="form-control "  name="name" >
                        @error('name')
                            <div class="text-danger">
                                <div data-field="name">* {{$message}}</div>
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="email">{{__('app.email')}}</label>
                        <input type="text" id="email" value="{{ $client->email }}" class="form-control "  name="email" {{ $editEmail ? 'disabled': '' }} >
                        @error('email')
                            <div class="text-danger">
                                <div data-field="email">* {{$message}}</div>
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="telephone">{{__('app.telephone')}}</label>
                        <input type="text" id="telephone" value="{{ $client->telephone }}" class="form-control "  name="telephone" >
                        @error('telephone')
                            <div class="text-danger">
                                <div data-field="telephone">* {{$message}}</div>
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-md-6 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="clientType">{{ __('app.type_client_singular') }}</label>
                        <select id="clientType"  class="form-select" name="clientType" >
                            @foreach($clientTypes as $clientType)
                                @if($clientType->id == $client->clientType )
                                    <option value="{{ $clientType->id }}" selected>{{$clientType->name}}</option>
                                @else
                                    <option value="{{ $clientType->id }}">{{$clientType->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('clientType')
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
                    <a href="{{ route('clients.index') }}">{{ __('app.go_index')}}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('page-scripts')
    <script>

        document.getElementById('clientType').addEventListener('change' ,() =>{
            let clientType = Number(document.getElementById('clientType').value);
            let email = document.getElementById('email')

            if(email.disabled && clientType !== 2){
                email.disabled = false
            }else if( clientType === 2){
                email.disabled = true
            }
        })

    </script>
@endpush
