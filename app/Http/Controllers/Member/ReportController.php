<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\ListBuilders\Member\MemberLevelDetailListBuilder;
use App\ListBuilders\Member\MyDirectListBuilder;
use App\ListBuilders\Member\MyDownLineListBuilder;
use App\Models\MagicPool;
use App\Models\MagicPoolTree;
use App\Models\Member;
use App\Models\RewardBonus;
use App\Models\RewardBonusIncome;
use Auth;
use DB;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * @throws Exception
     */
    public function direct(Request $request): RedirectResponse|Renderable|JsonResponse
    {
        return MyDirectListBuilder::render([
            'member_id' => $this->member->id,
        ]);
    }

    /**
     * @throws Exception
     */
    public function myDownline(Request $request): RedirectResponse|Renderable|JsonResponse
    {
        return MyDownLineListBuilder::render([
            'path' => $this->member->sponsor_path,
        ]);
    }

    public function tds(): RedirectResponse|Renderable|JsonResponse
    {
        $member = Auth::user()->member;
        $select = [DB::raw("DATE_FORMAT(created_at, '%M %Y') as monthYear, SUM(tds) as totalTds")];
        $groupBy = DB::raw('monthYear');

        $wt = DB::table('payout_members')
            ->select($select)
            ->where('member_id', $member->id)
            ->groupBy($groupBy);

        $records = $wt->get()->groupBy('monthYear')->map(function ($monthYear, $monthYearIndex) {
            return (object) [
                'monthYear' => $monthYearIndex,
                'gst' => $monthYear->sum('totalTds'),
            ];
        })->sortBy('monthYear')->values();

        return view('member.reports.tds', ['records' => $records]);
    }

    public function rewardAchiever(): RedirectResponse|Renderable|JsonResponse
    {
        $rewardAchievers = RewardBonusIncome::with('member.user')->orderBy('id', 'desc')
            ->paginate();

        //            ->map(function ($income) {
        //                return [
        //                    'name' => $income->member->user->name,
        //                    'image' => $income->member->present()->profileImage(),
        //                    'reward' => $income->reward,
        //                ];
        //            });
        return view('member.reports.reward-achiever', ['records' => $rewardAchievers]);
    }

    public function reward(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $details = RewardBonus::get()
            ->map(function ($reward) {
                $activeMember = Member::whereLevel($this->member->level + $reward->level)
                    ->whereNotNull('package_id')
                    ->where('sponsor_path', 'like', $this->member->sponsor_path.'/%')
                    ->count();

                $status = 'Pending';
                $statusColor = 'warning';

                $rewardBonusIncome = RewardBonusIncome::whereMemberId($this->member->id)
                    ->whereRewardBonusId($reward->id)->first();

                $actualMember = ($activeMember >= $reward->target_active_member) ? $reward->target_active_member : $activeMember;

                if ($rewardBonusIncome) {
                    $remainingMember = 0;
                    if ($rewardBonusIncome->status == RewardBonusIncome::STATUS_FLUSHED) {
                        $status = 'Flushed';
                        $statusColor = 'danger';
                    } else {
                        $status = 'Achieved';
                        $statusColor = 'success';
                    }
                } else {
                    if ($actualMember != $reward->target_active_member) {
                        $remainingMember = abs($activeMember - $reward->target_active_member);
                    } else {
                        $remainingMember = 0;
                    }
                }

                return [
                    'level' => $reward->level,
                    'reward' => $rewardBonusIncome ? $rewardBonusIncome->reward : $reward->reward,
                    'requiredMember' => $reward->target_active_member,
                    'actualMember' => $actualMember,
                    'remainingMember' => $remainingMember,
                    'status' => $status,
                    'statusColor' => $statusColor,
                ];
            });

        return view('member.reports.reward', ['details' => $details]);

    }

    public function level(Request $request)
    {
        $member = $this->member;
        $level = 1;

        do {
            $teamCount = Member::where('level', $level + $member->level)
                ->where('sponsor_path', 'like', $member->sponsor_path.'/%')
                ->count();

            $activeCount = Member::where('level', $level + $member->level)
                ->whereStatus(Member::STATUS_ACTIVE)
                ->where('sponsor_path', 'like', $member->sponsor_path.'/%')
                ->count();

            $inActiveCount = Member::where('level', $level + $member->level)
                ->whereStatus(Member::STATUS_FREE_MEMBER)
                ->where('sponsor_path', 'like', $member->sponsor_path.'/%')
                ->count();

            $details[] = [
                'id' => $level,
                'level' => $level,
                'teamCount' => $teamCount,
                'activeCount' => $activeCount,
                'inActiveCount' => $inActiveCount,
            ];

            $level++;
        } while ($level <= 8);

        return view('member.reports.level', [
            'levelDetails' => $details,
        ]);
    }

    /**
     * @throws Exception
     */
    public function memberLevelDetail(Request $request, $level = 0): Renderable|JsonResponse|RedirectResponse
    {
        if ($request->get('level')) {
            $level = (int) $request->get('level');
        }

        return MemberLevelDetailListBuilder::render([
            'path' => $this->member->sponsor_path,
            'memberLevel' => $this->member->level,
            'level' => $level,
        ],
            name: 'My '.($level ? ' Level '.$level.' Team' : '')
        );
    }

    public function magicPool()
    {
        $index = 0;
        $details = MagicPool::get()->map(function ($pool) use (&$index) {
            $treeMember = MagicPoolTree::whereMemberId($this->member->id)
                ->whereMagicPoolId($pool->id)
                ->first();
            $memberCount = $treeMember ? MagicPoolTree::where('parent_id', $treeMember->id)
                ->count() : 0;

            if ($memberCount == $pool->total_member) {
                $status = 'Achieved';
                $statusColor = 'success';
            } else {
                $index++;
                $status = 'Pending';
                $statusColor = 'warning';
            }
            if ($index == 1) {
                $status = 'Running';
                $statusColor = 'info';
            }

            return [
                'name' => $pool->name,
                'level' => $pool->level,
                'total_member' => $pool->total_member,
                'current_member' => $memberCount,
                'status' => $status,
                'statusColor' => $statusColor,
            ];
        });

        return view('member.reports.magic-pool', [
            'details' => $details,
        ]);
    }
}
