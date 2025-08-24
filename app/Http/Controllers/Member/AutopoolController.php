<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\MagicPool;
use App\Models\MagicPoolTree;
use Str;

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

        $member = MagicPoolTree::with('member.user', 'parent', 'member.package', 'member.sponsor.package', 'member.sponsor.user', 'children.parent', 'children.member.package', 'children.member.sponsor.package', 'children.member.sponsor.user')
            ->whereHas('member', function ($q) use ($code) {
                return $q->where('code', $code);
            })
            ->where('magic_pool_id', $magicPool->id)->first();

        $treeMember = MagicPoolTree::where('member_id', $this->member->id)
            ->where('magic_pool_id', $magicPool->id)
            ->first();

        if ($treeMember) {
            if (! $member || ! Str::contains($member->path, $treeMember->path)) {
                $member = MagicPoolTree::with('member.user', 'parent', 'member.package', 'member.sponsor.package', 'member.sponsor.user', 'children.parent', 'children.member.package', 'children.member.sponsor.package', 'children.member.sponsor.user')
                    ->whereHas('member', function ($q) {
                        return $q->where('code', $this->member->code);
                    })
                    ->where('magic_pool_id', $magicPool->id)->first();
            }
        }

        if (! $member) {
            $member = MagicPoolTree::with('member.user', 'parent', 'member.package', 'member.sponsor.package', 'member.sponsor.user', 'children.parent', 'children.member.package', 'children.member.sponsor.package', 'children.member.sponsor.user')
                ->whereHas('member', function ($q) {
                    return $q->where('code', $this->member->code);
                })
                ->where('magic_pool_id', $magicPool->id)->latest()->first();
        }

        return view('member.autopool-geneaology.show', ['autoPoolMember' => $member, 'magicPool' => $magicPool, 'genealogyIcons' => $genealogyIcons->all()]);
    }
}
