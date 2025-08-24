<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * App\Models\MagicPoolIncome
 *
 * @property int $id
 * @property int $member_id
 * @property int $magic_pool_tree_id
 * @property int $magic_pool_id
 * @property string $total_amount
 * @property string $upgrade_amount
 * @property string $net_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Member $member
 * @property-read \App\Models\WalletTransaction|null $walletTransaction
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolIncome newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolIncome newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolIncome query()
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolIncome whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolIncome whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolIncome whereMagicPoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolIncome whereMagicPoolTreeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolIncome whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolIncome whereNetAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolIncome whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolIncome whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolIncome whereUpgradeAmount($value)
 * @mixin \Eloquent
 */
class MagicPoolIncome extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function walletTransaction(): MorphOne|WalletTransaction
    {
        return $this->morphOne(WalletTransaction::class, 'responsible');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
