<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MagicPool
 *
 * @property int $id
 * @property string $name
 * @property int $level
 * @property int $total_member
 * @property int $total_income
 * @property int $upgrade_amount
 * @property int $net_income
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPool newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPool newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPool query()
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPool whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPool whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPool whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPool whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPool whereNetIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPool whereTotalIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPool whereTotalMember($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPool whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPool whereUpgradeAmount($value)
 * @mixin \Eloquent
 */
class MagicPool extends Model
{
    use HasFactory;

    protected $guarded = [];
}
