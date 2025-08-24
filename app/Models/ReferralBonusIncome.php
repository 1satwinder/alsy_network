<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * App\Models\ReferralBonusIncome
 *
 * @property int $id
 * @property int $top_up_id
 * @property int $member_id
 * @property int $from_member_id
 * @property string $total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Member $fromMember
 * @property-read \App\Models\Member $member
 * @property-read \App\Models\WalletTransaction|null $walletTransaction
 * @method static \Database\Factories\ReferralBonusIncomeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralBonusIncome newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralBonusIncome newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralBonusIncome query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralBonusIncome whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralBonusIncome whereFromMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralBonusIncome whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralBonusIncome whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralBonusIncome whereTopUpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralBonusIncome whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralBonusIncome whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReferralBonusIncome extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function walletTransaction(): MorphOne|WalletTransaction
    {
        return $this->morphOne(WalletTransaction::class, 'responsible');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function fromMember(): BelongsTo|Member
    {
        return $this->belongsTo(Member::class, 'from_member_id', 'id');
    }
}
