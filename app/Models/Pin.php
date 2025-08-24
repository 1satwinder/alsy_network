<?php

namespace App\Models;

use App\Presenters\PinPresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

/**
 * App\Models\Pin
 *
 * @property int $id
 * @property int $package_id
 * @property int $member_id
 * @property int|null $pin_request_id
 * @property string $code
 * @property string $amount
 * @property int|null $used_by
 * @property int|null $activated_by_id
 * @property int|null $activated_by_type 1:admin,2:member
 * @property \Illuminate\Support\Carbon|null $used_at
 * @property int $status 0: Un Used, 1: Used
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Member $member
 * @property-read \App\Models\Package $package
 * @property-read \App\Models\Member|null $usedBy
 * @method static \Database\Factories\PinFactory factory($count = null, $state = [])
 * @method static Builder|Pin fromDate(string $date)
 * @method static Builder|Pin maxAmount($max)
 * @method static Builder|Pin minAmount($min)
 * @method static Builder|Pin newModelQuery()
 * @method static Builder|Pin newQuery()
 * @method static Builder|Pin query()
 * @method static Builder|Pin toDate(string $date)
 * @method static Builder|Pin whereActivatedById($value)
 * @method static Builder|Pin whereActivatedByType($value)
 * @method static Builder|Pin whereAmount($value)
 * @method static Builder|Pin whereCode($value)
 * @method static Builder|Pin whereCreatedAt($value)
 * @method static Builder|Pin whereId($value)
 * @method static Builder|Pin whereMemberId($value)
 * @method static Builder|Pin wherePackageId($value)
 * @method static Builder|Pin wherePinRequestId($value)
 * @method static Builder|Pin whereStatus($value)
 * @method static Builder|Pin whereUpdatedAt($value)
 * @method static Builder|Pin whereUsedAt($value)
 * @method static Builder|Pin whereUsedBy($value)
 * @mixin \Eloquent
 */
class Pin extends Model
{
    use HasFactory;
    use PresentableTrait;

    protected $presenter = PinPresenter::class;

    const STATUS_UN_USED = 1;

    const STATUS_USED = 2;

    const STATUS_BLOCKED = 3;

    const STATUSES = [
        self::STATUS_UN_USED => 'Un Used',
        self::STATUS_USED => 'Used',
        self::STATUS_BLOCKED => 'Blocked',
    ];

    protected $guarded = [];

    protected $casts = ['used_at' => 'datetime'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function usedBy()
    {
        return $this->belongsTo(Member::class, 'used_by');
    }

    /**
     * @return bool
     */
    public function isUsed()
    {
        return $this->status == self::STATUS_USED;
    }

    /**
     * @return bool
     */
    public function isUnUsed()
    {
        return $this->status == self::STATUS_UN_USED;
    }

    /**
     * @return bool
     */
    public function isBlocked()
    {
        return $this->status == self::STATUS_BLOCKED;
    }

    /**
     * @return Builder
     */
    public function scopeMinAmount(Builder $query, $min)
    {
        return $query->where("{$this->getTable()}.amount", '>=', $min);
    }

    /**
     * @return Builder
     */
    public function scopeMaxAmount(Builder $query, $max)
    {
        return $query->where("{$this->getTable()}.amount", '<=', $max);
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
