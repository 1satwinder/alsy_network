<?php

namespace App\ListBuilders\Admin;

use App\ListBuilders\ListBuilder;
use App\ListBuilders\ListBuilderColumn;
use App\Models\SubPhotoGallery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SubPhotoGalleryListBuilder extends ListBuilder
{
    public static string $name = 'Sub Image Photo Gallery';

    public static function query(array $extras = [], ?Request $request = null): Builder
    {
        $query = SubPhotoGallery::with('photoGallery', 'media')->where('photo_gallery_id', $extras['photoGallery_id']);

        return self::buildQuery(
            $query,
            $request
        );
    }

    public static function createUrl(): ?string
    {
        return route('admin.sub-photo-gallery.create', request()->route('photoGallery'));
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
                name: 'Title',
                property: 'photoGallery.title',
                filterType: ListBuilderColumn::TYPE_TEXT,
            ),
            new ListBuilderColumn(
                name: 'Main Image',
                property: 'main_image',
                view: 'admin.sub-photo-gallery.datatable.main-image',
                shouldExport: false,
            ),
            new ListBuilderColumn(
                name: 'Status',
                property: 'status',
                filterType: ListBuilderColumn::TYPE_SELECT,
                view: 'admin.sub-photo-gallery.datatable.status',
                options: SubPhotoGallery::STATUSES,
                exportCallback: function ($model) {
                    return SubPhotoGallery::STATUSES[$model->status];
                }
            ),
            new ListBuilderColumn(
                name: 'Action',
                property: 'action',
                view: 'admin.sub-photo-gallery.datatable.action',
                shouldExport: false,
            ),
        ];
    }
}
