@extends('member.layouts.master')

@section('title')
    Income To Fund Wallet Transfer
@endsection

@section('content')
    @include('member.breadcrumbs', [
        'crumbs' => [
            'Income To Fund Wallet Transfer',
        ]
   ])
    <form method="post" action="{{route('member.income-wallet-transfer.store') }}" class="filePondForm"
          onsubmit="transferSubmit.disabled = true; return true;">
        @csrf
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <p>
                                    <span class="text-success">
                                        Income Wallet Balance : <b>{{  env('APP_CURRENCY', ' र ') }} {{ $member->wallet_balance}}</b>
                                    </span>
                                </p>
                                <div class="form-group">
                                    <label for="amount" class="required">Amount </label>
                                    <input id="amount" type="text" name="amount" class="form-control" oninput="validity.valid||(value='');"
                                           value="{{ old('amount') }}" min="1" placeholder="Enter Amount" required>
                                    <div class="text-danger calculateAmount"></div>
                                    @foreach($errors->get('amount') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
{{--                                <div class="form-group">--}}
{{--                                    <div class="form-password-toggle">--}}
{{--                                        <div class="input-group input-group-merge">--}}
{{--                                            <div class="form-floating form-floating-outline">--}}
{{--                                                <input type="password" class="form-control" id="financial_password"--}}
{{--                                                       name="financial_password"--}}
{{--                                                       required--}}
{{--                                                       placeholder="Enter Transaction Password">--}}
{{--                                                <label for="financial_password" class="required">Transaction--}}
{{--                                                    Password</label>--}}
{{--                                            </div>--}}
{{--                                            <span class="input-group-text cursor-pointer">--}}
{{--                                            <i class="mdi mdi-eye-off-outline"></i>--}}
{{--                                        </span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    @foreach($errors->get('financial_password') as $error)--}}
{{--                                        <div class="text-danger">{{ $error }}</div>--}}
{{--                                    @endforeach--}}
{{--                                </div>--}}
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary" type="submit" name="transferSubmit">
                                <i class="uil uil-message me-1"></i> Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('page-javascript')
    <script>

        function calculation() {
            let amount = $("#amount").val();
            let el = $('#amount');
            console.log(amount);
            if (amount > 0) {
                let adminCharge = ((amount * {{settings('admin_charge_percent')}}) / 100).toFixed(2);
                let total = (amount - adminCharge).toFixed(2);
                $('.calculateAmount').html(
                    '<span class="help-block text-primary font-weight-bold">Admin Charge : र ' + adminCharge + '</span><br>' +
                    '<span class="help-block text-primary font-weight-bold">Transfer Amount : र ' + total + '</span><br>'
                );
            } else {
                $('.calculateAmount').html('');
            }
        }

        $("body #amount").on('input', function () {
            calculation()
        });

        $(document).ready(function () {
            @if(old('amount'))
            calculation()
            @endif
        });
    </script>
@endpush
