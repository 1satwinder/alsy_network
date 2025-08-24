<?php

namespace App\Models;

use App\Presenters\FundWalletTransactionPresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Laracasts\Presenter\PresentableTrait;

/**
 * App\Models\FundWalletTransaction
 *
 * @property int $id
 * @property int $member_id
 * @property int $responsible_id
 * @property string $responsible_type
 * @property string $opening_balance
 * @property string $closing_balance
 * @property string $total
 * @property int $type 1: Credit, 2: Debit
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Member $member
 * @property-read Model|\Eloquent $responsible
 * @method static Builder|FundWalletTransaction credit()
 * @method static Builder|FundWalletTransaction debit()
 * @method static Builder|FundWalletTransaction newModelQuery()
 * @method static Builder|FundWalletTransaction newQuery()
 * @method static Builder|FundWalletTransaction query()
 * @method static Builder|FundWalletTransaction whereClosingBalance($value)
 * @method static Builder|FundWalletTransaction whereComment($value)
 * @method static Builder|FundWalletTransaction whereCreatedAt($value)
 * @method static Builder|FundWalletTransaction whereId($value)
 * @method static Builder|FundWalletTransaction whereMemberId($value)
 * @method static Builder|FundWalletTransaction whereOpeningBalance($value)
 * @method static Builder|FundWalletTransaction whereResponsibleId($value)
 * @method static Builder|FundWalletTransaction whereResponsibleType($value)
 * @method static Builder|FundWalletTransaction whereTotal($value)
 * @method static Builder|FundWalletTransaction whereType($value)
 * @method static Builder|FundWalletTransaction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FundWalletTransaction extends Model
{
    use HasFactory;
    use PresentableTrait;

    protected $guarded = ['id'];

    protected string $presenter = FundWalletTransactionPresenter::class;

    const int TYPE_CREDIT = 1;

    const int TYPE_DEBIT = 2;

    const array TYPES = [
        self::TYPE_CREDIT => 'Credit',
        self::TYPE_DEBIT => 'Debit',
    ];

    public function responsible(): MorphTo
    {
        return $this->morphTo();
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function scopeCredit(Builder $query): Builder
    {
        return $query->where("{$this->getTable()}.type", self::TYPE_CREDIT);
    }

    public function scopeDebit(Builder $query): Builder
    {
        return $query->where("{$this->getTable()}.type", self::TYPE_DEBIT);
    }
}
