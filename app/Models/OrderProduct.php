<?php

namespace App\Models;

use App\Presenters\OrderProductPresenter;
use App\Traits\CreationDateRangeScopes;
use App\Traits\HasStocks;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laracasts\Presenter\PresentableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\OrderProduct
 *
 * @property int $id
 * @property int $member_id
 * @property int $order_id
 * @property int|null $product_id
 * @property string|null $order_no
 * @property string|null $product_name
 * @property string|null $hsn_code
 * @property string|null $sku
 * @property string|null $category_name
 * @property string|null $transaction_id
 * @property string|null $mrp
 * @property string|null $dp
 * @property string|null $bv
 * @property string|null $total_mrp
 * @property string|null $total_dp
 * @property string|null $total_bv
 * @property string $taxable_value
 * @property string $discount
 * @property string|null $sgst_percentage
 * @property string|null $cgst_percentage
 * @property string|null $igst_percentage
 * @property string $gst_percentage
 * @property string|null $sgst_amount
 * @property string|null $cgst_amount
 * @property string|null $igst_amount
 * @property string $gst_amount
 * @property string $amount
 * @property int $quantity
 * @property string $total
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CompanyStockLedger> $companyStockLedger
 * @property-read int|null $company_stock_ledger_count
 * @property-read \App\Models\GSTType|null $gstType
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Member $member
 * @property-read \App\Models\Order $order
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderStatusLog> $orderStatusLog
 * @property-read int|null $order_status_log_count
 * @property-read \App\Models\Product|null $product
 * @method static Builder|OrderProduct createdAtFrom(string $date)
 * @method static Builder|OrderProduct createdAtTo(string $date)
 * @method static Builder|OrderProduct maxBv($max)
 * @method static Builder|OrderProduct maxDp($max)
 * @method static Builder|OrderProduct maxGst($max)
 * @method static Builder|OrderProduct maxMrp($max)
 * @method static Builder|OrderProduct maxQuantity($max)
 * @method static Builder|OrderProduct maxTotal($max)
 * @method static Builder|OrderProduct minBv($min)
 * @method static Builder|OrderProduct minDp($min)
 * @method static Builder|OrderProduct minGst($min)
 * @method static Builder|OrderProduct minMrp($min)
 * @method static Builder|OrderProduct minQuantity($min)
 * @method static Builder|OrderProduct minTotal($min)
 * @method static Builder|OrderProduct newModelQuery()
 * @method static Builder|OrderProduct newQuery()
 * @method static Builder|OrderProduct query()
 * @method static Builder|OrderProduct whereAmount($value)
 * @method static Builder|OrderProduct whereBv($value)
 * @method static Builder|OrderProduct whereCategoryName($value)
 * @method static Builder|OrderProduct whereCgstAmount($value)
 * @method static Builder|OrderProduct whereCgstPercentage($value)
 * @method static Builder|OrderProduct whereCreatedAt($value)
 * @method static Builder|OrderProduct whereDiscount($value)
 * @method static Builder|OrderProduct whereDp($value)
 * @method static Builder|OrderProduct whereGstAmount($value)
 * @method static Builder|OrderProduct whereGstPercentage($value)
 * @method static Builder|OrderProduct whereHsnCode($value)
 * @method static Builder|OrderProduct whereId($value)
 * @method static Builder|OrderProduct whereIgstAmount($value)
 * @method static Builder|OrderProduct whereIgstPercentage($value)
 * @method static Builder|OrderProduct whereMemberId($value)
 * @method static Builder|OrderProduct whereMrp($value)
 * @method static Builder|OrderProduct whereOrderId($value)
 * @method static Builder|OrderProduct whereOrderNo($value)
 * @method static Builder|OrderProduct whereProductId($value)
 * @method static Builder|OrderProduct whereProductName($value)
 * @method static Builder|OrderProduct whereQuantity($value)
 * @method static Builder|OrderProduct whereSgstAmount($value)
 * @method static Builder|OrderProduct whereSgstPercentage($value)
 * @method static Builder|OrderProduct whereSku($value)
 * @method static Builder|OrderProduct whereStatus($value)
 * @method static Builder|OrderProduct whereTaxableValue($value)
 * @method static Builder|OrderProduct whereTotal($value)
 * @method static Builder|OrderProduct whereTotalBv($value)
 * @method static Builder|OrderProduct whereTotalDp($value)
 * @method static Builder|OrderProduct whereTotalMrp($value)
 * @method static Builder|OrderProduct whereTransactionId($value)
 * @method static Builder|OrderProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderProduct extends Model implements HasMedia
{
    use CreationDateRangeScopes;
    use HasStocks;
    use InteractsWithMedia;
    use PresentableTrait;

    const MC_ORDER_PRODUCT_IMAGE = 'order_product_image';

    public const STATUS_IN_CHECKOUT = 1;

    public const STATUS_PLACE = 2;

    public const STATUS_CONFIRM = 3;

    public const STATUS_PROCESS = 4;

    public const STATUS_MANIFEST = 5;

    public const STATUS_DISPATCH = 6;

    public const STATUS_DELIVER = 7;

    public const STATUS_REPLACE = 8;

    public const STATUS_RETURN = 9;

    public const STATUS_CANCEL = 10;

    public const STATUS_REJECT = 11;

    public const STATUS_FAIL = 12;

    public const STATUSES = [
        self::STATUS_IN_CHECKOUT => 'In Check Out',
        self::STATUS_PLACE => 'Placed',
        self::STATUS_CONFIRM => 'Confirmed',
        self::STATUS_PROCESS => 'Process',
        self::STATUS_MANIFEST => 'Manifested',
        self::STATUS_DISPATCH => 'Dispatch',
        self::STATUS_DELIVER => 'Delivered',
        self::STATUS_REPLACE => 'Replace',
        self::STATUS_RETURN => 'Return',
        self::STATUS_CANCEL => 'Cancelled',
        self::STATUS_REJECT => 'Rejected',
        self::STATUS_FAIL => 'Fail',
    ];

    protected $guarded = [];

    protected $presenter = OrderProductPresenter::class;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MC_ORDER_PRODUCT_IMAGE)
            ->singleFile();
    }

    public function order(): BelongsTo|Order
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return HasMany|OrderStatusLog
     */
    public function orderStatusLog()
    {
        return $this->hasMany(OrderStatusLog::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function gstType(): BelongsTo
    {
        return $this->belongsTo(GSTType::class);
    }

    /**
     * @return Builder
     */
    public function scopeMinQuantity(Builder $query, $min)
    {
        return $query->where("{$this->getTable()}.quantity", '>=', $min);
    }

    /**
     * @return Builder
     */
    public function scopeMaxQuantity(Builder $query, $max)
    {
        return $query->where("{$this->getTable()}.quantity", '<=', $max);
    }

    /**
     * @return Builder
     */
    public function scopeMinBv(Builder $query, $min)
    {
        return $query->where("{$this->getTable()}.bv", '>=', $min);
    }

    /**
     * @return Builder
     */
    public function scopeMaxBv(Builder $query, $max)
    {
        return $query->where("{$this->getTable()}.bv", '<=', $max);
    }

    /**
     * @return Builder
     */
    public function scopeMinMrp(Builder $query, $min)
    {
        return $query->where("{$this->getTable()}.mrp", '>=', $min);
    }

    /**
     * @return Builder
     */
    public function scopeMaxMrp(Builder $query, $max)
    {
        return $query->where("{$this->getTable()}.mrp", '<=', $max);
    }

    /**
     * @return Builder
     */
    public function scopeMinDp(Builder $query, $min)
    {
        return $query->where("{$this->getTable()}.dp", '>=', $min);
    }

    /**
     * @return Builder
     */
    public function scopeMaxDp(Builder $query, $max)
    {
        return $query->where("{$this->getTable()}.dp", '<=', $max);
    }

    /**
     * @return Builder
     */
    public function scopeMinGst(Builder $query, $min)
    {
        return $query->where("{$this->getTable()}.gst_amount", '>=', $min);
    }

    /**
     * @return Builder
     */
    public function scopeMaxGst(Builder $query, $max)
    {
        return $query->where("{$this->getTable()}.gst_amount", '<=', $max);
    }

    /**
     * @return Builder
     */
    public function scopeMinTotal(Builder $query, $min)
    {
        return $query->where("{$this->getTable()}.total", '>=', $min);
    }

    /**
     * @return Builder
     */
    public function scopeMaxTotal(Builder $query, $max)
    {
        return $query->where("{$this->getTable()}.total", '<=', $max);
    }
}
