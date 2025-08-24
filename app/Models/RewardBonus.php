<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RewardBonus
 *
 * @property int $id
 * @property int $level
 * @property string $target_active_member
 * @property string $reward
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RewardBonusIncome> $rewardBonusIncome
 * @property-read int|null $reward_bonus_income_count
 * @method static \Database\Factories\RewardBonusFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|RewardBonus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RewardBonus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RewardBonus query()
 * @method static \Illuminate\Database\Eloquent\Builder|RewardBonus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RewardBonus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RewardBonus whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RewardBonus whereReward($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RewardBonus whereTargetActiveMember($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RewardBonus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RewardBonus extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function rewardBonusIncome()
    {
        return $this->hasMany(RewardBonusIncome::class);
    }
}
