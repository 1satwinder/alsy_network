<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GSTType
 *
 * @property int $id
 * @property string $hsn_code
 * @property float $sgst
 * @property float $cgst
 * @property string $gst
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|GSTType createdAtFrom(string $date)
 * @method static Builder|GSTType createdAtTo(string $date)
 * @method static \Database\Factories\GSTTypeFactory factory($count = null, $state = [])
 * @method static Builder|GSTType newModelQuery()
 * @method static Builder|GSTType newQuery()
 * @method static Builder|GSTType query()
 * @method static Builder|GSTType whereCgst($value)
 * @method static Builder|GSTType whereCreatedAt($value)
 * @method static Builder|GSTType whereGst($value)
 * @method static Builder|GSTType whereHsnCode($value)
 * @method static Builder|GSTType whereId($value)
 * @method static Builder|GSTType whereSgst($value)
 * @method static Builder|GSTType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GSTType extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'sgst' => 'float',
        'cgst' => 'float',
        'igst' => 'float',
    ];

    public function scopeCreatedAtFrom(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.created_at", '>=', $date);
    }

    public function scopeCreatedAtTo(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.created_at", '<=', $date);
    }
}
