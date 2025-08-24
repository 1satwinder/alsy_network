<?php

namespace App\Presenters;

use App\Models\TopUpPackageProduct;
use Laracasts\Presenter\Presenter;

/**
 * Class TopUpPresenter
 */
class TopUpPackageProductPresenter extends Presenter
{
    public function price(): string
    {
        return '₹ '.$this->entity->price;
    }

    public function gstSlab(): string
    {
        return TopUpPackageProduct::GST_SLABS[$this->entity->gst_slab];
    }
}
