<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\LegalDocument
 *
 * @property int $id
 * @property string|null $name
 * @property int $status 1: Active, 2: Inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|LegalDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegalDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegalDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder|LegalDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalDocument whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalDocument whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalDocument whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LegalDocument extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = ['id'];

    const STATUS_ACTIVE = 1;

    const STATUS_INACTIVE = 2;

    const STATUSES = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In-Active',
    ];

    const MC_LEGAL_DOCUMENTS = 'legal_document';

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MC_LEGAL_DOCUMENTS)
            ->singleFile();
    }
}
