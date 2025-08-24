<?php

namespace App\ListBuilders\Admin;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\KYC;
use App\Models\Member;
use App\Models\Package;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MemberListBuilder extends ListBuilder
{
    public static string $name = 'Members';

    public static string $defaultSort = 'id';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        return self::buildQuery(
            Member::query(),
            $request
        );
    }

    public static function columns(): array
    {
        return [
            new ListBuilderColumn(
                name: 'Action',
                property: 'action',
                view: 'admin.members.datatable.action',
                shouldExport: false,
            ),
            new ListBuilderColumn(
                name: 'Joining Date',
                property: 'created_at',
                filterType: ListBuilderColumn::TYPE_DATE_RANGE
            ),
            new ListBuilderColumn(
                name: 'Activation Date',
                property: 'activated_at',
                filterType: ListBuilderColumn::TYPE_DATE_RANGE
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
                filterType: ListBuilderColumn::TYPE_TEXT,
            ),
            new ListBuilderColumn(
                name: 'Mobile Number',
                property: 'user.mobile',
                filterType: ListBuilderColumn::TYPE_TEXT,
            ),
            new ListBuilderColumn(
                name: 'Income Wallet Balance',
                property: 'wallet_balance',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true,
            ),
            new ListBuilderColumn(
                name: 'Fund Wallet Balance',
                property: 'fund_wallet_balance',
                filterType: ListBuilderColumn::TYPE_NUMBER_RANGE,
                isCurrency: true,
            ),
            new ListBuilderColumn(
                name: 'Sponsor ID',
                property: 'sponsor.code',
                filterType: ListBuilderColumn::TYPE_TEXT,
                canCopy: true,
            ),
            new ListBuilderColumn(
                name: 'Sponsor Name',
                property: 'sponsor.user.name',
                filterType: ListBuilderColumn::TYPE_TEXT,
            ),
            new ListBuilderColumn(
                name: 'Sponsor Mobile Number',
                property: 'sponsor.user.mobile',
                filterType: ListBuilderColumn::TYPE_TEXT,
            ),
            new ListBuilderColumn(
                name: 'KYC',
                property: 'kyc.status',
                filterType: ListBuilderColumn::TYPE_SELECT,
                view: 'admin.members.datatable.kyc',
                options: KYC::STATUSES,
                exportCallback: function ($model) {
                    return $model->present()->kycStatus();
                }
            ),
            new ListBuilderColumn(
                name: 'Package',
                property: 'package.name',
                dbColumn: 'package_id',
                filterType: ListBuilderColumn::TYPE_SELECT,
                options: Package::all()->mapWithKeys(function (Package $package) {
                    return [$package->id => $package->name];
                })->toArray(),
                exportCallback: function ($model) {
                    return $model->package?->present()->nameAndAmount();
                },
                viewCallback: function ($model) {
                    return $model->package?->present()->nameAndAmount();
                }
            ),
            new ListBuilderColumn(
                name: 'Member Status',
                property: 'status',
                filterType: ListBuilderColumn::TYPE_SELECT,
                view: 'admin.members.datatable.status',
                options: Member::STATUSES,
                exportCallback: function ($model) {
                    return $model->present()->status();
                }
            ),
            new ListBuilderColumn(
                name: 'Member Paid',
                property: 'is_paid',
                filterType: ListBuilderColumn::TYPE_SELECT,
                options: Member::IS_PAID_STATUSES,
                exportCallback: function ($model) {
                    return $model->present()->isPaid();
                }
            ),
        ];
    }
}
