<?php

namespace App\ListBuilders\Member;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OrderListBuilder extends ListBuilder
{
    public static string $name = 'Orders';

    public static array $breadCrumbs = [
        'Orders',
    ];

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        $query = Order::where('member_id', $extras['member_id']);

        return self::buildQuery(
            $query,
            $request
        );
    }

    public static function columns(): array
    {
        return [
            new ListBuilderColumn(
                name: 'Action',
                property: 'action',
                view: 'member.order.datatable.action',
                shouldExport: false,
            ),
            new ListBuilderColumn(
                name: 'Date',
                property: 'created_at',
                filterType: ListBuilderColumn::TYPE_DATE_RANGE
            ),
            new ListBuilderColumn(
                name: 'Order ID',
                property: 'order_no',
                filterType: ListBuilderColumn::TYPE_TEXT
            ),
            new ListBuilderColumn(
                name: 'Total Items',
                property: 'total_items',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE
            ),
            new ListBuilderColumn(
                name: 'Total Quantity',
                property: 'total_quantity',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE
            ),
            new ListBuilderColumn(
                name: 'Total MRP',
                property: 'total_mrp',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true
            ),
            new ListBuilderColumn(
                name: 'Total DP',
                property: 'total_dp',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true
            ),
            new ListBuilderColumn(
                name: 'Total BV',
                property: 'total_bv',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
            ),
            new ListBuilderColumn(
                name: 'Taxable Amount',
                property: 'total_taxable_value',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true
            ),
            new ListBuilderColumn(
                name: 'Total GST',
                property: 'total_gst_amount',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true
            ),
            new ListBuilderColumn(
                name: 'Total',
                property: 'total',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true
            ),
        ];
    }
}
