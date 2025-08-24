<?php

namespace App\ListBuilders\Admin;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\GSTType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class GSTTypeListBuilder extends ListBuilder
{
    public static string $name = 'GST Types';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        return self::buildQuery(
            GSTType::query(),
            $request
        );
    }

    public static function createUrl(): ?string
    {
        return route('admin.gst-types.create');
    }

    public static function columns(): array
    {
        return [
            new ListBuilderColumn(
                name: 'Action',
                property: 'action',
                view: 'admin.gstTypes.datatable.action',
                shouldExport: false,
            ),
            new ListBuilderColumn(
                name: 'Date',
                property: 'created_at',
                filterType: ListBuilderColumn::TYPE_DATE_RANGE
            ),
            new ListBuilderColumn(
                name: 'HSN Code',
                property: 'hsn_code',
                filterType: ListBuilderColumn::TYPE_TEXT,
            ),
            new ListBuilderColumn(
                name: 'SGST (%)',
                property: 'sgst',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
            ),
            new ListBuilderColumn(
                name: 'CGST (%)',
                property: 'cgst',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
            ),
        ];
    }
}
