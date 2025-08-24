<?php

namespace App\Presenters;

use App\Models\WebSetting;
use Laracasts\Presenter\Presenter;

/**
 * Class MemberPresenter
 */
class WebSettingPresenter extends Presenter
{
    public function logo(): string
    {
        if (! $image = $this->entity->getFirstMediaUrl(WebSetting::MC_LOGO)) {
            $image = asset(asset(env('LOGO', '/images/logo.png')));
        }

        return $image;
    }

    public function favicon(): string
    {
        if (! $image = $this->entity->getFirstMediaUrl(WebSetting::MC_FAVICON)) {
            $image = asset(asset(env('FAVICON', '/images/favicon.png')));
        }

        return $image;
    }

    public function adminBackgroundCSS(): string
    {
        if ($image = $this->entity->getFirstMediaUrl(WebSetting::MC_ADMIN_BACKGROUND)) {
            return "background-image: url($image);";
        }

        return 'background: var(--primary);';
    }

    public function memberBackground(): string
    {
        if ($image = $this->entity->getFirstMediaUrl(WebSetting::MC_MEMBER_BACKGROUND)) {
            return "background-image: url($image);";
        }

        return 'background: var(--primary);';
    }
}
