<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class GenealogyController extends Controller
{
    public function show($code = null): View|\Illuminate\Foundation\Application|Factory|Application
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

        if (! $member) {
            /** @var Member $member */
            $member = Member::first();
        }

        $member->toGenealogy();

        return view('admin.genealogy.show', [
            'member' => $member,
            'genealogyIcons' => $genealogyIcons->all(),
        ]);
    }
}
