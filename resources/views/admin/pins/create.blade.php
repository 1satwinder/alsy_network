@extends('admin.layouts.master')

@section('title')
    Create Pin
@endsection

@section('content')
    @include('admin.breadcrumbs', [
         'crumbs' => [
             'Create Pins'
         ]
    ])
    <form method="post" action="{{ route('admin.pins.store') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <select name="package_id" id="package_id" class="form-control" data-toggle="select2"
                                            required>
                                        <option value="">Select Package</option>
                                        @foreach($packages as $package)
                                            <option value="{{ $package->id }}"
                                                {{ old('package_id') == $package->id ? 'selected' : ''}}
                                            >
                                                {{ $package->name }} ({{ env('APP_CURRENCY', ' र ') }}{{$package->amount}})
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="package_id">Package</label>
                                </div>
                                @foreach($errors->get('package_id') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" name="no_of_pins" class="form-control" id="no_of_pins"
                                           placeholder="How many pins to generate?" value="{{ old('no_of_pins') }}" required>
                                    <label for="no_of_pins" class="required">Number of Pins</label>
                                </div>
                                @foreach($errors->get('no_of_pins') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" required name="code" class="form-control memberCodeInput"
                                           placeholder="Whom to transfer the pins to?" value="{{ old('code') }}">
                                    <label for="account_number" class="required">Transfer To</label>
                                </div>
                                @foreach($errors->get('code') as $error)
                                    <span class="error text-danger memberName">{{ $error }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="text-sm-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="uil uil-message me-1"></i> Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
