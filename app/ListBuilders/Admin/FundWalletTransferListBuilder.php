<?php

namespace App\ListBuilders\Admin;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\FundWalletTransfer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FundWalletTransferListBuilder extends ListBuilder
{
    public static string $name = 'Fund Wallet Transfers';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        return self::buildQuery(
            FundWalletTransfer::with('fromMember', 'toMember', 'fundWalletTransactions'),
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
                name: 'From Member ID',
                property: 'fromMember.code',
                filterType: ListBuilderColumn::TYPE_TEXT,
                canCopy: true
            ),
            new ListBuilderColumn(
                name: 'From Member Name',
                property: 'fromMember.user.name',
                filterType: ListBuilderColumn::TYPE_TEXT,
            ),
            new ListBuilderColumn(
                name: 'To Member ID',
                property: 'toMember.code',
                filterType: ListBuilderColumn::TYPE_TEXT,
                canCopy: true
            ),
            new ListBuilderColumn(
                name: 'To Member Name',
                property: 'toMember.user.name',
                filterType: ListBuilderColumn::TYPE_TEXT,
            ),
            new ListBuilderColumn(
                name: 'Amount',
                property: 'amount',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true
            ),
        ];
    }
}
