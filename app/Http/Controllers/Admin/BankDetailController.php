<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ListBuilders\Admin\BankListBuilder;
use App\Models\Bank;
use DB;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Exceptions\MediaCannotBeDeleted;
use Throwable;

class BankDetailController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request): Renderable|JsonResponse|RedirectResponse
    {
        return BankListBuilder::render();
    }

    /**
     * @throws ValidationException
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     * @throws Throwable
     */
    public function store(Request $request): Renderable|JsonResponse|RedirectResponse
    {
        $validate = $this->validate($request, [
            'name' => 'required',
            'branch_name' => 'required',
            'ifsc' => 'required|min:11|max:11|alpha_num',
            'ac_type' => 'nullable|in:'.implode(',', [Bank::ACCOUNT_TYPE_SAVING, Bank::ACCOUNT_TYPE_CURRENT]),
            'account_holder_name' => 'required',
            'ac_number' => 'required|digits_between:9,18',
            'company_payment_department' => 'nullable|regex:/^[6789][0-9]{9}$/',
            'upi_id' => 'nullable|regex:/^[\w.-]+@[\w.-]+$/',
            'upi_number' => 'nullable|regex:/^[6789][0-9]{9}$/',
        ], [
            'name.required' => 'The bank name is required',
            'branch_name.required' => 'The branch name is required',
            'account_holder_name.required' => 'The account holder name is required',
            'ac_number.required' => 'The account number is required',
            'ac_number.digits_between' => 'The account number must be between 9 and 18 digits',
            'ac_type.required' => 'The account type is required',
            'ifsc.min' => 'The IFSC code length must be 11',
            'ifsc.max' => 'The IFSC code length must be 11',
            'ifsc.alpha_num' => 'The IFSC may only contain letters and digits',
            'ifsc.required' => 'The IFSC code is required',
            'upi.regex' => 'The UPI ID must be a valid format',
            'upi_id.regex' => 'The UPI ID format is invalid',
            'upi_number.regex' => 'The Phone pe | Gpay | Paytm number format is invalid',
            'upi_id.required' => 'The UPI ID is required',
            'company_payment_department.regex' => 'The Mobile Number Of Company Payment Department format is invalid',
        ]);

        DB::transaction(function () use ($request, $validate) {
            $bank = Bank::create(
                collect($validate)->except('qr_code')->toArray()
            );

            if ($fileName = $request->get('qr_code')) {

                $bank->addMediaFromDisk($fileName)
                    ->toMediaCollection(Bank::MC_QR_CODE);
            }
        });

        return redirect()->route('admin.banking.show')->with(['success' => 'Bank details added successfully']);
    }

    public function create(): Factory|View|Application
    {
        return view('admin.bank.create');
    }

    public function edit(Request $request, $id): Factory|View|Application
    {
        $detail = Bank::find($id);

        return view('admin.bank.edit', ['detail' => $detail]);
    }

    /**
     * @throws MediaCannotBeDeleted
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws ValidationException
     */
    public function update(Request $request, $id): Renderable|JsonResponse|RedirectResponse
    {
        $validate = $this->validate($request, [
            'name' => 'required',
            'branch_name' => 'required',
            'ifsc' => 'required|min:11|max:11|alpha_num',
            'ac_type' => 'nullable|in:'.implode(',', [Bank::ACCOUNT_TYPE_SAVING, Bank::ACCOUNT_TYPE_CURRENT]),
            'account_holder_name' => 'required',
            'ac_number' => 'required|digits_between:9,18',
            'status' => 'required',
            'upi_id' => 'nullable|regex:/^[\w.-]+@[\w.-]+$/',
            'company_payment_department' => 'nullable|regex:/^[6789][0-9]{9}$/',
            'upi_number' => 'nullable|regex:/^[6789][0-9]{9}$/',
        ], [
            'name.required' => 'The bank name is required',
            'branch_name.required' => 'The branch name is required',
            'ac_number.required' => 'The account number is required',
            'ac_number.digits_between' => 'The account number must be between 9 and 18 digits',
            'account_holder_name.required' => 'The account holder name is required',
            'ac_type.required' => 'The account type is required',
            'ifsc.min' => 'The IFSC code length must be 11',
            'ifsc.max' => 'The IFSC code length must be 11',
            'ifsc.alpha_num' => 'The IFSC may only contain letters and digits',
            'ifsc.required' => 'The IFSC code is required',
            'upi.regex' => 'The UPI ID must be a valid format',
            'company_payment_department.regex' => 'The Mobile Number Of Company Payment Department format is invalid',
            'upi_id.regex' => 'The UPI ID format is invalid',
            'upi_id.required' => 'The UPI ID is required',
            'upi_number.regex' => 'The Phone pe | Gpay | Paytm number format is invalid',
        ]);

        $bank = Bank::find($id);

        $bank->update(
            collect($validate)->except('qr_code')->toArray()
        );

        if ($fileName = $request->get('qr_code')) {

            $bank->addMediaFromDisk($fileName)
                ->toMediaCollection(Bank::MC_QR_CODE);
        } else {
            if ($oldQrImage = $bank->media()->where('collection_name', 'QR_Code')->first()) {
                $bank->deleteMedia($oldQrImage->id);
            }
        }

        return redirect()->route('admin.banking.show')->with(['success' => 'Bank details updated successfully']);
    }
}
