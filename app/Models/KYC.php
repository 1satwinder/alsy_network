<?php

namespace App\Models;

use App\Presenters\KYCPresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laracasts\Presenter\PresentableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\KYC
 *
 * @property int $id
 * @property int $member_id
 * @property int|null $admin_id
 * @property string|null $pan_card
 * @property string|null $aadhaar_card
 * @property string|null $bank_name
 * @property string|null $bank_branch
 * @property string|null $bank_ifsc
 * @property string|null $account_type
 * @property string|null $account_name
 * @property string|null $account_number
 * @property string|null $nominee_name
 * @property string|null $nominee_relation
 * @property int $status 1: Not Applied , 2: Pending, 3: Approved, 4: Rejected
 * @property string|null $reason
 * @property \Illuminate\Support\Carbon|null $applied_at
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property \Illuminate\Support\Carbon|null $rejected_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Admin|null $admin
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Member $member
 * @method static Builder|KYC appliedFromDate(string $date)
 * @method static Builder|KYC appliedToDate(string $date)
 * @method static Builder|KYC approved()
 * @method static Builder|KYC approvedFromDate(string $date)
 * @method static Builder|KYC approvedToDate(string $date)
 * @method static \Database\Factories\KYCFactory factory($count = null, $state = [])
 * @method static Builder|KYC newModelQuery()
 * @method static Builder|KYC newQuery()
 * @method static Builder|KYC notApplied()
 * @method static Builder|KYC pending()
 * @method static Builder|KYC query()
 * @method static Builder|KYC registerFromDate(string $date)
 * @method static Builder|KYC registerToDate(string $date)
 * @method static Builder|KYC rejected()
 * @method static Builder|KYC rejectedFromDate(string $date)
 * @method static Builder|KYC rejectedToDate(string $date)
 * @method static Builder|KYC whereAadhaarCard($value)
 * @method static Builder|KYC whereAccountName($value)
 * @method static Builder|KYC whereAccountNumber($value)
 * @method static Builder|KYC whereAccountType($value)
 * @method static Builder|KYC whereAdminId($value)
 * @method static Builder|KYC whereAppliedAt($value)
 * @method static Builder|KYC whereApprovedAt($value)
 * @method static Builder|KYC whereBankBranch($value)
 * @method static Builder|KYC whereBankIfsc($value)
 * @method static Builder|KYC whereBankName($value)
 * @method static Builder|KYC whereCreatedAt($value)
 * @method static Builder|KYC whereId($value)
 * @method static Builder|KYC whereMemberId($value)
 * @method static Builder|KYC whereNomineeName($value)
 * @method static Builder|KYC whereNomineeRelation($value)
 * @method static Builder|KYC wherePanCard($value)
 * @method static Builder|KYC whereReason($value)
 * @method static Builder|KYC whereRejectedAt($value)
 * @method static Builder|KYC whereStatus($value)
 * @method static Builder|KYC whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class KYC extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use PresentableTrait;

    protected $guarded = ['id'];

    protected $casts = ['applied_at' => 'datetime', 'approved_at' => 'datetime', 'rejected_at' => 'datetime'];

    protected $presenter = KYCPresenter::class;

    public const ACCOUNT_TYPE_SAVING = 1;

    public const ACCOUNT_TYPE_CURRENT = 2;

    public const ACCOUNT_TYPES = [
        self::ACCOUNT_TYPE_SAVING => 'Saving',
        self::ACCOUNT_TYPE_CURRENT => 'Current',
    ];

    const STATUS_NOT_APPLIED = 1;

    const STATUS_PENDING = 2;

    const STATUS_APPROVED = 3;

    const STATUS_REJECTED = 4;

    const STATUSES = [
        self::STATUS_NOT_APPLIED => 'Not Applied',
        self::STATUS_PENDING => 'Pending',
        self::STATUS_APPROVED => 'Approved',
        self::STATUS_REJECTED => 'Rejected',
    ];

    const MC_PAN_CARD = 'pan_card';

    const MC_INVOICE = 'invoice';

    const MC_CANCEL_CHEQUE = 'cancel_cheque';

    const MC_AADHAAR_CARD = 'aadhaar_card';

    const MC_AADHAAR_CARD_BACK = 'aadhaar_card_back';

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MC_PAN_CARD)
            ->singleFile();

        $this->addMediaCollection(self::MC_INVOICE)
            ->singleFile();

        $this->addMediaCollection(self::MC_CANCEL_CHEQUE)
            ->singleFile();

        $this->addMediaCollection(self::MC_AADHAAR_CARD)
            ->singleFile();

        $this->addMediaCollection(self::MC_AADHAAR_CARD_BACK)
            ->singleFile();
    }

    /**
     * @return BelongsTo|Member
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * @return bool
     */
    public function isNotApplied()
    {
        return $this->status == self::STATUS_NOT_APPLIED;
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

    /**
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeNotApplied($query)
    {
        return $query->where('status', self::STATUS_NOT_APPLIED);
    }

    /**
     * @param  Builder  $query
     * @return Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    /**
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    public function scopeRegisterFromDate(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.created_at", '>=', $date);
    }

    public function scopeRegisterToDate(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.created_at", '<=', $date);
    }

    public function scopeAppliedFromDate(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.applied_at", '>=', $date);
    }

    public function scopeAppliedToDate(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.applied_at", '<=', $date);
    }

    public function scopeApprovedFromDate(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.approved_at", '>=', $date);
    }

    public function scopeApprovedToDate(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.approved_at", '<=', $date);
    }

    public function scopeRejectedFromDate(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.rejected_at", '>=', $date);
    }

    public function scopeRejectedToDate(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.rejected_at", '<=', $date);
    }
}
