<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;

class SponsorGenealogyController extends Controller
{
    public function show($code = null)
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

        $member = Member::with('kyc', 'media', 'user', 'package', 'sponsor.user', 'currentMagicPoolTrees.magicPoolDetail')->whereCode($code)->first();
        if (! $member) {
            /** @var Member $member */
            $member = Member::with('kyc', 'media', 'user', 'package', 'sponsor.user', 'currentMagicPoolTrees.magicPoolDetail')->first();
        }

        return view('admin.sponsor-genealogy.show', [
            'member' => $member,
            'genealogyIcons' => $genealogyIcons->all(),
        ]);
    }
}
