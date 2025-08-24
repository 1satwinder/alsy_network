<?php

namespace App\ListBuilders\Admin;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\Country;
use App\Models\Inquiry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ContactInquiryListBuilder extends ListBuilder
{
    public static string $name = 'Contact Inquiries';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        $query = Inquiry::with('country');

        return self::buildQuery(
            $query,
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
                name: 'Country',
                property: 'country_id',
                filterType: ListBuilderColumn::TYPE_SELECT,
                options: Country::all()->mapWithKeys(function (Country $country) {
                    return [$country->id => $country->name];
                })->toArray(),
            ),
            new ListBuilderColumn(
                name: 'Name',
                property: 'name',
                filterType: ListBuilderColumn::TYPE_TEXT,
            ),
            new ListBuilderColumn(
                name: 'Email ID',
                property: 'email',
                filterType: ListBuilderColumn::TYPE_TEXT,
                canCopy: true
            ),
            new ListBuilderColumn(
                name: 'Mobile Number',
                property: 'mobile',
                filterType: ListBuilderColumn::TYPE_TEXT,
                canCopy: true
            ),
            new ListBuilderColumn(
                name: 'Message',
                property: 'message',
                filterType: ListBuilderColumn::TYPE_TEXT,
                view: 'admin.contact-inquiries.datatable.message',
            ),
        ];
    }
}
