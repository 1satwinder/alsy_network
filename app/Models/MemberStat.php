<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\MemberStat
 *
 * @property int $id
 * @property int $member_id
 * @property string $referral_bonus_income
 * @property string $team_bonus_income
 * @property string $magic_pool_bonus_income
 * @property string $admin_credit
 * @property string $all_income
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Member $member
 * @method static \Database\Factories\MemberStatFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|MemberStat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberStat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberStat query()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberStat whereAdminCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberStat whereAllIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberStat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberStat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberStat whereMagicPoolBonusIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberStat whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberStat whereReferralBonusIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberStat whereTeamBonusIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberStat whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MemberStat extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function member(): BelongsTo|Member
    {
        return $this->belongsTo(Member::class);
    }
}
