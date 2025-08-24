<?php

namespace App\ListBuilders\Admin;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\Package;
use App\Models\TopUp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TopUpListBuilder extends ListBuilder
{
    public static string $name = 'Top Up';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        $query = TopUp::with('member.user', 'package', 'toppedUp.user');

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
                canCopy: true,
            ),
            new ListBuilderColumn(
                name: 'Member Name',
                property: 'member.user.name',
                filterType: ListBuilderColumn::TYPE_TEXT
            ),
            new ListBuilderColumn(
                name: 'Package',
                property: 'package.name',
                dbColumn: 'package_id',
                filterType: ListBuilderColumn::TYPE_SELECT,
                options: Package::all()->mapWithKeys(fn (Package $package) => [$package->id => $package->present()->nameAndAmount()])->toArray(),
                exportCallback: function ($model) {
                    return $model->package?->present()->nameAndAmount();
                },
                viewCallback: function ($model) {
                    return $model->package?->present()->nameAndAmount();
                }
            ),
            new ListBuilderColumn(
                name: 'Package Amount',
                property: 'amount',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true,
            ),
            new ListBuilderColumn(
                name: 'PV',
                property: 'package.pv',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
            ),
            new ListBuilderColumn(
                name: 'Topped Up By',
                property: 'toppedUp.code',
                filterType: ListBuilderColumn::TYPE_TEXT,
                canCopy: true
            ),
            new ListBuilderColumn(
                name: 'Action',
                property: 'action',
                view: 'admin.reports.datatable.invoice',
                shouldExport: false,
            ),
        ];
    }
}
