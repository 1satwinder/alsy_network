<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Supplier
 *
 * @property int $id
 * @property string $name
 * @property int|null $state_id
 * @property int|null $city_id
 * @property string $email
 * @property string $mobile
 * @property string $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\City|null $city
 * @property-read \App\Models\State|null $state
 * @method static Builder|Supplier fromDate($fromDate)
 * @method static Builder|Supplier newModelQuery()
 * @method static Builder|Supplier newQuery()
 * @method static Builder|Supplier query()
 * @method static Builder|Supplier toDate($toDate)
 * @method static Builder|Supplier whereAddress($value)
 * @method static Builder|Supplier whereCityId($value)
 * @method static Builder|Supplier whereCreatedAt($value)
 * @method static Builder|Supplier whereEmail($value)
 * @method static Builder|Supplier whereId($value)
 * @method static Builder|Supplier whereMobile($value)
 * @method static Builder|Supplier whereName($value)
 * @method static Builder|Supplier whereStateId($value)
 * @method static Builder|Supplier whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Supplier extends Model
{
    protected $guarded = [];

    /**
     * @return HasOne|State
     */
    public function state()
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }

    /**
     * @return HasOne|City
     */
    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
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
