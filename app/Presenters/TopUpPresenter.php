<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

/**
 * Class TopUpPresenter
 */
class TopUpPresenter extends Presenter
{
    public function amount(): string
    {
        return $this->entity->amount;
    }

    public function gstAmount(): string
    {
        return $this->entity->gst_amount;
    }
}
