<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PayoutMember
 *
 * @property int $id
 * @property int $member_id
 * @property int $payout_id
 * @property string|null $pan_card
 * @property string|null $aadhaar_card
 * @property string|null $bank_name
 * @property string|null $bank_branch
 * @property string|null $bank_ifsc
 * @property string|null $account_type
 * @property string|null $account_name
 * @property string|null $account_number
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
 * @property int $status  1: Pending ,2: Complete
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Member $member
 * @method static Builder|PayoutMember fromDate($fromDate)
 * @method static Builder|PayoutMember maxAdminCharge($max)
 * @method static Builder|PayoutMember maxAdminCredit($max)
 * @method static Builder|PayoutMember maxAdminDebit($max)
 * @method static Builder|PayoutMember maxAmount($max)
 * @method static Builder|PayoutMember maxPayableAmount($max)
 * @method static Builder|PayoutMember maxPayoutAmount($max)
 * @method static Builder|PayoutMember maxTds($max)
 * @method static Builder|PayoutMember maxTotal($max)
 * @method static Builder|PayoutMember minAdminCharge($min)
 * @method static Builder|PayoutMember minAdminCredit($min)
 * @method static Builder|PayoutMember minAdminDebit($min)
 * @method static Builder|PayoutMember minAmount($min)
 * @method static Builder|PayoutMember minPayableAmount($min)
 * @method static Builder|PayoutMember minTds($min)
 * @method static Builder|PayoutMember minTotal($min)
 * @method static Builder|PayoutMember newModelQuery()
 * @method static Builder|PayoutMember newQuery()
 * @method static Builder|PayoutMember query()
 * @method static Builder|PayoutMember toDate($toDate)
 * @method static Builder|PayoutMember whereAadhaarCard($value)
 * @method static Builder|PayoutMember whereAccountName($value)
 * @method static Builder|PayoutMember whereAccountNumber($value)
 * @method static Builder|PayoutMember whereAccountType($value)
 * @method static Builder|PayoutMember whereAdminCharge($value)
 * @method static Builder|PayoutMember whereAdminCredit($value)
 * @method static Builder|PayoutMember whereAdminDebit($value)
 * @method static Builder|PayoutMember whereAmount($value)
 * @method static Builder|PayoutMember whereBankBranch($value)
 * @method static Builder|PayoutMember whereBankIfsc($value)
 * @method static Builder|PayoutMember whereBankName($value)
 * @method static Builder|PayoutMember whereComment($value)
 * @method static Builder|PayoutMember whereCreatedAt($value)
 * @method static Builder|PayoutMember whereId($value)
 * @method static Builder|PayoutMember whereMagicPoolBonusIncome($value)
 * @method static Builder|PayoutMember whereMagicPoolUpgrade($value)
 * @method static Builder|PayoutMember whereMemberId($value)
 * @method static Builder|PayoutMember wherePanCard($value)
 * @method static Builder|PayoutMember wherePayableAmount($value)
 * @method static Builder|PayoutMember wherePayoutId($value)
 * @method static Builder|PayoutMember whereReferralBonusIncome($value)
 * @method static Builder|PayoutMember whereStatus($value)
 * @method static Builder|PayoutMember whereTds($value)
 * @method static Builder|PayoutMember whereTeamBonusIncome($value)
 * @method static Builder|PayoutMember whereTotal($value)
 * @method static Builder|PayoutMember whereTransferToFundWallet($value)
 * @method static Builder|PayoutMember whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PayoutMember extends Model
{
    protected $guarded = [];

    const STATUS_PENDING = 1;

    const STATUS_COMPLETE = 2;

    const STATUSES = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_COMPLETE => 'Completed',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
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

    /**
     * @return Builder
     */
    public function scopeMinAdminDebit(Builder $query, $min)
    {
        return $query->where("{$this->getTable()}.admin_debit", '>=', $min);
    }

    /**
     * @return Builder
     */
    public function scopeMaxAdminDebit(Builder $query, $max)
    {
        return $query->where("{$this->getTable()}.admin_debit", '<=', $max);
    }

    /**
     * @return Builder
     */
    public function scopeMinAdminCredit(Builder $query, $min)
    {
        return $query->where("{$this->getTable()}.admin_credit", '>=', $min);
    }

    /**
     * @return Builder
     */
    public function scopeMaxAdminCredit(Builder $query, $max)
    {
        return $query->where("{$this->getTable()}.admin_credit", '<=', $max);
    }

    /**
     * @return Builder
     */
    public function scopeMinAmount(Builder $query, $min)
    {
        return $query->where("{$this->getTable()}.amount", '>=', $min);
    }

    /**
     * @return Builder
     */
    public function scopeMaxAmount(Builder $query, $max)
    {
        return $query->where("{$this->getTable()}.amount", '<=', $max);
    }

    /**
     * @return Builder
     */
    public function scopeMinTds(Builder $query, $min)
    {
        return $query->where("{$this->getTable()}.tds", '>=', $min);
    }

    /**
     * @return Builder
     */
    public function scopeMaxTds(Builder $query, $max)
    {
        return $query->where("{$this->getTable()}.tds", '<=', $max);
    }

    /**
     * @return Builder
     */
    public function scopeMinAdminCharge(Builder $query, $min)
    {
        return $query->where("{$this->getTable()}.admin_charge", '>=', $min);
    }

    /**
     * @return Builder
     */
    public function scopeMaxAdminCharge(Builder $query, $max)
    {
        return $query->where("{$this->getTable()}.admin_charge", '<=', $max);
    }

    /**
     * @return Builder
     */
    public function scopeMinTotal(Builder $query, $min)
    {
        return $query->where("{$this->getTable()}.total", '>=', $min);
    }

    /**
     * @return Builder
     */
    public function scopeMaxTotal(Builder $query, $max)
    {
        return $query->where("{$this->getTable()}.total", '<=', $max);
    }

    public function scopeMinPayableAmount(Builder $query, $min): Builder
    {
        return $query->where("{$this->getTable()}.payable_amount", '>=', $min);
    }

    public function scopeMaxPayableAmount(Builder $query, $max): Builder
    {
        return $query->where("{$this->getTable()}.payable_amount", '<=', $max);
    }

    /**
     * @return Builder
     */
    public function scopeMaxPayoutAmount(Builder $query, $max)
    {
        return $query->where("{$this->getTable()}.payable_amount", '<=', $max);
    }
}
