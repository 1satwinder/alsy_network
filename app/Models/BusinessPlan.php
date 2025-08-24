<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\BusinessPlan
 *
 * @property int $id
 * @property int $status 1: Active, 2: In-Active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @method static Builder|BusinessPlan newModelQuery()
 * @method static Builder|BusinessPlan newQuery()
 * @method static Builder|BusinessPlan query()
 * @method static Builder|BusinessPlan whereCreatedAt($value)
 * @method static Builder|BusinessPlan whereId($value)
 * @method static Builder|BusinessPlan whereStatus($value)
 * @method static Builder|BusinessPlan whereUpdatedAt($value)
 * @mixin Eloquent
 */
class BusinessPlan extends Model implements HasMedia
{
    use InteractsWithMedia;

    const MC_WEBSITE_PLAN = 'website_business_plan';

    protected $guarded = [];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MC_WEBSITE_PLAN)
            ->singleFile();
    }
}
