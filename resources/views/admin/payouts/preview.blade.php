@extends('admin.layouts.master')

@section('title','Payout Preview')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.payouts.store') }}" method="post">
                        @foreach($errors->get('memberIds') as $error)
                            <div class="text-danger my-1">
                                {{ $error }}
                            </div>
                        @endforeach
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="payoutTable">
                                <thead>
                                <tr>
                                    <th>Member ID</th>
                                    <th>Member Name</th>
                                    <th>Referral Bonus Income({{settings('APP_CURRENCY', ' र ')}})</th>
                                    <th>Team Bonus Income({{settings('APP_CURRENCY', ' र ')}})</th>
                                    <th>Magic Pool Bonus ({{settings('APP_CURRENCY', ' र ')}})</th>
                                    <th>Admin Credit ({{env('APP_CURRENCY', ' र ')}})</th>
                                    <th>Admin Debit ({{env('APP_CURRENCY', ' र ')}})</th>
                                    <th>Magic Pool Upgrade({{env('APP_CURRENCY', ' र ')}})</th>
                                    <th>Transfer To Fund Wallet ({{env('APP_CURRENCY', ' र ')}})</th>
                                    <th>Amount({{ settings('APP_CURRENCY') }})</th>
                                    <th>Admin Charge({{ settings('APP_CURRENCY') }})</th>
                                    <th>TDS({{ settings('APP_CURRENCY') }})</th>
                                    <th>Payable Amount({{ settings('APP_CURRENCY') }})</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($members as $member)
                                    <tr>
                                        <td> {{ $member->code }} </td>
                                        <td> {{ $member->name }} </td>
                                        <td> {{ settings('APP_CURRENCY').$member->referralBonusIncome }} </td>
                                        <td> {{ settings('APP_CURRENCY').$member->teamBonusIncome }} </td>
                                        <td> {{ settings('APP_CURRENCY').$member->magicPoolIncome }} </td>
                                        <td> {{ env('APP_CURRENCY', ' र ').round($member->adminCredit ,2) }} </td>
                                        <td> {{ env('APP_CURRENCY', ' र ').round($member->adminDebit ,2) }} </td>
                                        <td> {{ settings('APP_CURRENCY').$member->magicPoolUpgrade }} </td>
                                        <td> {{ env('APP_CURRENCY', ' र ').round($member->transferToFundWallet ,2) }} </td>
                                        <td> {{ settings('APP_CURRENCY').$member->amount }} </td>
                                        <td> {{ settings('APP_CURRENCY').$member->adminCharge }} </td>
                                        <td> {{ settings('APP_CURRENCY').$member->tds }} </td>
                                        <td> {{ settings('APP_CURRENCY').$member->payableAmount }} </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <b>Total</b>
                                    </td>
                                    <td>
                                        <b>{{ env('APP_CURRENCY').$totalPayableAmount }}</b>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

