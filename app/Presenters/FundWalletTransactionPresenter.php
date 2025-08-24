<?php

namespace App\Presenters;

use App\Models\FundWalletTransaction;
use Laracasts\Presenter\Presenter;

/**
 * Class WalletTransactionPresenter
 */
class FundWalletTransactionPresenter extends Presenter
{
    public function type(): string
    {
        return FundWalletTransaction::TYPES[$this->entity->type];
    }

    public function openingBalance(): string
    {
        return $this->entity->opening_balance;
    }

    public function closingBalance(): string
    {
        return $this->entity->closing_balance;
    }

    public function total(): string
    {
        return $this->entity->total;
    }
}
