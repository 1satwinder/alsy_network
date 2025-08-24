<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Inquiry
 *
 * @property int $id
 * @property int|null $country_id
 * @property string $name
 * @property string $email
 * @property string $mobile
 * @property string|null $message
 * @property int $is_read
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Country|null $country
 * @method static Builder|Inquiry fromDate(string $date)
 * @method static Builder|Inquiry newModelQuery()
 * @method static Builder|Inquiry newQuery()
 * @method static Builder|Inquiry query()
 * @method static Builder|Inquiry toDate(string $date)
 * @method static Builder|Inquiry whereCountryId($value)
 * @method static Builder|Inquiry whereCreatedAt($value)
 * @method static Builder|Inquiry whereEmail($value)
 * @method static Builder|Inquiry whereId($value)
 * @method static Builder|Inquiry whereIsRead($value)
 * @method static Builder|Inquiry whereMessage($value)
 * @method static Builder|Inquiry whereMobile($value)
 * @method static Builder|Inquiry whereName($value)
 * @method static Builder|Inquiry whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Inquiry extends Model
{
    protected $guarded = [];

    public function scopeFromDate(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.created_at", '>=', $date);
    }

    public function scopeToDate(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.created_at", '<=', $date);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
