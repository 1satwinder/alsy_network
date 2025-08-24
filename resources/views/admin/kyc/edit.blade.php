@extends('admin.layouts.master')

@section('title')
    Edit KYC Details
@endsection

@section('content')
    @include('admin.breadcrumbs', [
        'crumbTitle' => function () use ($kyc) {
            if ($kyc->isPending())
                $html = '<span class="btn btn-warning btn-sm">Pending</span>';
            else if ($kyc->isApproved())
                $html = '<span class="btn btn-success btn-sm">Approved</span>';
            else if ($kyc->isRejected())
                $html = '<span class="btn btn-danger btn-sm">Rejected</span>';

            return 'Edit KYC Details ('.$kyc->member->code.'): ' . $html;
        },
        'crumbs' => [
           'Edit KYC Details',
        ]
   ])

    <form action="{{ route('admin.kycs.update', $kyc) }}" class="filePondForm" method="post">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">{{strtoupper('Identity Information')}}</h5>
                        <div class="form-group mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" required name="pan_card" class="form-control"
                                       placeholder="Enter PAN Card"
                                       value="{{ old('pan_card', $kyc->pan_card) }}">
                                <label for="pan" class="required">PAN Card</label>
                            </div>
                            @foreach($errors->get('pan_card') as $error)
                                <span class="text-danger">{{ $error }}</span>
                            @endforeach
                        </div>

                        <div class="form-group mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" required name="aadhaar_card" class="form-control"
                                       placeholder="Enter Aadhaar Card"
                                       value="{{ old('aadhaar_card', $kyc->aadhaar_card) }}">
                                <label for="aadhaar" class="required">Aadhaar Card</label>
                            </div>
                            @foreach($errors->get('aadhaar_card') as $error)
                                <span class="text-danger">{{ $error }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="header-title"> {{strtoupper('Bank Information')}}</h5>

                        <div class="row">
                            <div class="form-group col-md-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" required name="account_name" class="form-control"
                                           placeholder="Enter Account Holder Name" id="Account"
                                           value="{{ old('account_name', $kyc->account_name) }}">
                                    <label for="Account" class="required">Account Holder Name </label>
                                </div>
                                @foreach($errors->get('account_name') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="account_number" class="form-control"
                                           placeholder="Enter Account Number" id="account_number"
                                           value="{{ old('account_number', $kyc->account_number) }}" required>
                                    <label for="account_number" class="required">Account Number</label>
                                </div>
                                @foreach($errors->get('account_number') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <select id="account_type" class="form-select" data-toggle="select2"
                                            name="account_type" required>
                                        @foreach($accountTypes as $value => $type)
                                            <option
                                                    value="{{ $value }}" {{ old('account_type', $kyc->account_type) == $value ? 'selected' : ''}}
                                            >
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="account_type">Account Type</label>
                                </div>
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="bank_ifsc" required class="form-control"
                                           placeholder="Enter IFSC Code" value="{{ old('bank_ifsc', $kyc->bank_ifsc) }}"
                                           id="bank_ifsc">
                                    <label for="bank_ifsc" class="required">IFSC Code</label>
                                    <span class="text-danger" id="bank_ifsc_error"></span>
                                </div>
                                @foreach($errors->get('bank_ifsc') as $error)
                                    <span class="text-danger backendError">{{ $error }}</span>
                                @endforeach
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="bank_name" required class="form-control"
                                           placeholder="Enter Bank Name" value="{{ old('bank_name', $kyc->bank_name) }}"
                                           id="bank_name"
                                    >
                                    <label for="bank_name" class="required">Bank Name </label>
                                </div>
                                @foreach($errors->get('bank_name') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" required name="bank_branch" class="form-control"
                                           placeholder="Enter Bank Branch"
                                           value="{{ old('bank_branch', $kyc->bank_branch) }}"
                                           id="bank_branch"
                                    >
                                    <label for="bank_branch" class="required">Bank Branch</label>
                                </div>
                                @foreach($errors->get('bank_branch') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">{{strtoupper('NOMINEE INFORMATION')}} </h5>
                        <div class="form-group mb-3">
                            <label class="required" for="example-input-small">Name</label>
                            <input type="text" required name="nominee_name" class="form-control"
                                   placeholder="Enter Nominee Name"
                                   value="{{ old('nominee_name', $kyc->nominee_name) }}">
                            @foreach($errors->get('nominee_name') as $error)
                                <span class="text-danger">{{ $error }}</span>
                            @endforeach
                        </div>
                        <div class="form-group mb-3">
                            <label class="required" for="example-input-small">Relation</label>
                            <input type="text" required name="nominee_relation" class="form-control"
                                   placeholder="Enter Nominee Relation"
                                   value="{{ old('nominee_relation', $kyc->nominee_relation) }}">
                            @foreach($errors->get('nominee_relation') as $error)
                                <span class="text-danger">{{ $error }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">{{strtoupper('Uploaded Documents')}} </h5>
                        <div class="row">
                            <div class="form-group mb-3 col-lg-3">
                                <label for="example-input-large">
                                    PAN Card Image <span class="text-danger">*</span>
                                </label>
                                <input type="file" class="filePondInput" name="pan_card_image"
                                       data-url="{{ $panCardImage }}"
                                       accept="image/*" required>
                                @foreach($errors->get('pan_card_image') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                            <div class="form-group mb-3 col-lg-3">
                                <label for="example-input-large">
                                    Aadhaar Card Front Image <span class="text-danger">*</span>
                                </label>
                                <input type="file" class="filePondInput" name="aadhaar_card_image"
                                       data-url="{{ $aadhaarCardImage }}" accept="image/*" required>
                                @foreach($errors->get('aadhaar_card_image') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                            <div class="form-group mb-3 col-lg-3">
                                <label for="example-input-large">
                                    Aadhaar Card Back Image <span class="text-danger">*</span>
                                </label>
                                <input type="file" class="filePondInput" name="aadhaar_card_back_image"
                                       data-url="{{ $aadhaarCardBackImage }}" accept="image/*" required>
                                @foreach($errors->get('aadhaar_card_back_image') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                            <div class="form-group mb-3 col-lg-3">
                                <label for="example-input-large">
                                    Cancel Cheque Or Bank PassBook Front Page Image
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="file" class="filePondInput" name="cancel_cheque_image"
                                       data-url="{{ $cancelChequeImage }}" accept="image/*" required>
                                @foreach($errors->get('cancel_cheque_image') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">
                    <i class="uil uil-message me-1"></i> Save
                </button>
            </div>
        </div>
    </form>
@endsection
@include('admin.layouts.filepond')

@push('page-javascript')
    <script>
        var bankIfsc = $('#bank_ifsc');
        var bankIfscError = $('#bank_ifsc_error');
        var bankName = $('#bank_name');
        var bankBranch = $('#bank_branch');

        bankIfsc.on('input', function () {
            var ifscCode = bankIfsc.val();

            if (ifscCode.length === 11) {
                $.ajax({
                    'url': 'https://ifsc.razorpay.com/' + ifscCode,
                    'success': function (res, status, xhr) {
                        if (xhr.status === 200) {
                            bankName.val(res.BANK);
                            bankBranch.val(res.BRANCH);
                            bankIfscError.html('');
                        }
                    }, 'error': function (xhr, status, error) {
                        if (xhr.status === 404) {
                            bankIfscError.siblings('.backendError').remove();
                            bankIfscError.html('Please enter a valid IFSC Code');
                        }
                    }
                })
            } else {
                bankName.val('');
                bankBranch.val('');
                bankIfscError.html('');
            }
        });
    </script>
@endpush
