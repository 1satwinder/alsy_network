<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BinaryMatch
 *
 * @property-read \App\Models\WalletTransaction|null $walletTransactions
 * @method static \Illuminate\Database\Eloquent\Builder|BinaryMatch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BinaryMatch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BinaryMatch query()
 * @mixin \Eloquent
 */
class BinaryMatch extends Model
{
    protected $guarded = [];

    public function walletTransactions()
    {
        return $this->morphOne(WalletTransaction::class, 'responsible');
    }
}
