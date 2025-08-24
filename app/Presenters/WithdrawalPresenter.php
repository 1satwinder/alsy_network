<?php

namespace App\Presenters;

use App\Models\WithdrawalRequest;
use Laracasts\Presenter\Presenter;

/**
 * Class PinRequestPresenter
 */
class WithdrawalPresenter extends Presenter
{
    public function status(): string
    {
        return WithdrawalRequest::STATUSES[$this->entity->status];
    }
}
