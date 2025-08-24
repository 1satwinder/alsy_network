<?php

namespace App\ListBuilders\Admin;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\KYC;
use App\Models\Package;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class KYCListBuilder extends ListBuilder
{
    public static string $name = 'KYCs';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        return self::buildQuery(
            KYC::with('admin', 'member.user'),
            $request
        );
    }

    public static function beforeDataTable(array $extras = [], ?Builder $query = null): string
    {
        return view('admin.kyc.aggregates', [
            'notAppliedCount' => KYC::notApplied()->count(),
            'pendingCount' => KYC::pending()->count(),
            'approvedCount' => KYC::approved()->count(),
            'rejectedCount' => KYC::rejected()->count(),
        ]);
    }

    public static function columns(): array
    {
        return [
            new ListBuilderColumn(
                name: 'Action',
                property: 'action',
                view: 'admin.kyc.datatable.action',
                shouldExport: false,
            ),
            new ListBuilderColumn(
                name: 'Status',
                property: 'status',
                filterType: ListBuilderColumn::TYPE_SELECT,
                view: 'admin.kyc.datatable.status',
                options: KYC::STATUSES,
                exportCallback: function ($model) {
                    return $model->present()->status();
                }
            ),
            new ListBuilderColumn(
                name: 'Register Date',
                property: 'created_at',
                filterType: ListBuilderColumn::TYPE_DATE_RANGE
            ),
            new ListBuilderColumn(
                name: 'Applied Date',
                property: 'applied_at',
                filterType: ListBuilderColumn::TYPE_DATE_RANGE
            ),
            new ListBuilderColumn(
                name: 'Admin Name',
                property: 'admin.name',
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
                name: 'Mobile',
                property: 'member.user.mobile',
                filterType: ListBuilderColumn::TYPE_TEXT
            ),
            new ListBuilderColumn(
                name: 'Package',
                property: 'member.package.name',
                dbColumn: 'member.package_id',
                filterType: ListBuilderColumn::TYPE_SELECT,
                options: Package::all()->mapWithKeys(function (Package $package) {
                    return [$package->id => $package->name];
                })->toArray(),
                exportCallback: function ($model) {
                    return $model->member->package->present()->nameAndAmount();
                }
            ),
            new ListBuilderColumn(
                name: 'PAN Card',
                property: 'pan_card',
                filterType: ListBuilderColumn::TYPE_TEXT
            ),
            new ListBuilderColumn(
                name: 'Aadhaar Card',
                property: 'aadhaar_card',
                filterType: ListBuilderColumn::TYPE_TEXT
            ),
            new ListBuilderColumn(
                name: 'Approved Date',
                property: 'approved_at',
                filterType: ListBuilderColumn::TYPE_DATE_RANGE
            ),
            new ListBuilderColumn(
                name: 'Rejected Date',
                property: 'rejected_at',
                filterType: ListBuilderColumn::TYPE_DATE_RANGE
            ),
            new ListBuilderColumn(
                name: 'Reject Reason',
                property: 'reason',
                filterType: ListBuilderColumn::TYPE_TEXT,
                view: 'admin.kyc.datatable.reason'
            ),
        ];
    }
}
