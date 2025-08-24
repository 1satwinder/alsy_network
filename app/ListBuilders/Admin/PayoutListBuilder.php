<?php

namespace App\ListBuilders\Admin;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\Payout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PayoutListBuilder extends ListBuilder
{
    public static string $name = 'Payouts';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        return self::buildQuery(
            Payout::query(),
            $request
        );
    }

    public static function beforeDataTable(array $extras = [], ?Builder $query = null): string
    {
        return view('admin.payouts.preview-button');
    }

    public static function columns(): array
    {
        return [
            new ListBuilderColumn(
                name: 'Action',
                property: 'action',
                view: 'admin.payouts.datatable.action',
                shouldExport: false,
            ),
            new ListBuilderColumn(
                name: 'Status',
                property: 'status',
                filterType: ListBuilderColumn::TYPE_SELECT,
                options: Payout::STATUSES,
            ),
            new ListBuilderColumn(
                name: 'Date',
                property: 'created_at',
                filterType: ListBuilderColumn::TYPE_DATE_RANGE
            ),
            new ListBuilderColumn(
                name: 'Referral Bonus Income',
                property: 'referral_bonus_income',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true,
            ),
            new ListBuilderColumn(
                name: 'Team Bonus Income',
                property: 'team_bonus_income',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true,
            ),
            new ListBuilderColumn(
                name: 'Magic Pool Bonus',
                property: 'magic_pool_bonus_income',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true,
            ),
            new ListBuilderColumn(
                name: 'Admin Credit',
                property: 'admin_credit',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true,
            ),
            new ListBuilderColumn(
                name: 'Admin Debit',
                property: 'admin_debit',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true,
            ),
            new ListBuilderColumn(
                name: 'Magic Pool Upgrade',
                property: 'magic_pool_upgrade',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true,
            ),
            new ListBuilderColumn(
                name: 'Transfer To Fund Wallet',
                property: 'transfer_to_fund_wallet',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true,
            ),
            new ListBuilderColumn(
                name: 'Amount',
                property: 'amount',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true,
            ),
            new ListBuilderColumn(
                name: 'Admin Charge',
                property: 'admin_charge',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true,
            ),
            new ListBuilderColumn(
                name: 'TDS',
                property: 'tds',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true,
            ),
            new ListBuilderColumn(
                name: 'Payable Amount',
                property: 'total',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true,
            ),
        ];
    }
}
