<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\CompanyStockLedger
 *
 * @property int $id
 * @property int $product_id
 * @property string $responsible_type
 * @property int $responsible_id
 * @property int|null $type 1: Inward, 2: Outward
 * @property int $quantity
 * @property string $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read Model|\Eloquent $responsible
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyStockLedger newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyStockLedger newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyStockLedger query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyStockLedger whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyStockLedger whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyStockLedger whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyStockLedger whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyStockLedger whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyStockLedger whereResponsibleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyStockLedger whereResponsibleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyStockLedger whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyStockLedger whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CompanyStockLedger extends Model
{
    const TYPE_INWARD = 1;

    const TYPE_OUTWARD = 2;

    protected $guarded = [];

    public function responsible()
    {
        return $this->morphTo('responsible');
    }

    /**
     * @return BelongsTo|Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
