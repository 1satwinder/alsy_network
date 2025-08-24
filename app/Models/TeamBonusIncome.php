<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * App\Models\TeamBonusIncome
 *
 * @property int $id
 * @property int $team_bonus_id
 * @property int $top_up_id
 * @property int $member_id
 * @property int $from_member_id
 * @property string $total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Member $fromMember
 * @property-read \App\Models\Member $member
 * @property-read \App\Models\WalletTransaction|null $walletTransaction
 * @method static \Database\Factories\TeamBonusIncomeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|TeamBonusIncome newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamBonusIncome newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamBonusIncome query()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamBonusIncome whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamBonusIncome whereFromMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamBonusIncome whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamBonusIncome whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamBonusIncome whereTeamBonusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamBonusIncome whereTopUpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamBonusIncome whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamBonusIncome whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TeamBonusIncome extends Model
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
