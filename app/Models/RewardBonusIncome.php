<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\RewardBonusIncome
 *
 * @property int $id
 * @property int $reward_bonus_id
 * @property int $member_id
 * @property string $reward
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Member $member
 * @method static \Database\Factories\RewardBonusIncomeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|RewardBonusIncome newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RewardBonusIncome newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RewardBonusIncome query()
 * @method static \Illuminate\Database\Eloquent\Builder|RewardBonusIncome whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RewardBonusIncome whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RewardBonusIncome whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RewardBonusIncome whereReward($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RewardBonusIncome whereRewardBonusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RewardBonusIncome whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RewardBonusIncome whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RewardBonusIncome extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public const STATUS_ACHIEVED = 1;

    public const STATUS_FLUSHED = 2;

    const STATUSES = [
        self::STATUS_ACHIEVED => 'Achieved',
        self::STATUS_FLUSHED => 'Flushed',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
