<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ListBuilders\Admin\RewardBonusDetailListBuilder;
use App\Models\RewardBonus;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RewardBonusController extends Controller
{
    public function index(): Renderable|JsonResponse|RedirectResponse
    {
        return RewardBonusDetailListBuilder::render();
    }

    public function edit(RewardBonus $rewardBonus): Renderable
    {
        return view('admin.reward-bonus.edit', [
            'rewardBonus' => $rewardBonus,
        ]);
    }

    public function update(Request $request, RewardBonus $rewardBonus): Renderable|RedirectResponse
    {
        $this->validate($request, [
            'reward' => 'required|max:255',
        ], [
            'reward.required' => 'The Reward Bonus Name is required',
            'reward.max' => 'The Reward Bonus Name must not be greater than 255 characters',
        ]);

        $rewardBonus->reward = $request->get('reward');
        $rewardBonus->save();

        return redirect()->route('admin.reward-bonus.index')->with(['success' => 'Reward Bonus Updated Successfully']);
    }
}
