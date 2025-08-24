<?php

namespace App\Models\Relations;

use App\Models\BinaryMatch;
use App\Models\FundWalletTransaction;
use App\Models\KYC;
use App\Models\MagicPoolTree;
use App\Models\MemberInvoice;
use App\Models\MemberLoginLog;
use App\Models\MemberStat;
use App\Models\MemberStatusLog;
use App\Models\Package;
use App\Models\Pin;
use App\Models\PinRequest;
use App\Models\RewardBonus;
use App\Models\SupportTicket;
use App\Models\TopUp;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait MemberRelations
{
    public function user(): BelongsTo|User
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo|static
    {
        return $this->belongsTo(self::class);
    }

    public function children(): HasMany|static
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function magicPoolTrees(): HasMany|static
    {
        return $this->hasMany(MagicPoolTree::class);
    }

    public function currentMagicPoolTrees()
    {
        return $this->hasOne(MagicPoolTree::class, 'member_id')->latest();
    }

    public function package(): BelongsTo|Package
    {
        return $this->belongsTo(Package::class);
    }

    public function topUps(): HasMany|TopUp
    {
        return $this->hasMany(TopUp::class);
    }

    public function sponsor(): BelongsTo|static
    {
        return $this->belongsTo(self::class);
    }

    public function memberStatusLog(): MemberStatusLog|HasMany
    {
        return $this->hasMany(MemberStatusLog::class);
    }

    public function rewardBonus(): BelongsTo|static
    {
        return $this->belongsTo(RewardBonus::class);
    }

    public function left(): HasOne|static
    {
        return $this->hasOne(self::class, 'id', 'left_id');
    }

    public function right(): HasOne|static
    {
        return $this->hasOne(self::class, 'id', 'right_id');
    }

    public function kyc(): HasOne|KYC
    {
        return $this->hasOne(KYC::class);
    }

    public function invoice(): HasOne|MemberInvoice
    {
        return $this->hasOne(MemberInvoice::class);
    }

    public function pinRequests(): HasMany|PinRequest
    {
        return $this->hasMany(PinRequest::class);
    }

    public function sponsored(): HasMany|static
    {
        return $this->hasMany(self::class, 'sponsor_id');
    }

    public function binaryMatches(): HasMany|BinaryMatch
    {
        return $this->hasMany(BinaryMatch::class);
    }

    public function walletTransactions(): HasMany|WalletTransaction
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function pins(): HasMany|Pin
    {
        return $this->hasMany(Pin::class);
    }

    public function supportTicket(): HasMany|SupportTicket
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function loginLogs(): HasMany|MemberLoginLog
    {
        return $this->hasMany(MemberLoginLog::class);
    }

    public function lastLoginLog(): HasOne|MemberLoginLog
    {
        return $this->hasOne(MemberLoginLog::class)
            ->latest();
    }

    public function stat(): HasOne|MemberStat
    {
        return $this->hasOne(MemberStat::class);
    }

    public function fundWalletTransactions(): HasMany|FundWalletTransaction
    {
        return $this->hasMany(FundWalletTransaction::class);
    }
}
