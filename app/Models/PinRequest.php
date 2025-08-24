<?php

namespace App\Models;

use App\Presenters\PinRequestPresenter;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\PinRequest
 *
 * @property int $id
 * @property int $member_id
 * @property int $package_id
 * @property int|null $bank_id
 * @property int $no_pins
 * @property string|null $payment_mode
 * @property string|null $reference_no
 * @property \Illuminate\Support\Carbon|null $deposit_date
 * @property int $status 1: Pending, 2: Approved, 3: Reject
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Bank|null $bank
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Member $member
 * @property-read \App\Models\Package $package
 * @method static Builder|PinRequest depositFromDate(string $date)
 * @method static Builder|PinRequest depositToDate(string $date)
 * @method static \Database\Factories\PinRequestFactory factory($count = null, $state = [])
 * @method static Builder|PinRequest fromDate(string $date)
 * @method static Builder|PinRequest maxNoPins($max)
 * @method static Builder|PinRequest minNoPins($min)
 * @method static Builder|PinRequest newModelQuery()
 * @method static Builder|PinRequest newQuery()
 * @method static Builder|PinRequest query()
 * @method static Builder|PinRequest toDate(string $date)
 * @method static Builder|PinRequest whereBankId($value)
 * @method static Builder|PinRequest whereCreatedAt($value)
 * @method static Builder|PinRequest whereDepositDate($value)
 * @method static Builder|PinRequest whereId($value)
 * @method static Builder|PinRequest whereMemberId($value)
 * @method static Builder|PinRequest whereNoPins($value)
 * @method static Builder|PinRequest wherePackageId($value)
 * @method static Builder|PinRequest wherePaymentMode($value)
 * @method static Builder|PinRequest whereReferenceNo($value)
 * @method static Builder|PinRequest whereStatus($value)
 * @method static Builder|PinRequest whereUpdatedAt($value)
 * @mixin Eloquent
 */
class PinRequest extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use PresentableTrait;

    protected string $presenter = PinRequestPresenter::class;

    const STATUS_PENDING = 1;

    const STATUS_APPROVED = 2;

    const STATUS_REJECTED = 3;

    const STATUSES = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_APPROVED => 'Approved',
        self::STATUS_REJECTED => 'Rejected',
    ];

    const MC_RECEIPT = 'payment_proof';

    const PM_CASH = 1;

    const PM_NEFT = 2;

    const PM_RTGS = 3;

    const PM_UPI = 4;

    const PM_CHEQUE = 5;

    const PM_DEMAND_DRAFT = 6;

    const PM_PAYTM = 7;

    const PM_OTHER = 8;

    const PAYMENT_MODES = [
        self::PM_CASH => 'CASH',
        self::PM_NEFT => 'NEFT',
        self::PM_RTGS => 'RTGS',
        self::PM_UPI => 'UPI',
        self::PM_CHEQUE => 'CHEQUE',
        self::PM_DEMAND_DRAFT => 'DEMAND DRAFT',
        self::PM_PAYTM => 'PAYTM',
        self::PM_OTHER => 'OTHER',
    ];

    protected $guarded = [];

    protected $casts = ['deposit_date' => 'datetime'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MC_RECEIPT)
            ->singleFile();
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function isPending(): bool
    {
        return $this->status == self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status == self::STATUS_APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status == self::STATUS_REJECTED;
    }

    /**
     * @return Builder
     */
    public function scopeMinNoPins(Builder $query, $min)
    {
        return $query->where("{$this->getTable()}.no_pins", '>=', $min);
    }

    /**
     * @return Builder
     */
    public function scopeMaxNoPins(Builder $query, $max)
    {
        return $query->where("{$this->getTable()}.no_pins", '<=', $max);
    }

    public function scopeFromDate(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.created_at", '>=', $date);
    }

    public function scopeToDate(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.created_at", '<=', $date);
    }

    public function scopeDepositFromDate(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.deposit_date", '>=', $date);
    }

    public function scopeDepositToDate(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.deposit_date", '<=', $date);
    }
}
