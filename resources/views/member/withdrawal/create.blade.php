@extends('member.layouts.master')
@section('title') Withdrawal Request @endsection

@section('content')
    @include('member.breadcrumbs', [
         'crumbs' => [
             'Withdrawal Request create'
         ]
    ])
    <form method="post" action="{{ route('member.withdrawals.store') }}">
        @csrf
        <div class="row">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="required">Number of Amount for Withdrawal Request </label><br>
                            <span class="text-danger">(Wallet Balance : {{ env('APP_CURRENCY')." ".Auth::user()->member->wallet_balance }})</span>
                            <input type="text" required autocomplete="off" name="amount" class="form-control" id="amount"
                                   oninput="validateNumber(this);"
                                   oninput="validity.valid||(value='');"
                                   placeholder="Enter Amount " value="{{old('amount')}}">
                            <div class="text-danger adminChargeAmount"></div>
                            <div class="text-danger tdsAmount"></div>
                            <div class="text-danger withdrawalAmount"></div>
                            @foreach($errors->get('amount') as $error)
                                <div class="text-danger code-error">{{ $error }}</div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="uil uil-message me-1"></i> Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('import-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css"/>
@endsection

@push('page-javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
    <script>
        var validNumber = new RegExp(/^\d*\.?\d*$/);
        var lastValid = document.getElementById("amount").value;

        function validateNumber(elem) {
            if (validNumber.test(elem.value)) {
                lastValid = elem.value;
            } else {
                elem.value = lastValid;
            }
        }
    </script>

    <script>
        $("body #amount").on('input', function () {
            let amount = $("#amount").val();
            let el = $('#amount');

            $.ajax({
                url: route('member.withdrawals.calculation'),
                data: {amount: amount},
                async: false,
                dataType: 'json',
                success: function (data) {
                    $('.withdrawalAmount').html('');
                    $('.adminChargeAmount').html('');
                    $('.tdsAmount').html('');
                    $('.code-error').html('');
                    if (data && data.tds > 0) {
                        $('.tdsAmount').html(
                            '<span class="help-block text-primary font-weight-bold">TDS Charge({{settings('tds_percent')}}%) : ' + data.tds + '</span>');
                    }
                    if (data && data.adminCharge > 0) {
                        $('.adminChargeAmount').html(
                            '<span class="help-block text-primary font-weight-bold">Admin Charge({{settings('admin_charge_percent')}}%) : ' + data.adminCharge + '</span>');
                    }
                    if (data && data.total > 0) {
                        $('.withdrawalAmount').html(
                            '<span class="help-block text-primary font-weight-bold">You Will Get Withdrawal : ' + data.total + '</span>');
                    }
                },
                error: function (jqXHR) {
                    $('.code-error').html('');
                    $('.tdsAmount').html('');
                    $('.adminChargeAmount').html('');
                    $('.withdrawalAmount').html('');
                    $('.withdrawalAmount').html(
                        '<span class="help-block text-danger font-weight-bold">Something went wrong, please try again</span>'
                    );
                },
            });
        });
    </script>
@endpush
