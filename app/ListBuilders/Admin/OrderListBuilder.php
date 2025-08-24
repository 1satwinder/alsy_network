<?php

namespace App\ListBuilders\Admin;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OrderListBuilder extends ListBuilder
{
    public static string $name = 'Orders';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        $query = Order::with('member.user');

        return self::buildQuery(
            $query,
            $request
        );
    }

    public static function beforeDataTable(array $extras = [], ?Builder $query = null): string
    {
        return view('admin.order.before-datatable', [
            'placed' => Order::whereType(Order::TYPE_CUSTOMER)->whereStatus(Order::STATUS_PLACED)->count(),
            'confirm' => Order::whereType(Order::TYPE_CUSTOMER)->whereStatus(Order::STATUS_CONFIRM)->count(),
            'manifest' => Order::whereType(Order::TYPE_CUSTOMER)->whereStatus(Order::STATUS_MANIFEST)->count(),
            'dispatch' => Order::whereType(Order::TYPE_CUSTOMER)->whereStatus(Order::STATUS_DISPATCH)->count(),
            'deliver' => Order::whereType(Order::TYPE_CUSTOMER)->whereStatus(Order::STATUS_DELIVER)->count(),
            'replace' => Order::whereType(Order::TYPE_CUSTOMER)->whereStatus(Order::STATUS_REPLACE)->count(),
            'statuses' => Order::STATUSES,
        ]);
    }

    public static function columns(): array
    {
        return [
            new ListBuilderColumn(
                name: '#',
                property: '#',
                view: 'admin.order.dataTable.status-action',
                shouldExport: false,
            ),
            new ListBuilderColumn(
                name: 'Action',
                property: 'action',
                view: 'admin.order.dataTable.action',
                shouldExport: false,
            ),
            new ListBuilderColumn(
                name: 'Invoice',
                property: 'invoice',
                view: 'admin.order.dataTable.invoice',
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
                name: 'Pay By',
                property: 'pay_by',
                filterType: ListBuilderColumn::TYPE_SELECT,
                options: Order::PAY_BY_STATUSES,
            ),
            new ListBuilderColumn(
                name: 'Payment Status',
                property: 'payment_status',
                filterType: ListBuilderColumn::TYPE_SELECT,
                options: Order::PAYMENT_STATUSES,
            ),
            new ListBuilderColumn(
                name: 'Status',
                property: 'status',
                filterType: ListBuilderColumn::TYPE_SELECT,
                options: Order::STATUSES,
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
                name: 'Total BV',
                property: 'total_bv',
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
                name: 'Total',
                property: 'total',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true
            ),
        ];
    }
}
