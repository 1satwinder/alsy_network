<?php

namespace App\ListBuilders\Admin;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\Faq;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FaqListBuilder extends ListBuilder
{
    public static string $name = 'FAQs';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        return self::buildQuery(
            Faq::query(),
            $request
        );
    }

    public static function createUrl(): ?string
    {
        return route('admin.faqs.create');
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
                name: 'Action',
                property: 'action',
                view: 'admin.faqs.datatable.action',
                shouldExport: false,
            ),
            new ListBuilderColumn(
                name: 'Status',
                property: 'status',
                filterType: ListBuilderColumn::TYPE_SELECT,
                view: 'admin.faqs.datatable.status',
                options: Faq::STATUSES,
                exportCallback: function ($model) {
                    return $model->present()->status();
                }
            ),
            new ListBuilderColumn(
                name: 'Question',
                property: 'question',
                filterType: ListBuilderColumn::TYPE_TEXT,
                view: 'admin.faqs.datatable.question',
            ),
            new ListBuilderColumn(
                name: 'Answer',
                property: 'answer',
                filterType: ListBuilderColumn::TYPE_TEXT,
                view: 'admin.faqs.datatable.answer',
            ),
        ];
    }
}
