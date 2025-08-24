<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laracasts\Presenter\PresentableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\SubPhotoGallery
 *
 * @property int $id
 * @property int $photo_gallery_id
 * @property string|null $youtube_link
 * @property int $status 1: Active, 2: In-Active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\PhotoGallery $photoGallery
 * @method static Builder|SubPhotoGallery fromDate(string $date)
 * @method static Builder|SubPhotoGallery newModelQuery()
 * @method static Builder|SubPhotoGallery newQuery()
 * @method static Builder|SubPhotoGallery query()
 * @method static Builder|SubPhotoGallery toDate(string $date)
 * @method static Builder|SubPhotoGallery whereCreatedAt($value)
 * @method static Builder|SubPhotoGallery whereId($value)
 * @method static Builder|SubPhotoGallery wherePhotoGalleryId($value)
 * @method static Builder|SubPhotoGallery whereStatus($value)
 * @method static Builder|SubPhotoGallery whereUpdatedAt($value)
 * @method static Builder|SubPhotoGallery whereYoutubeLink($value)
 * @mixin \Eloquent
 */
class SubPhotoGallery extends Model implements HasMedia
{
    use InteractsWithMedia, PresentableTrait;

    const STATUS_ACTIVE = 1;

    const STATUS_INACTIVE = 2;

    const SUB_IMAGE = 'sub_image_photo_gallery';

    const STATUSES = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In-Active',
    ];

    protected $guarded = ['id'];

    public function photoGallery(): BelongsTo|PhotoGallery
    {
        return $this->belongsTo(PhotoGallery::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::SUB_IMAGE);
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
