<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\ListBuilders\Member\PinRequestListBuilder;
use App\Models\Bank;
use App\Models\Package;
use App\Models\PinRequest;
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

class PinRequestController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request): RedirectResponse|Renderable|JsonResponse
    {
        return PinRequestListBuilder::render([
            'member_id' => $this->member->id,
        ]);
    }

    public function create(): RedirectResponse|Renderable
    {
        return view('member.pin-request.create', [
            'member' => Auth::user()->member,
            'packages' => Package::whereStatus(Package::STATUS_ACTIVE)->get(),
            'banks' => Bank::active()->get(),
            'paymentModes' => PinRequest::PAYMENT_MODES,
        ]);
    }

    /**
     * @throws Throwable
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse|Renderable
    {
        $this->validate($request, [
            'package_id' => 'required|exists:packages,id',
            'no_pins' => 'required|numeric|min:1|max:1000',
            //            'receipt' => 'required',
            'payment_mode' => 'required|in:'.implode(',', array_keys(PinRequest::PAYMENT_MODES)),
            'date' => 'required|date|before:tomorrow',
            'time' => 'required',
            'reference_no' => 'required',
            'bank_id' => 'required',
        ], [
            'package_id.required' => 'The Package is required',
            'no_pins.required' => 'The Pin Quantity is required',
            'no_pins.min' => 'The number of Pin must be at least 1',
            'no_pins.max' => 'The Pin may not be greater than 1000',
            'reference_no.required' => 'The Transaction number is required',
            'date.required' => 'The Deposit Date is required',
            'time.required' => 'The Deposit Time is required',
            'bank_id.required' => 'The Bank is required',
        ]);

        DB::transaction(function () use ($request) {
            $pinRequest = PinRequest::create([
                'member_id' => Auth::user()->member->id,
                'bank_id' => $request->get('bank_id'),
                'payment_mode' => $request->get('payment_mode'),
                'reference_no' => $request->get('reference_no'),
                'deposit_date' => Carbon::parse($request->get('date'))->format('Y-m-d').' '.date('H:i:s', strtotime($request->time)),
                'no_pins' => $request->get('no_pins'),
                'package_id' => $request->get('package_id'),
            ]);

            if ($fileName = $request->get('receipt')) {

                $pinRequest->addMediaFromDisk($fileName)
                    ->toMediaCollection(PinRequest::MC_RECEIPT);
            }
        });

        return redirect()->route('member.pin-requests.index')->with('success', 'Pin request created successfully.');
    }
}
