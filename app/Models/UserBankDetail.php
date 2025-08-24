<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserBankDetail
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $account_holder_name
 * @property string $account_no
 * @property string $branch_name
 * @property string $ifsc_code
 * @property string|null $paytm
 * @property string|null $phone_pay
 * @property string|null $google_pay
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserBankDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBankDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBankDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBankDetail whereAccountHolderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBankDetail whereAccountNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBankDetail whereBranchName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBankDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBankDetail whereGooglePay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBankDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBankDetail whereIfscCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBankDetail whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBankDetail wherePaytm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBankDetail wherePhonePay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBankDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBankDetail whereUserId($value)
 * @mixin \Eloquent
 */
class UserBankDetail extends Model
{
    protected $guarded = [];
}
