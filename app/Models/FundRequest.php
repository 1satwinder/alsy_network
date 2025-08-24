<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\FundRequest
 *
 * @property int $id
 * @property int|null $admin_id
 * @property int $member_id
 * @property int $bank_id
 * @property string $amount
 * @property string $transaction_no
 * @property string|null $payment_mode
 * @property \Illuminate\Support\Carbon|null $deposit_date
 * @property int $status 1: Pending, 2: Approved, 3: Reject
 * @property string|null $remark
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Admin|null $admin
 * @property-read \App\Models\Bank $bank
 * @property-read \App\Models\FundWalletTransaction|null $fundWalletTransaction
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Member $member
 * @method static \Illuminate\Database\Eloquent\Builder|FundRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FundRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FundRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|FundRequest whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundRequest whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundRequest whereBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundRequest whereDepositDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundRequest whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundRequest wherePaymentMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundRequest whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundRequest whereTransactionNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundRequest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FundRequest extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    const STATUS_PENDING = 1;

    const STATUS_APPROVED = 2;

    const STATUS_REJECTED = 3;

    const STATUSES = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_APPROVED => 'Approved',
        self::STATUS_REJECTED => 'Rejected',
    ];

    const string MC_RECEIPT = 'payment_proof';

    const PM_CASH = 1;

    const PM_NEFT = 2;

    const PM_RTGS = 3;

    const PM_UPI = 4;

    const PM_CHEQUE = 5;

    const PM_DEMAND_DRAFT = 6;

    const PM_PAYTM = 7;

    const PM_GPAY = 8;

    const PM_PHONEPE = 9;

    const PM_OTHER = 10;

    const PAYMENT_MODES = [
        self::PM_CASH => 'CASH',
        self::PM_NEFT => 'NEFT',
        self::PM_RTGS => 'RTGS',
        self::PM_UPI => 'UPI',
        self::PM_CHEQUE => 'CHEQUE',
        self::PM_DEMAND_DRAFT => 'DEMAND DRAFT',
        self::PM_PAYTM => 'PAYTM',
        self::PM_GPAY => 'GPAY',
        self::PM_PHONEPE => 'PhonePe',
        self::PM_OTHER => 'OTHER',
    ];

    protected $guarded = ['id'];

    protected $casts = ['approve_at' => 'datetime', 'reject_at' => 'datetime', 'deposit_date' => 'datetime'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MC_RECEIPT)
            ->singleFile();
    }

    public function fundWalletTransaction(): MorphOne
    {
        return $this->morphOne(FundWalletTransaction::class, 'responsible');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function isPending(): bool
    {
        return $this->status == self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status == self::STATUS_APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status == self::STATUS_REJECTED;
    }
}
