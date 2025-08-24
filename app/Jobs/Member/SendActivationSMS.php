<?php

namespace App\Jobs\Member;

use App\Library\Sms;
use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendActivationSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Member $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    public function handle(): void
    {
        $message = sprintf(
            "Hello User!! %s You've successfully activated. Your journey with us to success starts now.",
            $this->member->code,

        );

        Sms::send($this->member->user->mobile, $message);
    }
}
