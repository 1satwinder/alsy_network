<?php

namespace App\Models;

use App\Presenters\PayoutPresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laracasts\Presenter\PresentableTrait;

/**
 * App\Models\Payout
 *
 * @property int $id
 * @property string $amount
 * @property string $tds
 * @property string $admin_charge
 * @property string $total
 * @property string $referral_bonus_income
 * @property string $team_bonus_income
 * @property string $magic_pool_bonus_income
 * @property string $magic_pool_upgrade
 * @property string $transfer_to_fund_wallet
 * @property string $admin_credit
 * @property string $admin_debit
 * @property string $payable_amount
 * @property int $status 1: Pending, 2: Complete
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PayoutMember> $payoutMembers
 * @property-read int|null $payout_members_count
 * @method static Builder|Payout fromDate(string $date)
 * @method static Builder|Payout maxAdminCharge($max)
 * @method static Builder|Payout maxAdminCredit($max)
 * @method static Builder|Payout maxAdminDebit($max)
 * @method static Builder|Payout maxAmount($max)
 * @method static Builder|Payout maxPayableAmount($max)
 * @method static Builder|Payout maxTds($max)
 * @method static Builder|Payout maxTotal($max)
 * @method static Builder|Payout minAdminCharge($min)
 * @method static Builder|Payout minAdminCredit($min)
 * @method static Builder|Payout minAdminDebit($min)
 * @method static Builder|Payout minAmount($min)
 * @method static Builder|Payout minPayableAmount($min)
 * @method static Builder|Payout minTds($min)
 * @method static Builder|Payout minTotal($min)
 * @method static Builder|Payout newModelQuery()
 * @method static Builder|Payout newQuery()
 * @method static Builder|Payout query()
 * @method static Builder|Payout toDate(string $date)
 * @method static Builder|Payout whereAdminCharge($value)
 * @method static Builder|Payout whereAdminCredit($value)
 * @method static Builder|Payout whereAdminDebit($value)
 * @method static Builder|Payout whereAmount($value)
 * @method static Builder|Payout whereComment($value)
 * @method static Builder|Payout whereCreatedAt($value)
 * @method static Builder|Payout whereId($value)
 * @method static Builder|Payout whereMagicPoolBonusIncome($value)
 * @method static Builder|Payout whereMagicPoolUpgrade($value)
 * @method static Builder|Payout wherePayableAmount($value)
 * @method static Builder|Payout whereReferralBonusIncome($value)
 * @method static Builder|Payout whereStatus($value)
 * @method static Builder|Payout whereTds($value)
 * @method static Builder|Payout whereTeamBonusIncome($value)
 * @method static Builder|Payout whereTotal($value)
 * @method static Builder|Payout whereTransferToFundWallet($value)
 * @method static Builder|Payout whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Payout extends Model
{
    use PresentableTrait;

    const STATUS_PENDING = 1;

    const STATUS_COMPLETED = 2;

    const STATUSES = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_COMPLETED => 'Completed',
    ];

    protected $guarded = [];

    protected $presenter = PayoutPresenter::class;

    /**
     * @return HasMany|PayoutMember
     */
    public function payoutMembers()
    {
        return $this->hasMany(PayoutMember::class);
    }

    public function isPending(): bool
    {
        return $this->status == self::STATUS_PENDING;
    }

    public function isCompleted(): bool
    {
        return $this->status == self::STATUS_COMPLETED;
    }

    public function scopeFromDate(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.created_at", '>=', $date);
    }

    public function scopeToDate(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.created_at", '<=', $date);
    }

    public function scopeMinAdminDebit(Builder $query, $min): Builder
    {
        return $query->where("{$this->getTable()}.admin_debit", '>=', $min);
    }

    public function scopeMaxAdminDebit(Builder $query, $max): Builder
    {
        return $query->where("{$this->getTable()}.admin_debit", '<=', $max);
    }

    public function scopeMinAdminCredit(Builder $query, $min): Builder
    {
        return $query->where("{$this->getTable()}.admin_credit", '>=', $min);
    }

    public function scopeMaxAdminCredit(Builder $query, $max): Builder
    {
        return $query->where("{$this->getTable()}.admin_credit", '<=', $max);
    }

    public function scopeMinAdminCharge(Builder $query, $min): Builder
    {
        return $query->where("{$this->getTable()}.admin_charge", '>=', $min);
    }

    public function scopeMaxAdminCharge(Builder $query, $max): Builder
    {
        return $query->where("{$this->getTable()}.admin_charge", '<=', $max);
    }

    public function scopeMinAmount(Builder $query, $min): Builder
    {
        return $query->where("{$this->getTable()}.amount", '>=', $min);
    }

    public function scopeMaxAmount(Builder $query, $max): Builder
    {
        return $query->where("{$this->getTable()}.amount", '<=', $max);
    }

    public function scopeMinPayableAmount(Builder $query, $min): Builder
    {
        return $query->where("{$this->getTable()}.payable_amount", '>=', $min);
    }

    public function scopeMaxPayableAmount(Builder $query, $max): Builder
    {
        return $query->where("{$this->getTable()}.payable_amount", '<=', $max);
    }

    public function scopeMinTds(Builder $query, $min): Builder
    {
        return $query->where("{$this->getTable()}.tds", '>=', $min);
    }

    public function scopeMaxTds(Builder $query, $max): Builder
    {
        return $query->where("{$this->getTable()}.tds", '<=', $max);
    }

    public function scopeMinTotal(Builder $query, $min): Builder
    {
        return $query->where("{$this->getTable()}.total", '>=', $min);
    }

    public function scopeMaxTotal(Builder $query, $max): Builder
    {
        return $query->where("{$this->getTable()}.total", '<=', $max);
    }
}
