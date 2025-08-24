<?php

namespace App\ListBuilders\Admin;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\TopUp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class GSTManagerListBuilder extends ListBuilder
{
    public static string $name = 'GST Manager';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        return self::buildQuery(
            TopUp::query(),
            $request
        );
    }

    public static function beforeDataTable(array $extras = [], ?Builder $query = null): string
    {
        return view('admin.gst.aggregates', [
            'amount' => $query->sum('gst_amount'),
        ]);
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
                name: 'Paid Amount',
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
        ];
    }
}
