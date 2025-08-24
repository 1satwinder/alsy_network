<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\TrendingProducts
 *
 * @property int $id
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|TrendingProducts newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TrendingProducts newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TrendingProducts query()
 * @method static \Illuminate\Database\Eloquent\Builder|TrendingProducts whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrendingProducts whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrendingProducts whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrendingProducts whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TrendingProducts extends Model
{
    const ACTIVE = 1;

    const INACTIVE = 2;

    protected $guarded = [];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
