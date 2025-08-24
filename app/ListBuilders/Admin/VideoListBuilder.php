<?php

namespace App\ListBuilders\Admin;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\Video;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class VideoListBuilder extends ListBuilder
{
    public static string $name = 'Videos';

    public static string $permissionPrefix = 'Website Setting';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        $query = Video::query();

        return self::buildQuery(
            $query,
            $request
        );
    }

    public static function createUrl(): ?string
    {
        return route('admin.video.create');
    }

    public static function beforeDataTable(array $extras = [], ?Builder $query = null): string
    {
        return view('admin.video.status-change');
    }

    public static function columns(): array
    {
        return [
            new ListBuilderColumn(
                name: 'Action',
                property: 'action',
                view: 'admin.video.datatable.action',
                shouldExport: false,
            ),
            new ListBuilderColumn(
                name: 'Select',
                property: '#',
                view: 'admin.video.datatable.checkbox',
                shouldExport: false,
            ),
            new ListBuilderColumn(
                name: 'Status',
                property: 'status',
                filterType: ListBuilderColumn::TYPE_SELECT,
                view: 'admin.video.datatable.status',
                options: Video::STATUSES,
                exportCallback: function ($model) {
                    return Video::STATUSES[$model->status];
                }
            ),
            new ListBuilderColumn(
                name: 'Date',
                property: 'created_at',
                filterType: ListBuilderColumn::TYPE_DATE_RANGE
            ),
            new ListBuilderColumn(
                name: 'Title',
                property: 'title',
                filterType: ListBuilderColumn::TYPE_TEXT,
            ),
            new ListBuilderColumn(
                name: 'Link',
                property: 'link',
                filterType: ListBuilderColumn::TYPE_TEXT,
            ),
            new ListBuilderColumn(
                name: 'Description',
                property: 'description',
                filterType: ListBuilderColumn::TYPE_TEXT,
                view: 'admin.video.datatable.data',
            ),
        ];
    }
}
