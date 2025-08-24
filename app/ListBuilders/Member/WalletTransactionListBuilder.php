<?php

namespace App\ListBuilders\Member;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\WalletTransaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class WalletTransactionListBuilder extends ListBuilder
{
    public static string $name = 'Income Wallet Transactions';

    public static array $breadCrumbs = [
        'Wallet Transactions',
    ];

    public static function query(array $extras = [], ?Request $request = null): Builder
    {

        return self::buildQuery(
            WalletTransaction::whereMemberId($extras['member_id']),
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
                name: 'Total Amount',
                property: 'amount',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true,
            ),
            //            new ListBuilderColumn(
            //                name: 'Admin Charge',
            //                property: 'admin_charge',
            //                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
            //                isCurrency: true,
            //            ),
            //            new ListBuilderColumn(
            //                name: 'TDS',
            //                property: 'tds',
            //                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
            //                isCurrency: true,
            //            ),
            //            new ListBuilderColumn(
            //                name: 'Net Amount',
            //                property: 'total',
            //                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
            //                isCurrency: true,
            //            ),
            new ListBuilderColumn(
                name: 'Type',
                property: 'type',
                filterType: ListBuilderColumn::TYPE_SELECT,
                view: 'member.wallet-transactions.datatable.type',
                options: WalletTransaction::TYPES,
                exportCallback: function ($model) {
                    return $model->present()->type();
                }
            ),
            new ListBuilderColumn(
                name: 'Remark',
                property: 'comment',
                filterType: ListBuilderColumn::TYPE_TEXT,
            ),
        ];
    }
}
