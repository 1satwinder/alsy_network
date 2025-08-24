<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ListBuilders\Admin\MagicPoolBonusIncomeListBuilder;
use App\ListBuilders\Admin\ReferralBonusIncomeListBuilder;
use App\ListBuilders\Admin\RewardBonusIncomeListBuilder;
use App\ListBuilders\Admin\TeamBonusIncomeListBuilder;
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
        return ReferralBonusIncomeListBuilder::render();
    }

    /**
     * @throws Exception
     */
    public function teamBonusIncome(Request $request): Renderable|JsonResponse|RedirectResponse
    {
        return TeamBonusIncomeListBuilder::render();
    }

    /**
     * @throws Exception
     */
    public function rewardBonusIncome(Request $request): Renderable|JsonResponse|RedirectResponse
    {
        return RewardBonusIncomeListBuilder::render();
    }

    /**
     * @throws Exception
     */
    public function magicPoolBonusIncome(Request $request): Renderable|JsonResponse|RedirectResponse
    {
        return MagicPoolBonusIncomeListBuilder::render();
    }
}
