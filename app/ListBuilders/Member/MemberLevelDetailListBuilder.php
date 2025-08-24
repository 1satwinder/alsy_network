<?php

namespace App\ListBuilders\Member;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\Member;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MemberLevelDetailListBuilder extends ListBuilder
{
    public static string $name = 'Level Detail';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        if ($extras['level']) {
            $query = Member::with('user', 'sponsor')
                ->where('sponsor_path', 'like', "{$extras['path']}/%")
                ->where('level', $extras['memberLevel'] + $extras['level'])
                ->orderByDesc('id');
        } else {
            $query = Member::with('user', 'sponsor')
                ->where('sponsor_path', 'like', "{$extras['path']}/%")
                ->orderByDesc('id');
        }

        return self::buildQuery(
            $query,
            $request
        );
    }

    public static function columns(): array
    {
        return [
            new ListBuilderColumn(
                name: 'Joining Date',
                property: 'created_at',
                filterType: ListBuilderColumn::TYPE_DATE_RANGE,
            ),
            new ListBuilderColumn(
                name: 'Activation Date',
                property: 'activated_at',
                filterType: ListBuilderColumn::TYPE_DATE_RANGE,
            ),
            new ListBuilderColumn(
                name: 'Member ID',
                property: 'code',
                filterType: ListBuilderColumn::TYPE_TEXT,
                canCopy: true,
            ),
            new ListBuilderColumn(
                name: 'Member Name',
                property: 'user.name',
                filterType: ListBuilderColumn::TYPE_TEXT
            ),
            new ListBuilderColumn(
                name: 'Sponsor ID',
                property: 'sponsor.code',
                filterType: ListBuilderColumn::TYPE_TEXT,
                canCopy: true,
            ),
            new ListBuilderColumn(
                name: 'Status',
                property: 'status',
                filterType: ListBuilderColumn::TYPE_SELECT,
                view: 'member.reports.datatable.direct.status',
                options: Member::STATUSES,
                exportCallback: function ($model) {
                    return $model->present()->status();
                }
            ),
        ];
    }
}
