<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\CategorySlider
 *
 * @property int $id
 * @property int $category_id
 * @property int $status 1: Active, 2: In-Active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @method static \Illuminate\Database\Eloquent\Builder|CategorySlider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategorySlider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategorySlider query()
 * @method static \Illuminate\Database\Eloquent\Builder|CategorySlider whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategorySlider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategorySlider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategorySlider whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategorySlider whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CategorySlider extends Model
{
    protected $guarded = [];

    const ACTIVE = 1;

    const INACTIVE = 2;

    public function category(): BelongsTo|Category
    {
        return $this->belongsTo(Category::class);
    }
}
