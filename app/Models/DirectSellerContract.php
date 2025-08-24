<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\DirectSellerContract
 *
 * @property int $id
 * @property int $status 1: Active, 2: In-Active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|DirectSellerContract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DirectSellerContract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DirectSellerContract query()
 * @method static \Illuminate\Database\Eloquent\Builder|DirectSellerContract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DirectSellerContract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DirectSellerContract whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DirectSellerContract whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DirectSellerContract extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    const MC_DIRECT_SELLER_CONTRACT = 'direct_seller_contract';

    protected $guarded = [];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MC_DIRECT_SELLER_CONTRACT)
            ->singleFile();
    }
}
