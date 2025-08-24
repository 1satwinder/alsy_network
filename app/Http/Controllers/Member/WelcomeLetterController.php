<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Response;
use Image;
use Laracasts\Presenter\Exceptions\PresenterException;
use PDF;

class WelcomeLetterController extends Controller
{
    /**
     * @throws PresenterException
     */
    public function download(): Response
    {
        $logo = Image::make(
            settings()->getFileUrl('logo', asset(env('LOGO', '/images/logo.png')))
        )->encode('data-url')->__toString();

        $proFile = Image::make(
            $this->member->present()->profileImage()
        )->encode('data-url')->__toString();

        $member = Member::with('user', 'media')->find($this->member->id);

        $pdf = PDF::loadView('member.welcome-letter.show', [
            'member' => $member,
            'logo' => $logo,
            'proFile' => $proFile,
        ]);

        return $pdf->download("Welcome-letter-{$this->member->code}.pdf")->header('X-Vapor-Base64-Encode', 'True');

    }
}
