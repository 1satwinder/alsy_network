<?php

namespace App\ListBuilders\Member;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\Package;
use App\Models\TopUp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TopUpListBuilder extends ListBuilder
{
    public static string $name = 'Topup';

    public static array $breadCrumbs = [
        'Topup',
    ];

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        return self::buildQuery(
            TopUp::whereMemberId($extras['member_id']),
            $request
        );
    }

    public static function createUrl(): ?string
    {
        return route('member.topups.create');
    }

    public static function createButtonName(): ?string
    {
        return 'Topup';
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
                name: 'Invoice No',
                property: 'invoice_no',
                filterType: ListBuilderColumn::TYPE_TEXT,
            ),
            new ListBuilderColumn(
                name: 'Package',
                property: 'package.name',
                dbColumn: 'package_id',
                filterType: ListBuilderColumn::TYPE_SELECT,
                options: Package::all()->mapWithKeys(function (Package $package) {
                    return [$package->id => $package->present()->nameAndAmount()];
                })->toArray(),
                exportCallback: function ($model) {
                    return $model->package?->present()->nameAndAmount();
                },
                viewCallback: function ($model) {
                    return $model->package?->present()->nameAndAmount();
                }
            ),
            new ListBuilderColumn(
                name: 'PV',
                property: 'package.pv',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
            ),
            new ListBuilderColumn(
                name: 'Amount',
                property: 'amount',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true,
            ),
            new ListBuilderColumn(
                name: 'GST Amount',
                property: 'gst_amount',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true,
            ),
            new ListBuilderColumn(
                name: 'Topped Up By',
                property: 'toppedUp.code',
                filterType: ListBuilderColumn::TYPE_TEXT,
                canCopy: true
            ),
        ];
    }
}
