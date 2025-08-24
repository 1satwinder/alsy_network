<?php

namespace App\ListBuilders\Member;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\ReferralBonusIncome;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ReferralBonusIncomeListBuilder extends ListBuilder
{
    public static string $name = 'Referral Bonus Income';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        $query = ReferralBonusIncome::with('member.user', 'fromMember.user', 'walletTransaction')->where('member_id', $extras['member_id']);

        return self::buildQuery(
            $query,
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
                filterType: ListBuilderColumn::TYPE_TEXT
            ),
            new ListBuilderColumn(
                name: 'Amount',
                property: 'total',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true
            ),
            new ListBuilderColumn(
                name: 'Remark',
                property: 'walletTransaction.comment',
                filterType: ListBuilderColumn::TYPE_TEXT,
            ),
        ];
    }
}
