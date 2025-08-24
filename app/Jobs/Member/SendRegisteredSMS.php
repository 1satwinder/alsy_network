<?php

namespace App\Jobs\Member;

use App\Library\Sms;
use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Laracasts\Presenter\Exceptions\PresenterException;

class SendRegisteredSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Member $member;

    private string $password;

    private string $financialPassword;

    public function __construct(Member $member, string $password)
    {
        $this->member = $member;
        $this->password = $password;
    }

    /**
     * @throws PresenterException
     */
    public function handle(): void
    {
        $message = sprintf(
            'Welcome , Dear User Your, USER ID: %s, Login Password: %s,You can login with this on our Website.',
            $this->member->code,
            $this->password,
        );

        Sms::send($this->member->user->mobile, $message);
    }
}
