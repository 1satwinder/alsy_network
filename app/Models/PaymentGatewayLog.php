<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\PaymentGatewayLog
 *
 * @property int $id
 * @property int|null $top_up_id
 * @property int|null $order_id
 * @property string $response
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order|null $order
 * @method static Builder|PaymentGatewayLog newModelQuery()
 * @method static Builder|PaymentGatewayLog newQuery()
 * @method static Builder|PaymentGatewayLog query()
 * @method static Builder|PaymentGatewayLog whereCreatedAt($value)
 * @method static Builder|PaymentGatewayLog whereId($value)
 * @method static Builder|PaymentGatewayLog whereOrderId($value)
 * @method static Builder|PaymentGatewayLog whereResponse($value)
 * @method static Builder|PaymentGatewayLog whereTopUpId($value)
 * @method static Builder|PaymentGatewayLog whereUpdatedAt($value)
 * @mixin Eloquent
 */
class PaymentGatewayLog extends Model
{
    protected $guarded = ['id'];

    /**
     * @return BelongsTo|Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
