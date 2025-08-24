<?php

namespace App\Jobs;

use App\Library\Sms;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOTPSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $mobile;

    private int $otp;

    private string $password;

    public function __construct(string $mobile, int $otp)
    {
        $this->mobile = $mobile;
        $this->otp = $otp;
    }

    public function handle(): void
    {
        $message = sprintf(
            'OTP for your mobile number verification is %s.',
            $this->otp,
        );

        Sms::send($this->mobile, $message);
    }
}
