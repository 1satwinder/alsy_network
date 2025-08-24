<?php

namespace App\ListBuilders\Member;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\FundWalletTransfer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FundWalletTransferListBuilder extends ListBuilder
{
    public static string $name = 'Fund Wallet Transfer';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        return self::buildQuery(
            FundWalletTransfer::with('fromMember', 'toMember', 'fundWalletTransactions')
                ->where('from_member_id', $extras['member_id']),
            $request
        );
    }

    public static function createButtonName(): ?string
    {
        return 'Transfer';
    }

    public static function createUrl(): ?string
    {
        return route('member.fund-wallet-transfer.create');
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
