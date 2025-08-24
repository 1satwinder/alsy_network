<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\ListBuilders\Member\MagicPoolBonusIncomeListBuilder;
use App\ListBuilders\Member\ReferralBonusIncomeListBuilder;
use App\ListBuilders\Member\RewardBonusIncomeListBuilder;
use App\ListBuilders\Member\TeamBonusIncomeListBuilder;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    /**
     * @throws Exception
     */
    public function referralBonusIncome(Request $request): Renderable|JsonResponse|RedirectResponse
    {
        return ReferralBonusIncomeListBuilder::render([
            'member_id' => $this->member->id,
        ]);
    }

    /**
     * @throws Exception
     */
    public function teamBonusIncome(Request $request): Renderable|JsonResponse|RedirectResponse
    {
        return TeamBonusIncomeListBuilder::render([
            'member_id' => $this->member->id,
        ]);
    }

    /**
     * @throws Exception
     */
    public function rewardBonusIncome(Request $request): Renderable|JsonResponse|RedirectResponse
    {
        return RewardBonusIncomeListBuilder::render([
            'member_id' => $this->member->id,
        ]);
    }

    /**
     * @throws Exception
     */
    public function magicPoolBonusIncome(Request $request): Renderable|JsonResponse|RedirectResponse
    {
        return MagicPoolBonusIncomeListBuilder::render([
            'member_id' => $this->member->id,
        ]);
    }
}
