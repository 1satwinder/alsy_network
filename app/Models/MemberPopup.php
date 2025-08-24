<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\MemberPopup
 *
 * @property int $id
 * @property string $name
 * @property string|null $link
 * @property int $status 1: Active, 2: In-Active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPopup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPopup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPopup query()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPopup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPopup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPopup whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPopup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPopup whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberPopup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MemberPopup extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    const STATUS_ACTIVE = 1;

    const STATUS_INACTIVE = 2;

    const STATUSES = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In-Active',
    ];

    public const TYPE_IMAGE = 1;

    public const TYPE_VIDEO = 2;

    const TYPE = [
        self::TYPE_IMAGE => 'Image',
        self::TYPE_VIDEO => 'Video',
    ];

    const MEDIA_COLLECTION_IMAGE_MEMBER_POPUP = 'member_popup';

    protected $guarded = [];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MEDIA_COLLECTION_IMAGE_MEMBER_POPUP)
            ->singleFile();
    }
}
