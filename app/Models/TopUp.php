<?php

namespace App\Models;

use App\Presenters\TopUpPresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laracasts\Presenter\PresentableTrait;

/**
 * App\Models\TopUp
 *
 * @property int $id
 * @property int $package_id
 * @property int $member_id
 * @property int $topped_up_by
 * @property string|null $invoice_no
 * @property string|null $sgst_amount
 * @property string|null $cgst_amount
 * @property string|null $igst_amount
 * @property string $amount
 * @property string $package_amount
 * @property string|null $gst_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\InvoiceAddress|null $invoiceAddress
 * @property-read \App\Models\Member $member
 * @property-read \App\Models\Package $package
 * @property-read \App\Models\Pin|null $pin
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TopUpPackageProduct> $topUpPackageProducts
 * @property-read int|null $top_up_package_products_count
 * @property-read \App\Models\Member $toppedUp
 * @method static Builder|TopUp active()
 * @method static Builder|TopUp createdAtFrom(string $date)
 * @method static Builder|TopUp createdAtTo(string $date)
 * @method static \Database\Factories\TopUpFactory factory($count = null, $state = [])
 * @method static Builder|TopUp fromDate($fromDate)
 * @method static Builder|TopUp maxAmount($max)
 * @method static Builder|TopUp maxGstAmount($max)
 * @method static Builder|TopUp minAmount($min)
 * @method static Builder|TopUp minGstAmount($min)
 * @method static Builder|TopUp newModelQuery()
 * @method static Builder|TopUp newQuery()
 * @method static Builder|TopUp notExpired()
 * @method static Builder|TopUp query()
 * @method static Builder|TopUp toDate($toDate)
 * @method static Builder|TopUp whereAmount($value)
 * @method static Builder|TopUp whereCgstAmount($value)
 * @method static Builder|TopUp whereCreatedAt($value)
 * @method static Builder|TopUp whereGstAmount($value)
 * @method static Builder|TopUp whereId($value)
 * @method static Builder|TopUp whereIgstAmount($value)
 * @method static Builder|TopUp whereInvoiceNo($value)
 * @method static Builder|TopUp whereMemberId($value)
 * @method static Builder|TopUp wherePackageAmount($value)
 * @method static Builder|TopUp wherePackageId($value)
 * @method static Builder|TopUp whereSgstAmount($value)
 * @method static Builder|TopUp whereToppedUpBy($value)
 * @method static Builder|TopUp whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TopUp extends Model
{
    use HasFactory;
    use PresentableTrait;

    protected $guarded = [];

    protected $presenter = TopUpPresenter::class;

    public function topUpPackageProducts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TopUpPackageProduct::class);
    }

    public const TYPE_SELF = 1;

    public const TYPE_OTHER = 2;

    const TYPE = [
        self::TYPE_SELF => 'Self',
        self::TYPE_OTHER => 'Other',
    ];

    /**
     * @param  Builder|TopUp  $query
     * @return Builder|TopUp
     */
    public function scopeActive($query)
    {
        return $query->where("{$this->getTable()}.active", true);
    }

    /**
     * @param  Builder|TopUp  $query
     * @return Builder|TopUp
     */
    public function scopeNotExpired($query)
    {
        return $query->where("{$this->getTable()}.roi_completed_weeks", '<', 20);
    }

    /**
     * @return BelongsTo|Member
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * @return BelongsTo|Package
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function pin()
    {
        return $this->belongsTo(Pin::class);
    }

    public function scopeCreatedAtFrom(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.created_at", '>=', $date);
    }

    public function scopeCreatedAtTo(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.created_at", '<=', $date);
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

    /**
     * @return Builder
     */
    public function scopeMinGstAmount(Builder $query, $min)
    {
        return $query->where("{$this->getTable()}.gst_amount", '>=', $min);
    }

    /**
     * @return Builder
     */
    public function scopeMaxGstAmount(Builder $query, $max)
    {
        return $query->where("{$this->getTable()}.gst_amount", '<=', $max);
    }

    /**
     * @return BelongsTo
     */
    public function toppedUp()
    {
        return $this->belongsTo(Member::class, 'topped_up_by', 'id');
    }

    /**
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeFromDate(Builder $query, $fromDate)
    {
        return $query->whereDate("{$this->getTable()}.created_at", '>=', $fromDate);
    }

    /**
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeToDate(Builder $query, $toDate)
    {
        return $query->whereDate("{$this->getTable()}.created_at", '<=', $toDate);
    }

    public function invoiceAddress()
    {
        return $this->hasOne(InvoiceAddress::class);
    }
}
