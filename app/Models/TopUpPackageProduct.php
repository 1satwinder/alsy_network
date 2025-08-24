<?php

namespace App\Models;

use App\Presenters\TopUpPackageProductPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

/**
 * App\Models\TopUpPackageProduct
 *
 * @property int $id
 * @property int $package_id
 * @property int $top_up_id
 * @property int $package_product_id
 * @property string $name
 * @property string|null $sgst_percentage
 * @property string|null $cgst_percentage
 * @property string|null $igst_percentage
 * @property string $gst_percentage
 * @property string|null $sgst_amount
 * @property string|null $cgst_amount
 * @property string|null $igst_amount
 * @property string|null $total_gst_amount
 * @property string $amount
 * @property string $price
 * @property string $hsn_code
 * @property int $gst_slab
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $gst_amount
 * @property-read \App\Models\PackageProduct $products
 * @property-read \App\Models\TopUp $topUp
 * @method static \Database\Factories\TopUpPackageProductFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpPackageProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpPackageProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpPackageProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpPackageProduct whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpPackageProduct whereCgstAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpPackageProduct whereCgstPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpPackageProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpPackageProduct whereGstPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpPackageProduct whereGstSlab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpPackageProduct whereHsnCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpPackageProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpPackageProduct whereIgstAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpPackageProduct whereIgstPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpPackageProduct whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpPackageProduct wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpPackageProduct wherePackageProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpPackageProduct wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpPackageProduct whereSgstAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpPackageProduct whereSgstPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpPackageProduct whereTopUpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpPackageProduct whereTotalGstAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopUpPackageProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TopUpPackageProduct extends Model
{
    use HasFactory;
    use PresentableTrait;

    protected $presenter = TopUpPackageProductPresenter::class;

    protected $guarded = ['id'];

    const GST_SLAB_0 = 1;

    const GST_SLAB_5 = 2;

    const GST_SLAB_12 = 3;

    const GST_SLAB_18 = 4;

    const GST_SLAB_28 = 5;

    const GST_SLABS = [
        self::GST_SLAB_0 => '0 %',
        self::GST_SLAB_5 => '5 %',
        self::GST_SLAB_12 => '12 %',
        self::GST_SLAB_18 => '18 %',
        self::GST_SLAB_28 => '28 %',
    ];

    public function getGstAmountAttribute()
    {
        switch ($this->gst_slab) {
            case self::GST_SLAB_5:
                return round($this->price - ($this->price / 1.05));
            case self::GST_SLAB_12:
                return round($this->price - ($this->price / 1.12));
            case self::GST_SLAB_18:
                return round($this->price - ($this->price / 1.18));
            case self::GST_SLAB_28:
                return round($this->price - ($this->price / 1.28));
            default:
                return 0;
        }
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PackageProduct::class, 'package_product_id', 'id');
    }

    public function topUp(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TopUp::class);
    }
}
