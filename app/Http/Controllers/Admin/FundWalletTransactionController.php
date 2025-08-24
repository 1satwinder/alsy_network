<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ListBuilders\Admin\FundWalletTransactionListBuilder;
use App\ListBuilders\Admin\FundWalletTransferListBuilder;
use App\Models\Admin;
use App\Models\FundWalletTransaction;
use App\Models\Member;
use Auth;
use DB;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class FundWalletTransactionController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request): Renderable|JsonResponse|RedirectResponse
    {
        return FundWalletTransactionListBuilder::render();
    }

    /**
     * @throws Exception
     */
    public function transfer(Request $request): Renderable|JsonResponse|RedirectResponse
    {
        return FundWalletTransferListBuilder::render();
    }

    public function create(): Renderable|RedirectResponse
    {
        return view('admin.fund-wallet-transactions.create', [
            'types' => FundWalletTransaction::TYPES,
            'recentTransactions' => FundWalletTransaction::whereResponsibleType(Admin::class)
                ->with(['member.user'])
                ->latest('id')
                ->take(10)
                ->get(),
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric|min:1',
            'type' => 'required|in:'.implode(',', array_keys(FundWalletTransaction::TYPES)),
            'code' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (! Member::whereCode($value)->notBlocked()->exists()) {
                        $fail('Member ID is invalid or blocked');
                    }
                },
            ],
        ], [
            'code.required' => 'Member ID is required',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $amount = $request->get('amount');
                $member = Member::whereCode($request->get('code'))->first();

                if ($request->get('type') == FundWalletTransaction::TYPE_DEBIT) {
                    if ($member->fund_wallet_balance < $amount) {
                        return redirect()->back()
                            ->with(['error' => 'Member does not have enough balance for this transaction'])
                            ->withInput();
                    } else {
                        $type = FundWalletTransaction::TYPE_DEBIT;
                        $closingBalance = $member->fund_wallet_balance - $amount;
                        $successMessage = 'Wallet debited successfully';
                    }
                } else {
                    $type = FundWalletTransaction::TYPE_CREDIT;
                    $closingBalance = $member->fund_wallet_balance + $amount;
                    $successMessage = 'Wallet credited successfully';
                }

                $member->fundWalletTransactions()->create([
                    'member_id' => $member->id,
                    'opening_balance' => $member->fund_wallet_balance,
                    'closing_balance' => $closingBalance,
                    'amount' => $amount,
                    'tds' => 0.00,
                    'admin_charge' => 0.00,
                    'total' => $amount,
                    'type' => $type,
                    'responsible_id' => Auth::user()->id,
                    'responsible_type' => Admin::class,
                    'comment' => $request->get('comment'),
                ]);

                return redirect()->back()->with(['success' => $successMessage]);
            });
        } catch (Throwable $e) {
            return $this->logExceptionAndRespond($e);
        }
    }
}
