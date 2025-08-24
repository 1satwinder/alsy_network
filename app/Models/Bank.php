<?php

namespace App\Models;

use App\Presenters\BankPresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\Bank
 *
 * @property int $id
 * @property string|null $upi_id
 * @property string|null $upi_number
 * @property string|null $company_payment_department
 * @property string $name
 * @property string $branch_name
 * @property string $account_holder_name
 * @property string $ac_number
 * @property string $ifsc
 * @property int $ac_type 1:saving,2:current
 * @property int $status 1:active,2:inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @method static Builder|Bank active()
 * @method static \Database\Factories\BankFactory factory($count = null, $state = [])
 * @method static Builder|Bank fromDate(string $date)
 * @method static Builder|Bank newModelQuery()
 * @method static Builder|Bank newQuery()
 * @method static Builder|Bank query()
 * @method static Builder|Bank toDate(string $date)
 * @method static Builder|Bank whereAcNumber($value)
 * @method static Builder|Bank whereAcType($value)
 * @method static Builder|Bank whereAccountHolderName($value)
 * @method static Builder|Bank whereBranchName($value)
 * @method static Builder|Bank whereCompanyPaymentDepartment($value)
 * @method static Builder|Bank whereCreatedAt($value)
 * @method static Builder|Bank whereId($value)
 * @method static Builder|Bank whereIfsc($value)
 * @method static Builder|Bank whereName($value)
 * @method static Builder|Bank whereStatus($value)
 * @method static Builder|Bank whereUpdatedAt($value)
 * @method static Builder|Bank whereUpiId($value)
 * @method static Builder|Bank whereUpiNumber($value)
 * @mixin \Eloquent
 */
class Bank extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use PresentableTrait;

    const MC_QR_CODE = 'QR_Code';

    const ACCOUNT_TYPE_SAVING = 1;

    const ACCOUNT_TYPE_CURRENT = 2;

    const TYPES = [
        self::ACCOUNT_TYPE_SAVING => 'Saving',
        self::ACCOUNT_TYPE_CURRENT => 'Current',
    ];

    const STATUS_ACTIVE = 1;

    const STATUS_INACTIVE = 2;

    const STATUSES = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In-Active',
    ];

    protected $guarded = [];

    protected string $presenter = BankPresenter::class;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MC_QR_CODE)
            ->singleFile();
    }

    /**
     * @return Builder
     */
    public function scopeActive(Builder $query)
    {
        return $query->where("{$this->getTable()}.status", self::STATUS_ACTIVE);
    }

    public function scopeFromDate(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.created_at", '>=', $date);
    }

    public function scopeToDate(Builder $query, string $date): Builder
    {
        return $query->whereDate("{$this->getTable()}.created_at", '<=', $date);
    }
}
