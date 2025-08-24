<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\MemberInvoice
 *
 * @property int $id
 * @property int $member_id
 * @property int $status 1: Pending, 2: Approved, 3: Rejected
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Member $member
 * @method static Builder|MemberInvoice newModelQuery()
 * @method static Builder|MemberInvoice newQuery()
 * @method static Builder|MemberInvoice pending()
 * @method static Builder|MemberInvoice query()
 * @method static Builder|MemberInvoice whereCreatedAt($value)
 * @method static Builder|MemberInvoice whereId($value)
 * @method static Builder|MemberInvoice whereMemberId($value)
 * @method static Builder|MemberInvoice whereStatus($value)
 * @method static Builder|MemberInvoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MemberInvoice extends Model implements HasMedia
{
    use InteractsWithMedia;

    const STATUS_PENDING = 1;

    const STATUS_APPROVED = 2;

    const STATUS_REJECTED = 3;

    const MC_INVOICE = 'invoice';

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::updating(function (self $memberInvoice) {
            // if ($memberInvoice->status == self::STATUS_PENDING) {
            //     throw new Exception('Member Invoice status should not be set to PENDING again as PV is already rewarded!!');
            // }
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MC_INVOICE)
            ->singleFile();
    }

    /**
     * @return BelongsTo|Member
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * @param  Builder|self  $query
     * @return mixed
     */
    public function scopePending($query)
    {
        return $query->whereStatus(self::STATUS_PENDING);
    }

    /**
     * @return bool
     */
    public function isApproved()
    {
        return $this->status == self::STATUS_APPROVED;
    }
}
