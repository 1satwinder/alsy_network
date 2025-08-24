<?php

namespace App\Jobs\Admin;

use App\Library\Sms;
use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AdminSendForgotPasswordSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $password;

    public Admin $admin;

    public function __construct(Admin $admin, string $password)
    {
        $this->admin = $admin;
        $this->password = $password;
    }

    public function handle(): void
    {
        $message = sprintf(
            'Dear %s , We have received a reset password request. Please login with Your new password %s.',
            $this->admin->name,
            $this->password
        );

        Sms::send($this->admin->mobile, $message);
    }
}
