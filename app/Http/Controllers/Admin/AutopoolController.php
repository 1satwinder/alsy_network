<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MagicPool;
use App\Models\MagicPoolTree;

class AutopoolController extends Controller
{
    public function index(MagicPool $magicPool, $code = null)
    {
        $genealogyIcons = collect([
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

        $member = MagicPoolTree::with('parent', 'member.package', 'member.sponsor.package', 'member.sponsor.user', 'children.parent', 'children.member.package', 'children.member.sponsor.package', 'children.member.sponsor.user')
            ->whereHas('member', function ($q) use ($code) {
                return $q->where('code', $code);
            })
            ->where('magic_pool_id', $magicPool->id)->first();

        if (! $member) {
            $member = MagicPoolTree::with('parent', 'member.package', 'member.sponsor.package', 'member.sponsor.user', 'children.parent', 'children.member.package', 'children.member.sponsor.package', 'children.member.sponsor.user')
                ->where('magic_pool_id', $magicPool->id)
                ->orderBy('id', 'ASC')
                ->first();
        }

        return view('admin.autoPool.show', [
            'autoPoolMember' => $member,
            'magicPool' => $magicPool,
            'genealogyIcons' => $genealogyIcons->all(),
        ]);
    }
}
