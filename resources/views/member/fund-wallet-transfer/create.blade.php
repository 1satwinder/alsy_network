@extends('member.layouts.master')

@section('title')
    Fund Transfer
@endsection

@section('content')
    @include('member.breadcrumbs', [
        'crumbs' => [
            'Fund Transfer',
        ]
   ])
    <form method="post" action="{{route('member.fund-wallet-transfer.store') }}"
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
                                        Fund Wallet Balance : <b>{{ env('APP_CURRENCY')." ".$member->fund_wallet_balance}}</b>
                                    </span>
                                </p>
                                <div class="form-group">
                                    <label for="code" class="required">Member ID </label>
                                    <input id="code" type="text" name="code" class="form-control transferCodeInput"
                                           value="{{ old('code') }}" min="1" placeholder="Enter Member ID" required>
                                    @foreach($errors->get('code') as $error)
                                        <span class="text-danger transferName">{{ $error }}</span>
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label for="amount" class="required">Amount </label>
                                    <input id="amount" type="number" name="amount" class="form-control"
                                           value="{{ old('amount') }}" min="1" placeholder="Enter Amount" required>
                                    @foreach($errors->get('amount') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
{{--                                <div class="form-group">--}}
{{--                                    <div class="form-password-toggle">--}}
{{--                                        <div class="input-group input-group-merge">--}}
{{--                                            <div class="form-floating form-floating-outline">--}}
{{--                                                <input type="password" class="form-control" id="financial_password" name="financial_password"--}}
{{--                                                       required--}}
{{--                                                       placeholder="Enter Transaction Password">--}}
{{--                                                <label for="financial_password" class="required">Transaction Password</label>--}}
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
        $(document).ready(function () {
            @if(trim(old('code')))
            getMemberDetail('{{ old('code') }}')
            @endif
        })

        $(".transferCodeInput").keyup(function () {
            getMemberDetail($(".transferCodeInput").val())
        })

        function getMemberDetail(code){
            let el = $('.transferCodeInput');

            if (code.length >= 6) {
                $.ajax({
                    url: route('members.show', code),
                    data: {code: code},
                    async: false,
                    dataType: 'json',
                    success: function (data) {
                        el.siblings('.transferName').remove();
                        if (data) {
                            el.after('')

                            el.after(
                                '<div class="help-block transferName text-primary font-weight-bold">' + data.user.name + '</div>'
                            );
                        }
                    },
                    error: function(jqXHR) {
                        el.siblings('.transferName').remove();
                        el.after('')
                        if (jqXHR.status === 404) {
                            el.after(
                                '<div class="help-block transferName text-danger font-weight-bold">Member not found</div>'
                            );
                        } else {
                            el.after(
                                '<div class="help-block  text-danger font-weight-bold">Something went wrong, please try again.</div>'
                            );
                        }
                    },
                });
            }else {
                el.siblings('.transferName').remove();
                el.after('')
                if (code.length > 0) {
                    el.after(
                        '<span class="help-block transferName text-danger font-weight-bold">Member not found</span>'
                    );
                }
            }
        }
    </script>
@endpush
