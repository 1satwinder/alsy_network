<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\ListBuilders\Member\FundRequestListBuilder;
use App\Models\Bank;
use App\Models\FundRequest;
use Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class FundRequestController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request): RedirectResponse|Renderable|JsonResponse
    {
        return FundRequestListBuilder::render([
            'member_id' => $this->member->id,
        ]);
    }

    public function create(): RedirectResponse|Renderable
    {
        return view('member.fund-request.create', [
            'member' => Auth::user()->member,
            'banks' => Bank::active()->get(),
            'paymentModes' => FundRequest::PAYMENT_MODES,
        ]);
    }

    /**
     * @throws Throwable
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse|Renderable
    {
        $this->validate($request, [
            'amount' => 'required|numeric|min:1',
            'receipt' => 'required',
            'transaction_no' => 'required',
            'payment_mode' => 'required|in:'.implode(',', array_keys(FundRequest::PAYMENT_MODES)),
            'bank_id' => 'required|exists:banks,id',
            'date' => 'required|date',
            'time' => 'required',
        ], [
            'amount.required' => 'The amount is required',
            'transaction_no.required' => 'The Transaction number is required',
            'transaction_no.unique' => 'The Transaction number has already been taken',
            'amount.numeric' => 'The amount must be a number.',
            'amount.min' => 'The number of amount must be at least 1',
            'bank_id.required' => 'The Bank is required',
            'receipt.required' => 'The receipt is required',
            'date.required' => 'The deposit date is required',
            'time.required' => 'The deposit time is required',
        ]);

        try {
            return DB::transaction(function () use ($request) {

                if (FundRequest::where('transaction_no', $request->get('transaction_no'))->lockForUpdate()->exists()) {
                    return redirect()->back()->with(['error' => 'The Transaction Number must be unique and cannot be reused'])->withInput();
                }

                if ($request->get('date')) {
                    $date = Carbon::parse($request->get('date'))->format('Y-m-d').' '.date('H:i:s', strtotime($request->get('time')));
                } else {
                    $date = null;
                }

                $fundRequest = FundRequest::create([
                    'member_id' => Auth::user()->member->id,
                    'bank_id' => $request->get('bank_id'),
                    'payment_mode' => $request->get('payment_mode'),
                    'amount' => $request->get('amount'),
                    'transaction_no' => $request->get('transaction_no'),
                    'deposit_date' => $date,
                ]);

                if ($fileName = $request->get('receipt')) {

                    $fundRequest->addMediaFromDisk($fileName)
                        ->toMediaCollection(FundRequest::MC_RECEIPT);
                }

                return redirect()->route('member.fund-requests.index')->with('success', 'Fund request applied successfully');
            });
        } catch (Throwable $e) {
            return $this->logExceptionAndRespond($e);
        }
    }
}
