<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderStatusLog
 *
 * @property int $id
 * @property int $order_product_id
 * @property int|null $order_id
 * @property int $status
 * @property string|null $remarks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusLog whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusLog whereOrderProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusLog whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderStatusLog extends Model
{
    protected $guarded = [];

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
}
