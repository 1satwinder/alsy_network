<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Str;

/**
 * App\Models\MagicPoolTree
 *
 * @property int $id
 * @property int $magic_pool_id
 * @property int $member_id
 * @property int|null $parent_id
 * @property string|null $path
 * @property int $level
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, MagicPoolTree> $children
 * @property-read int|null $children_count
 * @property-read \App\Models\MagicPool $magicPoolDetail
 * @property-read \App\Models\Member $member
 * @property-read MagicPoolTree|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolTree newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolTree newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolTree query()
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolTree whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolTree whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolTree whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolTree whereMagicPoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolTree whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolTree whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolTree wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolTree wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagicPoolTree whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MagicPoolTree extends Model
{
    use HasFactory;

    protected $guarded;

    public function magicPoolDetail(): BelongsTo
    {
        return $this->belongsTo(MagicPool::class, 'magic_pool_id', 'id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function isChildOf(MagicPoolTree $parent): bool
    {
        return Str::contains($this->path, $parent->path);
    }
}
