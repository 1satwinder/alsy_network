<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\OrderRequest
 *
 * @property-read \App\Models\Bank|null $bank
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Member|null $member
 * @method static Builder|OrderRequest depositFromDate(string $date)
 * @method static Builder|OrderRequest depositToDate(string $date)
 * @method static Builder|OrderRequest fromDate(string $date)
 * @method static Builder|OrderRequest newModelQuery()
 * @method static Builder|OrderRequest newQuery()
 * @method static Builder|OrderRequest query()
 * @method static Builder|OrderRequest toDate(string $date)
 * @mixin \Eloquent
 */
class OrderRequest extends Model implements HasMedia
{
    use InteractsWithMedia, PresentableTrait;

    const STATUS_PENDING = 1;

    const STATUS_APPROVED = 2;

    const STATUS_REJECTED = 3;

    const STATUSES = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_APPROVED => 'Approved',
        self::STATUS_REJECTED => 'Rejected',
    ];

    const MC_RECEIPT = 'order_request_payment_proof';

    const TYPE_BANK = 1;

    const TYPE_PHONE_PAY = 2;

    const TYPE_GOOGLE_PAY = 3;

    const TYPES = [
        self::TYPE_BANK => 'Bank',
        self::TYPE_PHONE_PAY => 'PhonePay',
        self::TYPE_GOOGLE_PAY => 'GooglePay',
    ];

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
