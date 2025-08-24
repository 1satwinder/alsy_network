<?php

namespace App\Models;

use App\Presenters\PackageProductPresenter;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

/**
 * App\Models\PackageProduct
 *
 * @property int $id
 * @property int $package_id
 * @property string $name
 * @property string $price
 * @property string $hsn_code
 * @property int $gst_slab
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $gst_amount
 * @method static Builder|PackageProduct newModelQuery()
 * @method static Builder|PackageProduct newQuery()
 * @method static Builder|PackageProduct query()
 * @method static Builder|PackageProduct whereCreatedAt($value)
 * @method static Builder|PackageProduct whereGstSlab($value)
 * @method static Builder|PackageProduct whereHsnCode($value)
 * @method static Builder|PackageProduct whereId($value)
 * @method static Builder|PackageProduct whereName($value)
 * @method static Builder|PackageProduct wherePackageId($value)
 * @method static Builder|PackageProduct wherePrice($value)
 * @method static Builder|PackageProduct whereUpdatedAt($value)
 * @mixin Eloquent
 */
class PackageProduct extends Model
{
    use PresentableTrait;

    protected $presenter = PackageProductPresenter::class;

    protected $guarded = ['id'];

    const GST_SLAB_0 = 1;

    const GST_SLAB_5 = 2;

    const GST_SLAB_12 = 3;

    const GST_SLAB_18 = 4;

    const GST_SLAB_28 = 5;

    const GST_SLABS = [
        self::GST_SLAB_0 => '0',
        self::GST_SLAB_5 => '5',
        self::GST_SLAB_12 => '12',
        self::GST_SLAB_18 => '18',
        self::GST_SLAB_28 => '28',
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
}
