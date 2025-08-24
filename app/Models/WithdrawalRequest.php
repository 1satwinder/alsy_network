<?php

namespace App\Models;

use App\Presenters\WithdrawalPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laracasts\Presenter\PresentableTrait;

/**
 * App\Models\WithdrawalRequest
 *
 * @property int $id
 * @property int $member_id
 * @property int|null $admin_id
 * @property int|null $payout_id
 * @property string $amount
 * @property string $admin_charge
 * @property string $tds
 * @property string $total
 * @property int $status 1:pending,2:approve,3:reject
 * @property int $payout_status 0:pending,1:done
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Admin|null $admin
 * @property-read \App\Models\Member $member
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereAdminCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest wherePayoutId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest wherePayoutStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereTds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WithdrawalRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    use PresentableTrait;

    protected $presenter = WithdrawalPresenter::class;

    const STATUS_PENDING = 1;

    const STATUS_APPROVED = 2;

    const STATUS_REJECTED = 3;

    const PAYOUT_PENDING = 0;

    const PAYOUT_DONE = 1;

    const STATUSES = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_APPROVED => 'Approved',
        self::STATUS_REJECTED => 'Rejected',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return $this->status == self::STATUS_PENDING;
    }

    /**
     * @return bool
     */
    public function isApproved()
    {
        return $this->status == self::STATUS_APPROVED;
    }

    /**
     * @return bool
     */
    public function isRejected()
    {
        return $this->status == self::STATUS_REJECTED;
    }
}
