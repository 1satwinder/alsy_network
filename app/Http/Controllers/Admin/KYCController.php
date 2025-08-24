<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ListBuilders\Admin\KYCListBuilder;
use App\Models\KYC;
use DB;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class KYCController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(): Renderable|JsonResponse|RedirectResponse
    {
        return KYCListBuilder::render();
    }

    public function show(KYC $kyc)
    {
        return view('admin.kyc.show', [
            'kyc' => $kyc,
            'panCardImage' => $kyc->getFirstMediaUrl(KYC::MC_PAN_CARD),
            'aadhaarCardImage' => $kyc->getFirstMediaUrl(KYC::MC_AADHAAR_CARD),
            'aadhaarCardBackImage' => $kyc->getFirstMediaUrl(KYC::MC_AADHAAR_CARD_BACK),
            'cancelChequeImage' => $kyc->getFirstMediaUrl(KYC::MC_CANCEL_CHEQUE),
        ]);
    }

    public function edit(KYC $kyc)
    {
        return view('admin.kyc.edit', [
            'kyc' => $kyc,
            'panCardImage' => $kyc->getFirstMediaUrl(KYC::MC_PAN_CARD),
            'aadhaarCardImage' => $kyc->getFirstMediaUrl(KYC::MC_AADHAAR_CARD),
            'aadhaarCardBackImage' => $kyc->getFirstMediaUrl(KYC::MC_AADHAAR_CARD_BACK),
            'cancelChequeImage' => $kyc->getFirstMediaUrl(KYC::MC_CANCEL_CHEQUE),
            'accountTypes' => KYC::ACCOUNT_TYPES,
        ]);
    }

    /**
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function update(KYC $kyc, Request $request)
    {
        $this->validate($request, [
            'pan_card' => 'required|regex:/^[A-Z]{5}[0-9]{4}[A-Z]$/',
            'aadhaar_card' => 'required|digits:12',
            'account_name' => 'required',
            'account_number' => 'required|digits_between:9,18',
            'account_type' => 'required|in:'.implode(',', array_keys(KYC::ACCOUNT_TYPES)),
            'bank_name' => 'required',
            'bank_branch' => 'required',
            'bank_ifsc' => 'required|min:11|max:11|alpha_num',
            //            'pan_card_image' => 'required',
            //            'aadhaar_card_image' => 'required',
            //            'aadhaar_card_back_image' => 'required',
            'cancel_cheque_image' => 'required',
            'nominee_name' => 'required',
            'nominee_relation' => 'required',
        ], [
            'pan_card.required' => 'The PAN Card is required',
            'pan_card.regex' => 'The PAN card format is invalid',
            'aadhaar_card.required' => 'The aadhaar card is required',
            'aadhaar_card.digits' => 'The aadhaar card must be 12 digits',
            'account_number.required' => 'The account number is required',
            'account_number.digits_between' => 'The account number  must be between 9 and 18 digits',
            'account_type.required' => 'The account type is required',
            'bank_name.required' => 'The bank name is required',
            'bank_branch.required' => 'The bank branch is required',
            'bank_ifsc.min' => 'The IFSC code length must be 11',
            'bank_ifsc.max' => 'The IFSC code length must be 11',
            'bank_ifsc.alpha_num' => 'The IFSC may only contain letters and digits',
            'bank_ifsc.required' => 'The IFSC code is required',
            'account_name.required' => 'The account holder name is required',
            'nominee_name.required' => 'The nominee name is required',
            'nominee_relation.required' => 'The nominee relation is required',
        ]);

        if ($request->get('pan_card') !== 'ABBCA0900E') {
            if (
                KYC::wherePanCard($request->get('pan_card'))
                    ->whereNotNull('pan_card')
                    ->where('status', '!=', KYC::STATUS_REJECTED)
                    ->where('member_id', '!=', $kyc->member_id)
                    ->count() >= 3
            ) {
                return redirect()->back()->with('error', 'The same PAN card number can only be used by three members for kyc')->withInput();
            }
        }

        try {
            return DB::transaction(function () use ($kyc, $request) {
                $kyc->update([
                    'pan_card' => $request->get('pan_card'),
                    'aadhaar_card' => $request->get('aadhaar_card'),
                    'account_name' => $request->get('account_name'),
                    'account_number' => $request->get('account_number'),
                    'account_type' => $request->get('account_type'),
                    'bank_name' => $request->get('bank_name'),
                    'bank_branch' => $request->get('bank_branch'),
                    'bank_ifsc' => $request->get('bank_ifsc'),
                    'nominee_name' => $request->get('nominee_name'),
                    'nominee_relation' => $request->get('nominee_relation'),
                ]);

                if ($fileName = $request->get('pan_card_image')) {
                    $kyc->addMediaFromDisk($fileName)
                        ->toMediaCollection(KYC::MC_PAN_CARD);
                }

                if ($fileName = $request->get('aadhaar_card_image')) {
                    $kyc->addMediaFromDisk($fileName)
                        ->toMediaCollection(KYC::MC_AADHAAR_CARD);
                }

                if ($fileName = $request->get('aadhaar_card_back_image')) {
                    $kyc->addMediaFromDisk($fileName)
                        ->toMediaCollection(KYC::MC_AADHAAR_CARD_BACK);
                }

                if ($fileName = $request->get('cancel_cheque_image')) {
                    $kyc->addMediaFromDisk($fileName)
                        ->toMediaCollection(KYC::MC_CANCEL_CHEQUE);
                }

                return redirect()->back()->with('success', 'KYC saved successfully');
            });
        } catch (Throwable $e) {

            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }
}
