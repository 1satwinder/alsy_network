<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * App\Models\FundWalletTransfer
 *
 * @property int $id
 * @property int $from_member_id
 * @property int $to_member_id
 * @property string $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Member $fromMember
 * @property-read \App\Models\FundWalletTransaction|null $fundWalletTransactions
 * @property-read \App\Models\Member $toMember
 * @method static \Illuminate\Database\Eloquent\Builder|FundWalletTransfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FundWalletTransfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FundWalletTransfer query()
 * @method static \Illuminate\Database\Eloquent\Builder|FundWalletTransfer whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundWalletTransfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundWalletTransfer whereFromMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundWalletTransfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundWalletTransfer whereToMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FundWalletTransfer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FundWalletTransfer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function fromMember(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'from_member_id', 'id');
    }

    public function toMember(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'to_member_id', 'id');
    }

    public function fundWalletTransactions(): MorphOne
    {
        return $this->morphOne(FundWalletTransaction::class, 'responsible');
    }
}
