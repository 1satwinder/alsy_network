<?php

namespace App\ListBuilders\Admin;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\PhotoGallery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PhotoGalleryListBuilder extends ListBuilder
{
    public static string $name = 'Photo Gallery';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        $query = PhotoGallery::with('subImages', 'media');

        return self::buildQuery(
            $query,
            $request
        );
    }

    public static function createUrl(): ?string
    {
        return route('admin.photo-gallery.create');
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
                view: 'admin.photo-gallery.datatable.action',
                shouldExport: false,
            ),
            new ListBuilderColumn(
                name: 'Title',
                property: 'title',
                filterType: ListBuilderColumn::TYPE_TEXT,
            ),
            new ListBuilderColumn(
                name: 'Main Image',
                property: 'main_image',
                view: 'admin.photo-gallery.datatable.main-image',
                shouldExport: false,
            ),
            new ListBuilderColumn(
                name: 'Status',
                property: 'status',
                filterType: ListBuilderColumn::TYPE_SELECT,
                view: 'admin.photo-gallery.datatable.status',
                options: PhotoGallery::STATUSES,
                exportCallback: function ($model) {
                    return PhotoGallery::STATUSES[$model->status];
                }
            ),
        ];
    }
}
