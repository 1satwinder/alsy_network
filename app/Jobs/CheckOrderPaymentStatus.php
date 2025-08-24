<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class CheckOrderPaymentStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @throws Throwable
     */
    public function handle(): void
    {
        Order::with('products.product')
            ->whereIn('payment_status', [Order::PAYMENT_IN_CHECKOUT, Order::PAYMENT_AUTHORISE])
            ->whereNotNull('transaction_id')
            ->eachById(function (Order $order) {
                $order->updateAndProcessPaymentStatus(
                    $order->transaction_id
                );
            });
    }
}
