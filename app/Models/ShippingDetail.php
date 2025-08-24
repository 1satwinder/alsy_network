<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ShippingDetail
 *
 * @method static Builder|ShippingDetail newModelQuery()
 * @method static Builder|ShippingDetail newQuery()
 * @method static Builder|ShippingDetail query()
 * @mixin Eloquent
 */
class ShippingDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    const STATUS_ACTIVE = 1;

    const STATUS_INACTIVE = 2;
}
