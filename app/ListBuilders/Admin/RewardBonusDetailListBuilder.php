<?php

namespace App\ListBuilders\Admin;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\RewardBonus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class RewardBonusDetailListBuilder extends ListBuilder
{
    public static string $name = 'Reward Bonus Detail';

    public static string $defaultSort = 'id';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        return self::buildQuery(
            RewardBonus::query(),
            $request
        );
    }

    public static function columns(): array
    {
        return [
            new ListBuilderColumn(
                name: 'Action',
                property: 'action',
                view: 'admin.reward-bonus.datatable.action',
                shouldExport: false,
            ),
            new ListBuilderColumn(
                name: 'Level',
                property: 'level',
                filterType: ListBuilderColumn::TYPE_TEXT
            ),
            new ListBuilderColumn(
                name: 'Active Member (Target)',
                property: 'target_active_member',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE
            ),
            new ListBuilderColumn(
                name: 'Reward',
                property: 'reward',
                filterType: ListBuilderColumn::TYPE_TEXT
            ),
        ];
    }
}
