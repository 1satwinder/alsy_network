<?php

namespace App\ListBuilders\Admin;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\Bank;
use App\Models\FundRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FundRequestListBuilder extends ListBuilder
{
    public static string $name = 'Fund Requests';

    public static string $permissionPrefix = 'Fund Requests';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        $query = FundRequest::with('bank', 'media', 'member.user');

        return self::buildQuery(
            $query,
            $request
        );
    }

    public static function beforeDataTable(array $extras = [], ?Builder $query = null): string
    {
        return view('admin.fund-request.aggregates', [
            'amount' => $query->whereIn('status', [FundRequest::STATUS_APPROVED, FundRequest::STATUS_PENDING])->sum('amount'),
        ]);
    }

    public static function columns(): array
    {
        return [
            new ListBuilderColumn(
                name: 'Action',
                property: 'action',
                view: 'admin.fund-request.datatable.action',
                shouldExport: false,
            ),
            new ListBuilderColumn(
                name: 'Date',
                property: 'created_at',
                filterType: ListBuilderColumn::TYPE_DATE_RANGE
            ),
            new ListBuilderColumn(
                name: 'Status',
                property: 'status',
                filterType: ListBuilderColumn::TYPE_SELECT,
                view: 'admin.fund-request.datatable.status',
                options: FundRequest::STATUSES,
                exportCallback: function ($model) {
                    return FundRequest::STATUSES[$model->status];
                }
            ),
            new ListBuilderColumn(
                name: 'Admin Name',
                property: 'admin.name',
                filterType: ListBuilderColumn::TYPE_TEXT,
            ),
            new ListBuilderColumn(
                name: 'Member ID',
                property: 'member.code',
                filterType: ListBuilderColumn::TYPE_TEXT,
                canCopy: true,
            ),
            new ListBuilderColumn(
                name: 'Member Name',
                property: 'member.user.name',
                filterType: ListBuilderColumn::TYPE_TEXT
            ),

            new ListBuilderColumn(
                name: 'Amount',
                property: 'amount',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true
            ),
            new ListBuilderColumn(
                name: 'Bank',
                property: 'bank.name',
                dbColumn: 'bank_id',
                filterType: ListBuilderColumn::TYPE_SELECT,
                options: Bank::all()->mapWithKeys(function (Bank $bank) {
                    return [$bank->id => $bank->name];
                })->toArray(),
            ),
            new ListBuilderColumn(
                name: 'Payment Mode',
                property: 'payment_mode',
                filterType: ListBuilderColumn::TYPE_SELECT,
                options: FundRequest::PAYMENT_MODES,
            ),
            new ListBuilderColumn(
                name: 'Transaction Number',
                property: 'transaction_no',
                filterType: ListBuilderColumn::TYPE_TEXT,
            ),
            new ListBuilderColumn(
                name: 'Receipt',
                property: 'receipt',
                view: 'admin.fund-request.datatable.receipt',
                shouldExport: false,
            ),
            new ListBuilderColumn(
                name: 'Deposit Date',
                property: 'deposit_date',
                filterType: ListBuilderColumn::TYPE_DATE_RANGE
            ),
            new ListBuilderColumn(
                name: 'Reject Reason',
                property: 'remark',
                view: 'admin.fund-request.datatable.reject-reason',
            ),
        ];
    }
}
