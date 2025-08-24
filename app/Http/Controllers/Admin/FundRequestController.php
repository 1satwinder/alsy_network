<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ListBuilders\Admin\FundRequestListBuilder;
use App\Models\FundRequest;
use App\Models\FundWalletTransaction;
use App\Models\User;
use DB;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FundRequestController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(): Renderable|JsonResponse|RedirectResponse
    {
        return FundRequestListBuilder::render();
    }

    /**
     * @throws ValidationException
     */
    public function approve(FundRequest $fundRequest, Request $request)
    {
        $fundRequest = FundRequest::where('id', $fundRequest->id)->lockForUpdate()->first();

        if ($fundRequest->status == FundRequest::STATUS_APPROVED) {
            return redirect()->route('admin.fund-requests.index')->with(['error' => 'Fund Request already approved']);
        }

        if ($fundRequest->status != FundRequest::STATUS_PENDING) {
            return redirect()->route('admin.fund-requests.index')->with(['error' => 'Please select valid fund request']);
        }

        try {
            return DB::transaction(function () use ($fundRequest) {
                $fundRequest->update([
                    'status' => FundRequest::STATUS_APPROVED,
                    'admin_id' => $this->admin->id,
                ]);

                $member = $fundRequest->member;
                $type = FundWalletTransaction::TYPE_CREDIT;
                $closingBalance = $member->fund_wallet_balance + $fundRequest->amount;
                $successMessage = 'Fund Request credited successfully';

                $member->fundWalletTransactions()->create([
                    'member_id' => $member->id,
                    'opening_balance' => $member->fund_wallet_balance,
                    'closing_balance' => $closingBalance,
                    'amount' => $fundRequest->amount,
                    'total' => $fundRequest->amount,
                    'type' => $type,
                    'responsible_id' => $member->id,
                    'responsible_type' => User::class,
                    'comment' => $successMessage,
                ]);

                return redirect()->back()->with('success', 'Fund Request approved successfully');
            });
        } catch (\Throwable $e) {
            return $this->logExceptionAndRespond($e);
        }
    }

    /**
     * @throws ValidationException
     */
    public function reject(FundRequest $fundRequest, Request $request)
    {
        $fundRequest = FundRequest::where('id', $fundRequest->id)->lockForUpdate()->first();

        if ($fundRequest->status != FundRequest::STATUS_PENDING) {
            return redirect()->route('admin.fund-requests.index')->with(['error' => 'Please select valid fund request']);
        }

        try {
            return DB::transaction(function () use ($fundRequest, $request) {
                $fundRequest->update([
                    'status' => FundRequest::STATUS_REJECTED,
                    'remark' => $request->get('remark') ? $request->get('remark') : null,
                    'admin_id' => $this->admin->id,
                ]);

                return redirect()->back()->with('success', 'Fund Request rejected successfully');
            });
        } catch (\Throwable $e) {
            return $this->logExceptionAndRespond($e);
        }
    }
}
