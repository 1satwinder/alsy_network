@extends('admin.layouts.master')
@section('title','Payout Details List')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mt-2">
                <div class="card-header bg-dark py-3 text-white">
                    <div class="card-widgets">
                        <a data-toggle="collapse" href="#filters" role="button" aria-expanded="{{ Agent::isMobile() ? 'true' : 'false'}}"
                           aria-controls="filters" class="{{ Agent::isMobile() ? 'collapsed' : ''}}">
                            <i class="uil uil-minus"></i>
                        </a>
                    </div>
                    <h5 class="card-title mb-0 text-white">Payouts Detail</h5>
                </div>
                <div id="filters" class="collapse {{ Agent::isMobile() ? '' : 'show'}}">
                    <div class="card-body">
                        <form action="{{ route('admin.payouts.details',$id) }}" id="filterForm">
                            <div class="row">
                                <div class="form-group col-sm-6 col-md-3 col-lg-2">
                                    <label>From Date</label>
                                    <input type="date" name="from_date" class="form-control"
                                           placeholder="From Date">
                                </div>
                                <div class="form-group col-sm-6 col-md-3 col-lg-2">
                                    <label>To Date</label>
                                    <input type="date" name="to_date" class="form-control"
                                           placeholder="To Date">
                                </div>
                                <div class="form-group col-sm-6 col-md-3 col-lg-2">
                                    <label>Member ID</label>
                                    <input type="text" name="member.code" class="form-control"
                                           placeholder="Member ID">
                                </div>
                                <div class="form-group col-sm-6 col-md-3 col-lg-2">
                                    <label>Member Name</label>
                                    <input type="text" name="member.user.name" class="form-control"
                                           placeholder="Member Name">
                                </div>
                                <div class="form-group col-sm-6 col-md-3 col-lg-2">
                                    <label>Bank Name</label>
                                    <input type="text" name="member.kyc.bank_name" class="form-control"
                                           placeholder="Bank Name">
                                </div>
                                <div class="form-group col-sm-6 col-md-3 col-lg-2">
                                    <label>Bank Branch Name</label>
                                    <input type="text" name="member.kyc.bank_branch" class="form-control"
                                           placeholder="Bank Branch Name">
                                </div>
                                <div class="form-group col-sm-6 col-md-3 col-lg-2">
                                    <label>IFSC Code</label>
                                    <input type="text" name="member.kyc.bank_ifsc" class="form-control"
                                           placeholder="IFSC Code">
                                </div>
                                <div class="form-group col-sm-6 col-md-3 col-lg-2">
                                    <label>Account Holder Name</label>
                                    <input type="text" name="member.kyc.account_name" class="form-control"
                                           placeholder="Account Holder Name">
                                </div>
                                <div class="form-group col-sm-6 col-md-3 col-lg-2">
                                    <label>Account Number</label>
                                    <input type="text" name="member.kyc.account_number" class="form-control"
                                           placeholder="Account Number">
                                </div>
                                <div class="form-group col-sm-6 col-md-3 col-lg-2">
                                    <label>Pan Card</label>
                                    <input type="text" name="member.kyc.pan_card" class="form-control"
                                           placeholder="Pan Card">
                                </div>
                                <div class="form-group col-sm-6 col-md-3 col-lg-2">
                                    <label>Admin Credit</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" name="min_admin_credit" class="form-control"
                                                   placeholder="Min">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" name="max_admin_credit" class="form-control"
                                                   placeholder="Max">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 col-md-3 col-lg-2">
                                    <label>Admin Debit</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" name="min_admin_debit" class="form-control"
                                                   placeholder="Min">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" name="max_admin_debit" class="form-control"
                                                   placeholder="Max">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 col-md-3 col-lg-2">
                                    <label>Amount</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" name="min_amount" class="form-control"
                                                   placeholder="Min">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" name="max_amount" class="form-control"
                                                   placeholder="Max">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 col-md-3 col-lg-2">
                                    <label>Admin Charge</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" name="min_admin_charge" class="form-control"
                                                   placeholder="Min">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" name="max_admin_charge" class="form-control"
                                                   placeholder="Max">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 col-md-3 col-lg-2">
                                    <label>Gross Amount</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" name="min_total" class="form-control"
                                                   placeholder="Min">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" name="max_total" class="form-control"
                                                   placeholder="Max">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 col-md-3 col-lg-2">
                                    <label>TDS</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" name="min_tds" class="form-control"
                                                   placeholder="Min">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" name="max_tds" class="form-control"
                                                   placeholder="Max">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 col-md-3 col-lg-2">
                                    <label>Payable Amount</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" name="min_payable_amount" class="form-control"
                                                   placeholder="Min">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" name="max_payable_amount" class="form-control"
                                                   placeholder="Max">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <a href="{{ route('admin.payouts.details',$id) }}"
                                       class="btn btn-danger waves-effect waves-light font-weight-bold">
                                        Reset
                                    </a>
                                    <button type="submit" name="filter" value="filter"
                                            onclick="shouldExport = false;"
                                            class="btn btn-primary waves-effect waves-light font-weight-bold">
                                        Apply Filter
                                    </button>
                                    <button type="submit" name="export" value="csv" onclick="shouldExport = true;"
                                            class="btn btn-secondary waves-effect waves-light font-weight-bold float-right">
                                        Export
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped" id="payoutMemberTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Member Id</th>
                                <th>Member Name</th>
                                <th>Bank Name</th>
                                <th>Bank Branch Name</th>
                                <th>IFSC Code</th>
                                <th>Account Holder Name</th>
                                <th>Account Number</th>
                                <th>Pan Card</th>
                                <th>Admin Credit ({{ env('APP_CURRENCY', ' र ') }})</th>
                                <th>Admin Debit ({{ env('APP_CURRENCY', ' र ') }})</th>
                                <th>Amount ({{ env('APP_CURRENCY', ' र ') }})</th>
                                <th>Admin Charge ({{ env('APP_CURRENCY', ' र ') }})</th>
                                <th>Gross Amount ({{ env('APP_CURRENCY', ' र ') }})</th>
                                <th>TDS ({{ env('APP_CURRENCY', ' र ') }})</th>
                                <th>Payable Amount ({{ env('APP_CURRENCY', ' र ') }})</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-javascript')
    <script>
        var dataTable = $('#payoutMemberTable').DataTable({
            ajax: {
                url: '{{ route('admin.payouts.details',$id) }}',
            },
            "columns": [
                {data: 'DT_RowIndex', width: '5%'},
                {name: "created_at", data: "created_at"},
                {name: "member.code", data: "member.code"},
                {name: "member.user.name", data: "member.user.name"},
                {name: "member.kyc.bank_name", data: "member.kyc.bank_name"},
                {name: "member.kyc.bank_branch", data: "member.kyc.bank_branch"},
                {name: "member.kyc.bank_ifsc", data: "member.kyc.bank_ifsc"},
                {name: "member.kyc.account_name", data: "member.kyc.account_name"},
                {name: "member.kyc.account_number", data: "member.kyc.account_number"},
                {name: "member.kyc.pan_card", data: "member.kyc.pan_card"},
                {name: "admin_credit", data: "admin_credit"},
                {name: "admin_debit", data: "admin_debit"},
                {name: "amount", data: "amount"},
                {name: "admin_charge", data: "admin_charge"},
                {name: "total", data: "total"},
                {name: "tds", data: "tds"},
                {name: "payable_amount", data: "payable_amount"},
            ]
        });
    </script>
@endpush

