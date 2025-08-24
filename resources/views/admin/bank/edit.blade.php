@extends('admin.layouts.master')
@section('title')
    Update Bank Details
@endsection

@section('content')
    @include('admin.breadcrumbs', [
       'crumbs' => [
           'Update Bank Details'
       ]
   ])
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.banking.update',['id'=>$detail->id])}}" method="post" role="form"
                          enctype="multipart/form-data" class="filePondForm">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="name" class="form-control"
                                           value="{{ old('name',$detail->name) }}"
                                           placeholder="Enter Bank Name" required>
                                    <label class="required">Bank Name</label>
                                </div>
                                @foreach($errors->get('name') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>
                            <div class="form-group col-lg-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="branch_name" class="form-control"
                                           value="{{ old('branch_name',$detail->branch_name) }}"
                                           placeholder="Enter Branch Name" required>
                                    <label class="required">Branch Name</label>
                                </div>
                                @foreach($errors->get('branch_name') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>
                            <div class="form-group col-lg-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <select name="ac_type" class="form-control" required>
                                        <option value=""> Select Account Type</option>
                                        <option
                                            value="1" {{ old('ac_type',$detail->ac_type) == \App\Models\Bank::ACCOUNT_TYPE_SAVING ? 'selected' : ''}}>
                                            Saving
                                        </option>
                                        <option
                                            value="2" {{ old('ac_type',$detail->ac_type) == \App\Models\Bank::ACCOUNT_TYPE_CURRENT ? 'selected' : ''}}>
                                            Current
                                        </option>
                                    </select>
                                    <label class="required">Account Type</label>
                                </div>
                                @foreach($errors->get('ac_type') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>
                            <div class="form-group col-lg-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="account_holder_name" class="form-control"
                                           value="{{ old('account_holder_name', $detail->account_holder_name) }}"
                                           placeholder="Enter Account Holder Name" required>
                                    <label class="required">Account Holder Name</label>
                                </div>
                                @foreach($errors->get('account_holder_name') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>
                            <div class="form-group col-lg-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="ac_number" class="form-control"
                                           value="{{ old('ac_number',$detail->ac_number) }}"
                                           placeholder="Enter Account number" required>
                                    <label class="required">Account number</label>
                                </div>
                                @foreach($errors->get('ac_number') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>
                            <div class="form-group col-lg-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="ifsc" class="form-control"
                                           value="{{ old('ifsc',$detail->ifsc) }}"
                                           placeholder="Enter IFSC Code" required>
                                    <label class="required">IFSC Code</label>
                                </div>
                                @foreach($errors->get('ifsc') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="upi_number" id="upi_number" class="form-control"
                                           value="{{old('upi_number',$detail->upi_number)}}"
                                           placeholder="Enter UPI ID">
                                    <label for="upi_number">Phone pe | Gpay | Paytm Number</label>
                                </div>
                                @foreach($errors->get('upi_number') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="company_payment_department" id="company_mobile" class="form-control" value="{{old('company_payment_department',$detail->company_payment_department)}}"
                                           placeholder="Enter Mobile Number Of Company Payment Department">
                                    <label for="company_mobile" class="">Mobile Number Of Company Payment Department</label>
                                </div>
                                @foreach($errors->get('company_payment_department') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>
                            <div class="form-group col-lg-4 col-12 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="upi_id" class="form-control"
                                           value="{{old('upi_id',$detail->upi_id)}}"
                                           placeholder="Enter UPI ID">
                                    <label>UPI ID</label>
                                </div>
                                @foreach($errors->get('upi_id') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>
                            <div class="form-group col-lg-4 col-12 mb-3">
                                <label>QR Code</label>
                                <input type="file" class="filePondInput" name="qr_code"
                                       data-url="{{$detail->getFirstMediaUrl(\App\Models\Bank::MC_QR_CODE) }}"
                                       accept="image/*">
                                @foreach($errors->get('qr_code') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                            <div class="form-group col-lg-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <select name="status" class="form-control" data-toggle="select2" required>
                                        <option value=""> Select Status</option>
                                        <option
                                            value="1" {{ old('status',$detail->status) == \App\Models\Bank::STATUS_ACTIVE ? 'selected' : ''}}>
                                            Active
                                        </option>
                                        <option
                                            value="2" {{ old('status',$detail->status) == \App\Models\Bank::STATUS_INACTIVE ? 'selected' : ''}}>
                                            In-Active
                                        </option>
                                    </select>
                                    <label class="required">Status</label>
                                </div>
                                @foreach($errors->get('status') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>
                            <div class="form-group col-12 text-center">
                                <button class="btn btn-primary my-3">
                                    <i class="uil uil-message me-1"></i> Submit
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
