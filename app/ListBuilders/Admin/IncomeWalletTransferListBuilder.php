<?php

namespace App\ListBuilders\Admin;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\IncomeWalletTransfer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class IncomeWalletTransferListBuilder extends ListBuilder
{
    public static string $name = 'Income Wallet Transfers';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        return self::buildQuery(
            IncomeWalletTransfer::with('member', 'walletTransactions'),
            $request
        );
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
                name: 'Member ID',
                property: 'member.code',
                filterType: ListBuilderColumn::TYPE_TEXT,
                canCopy: true
            ),
            new ListBuilderColumn(
                name: 'Member Name',
                property: 'member.user.name',
                filterType: ListBuilderColumn::TYPE_TEXT,
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
            new ListBuilderColumn(
                name: 'Remark',
                property: 'walletTransactions.comment',
                filterType: ListBuilderColumn::TYPE_TEXT,
            ),
        ];
    }
}
