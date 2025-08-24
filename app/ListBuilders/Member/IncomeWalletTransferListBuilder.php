<?php

namespace App\ListBuilders\Member;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\IncomeWalletTransfer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class IncomeWalletTransferListBuilder extends ListBuilder
{
    public static string $name = 'Income Wallet Transfer';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        return self::buildQuery(
            IncomeWalletTransfer::with('member', 'walletTransactions')->where('member_id', $extras['member_id']),
            $request
        );
    }

    public static function createButtonName(): ?string
    {
        return 'Transfer';
    }

    public static function createUrl(): ?string
    {
        return route('member.income-wallet-transfer.create');
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
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true
            ),
            new ListBuilderColumn(
                name: 'Admin Charge',
                property: 'admin_charge',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true
            ),
            new ListBuilderColumn(
                name: 'Total',
                property: 'total',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true
            ),
            //            new ListBuilderColumn(
            //                name: 'Remark',
            //                property: 'walletTransactions.comment',
            //                filterType: ListBuilderColumn::TYPE_TEXT,
            //            ),
        ];
    }
}
