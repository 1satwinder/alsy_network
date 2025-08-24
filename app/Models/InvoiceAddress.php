<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\InvoiceAddress
 *
 * @property int $id
 * @property int $top_up_id
 * @property int $member_id
 * @property string $name
 * @property int|null $country_id
 * @property int|null $state_id
 * @property int|null $city_id
 * @property string|null $member_address
 * @property string|null $member_email
 * @property string|null $member_mobile
 * @property int|null $member_pincode
 * @property string|null $admin_address
 * @property string|null $admin_city
 * @property string|null $admin_state
 * @property string|null $admin_pincode
 * @property string|null $admin_mobile
 * @property string|null $admin_email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\City|null $city
 * @property-read \App\Models\Member|null $member
 * @property-read \App\Models\State|null $state
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceAddress whereAdminAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceAddress whereAdminCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceAddress whereAdminEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceAddress whereAdminMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceAddress whereAdminPincode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceAddress whereAdminState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceAddress whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceAddress whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceAddress whereMemberAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceAddress whereMemberEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceAddress whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceAddress whereMemberMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceAddress whereMemberPincode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceAddress whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceAddress whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceAddress whereTopUpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceAddress whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InvoiceAddress extends Model
{
    protected $guarded = ['id'];

    /**
     * @return HasOne|Member
     */
    public function member()
    {
        return $this->hasOne(Member::class);
    }

    /**
     * @return BelongsTo|State
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * @return BelongsTo|City
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
