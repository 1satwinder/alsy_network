<?php

namespace App\Presenters;

use App\Models\KYC;
use App\Models\Member;
use App\Models\User;
use Exception;
use Laracasts\Presenter\Presenter;

/**
 * Class MemberPresenter
 */
class MemberPresenter extends Presenter
{
    /**
     * @return string
     */
    public function genealogyImage()
    {
        // Check if member has a profile image and it's accessible
        if ($this->entity->hasMedia(Member::MC_PROFILE_IMAGE)) {
            $image = $this->entity->getFirstMediaUrl(Member::MC_PROFILE_IMAGE);
            
            // Only return the image if it's a valid URL
            if ($image && filter_var($image, FILTER_VALIDATE_URL)) {
                return $image;
            }
        }
        
        // Fallback to blank.svg if no image or invalid image URL
        return asset('images/blank.svg');
    }

    public function genealogyImageBackground(): string
    {
        if ($this->entity->status == Member::STATUS_FREE_MEMBER) {
            return '#f50114';
        } elseif ($this->entity->status == Member::STATUS_ACTIVE) {
            if (! $this->entity->kyc || $this->entity->kyc->status != KYC::STATUS_APPROVED) {
                return '#facc00';
            } else {
                return '#38ba4b';
            }
        } elseif ($this->entity->status == Member::STATUS_BLOCKED) {
            return '#1f1b20';
        }

        return '';
    }

    /**
     * @return string
     */
    public function profileImage()
    {
        if (! $image = $this->entity->getFirstMediaUrl(Member::MC_PROFILE_IMAGE)) {
            if ($this->entity->user->gender == User::GENDER_FEMALE) {
                $image = asset('images/female.png');
            } else {
                $image = asset('images/user.png');
            }
        }

        return $image;
    }

    /**
     * @return string
     */
    public function referralLink()
    {
        return route('member.register.create', ['code' => $this->entity->code]);
    }

    public function kycStatus(): string
    {
        if ($this->entity->kyc) {
            return KYC::STATUSES[$this->entity->kyc->status];
        } else {
            return 'N/A';
        }
    }

    /**
     * @return string
     */
    public function status()
    {
        if ($this->entity->isFree()) {
            return 'Free';
        } elseif ($this->entity->isBlocked()) {
            return 'Blocked';
        } else {
            return 'Active';
        }
    }

    public function isPaid()
    {
        if ($this->entity->is_paid == Member::IS_UN_PAID) {
            return 'Un Paid';
        } else {
            return 'Paid';
        }
    }

    public function walletBalance(): string
    {
        return env('APP_CURRENCY', ' र ').round($this->entity->wallet_balance, 2);
    }
}
