<?php

namespace App\Models;

use App\Presenters\PackagePresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laracasts\Presenter\PresentableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\Package
 *
 * @property int $id
 * @property int|null $admin_id
 * @property string $name
 * @property string $amount
 * @property string $referral_bonus_per
 * @property string $pv
 * @property int $status 1: Active, 2: In-Active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Admin|null $admin
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PackageProduct> $products
 * @property-read int|null $products_count
 * @method static Builder|Package active()
 * @method static Builder|Package fromDate(string $date)
 * @method static Builder|Package maxAmount($max)
 * @method static Builder|Package maxCapping($max)
 * @method static Builder|Package maxPv($max)
 * @method static Builder|Package minAmount($min)
 * @method static Builder|Package minCapping($min)
 * @method static Builder|Package minPv($min)
 * @method static Builder|Package newModelQuery()
 * @method static Builder|Package newQuery()
 * @method static Builder|Package query()
 * @method static Builder|Package toDate(string $date)
 * @method static Builder|Package whereAdminId($value)
 * @method static Builder|Package whereAmount($value)
 * @method static Builder|Package whereCreatedAt($value)
 * @method static Builder|Package whereId($value)
 * @method static Builder|Package whereName($value)
 * @method static Builder|Package wherePv($value)
 * @method static Builder|Package whereReferralBonusPer($value)
 * @method static Builder|Package whereStatus($value)
 * @method static Builder|Package whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Package extends Model implements HasMedia
{
    use InteractsWithMedia;
    use PresentableTrait;

    const STATUS_ACTIVE = 1;

    const STATUS_INACTIVE = 2;

    const STATUSES = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In-Active',
    ];

    const TYPE_WORKING = 1;

    const TYPE_NON_WORKING = 2;

    protected $guarded = [];

    protected $presenter = PackagePresenter::class;

    const MC_PACKAGE_IMAGE = 'package_image';

    public function admin(): BelongsTo|Admin
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MC_PACKAGE_IMAGE)
            ->singleFile();
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    /**
     * @return bool
     */
    public function isInActive()
    {
        return $this->status == self::STATUS_INACTIVE;
    }

    /**
     * Get the magic pool allocation amount for this package
     * 
     * @return float Fixed allocation amount (₹200)
     */
    public function getMagicPoolAllocationAmount(): float
    {
        return \App\Helpers\MagicPoolHelper::calculateAllocationAmount($this);
    }

    /**
     * @return Builder
     */
    public function scopeActive(Builder $query)
    {
        return $query->where("{$this->getTable()}.status", self::STATUS_ACTIVE);
    }

    /**
     * @return HasMany|PackageProduct
     */
    public function products()
    {
        return $this->hasMany(PackageProduct::class);
    }

    public function scopeFromDate(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.created_at", '>=', $date);
    }

    public function scopeToDate(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.created_at", '<=', $date);
    }

    public function scopeMinAmount(Builder $query, $min): Builder
    {
        return $query->where("{$this->getTable()}.amount", '>=', $min);
    }

    public function scopeMaxAmount(Builder $query, $max): Builder
    {
        return $query->where("{$this->getTable()}.amount", '<=', $max);
    }

    public function scopeMinCapping(Builder $query, $min): Builder
    {
        return $query->where("{$this->getTable()}.capping", '>=', $min);
    }

    public function scopeMaxCapping(Builder $query, $max): Builder
    {
        return $query->where("{$this->getTable()}.capping", '<=', $max);
    }

    public function scopeMinPv(Builder $query, $min): Builder
    {
        return $query->where("{$this->getTable()}.pv", '>=', $min);
    }

    public function scopeMaxPv(Builder $query, $max): Builder
    {
        return $query->where("{$this->getTable()}.pv", '<=', $max);
    }
}
