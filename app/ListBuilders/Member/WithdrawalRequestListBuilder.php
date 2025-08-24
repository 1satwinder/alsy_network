<?php

namespace App\ListBuilders\Member;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\WithdrawalRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class WithdrawalRequestListBuilder extends ListBuilder
{
    public static string $name = 'Withdrawal Requests';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {

        $query = WithdrawalRequest::with('member')->where('member_id', $extras['member_id']);

        return self::buildQuery(
            $query,
            $request
        );
    }

    public static function createUrl(): ?string
    {
        return route('member.withdrawals.create');
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
                name: 'Status',
                property: 'status',
                filterType: ListBuilderColumn::TYPE_SELECT,
                view: 'member.withdrawal.datatable.status',
                options: WithdrawalRequest::STATUSES,
                exportCallback: function ($model) {
                    return WithdrawalRequest::STATUSES[$model->status];
                }
            ),
            //            new ListBuilderColumn(
            //                name: 'Amount',
            //                property: 'amount',
            //                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
            //                isCurrency: true
            //            ),
            //            new ListBuilderColumn(
            //                name: 'TDS',
            //                property: 'tds',
            //                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
            //                isCurrency: true
            //            ),
            new ListBuilderColumn(
                name: 'Total',
                property: 'total',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true
            ),
        ];
    }
}
