<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ListBuilders\Admin\LevelDetailListBuilder;
use App\ListBuilders\Admin\MostActiveMemberListBuilder;
use App\ListBuilders\Admin\TopEarnersListBuilder;
use App\ListBuilders\Admin\TopUpListBuilder;
use App\Models\Member;
use App\Models\RewardBonus;
use App\Models\RewardBonusIncome;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * @throws Exception
     */
    public function topUp(): Renderable|JsonResponse|RedirectResponse
    {
        return TopUpListBuilder::render();
    }

    /**
     * @throws Exception
     */
    public function mostActiveMember(): Renderable|JsonResponse|RedirectResponse
    {
        return MostActiveMemberListBuilder::render();
    }

    /**
     * @throws Exception
     */
    public function topEarners(): Renderable|JsonResponse|RedirectResponse
    {
        return TopEarnersListBuilder::render();
    }

    public function reward(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'code' => 'required|exists:members,code',
            ], [
                'code.required' => 'The Member ID is required.',
                'code.exists' => 'Invalid Member ID.',
            ]);
            $member = Member::whereCode($request->get('code'))->first();

            $details = RewardBonus::get()
                ->map(function ($reward) use ($member) {
                    $activeMember = Member::whereLevel($member->level + $reward->level)
                        ->whereNotNull('package_id')
                        ->where('sponsor_path', 'like', $member->sponsor_path.'/%')
                        ->count();

                    $status = 'Pending';
                    $statusColor = 'warning';

                    $rewardBonusIncome = RewardBonusIncome::whereMemberId($member->id)
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

            return view('admin.reports.reward-report', [
                'rewards' => $details,
                'member' => $member,
            ]);
        }

        return view('admin.reports.reward-report', [
            'member' => null,
        ]);
    }

    public function level(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'code' => 'required|exists:members,code',
            ], [
                'code.required' => 'The Member ID is required.',
                'code.exists' => 'Invalid Member ID.',
            ]);
            $member = Member::whereCode($request->get('code'))->first();

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

            return view('admin.reports.level', [
                'levelDetails' => $details,
                'member' => $member,
            ]);
        }

        return view('admin.reports.level', [
            'member' => null,
        ]);
    }

    /**
     * @throws Exception
     */
    public function levelDetail(Request $request, $level = 0): Renderable|JsonResponse|RedirectResponse
    {
        if ($request->get('level')) {
            $level = (int) $request->get('level');
        }

        $member = Member::find($request->get('memberId'));

        return LevelDetailListBuilder::render([
            'path' => $member->sponsor_path,
            'memberLevel' => $member->level,
            'level' => $level,
        ],
            name: 'My '.($level ? ' Level '.$level.' Team' : '')
        );
    }
}
