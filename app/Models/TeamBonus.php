<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TeamBonus
 *
 * @property int $id
 * @property int $level
 * @property int $direct
 * @property int $income_percent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\TeamBonusFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|TeamBonus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamBonus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamBonus query()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamBonus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamBonus whereDirect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamBonus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamBonus whereIncomePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamBonus whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamBonus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TeamBonus extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
}
