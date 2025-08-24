<?php

namespace App\ListBuilders\Admin;

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
        $query = RewardBonusIncome::with('member.user');

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
                name: 'Member ID',
                property: 'member.code',
                filterType: ListBuilderColumn::TYPE_TEXT,
                canCopy: true
            ),
            new ListBuilderColumn(
                name: 'Member Name',
                property: 'member.user.name',
                filterType: ListBuilderColumn::TYPE_TEXT
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
                view: 'admin.reports.datatable.status',
                options: RewardBonusIncome::STATUSES,
                exportCallback: function ($model) {
                    return RewardBonusIncome::STATUSES[$model->status];
                }
            ),
        ];
    }
}
