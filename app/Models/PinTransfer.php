<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\PinTransfer
 *
 * @property int $id
 * @property int $pin_id
 * @property int $from_id
 * @property int $to_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Member $memberFrom
 * @property-read \App\Models\Member $memberTo
 * @property-read \App\Models\Pin $pin
 * @method static Builder|PinTransfer fromDate($fromDate)
 * @method static Builder|PinTransfer newModelQuery()
 * @method static Builder|PinTransfer newQuery()
 * @method static Builder|PinTransfer query()
 * @method static Builder|PinTransfer toDate($toDate)
 * @method static Builder|PinTransfer whereCreatedAt($value)
 * @method static Builder|PinTransfer whereFromId($value)
 * @method static Builder|PinTransfer whereId($value)
 * @method static Builder|PinTransfer wherePinId($value)
 * @method static Builder|PinTransfer whereToId($value)
 * @method static Builder|PinTransfer whereUpdatedAt($value)
 * @mixin Eloquent
 */
class PinTransfer extends Model
{
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function pin()
    {
        return $this->belongsTo(Pin::class);
    }

    /**
     * @return BelongsTo
     */
    public function memberFrom()
    {
        return $this->belongsTo(Member::class, 'from_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function memberTo()
    {
        return $this->belongsTo(Member::class, 'to_id', 'id');
    }

    /**
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeFromDate(Builder $query, $fromDate)
    {
        return $query->whereDate("{$this->getTable()}.created_at", '>=', $fromDate);
    }

    /**
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeToDate(Builder $query, $toDate)
    {
        return $query->whereDate("{$this->getTable()}.created_at", '<=', $toDate);
    }
}
