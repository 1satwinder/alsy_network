<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\Admin\GeneratePayout;
use App\ListBuilders\Admin\PayoutDetailListBuilder;
use App\ListBuilders\Admin\PayoutListBuilder;
use App\Models\Member;
use App\Models\Payout;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Throwable;

class PayoutController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request): Renderable|JsonResponse|RedirectResponse
    {
        return PayoutListBuilder::render();
    }

    public function store(Request $request): RedirectResponse
    {
        if (Payout::whereStatus(Payout::STATUS_PENDING)->exists()) {
            return redirect()
                ->route('admin.payouts.index')
                ->with(['error' => 'A payout is already processing. Please try again after all payouts have completed processing']);
        }

        $this->validate($request, [
            'memberIds' => 'required|array|min:1',
            'memberIds.*' => [
                'required',
                Rule::exists('members', 'id')->whereNot('status', Member::STATUS_BLOCKED),
            ],
        ], [
            'memberIds.required' => 'Please select at least one member for Payout',
            'memberIds.min' => 'Please select at least one member for Payout',
        ]);
        try {
            GeneratePayout::dispatch($request->get('memberIds'));

            return redirect()
                ->route('admin.payouts.index')
                ->with(['success' => 'Payout will be processed shortly']);
        } catch (Throwable $e) {
            return $this->logExceptionAndRespond($e);
        }
    }

    /**
     * @throws Exception
     */
    public function show($id): Renderable|JsonResponse|RedirectResponse
    {
        return PayoutDetailListBuilder::render(
            extras: [
                'id' => $id,
            ],
        );
    }
}
