<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\PhotoGallery
 *
 * @property int $id
 * @property string $title
 * @property int $status 1: Active, 2: In-Active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Collection<int, \App\Models\SubPhotoGallery> $subImages
 * @property-read int|null $sub_images_count
 * @method static Builder|PhotoGallery fromDate(string $date)
 * @method static Builder|PhotoGallery newModelQuery()
 * @method static Builder|PhotoGallery newQuery()
 * @method static Builder|PhotoGallery query()
 * @method static Builder|PhotoGallery toDate(string $date)
 * @method static Builder|PhotoGallery whereCreatedAt($value)
 * @method static Builder|PhotoGallery whereId($value)
 * @method static Builder|PhotoGallery whereStatus($value)
 * @method static Builder|PhotoGallery whereTitle($value)
 * @method static Builder|PhotoGallery whereUpdatedAt($value)
 * @mixin Eloquent
 */
class PhotoGallery extends Model implements HasMedia
{
    use InteractsWithMedia;
    use PresentableTrait;

    const STATUS_ACTIVE = 1;

    const STATUS_INACTIVE = 2;

    const STATUSES = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In-Active',
    ];

    const MAIN_IMAGE = 'main_image_photo_gallery';

    protected $guarded = [];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MAIN_IMAGE)
            ->singleFile();
    }

    public function subImages()
    {
        return $this->hasMany(SubPhotoGallery::class);
    }

    public function scopeFromDate(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.created_at", '>=', $date);
    }

    public function scopeToDate(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.created_at", '<=', $date);
    }
}
