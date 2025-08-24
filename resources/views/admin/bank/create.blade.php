@extends('admin.layouts.master')
@section('title') Create Bank Details @endsection

@section('content')
    @include('admin.breadcrumbs', [
        'crumbs' => [
            'Create Bank Details'
        ]
    ])
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.banking.store')}}" method="post" role="form" class="filePondForm">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}"
                                           placeholder="Enter Bank Name" required>
                                    <label for="name" class="required">Bank Name</label>
                                </div>
                                @foreach($errors->get('name') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="branch_name" id="branch_name" class="form-control" value="{{old('branch_name')}}"
                                           placeholder="Enter Branch Name" required>
                                    <label for="branch_name" class="required">Branch Name</label>
                                </div>
                                @foreach($errors->get('branch_name') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>

                            <div class="form-group col-lg-4 col-12 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <select name="ac_type" id="ac_type" class="form-control" data-toggle="select2" required="">
                                        <option value=""> Select Account Type</option>
                                        <option
                                            value="1" {{old('ac_type') == \App\Models\Bank::ACCOUNT_TYPE_SAVING ? 'selected' : ''}}>
                                            Saving
                                        </option>
                                        <option
                                            value="2" {{old('ac_type') == \App\Models\Bank::ACCOUNT_TYPE_CURRENT ? 'selected' : ''}}>
                                            Current
                                        </option>
                                    </select>
                                    <label for="ac_type" class="required">Account Type</label>
                                </div>
                                @foreach($errors->get('ac_type') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="account_holder_name" id="account_holder_name" class="form-control"
                                           value="{{old('account_holder_name')}}" placeholder="Enter Account Holder Name"
                                           required>
                                    <label for="account_holder_name" class="required">Account Holder Name</label>
                                </div>
                                @foreach($errors->get('account_holder_name') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="ac_number" id="ac_number" class="form-control" value="{{old('ac_number')}}"
                                           placeholder="Enter Account number"
                                           required>
                                    <label for="ac_number" class="required">Account number</label>
                                </div>
                                @foreach($errors->get('ac_number') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="ifsc" id="ifsc" class="form-control" value="{{old('ifsc')}}"
                                           placeholder="Enter IFSC Code" required>
                                    <label for="ifsc" class="required">IFSC Code</label>
                                </div>
                                @foreach($errors->get('ifsc') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="upi_number" id="upi_number" class="form-control" value="{{old('upi_number')}}"
                                           placeholder="Enter UPI ID">
                                    <label for="upi_number">Phone pe | Gpay | Paytm Number</label>
                                </div>
                                @foreach($errors->get('upi_number') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="company_payment_department" id="company_mobile" class="form-control" value="{{old('company_payment_department')}}"
                                           placeholder="Enter Mobile Number Of Company Payment Department">
                                    <label for="company_mobile" class="">Mobile Number Of Company Payment Department</label>
                                </div>
                                @foreach($errors->get('company_payment_department') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="upi_id" id="upi_id" class="form-control"
                                           value="{{old('upi_id')}}"
                                           placeholder="Enter UPI ID">
                                    <label for="upi_id">UPI ID</label>
                                </div>
                                @foreach($errors->get('upi_id') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>

                            <div class="form-group col-lg-4 col-12 mb-3">
                                <label>QR Code</label>
                                <input type="file" class="filePondInput" name="qr_code"
                                       accept="image/*">
                                @foreach($errors->get('qr_code') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>

                            <div class="form-group col-md-12 text-center">
                                <button class="btn btn-primary mt-2 mb-3" type="submit"><i class="uil uil-message me-1"></i>
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('admin.layouts.filepond')
