<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Otp
 *
 * @property int $id
 * @property string|null $mobile
 * @property string|null $otp
 * @property int $type
 * @property int $status 1: used, 2: unused
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Otp newModelQuery()
 * @method static Builder|Otp newQuery()
 * @method static Builder|Otp query()
 * @method static Builder|Otp whereCreatedAt($value)
 * @method static Builder|Otp whereId($value)
 * @method static Builder|Otp whereMobile($value)
 * @method static Builder|Otp whereOtp($value)
 * @method static Builder|Otp whereStatus($value)
 * @method static Builder|Otp whereType($value)
 * @method static Builder|Otp whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Otp extends Model
{
    use HasFactory;

    public const int STATUS_USED = 1;

    public const int STATUS_UNUSED = 2;

    const array STATUSES = [
        self::STATUS_USED => 'used',
        self::STATUS_UNUSED => 'unused',
    ];

    const int ACTION_REGISTER = 1;

    const int ACTION_LOGIN = 2;

    const int ACTION_FORGOT_PASSWORD = 3;

    const array ACTIONS = [
        self::ACTION_REGISTER => 'register',
        self::ACTION_LOGIN => 'login',
        self::ACTION_FORGOT_PASSWORD => 'forgot password',
    ];

    protected $guarded = [];
}
