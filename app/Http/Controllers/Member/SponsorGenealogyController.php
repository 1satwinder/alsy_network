<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Contracts\Support\Renderable;
use Str;

class SponsorGenealogyController extends Controller
{
    public function sponsorShow($code = null): Renderable
    {
        $genealogyIcons = collect([
            [
                'name' => 'free',
                'image' => 'images/blank.svg',
                'color' => '#f50114',
            ],
            [
                'name' => 'Incomplete KYC',
                'image' => 'images/blank.svg',
                'color' => '#facc00',
            ],
            [
                'name' => 'Active',
                'image' => 'images/blank.svg',
                'color' => '#38ba4b',
            ],
            [
                'name' => 'Block',
                'image' => 'images/blank.svg',
                'color' => '#1f1b20',
            ],
        ]);

        $member = Member::whereCode($code)->with('kyc', 'media', 'user', 'package', 'sponsor.user', 'currentMagicPoolTrees.magicPoolDetail')->first();

        if (! $member || ! Str::contains($member->sponsor_path, $this->member->sponsor_path)) {
            $member = Member::with('kyc', 'media', 'user', 'package', 'sponsor.user', 'currentMagicPoolTrees.magicPoolDetail')->find($this->member->id);
        }

        return view('member.sponsor-genealogy.show', [
            'member' => $member,
            'genealogyIcons' => $genealogyIcons->all(),
        ]);
    }
}
