<?php

namespace App\ListBuilders\Member;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\Bank;
use App\Models\FundRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FundRequestListBuilder extends ListBuilder
{
    public static string $name = 'Fund Requests';

    public static array $breadCrumbs = [
        'Fund Requests',
    ];

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        return self::buildQuery(
            FundRequest::whereMemberId($extras['member_id'])->with('bank', 'media'),
            $request
        );
    }

    public static function createUrl(): ?string
    {
        return route('member.fund-requests.create');
    }

    public static function createButtonName(): ?string
    {
        return 'Fund Request';
    }

    public static function columns(): array
    {
        return [
            new ListBuilderColumn(
                name: 'Date',
                property: 'created_at',
                filterType: ListBuilderColumn::TYPE_DATE_RANGE
            ),
            new ListBuilderColumn(
                name: 'Amount',
                property: 'amount',
                dbColumn: 'amount',
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
                filterType: ListBuilderColumn::TYPE_TEXT
            ),

            new ListBuilderColumn(
                name: 'Receipt',
                property: 'receipt',
                view: 'member.fund-request.datatable.receipt',
                shouldExport: false,
            ),
            new ListBuilderColumn(
                name: 'Status',
                property: 'status',
                filterType: ListBuilderColumn::TYPE_SELECT,
                view: 'member.fund-request.datatable.status',
                options: FundRequest::STATUSES,
                exportCallback: function ($model) {
                    return FundRequest::STATUSES[$model->status];
                }
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
