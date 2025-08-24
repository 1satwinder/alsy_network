<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * App\Models\IncomeWalletTransfer
 *
 * @property int $id
 * @property int $member_id
 * @property string $amount
 * @property string $admin_charge
 * @property string $total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Member $member
 * @property-read \App\Models\WalletTransaction|null $walletTransactions
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeWalletTransfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeWalletTransfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeWalletTransfer query()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeWalletTransfer whereAdminCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeWalletTransfer whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeWalletTransfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeWalletTransfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeWalletTransfer whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeWalletTransfer whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeWalletTransfer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class IncomeWalletTransfer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function walletTransactions(): MorphOne
    {
        return $this->morphOne(WalletTransaction::class, 'responsible');
    }
}
