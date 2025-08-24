@extends('member.layouts.master')

@section('title')
    Create Fund Request
@endsection

@section('content')
    @include('member.breadcrumbs', [
        'crumbs' => [
            'Create Fund Request',
        ]
   ])
    <form method="post" action="{{route('member.fund-requests.store') }}" class="filePondForm"
          onsubmit="pinSubmit.disabled = true; return true;">
        @csrf
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <p style="color: red">Fund Wallet Balance : <span
                                        class="text-success">{{ env('APP_CURRENCY','₹')." ".$member->fund_wallet_balance}}
                                </p>
                                <div class="form-group">
                                    <div class="form-floating form-floating-outline">
                                        <input id="amount" type="number" name="amount" class="form-control"
                                               value="{{ old('amount') }}" min="1" placeholder="Enter Amount" required>
                                        <label for="amount" class="required">Amount </label>
                                    </div>
                                    @foreach($errors->get('amount') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="form-floating form-floating-outline">
                                        <select id="bank_id" name="bank_id" class="form-control" required
                                                data-toggle="select2">
                                            <option value="">Select Bank</option>
                                            @foreach($banks as $bank)
                                                <option
                                                    value="{{ $bank->id }}" {{ old('bank_id') == $bank->id ? 'selected' : '' }}>
                                                    {{ $bank->name }} - {{ $bank->ac_number }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label class="required" for="bank_id">Bank</label>
                                    </div>
                                    @foreach($errors->get('bank_id') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="form-floating form-floating-outline">
                                        <select id="payment_mode" name="payment_mode" class="form-control"
                                                data-toggle="select2" required>
                                            <option value="">Select Payment Mode</option>
                                            @foreach($paymentModes as $value => $paymentMode)
                                                <option
                                                    value="{{ $value }}" {{ old('payment_mode') == $value ? 'selected' : '' }}>
                                                    {{ $paymentMode }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="payment_mode" class="required">Payment Mode</label>
                                    </div>
                                    @foreach($errors->get('payment_mode') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="form-floating form-floating-outline">
                                    <input id="transaction_no" type="text" name="transaction_no"
                                           class="form-control"
                                           value="{{ old('transaction_no') }}" min="1"
                                           placeholder="Enter Transaction Number" required>
                                        <label for="transaction_no" class="required">Transaction Number</label>
                                    </div>
                                    @foreach($errors->get('transaction_no') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="form-floating form-floating-outline">
                                        <input id="date" type="date" name="date" class="form-control" value="{{ old('date') }}"
                                               max="{{ now()->format('Y-m-d') }}">
                                        <label for="date" class="required">Deposit Date</label>
                                    </div>
                                    @foreach($errors->get('date') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="form-floating form-floating-outline">
                                        <input id="time" type="time" name="time" autocomplete="off" class="form-control"
                                               value="{{ old('time') }}" placeholder="Deposit Time">
                                        <label for="time" class="required">Deposit Time</label>
                                    </div>
                                    @foreach($errors->get('time') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="required">Upload Receipt</label>
                                    <input type="file" name="receipt" class="filePondInput" value="{{ old('image') }}"
                                           accept="image/*"
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
            @foreach($banks as $bank)
                <div class="col-lg-4 bankBlock" id="bankBlock{{ $bank->id }}" style="display: none">
                    <div class="card mb-2">
                        <div class="card-header">
                            <h4>Bank Details</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="d-flex align-items-center mb-3">
                                    <span class="fw-semibold mx-1">Bank Name :</span>
                                    <span> {{ $bank->name }}</span>
                                </li>
                                <li class="d-flex align-items-center mb-3">
                                    <span class="fw-semibold mx-1">Branch Name :</span>
                                    <span> {{ $bank->branch_name }}</span>
                                </li>
                                <li class="d-flex align-items-center mb-3">
                                    <span class="fw-semibold mx-1">Account Holder Name :</span>
                                    <span> {{ $bank->account_holder_name }}</span>
                                </li>
                                <li class="d-flex align-items-center mb-3">
                                    <span class="fw-semibold mx-1">Account Number :</span>
                                    <span> {{ $bank->ac_number }}</span>
                                </li>
                                <li class="d-flex align-items-center mb-3">
                                    <span class="fw-semibold mx-1">IFSC Code :</span>
                                    <span> {{ $bank->ifsc }}</span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <span class="fw-semibold mx-1">Account Type :</span>
                                    <span>  {{ \App\Models\Bank::TYPES[$bank->ac_type] }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @if($bank->upi_id || $bank->upi_mobile || $bank->company_mobile || $bank->paytm_number)
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="row">
                                    <ul class="list-unstyled mb-0">
                                        @if($bank->upi_id)
                                            <li class="d-flex align-items-center mb-3">
                                                <span class="fw-semibold mx-1">UPI ID :</span>
                                                <span>{{ $bank->upi_id }}</span>
                                            </li>
                                        @endif
                                        @if($bank->upi_number)
                                            <li class="d-flex align-items-center mb-3">
                                            <span
                                                class="fw-semibold mx-1">PHONE Pe / GOOGLE PAY / PAYTM MOBILE NUMBER :</span>
                                                <span>{{ $bank->upi_number }}</span>
                                            </li>
                                        @endif
                                        @if($bank->company_payment_department)
                                            <li class="d-flex align-items-center mb-3">
                                            <span
                                                class="fw-semibold mx-1">MOBILE NUM OF COMPANY PAYMENT DEPARTMENT :</span>
                                                <span>{{ $bank->company_payment_department }}</span>
                                            </li>
                                        @endif
                                        @if($bank->paytm_number)
                                            <li class="d-flex align-items-center">
                                                <span class="fw-semibold mx-1">Paytm Number :</span>
                                                <span>{{ $bank->paytm_number }}</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($bank->getFirstMediaUrl(\App\Models\Bank::MC_QR_CODE))
                        <div class="card mb-2">
                            <div class="card-body text-center">
                                <h4>QR Code</h4>
                                <a href="{{ $bank->getFirstMediaUrl(\App\Models\Bank::MC_QR_CODE) }}"
                                   class="image-popup" title="QR Code">
                                    <img src="{{ $bank->getFirstMediaUrl(\App\Models\Bank::MC_QR_CODE) }}"
                                         class="img-fluid" alt="">
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </form>
@endsection
@include('admin.layouts.filepond')
@push('page-javascript')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('.bankBlock').hide();

            @if($errors->any())
                bankId = {{ old('bank_id') }}
            $('#bankBlock' + bankId).show()
            @endif
        });

        $('#bank_id').change(function () {
            let bankId = $(this).val()
            $('.bankBlock').hide();

            $('#bankBlock' + bankId).show()
        });

        $('#cancel-btn').click(function () {
            Swal.fire({
                title: 'Do you want to Cancel?',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                confirmButtonColor: '#EA5455',
                denyButtonText: `No`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    window.location = '{{ route('member.fund-requests.index') }}'
                }
            })
        });
    </script>
    <script>
        $(document).ready(function () {
            $(".image-popup").magnificPopup({
                type: "image",
                closeOnContentClick: !1,
                closeBtnInside: !1,
                mainClass: "mfp-with-zoom mfp-img-mobile",
                image: {
                    verticalFit: !0, titleSrc: function (e) {
                        return e.el.attr("title")
                    }
                },
                gallery: {enabled: !0},
                zoom: {
                    enabled: !0, duration: 300, opener: function (e) {
                        return e.find("img")
                    }
                }
            })
        });
    </script>
@endpush
