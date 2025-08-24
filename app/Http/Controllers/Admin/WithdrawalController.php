<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ListBuilders\Admin\WithdrawalRequestListBuilder;
use App\Models\WalletTransaction;
use App\Models\WithdrawalRequest;
use DB;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class WithdrawalController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request): Renderable|JsonResponse|RedirectResponse
    {
        return WithdrawalRequestListBuilder::render();
    }

    /**
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function update(Request $request, WithdrawalRequest $withdrawalRequest)
    {
        if (! $withdrawalRequest->isPending()) {
            return redirect()->back()->with(['error' => 'Withdrawal Request is already approved or rejected']);
        }

        $this->validate($request, ['status' => 'required|in:'.implode(',', [WithdrawalRequest::STATUS_APPROVED, WithdrawalRequest::STATUS_REJECTED])]);

        try {
            return DB::transaction(function () use ($withdrawalRequest, $request) {

                if ($request->get('status') == WithdrawalRequest::STATUS_REJECTED) {

                    $withdrawalRequest->update([
                        'status' => WithdrawalRequest::STATUS_REJECTED,
                        'admin_id' => $this->admin->id,
                    ]);

                    $member = $withdrawalRequest->member;

                    $member->walletTransactions()->create([
                        'member_id' => $member->id,
                        'opening_balance' => $member->wallet_balance,
                        'closing_balance' => $member->wallet_balance + $withdrawalRequest->amount,
                        'amount' => $withdrawalRequest->amount,
                        'tds' => 0.00,
                        'admin_charge' => 0.00,
                        'total' => $withdrawalRequest->amount,
                        'type' => WalletTransaction::TYPE_CREDIT,
                        'responsible_id' => $withdrawalRequest->id,
                        'responsible_type' => WithdrawalRequest::class,
                        'comment' => "Withdrawal Request {$withdrawalRequest->id} rejected.", ]);

                    return redirect()->back()->with(['success' => 'Withdrawal request rejected successfully']);

                } elseif ($request->get('status') == WithdrawalRequest::STATUS_APPROVED) {

                    $withdrawalRequest->update([
                        'status' => WithdrawalRequest::STATUS_APPROVED,
                        'admin_id' => $this->admin->id,
                    ]);

                    return redirect()->back()->with(['success' => 'Withdrawal request approved successfully']);
                } else {
                    return redirect()->back()->with(['error' => 'Something went wrong please try again']);
                }
            });
        } catch (Throwable $e) {
            return redirect()->back()->with(['error' => 'Something went wrong please try again']);
        }
    }

    /**
     * @throws Throwable
     */
    public function statusUpdate(Request $request): RedirectResponse
    {
        if ($request->get('changeStatus')) {
            if (count($request->get('withdrawalRequest')) > 0) {
                DB::transaction(function () use ($request) {
                    WithdrawalRequest::whereIn('id', $request->get('withdrawalRequest'))
                        ->update(['status' => $request->get('changeStatus')]);
                });

                return redirect()->back()->with(['success' => 'Withdrawal Request status changed successfully']);
            }

            return redirect()->back()->with(['error' => 'Please select status']);
        }

        return redirect()->back()->with(['error' => 'Please select status']);
    }
}
