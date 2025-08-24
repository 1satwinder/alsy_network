<?php

namespace App\ListBuilders\Member;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\RewardBonusIncome;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class RewardBonusIncomeListBuilder extends ListBuilder
{
    public static string $name = 'Reward Bonus Income';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        $query = RewardBonusIncome::where('member_id', $extras['member_id']);

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
                name: 'Reward',
                property: 'reward',
                filterType: ListBuilderColumn::TYPE_TEXT,
            ),
            new ListBuilderColumn(
                name: 'Status',
                property: 'status',
                filterType: ListBuilderColumn::TYPE_SELECT,
                view: 'member.reports.datatable.reward.status',
                options: RewardBonusIncome::STATUSES,
                exportCallback: function ($model) {
                    return RewardBonusIncome::STATUSES[$model->status];
                }
            ),
        ];
    }
}
