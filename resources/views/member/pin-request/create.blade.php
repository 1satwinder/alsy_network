@extends('member.layouts.master')

@section('title')
    Create Pin Request
@endsection

@section('content')
    @include('member.breadcrumbs', [
          'crumbs' => [
              'Create Pin Request'
          ]
     ])
    <form method="post" action="{{route('member.pin-requests.store') }}" class="filePondForm"
          onsubmit="pinSubmit.disabled = true; return true;">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group mb-lg-4 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <select id="Package" class="form-select" name="package_id" data-toggle="select2"
                                                required>
                                            <option value="">Select Package</option>
                                            @foreach($packages as $package)
                                                <option
                                                    value="{{ $package->id }}" {{ old('package_id') == $package->id ? 'selected' : '' }}>
                                                    {{ $package->name }}
                                                    <b>({{ env('APP_CURRENCY', ' र ') }} {{ $package->amount}})</b>
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="Package">Package</label>
                                    </div>
                                    @foreach($errors->get('package_id') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-lg-4 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input id="pin" type="number" name="no_pins" class="form-control"
                                               value="{{ old('no_pins') }}" min="1" placeholder="Enter Pin Quantity"
                                               required>
                                        <label for="pin" class="required">Pin Quantity</label>
                                    </div>
                                    @foreach($errors->get('no_pins') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group mb-lg-4 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <select id="payment_mode" class="form-select" name="payment_mode" data-toggle="select2"
                                                required>
                                            <option value="">Select Payment mode</option>
                                            @foreach($paymentModes as $value => $paymentMode)
                                                <option
                                                    value="{{ $value }}" {{ old('payment_mode') == $value ? 'selected' : '' }}>
                                                    {{ $paymentMode }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="payment_mode">Payment Mode</label>
                                    </div>
                                    @foreach($errors->get('payment_mode') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-lg-4 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <select id="bank_id" class="form-select" name="bank_id" data-toggle="select2"
                                                required>
                                            <option value="">Please Select Bank</option>
                                            @foreach($banks as $bank)
                                                <option
                                                    value="{{ $bank->id }}" {{ old('bank_id') == $bank->id ? 'selected' : '' }}>
                                                    {{ $bank->name }} - {{ $bank->ac_number }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="bank_id">Bank</label>
                                    </div>
                                    @foreach($errors->get('bank_id') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-lg-4 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input id="reference" type="text" name="reference_no" class="form-control"
                                               value="{{ old('reference_no') }}" placeholder="Transaction number"
                                               required>
                                        <label for="reference" class="required">Transaction number</label>
                                    </div>
                                    @foreach($errors->get('reference_no') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="form-floating form-floating-outline">
                                        <input id="date" type="date" name="date" class="form-control"
                                               value="{{ old('date') }}"
                                               max="{{ now()->format('Y-m-d') }}" required>
                                        <label for="date" class="required">Deposit Date </label>
                                    </div>
                                    @foreach($errors->get('date') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="form-floating form-floating-outline">
                                        <input id="time" type="time" name="time" autocomplete="off" class="form-control"
                                               value="{{ old('time') }}" placeholder="Deposit Time" required="">
                                        <label for="time" class="required">Deposit Time </label>
                                    </div>
                                    @foreach($errors->get('time') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="required">Upload Receipt</label>
                                    <input type="file" name="receipt" class="filePondInput" value="{{ old('image') }}"
                                           required>
                                    @foreach($errors->get('receipt') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary" type="submit" name="pinSubmit">
                                <i class="uil uil-message me-1"></i> Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@include('admin.layouts.filepond')

@push('page-javascript')
    <script>
        $("#basic-datepicker").flatpickr({
            maxDate: new Date(),
            defaultDate: ["{{ old('date') }}"],
        });
    </script>
@endpush
