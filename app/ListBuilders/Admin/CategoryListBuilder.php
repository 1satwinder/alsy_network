<?php

namespace App\ListBuilders\Admin;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CategoryListBuilder extends ListBuilder
{
    public static string $name = 'Category';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        $query = Category::withCount('children');

        if ($parent = Category::find($extras['parent_id'])) {
            $query->whereParentId($parent->id);
        } else {
            $query->whereNull('parent_id');
        }

        return self::buildQuery(
            $query,
            $request
        );
    }

    public static function createUrl(): ?string
    {
        return route('admin.categories.create');
    }

    public static function beforeDataTable(array $extras = [], ?Builder $query = null): string
    {
        return view('admin.category.status-change');
    }

    public static function columns(): array
    {
        return [
            new ListBuilderColumn(
                name: 'Action',
                property: 'action',
                view: 'admin.category.datatable.action',
                shouldExport: false,
            ),
            new ListBuilderColumn(
                name: 'Select',
                property: '#',
                view: 'admin.category.datatable.checkbox',
                shouldExport: false,
            ),
            new ListBuilderColumn(
                name: 'Date',
                property: 'created_at',
                filterType: ListBuilderColumn::TYPE_DATE_RANGE
            ),
            new ListBuilderColumn(
                name: 'Parent Name',
                property: 'parent.name',
                filterType: ListBuilderColumn::TYPE_TEXT,
            ),
            new ListBuilderColumn(
                name: 'Category Name',
                property: 'name',
                view: 'admin.category.datatable.name',
            ),
            new ListBuilderColumn(
                name: 'Status',
                property: 'status',
                filterType: ListBuilderColumn::TYPE_SELECT,
                view: 'admin.category.datatable.status',
                options: Category::STATUSES,
                exportCallback: function ($model) {
                    return $model->present()->status();
                }
            ),
        ];
    }
}
