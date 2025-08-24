<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Auth;

class GenealogyController extends Controller
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

        $member = Member::whereCode($code)->first();

        if (! $member || ! $member->isChildOf(Auth::user()->member)) {
            $member = Auth::user()->member;
        }

        $side = null;
        if ($member->id != Auth::user()->member->id) {
            if (Auth::user()->member->left && $member->isChildOf(Auth::user()->member->left)) {
                $side = Member::PARENT_SIDE_LEFT;
            }
            if (Auth::user()->member->right && $member->isChildOf(Auth::user()->member->right)) {
                $side = Member::PARENT_SIDE_RIGHT;
            }
        }

        $member->toGenealogy();

        return view('member.genealogy.show', [
            'member' => $member,
            'side' => $side,
            'genealogyIcons' => $genealogyIcons->all(),
        ]);
    }
}
