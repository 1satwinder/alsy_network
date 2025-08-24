<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\ListBuilders\Member\FundWalletTransferListBuilder;
use App\Models\FundWalletTransaction;
use App\Models\FundWalletTransfer;
use App\Models\Member;
use Auth;
use DB;
use Exception;
use Hash;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class FundWalletTransferController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(): Renderable|JsonResponse|RedirectResponse
    {
        return FundWalletTransferListBuilder::render([
            'member_id' => $this->member->id,
        ]);
    }

    public function create(): RedirectResponse|Renderable
    {
        return view('member.fund-wallet-transfer.create', [
            'member' => Auth::user()->member,
        ]);
    }

    /**
     * @throws ValidationException
     * @throws Throwable
     */
    public function store(Request $request): RedirectResponse|Renderable
    {
        $this->validate($request, [
            'code' => 'required|exists:members,code',
            'amount' => 'required|numeric|min:1',
            //            'financial_password' => 'required',
        ], [
            'amount.required' => 'The amount is required',
            'amount.numeric' => 'The amount must be a number.',
            'amount.min' => 'The number of amount must be at least 1',
            'code.required' => 'The Member ID is required',
            'code.exists' => 'Member not found',
            //            'financial_password.required' => 'The transaction password is required',
        ]);

        //        if (! Hash::check($request->get('financial_password'), $this->member->user->financial_password)) {
        //            return redirect()->back()->with('error', 'Invalid Transaction Password.')->withInput();
        //        }

        $toMember = Member::where('code', $request->get('code'))->first();

        if (! $toMember) {
            return redirect()
                ->back()
                ->withInput()
                ->with(['error' => 'Member not found']);
        }

        if ($toMember->status == Member::STATUS_BLOCKED) {
            return redirect()
                ->back()
                ->withInput()
                ->with(['error' => 'Member blocked by admin']);
        }

        if ($toMember->id == $this->member->id) {
            return redirect()
                ->back()
                ->withInput()
                ->with(['error' => 'Can not transfer to self']);
        }

        if ($request->get('amount') > $this->member->fund_wallet_balance) {
            return redirect()
                ->back()
                ->withInput()
                ->with(['error' => 'You do not have enough balance for this transaction']);
        }

        try {
            DB::transaction(function () use ($toMember, $request) {
                $fundWalletTransfer = FundWalletTransfer::create([
                    'from_member_id' => $this->member->id,
                    'to_member_id' => $toMember->id,
                    'amount' => $request->get('amount'),
                ]);

                $fundWalletTransfer->fromMember->fundWalletTransactions()->create([
                    'opening_balance' => $fundWalletTransfer->fromMember->fund_wallet_balance,
                    'closing_balance' => $fundWalletTransfer->fromMember->fund_wallet_balance - $fundWalletTransfer->amount,
                    'amount' => $fundWalletTransfer->amount,
                    'total' => $fundWalletTransfer->amount,
                    'type' => FundWalletTransaction::TYPE_DEBIT,
                    'tds' => 0,
                    'admin_charge' => 0,
                    'responsible_id' => $fundWalletTransfer->id,
                    'responsible_type' => FundWalletTransfer::class,
                    'comment' => 'Transfer to '.$fundWalletTransfer->toMember->user->name.'('.$fundWalletTransfer->toMember->code.')',
                ]);

                $fundWalletTransfer->toMember->fundWalletTransactions()->create([
                    'opening_balance' => $fundWalletTransfer->toMember->fund_wallet_balance,
                    'closing_balance' => $fundWalletTransfer->toMember->fund_wallet_balance + $fundWalletTransfer->amount,
                    'amount' => $fundWalletTransfer->amount,
                    'total' => $fundWalletTransfer->amount,
                    'type' => FundWalletTransaction::TYPE_CREDIT,
                    'tds' => 0,
                    'admin_charge' => 0,
                    'responsible_id' => $fundWalletTransfer->id,
                    'responsible_type' => FundWalletTransfer::class,
                    'comment' => 'Received from '.$fundWalletTransfer->fromMember->user->name.'('.$fundWalletTransfer->fromMember->code.')',
                ]);
            });

            return redirect()->route('member.fund-wallet-transfer.index')
                ->with('success', 'Fund wallet transferred successfully');

        } catch (Throwable $e) {
            return $this->logExceptionAndRespond($e);
        }
    }
}
