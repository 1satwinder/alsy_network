<?php

namespace App\Observers;

use App\Models\Member;
use Auth;

class MemberObserver
{
    public function created(Member $member): void
    {
        $member->kyc()->create([]);

        if (! $member->code) {
            do {
                $code = 'AS'.(string) mt_rand(11111111, 99999999);
            } while (Member::whereCode($code)->exists());

            $member->code = $code;
        }

        // Increment the count of members sponsored by this member's sponsor
        if ($member->sponsor) {
            // Save member's sponsor path appending to the sponsor's path
            $member->sponsor_path = $member->sponsor->sponsor_path.'/'.$member->id;
            $member->sponsor->increment('sponsored_count');
        }

        $member->save();
    }

    public function updated(Member $member): void
    {
        if ($member->isDirty('status') && $member->getOriginal('status')) {
            $member->memberStatusLog()->create([
                'admin_user_id' => Auth::user() && Auth::user()->hasRole('admin') ? Auth::user()->id : null,
                'last_status' => $member->getOriginal('status'),
                'new_status' => $member->status,
            ]);
        }
    }
}
