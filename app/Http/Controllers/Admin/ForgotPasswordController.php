<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\Admin\AdminSendForgotPasswordSMS;
use App\Jobs\Member\SendOTPSMS;
use App\Mail\SendGeneralMail;
use App\Models\Admin;
use App\Models\Otp;
use Closure;
use Exception;
use Hash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Mail;
use Throwable;

class ForgotPasswordController extends Controller
{
    public function create(): Factory|View
    {
        return view('admin.forget-password.create');
    }

    /**
     * @throws ValidationException
     * @throws Exception
     */
    public function Store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'mobile' => [
                'required',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (is_numeric($value)) {
                        if (! preg_match('/^[6789][0-9]{9}$/', $value)) {
                            $fail('The mobile number format is invalid');
                        }
                    }
                },
            ],
        ], [
            'mobile.required' => 'Mobile Number is required',
        ]);

        try {
            if ($admin = Admin::where('mobile', $request->get('mobile'))
                ->first()
            ) {
                if ($admin->roles()->where('name', 'admin')->first()) {
                    $password = mt_rand(11111111, 99999999);

                    $admin->update(['password' => Hash::make($password)]);

                    if (settings('sms_enabled')) {
                        AdminSendForgotPasswordSMS::dispatch($admin, $password);
                    }

                    if (settings('email_enabled')) {
                        $title = 'Forgot Password';
                        $body = sprintf(
                            'We have received a reset password request. Please login with your new password %s',
                            $password,
                        );
                        $AdminUserMail = [
                            'name' => $admin->name,
                            'email' => $admin->email,
                        ];

                        Mail::to($admin->email)->send(new SendGeneralMail($AdminUserMail, $title, $body));
                    }

                    return redirect()
                        ->route('admin.login.create')
                        ->with(['success' => 'Password sent successfully to your registered Mobile Number']);
                } else {
                    return redirect()->back()->with('error', 'The Mobile Number is invalid');
                }
            } else {
                return redirect()->back()->with('error', 'The Mobile Number is invalid');
            }
        } catch (Throwable $e) {
            return $this->logExceptionAndRespond($e);
        }
    }

    /**
     * @throws ValidationException
     */
    //    public function sendOtpForgotPassword(Request $request): JsonResponse
    //    {
    //        $this->validate($request, [
    //            'mobile' => 'required|regex:/^[6789][0-9]{9}$/|exists:admins,mobile',
    //        ], [
    //            'mobile.numeric' => 'The mobile number must be a number',
    //            'mobile.required' => 'The mobile number is required',
    //            'mobile.regex' => 'The mobile number format is invalid',
    //            'mobile.unique' => 'The mobile number has already been taken',
    //        ]);
    //
    //        if (Otp::where('mobile', $request->input('mobile'))
    //                ->where('type', OTP::ACTION_FORGOT_PASSWORD)
    //                ->whereDate('created_at', today())
    //                ->count() >= 5
    //        ) {
    //            return response()->json(['status' => false, 'message' => 'You have reached the maximum number of OTP requests for today']);
    //        }
    //
    //        //        if (env('APP_ENV') !== 'production') {
    //        //            $otp = '111111';
    //        //        } else {
    //        $otp = rand('100001', '999999');
    //        //        }
    //
    //        Otp::whereMobile($request->input('mobile'))
    //            ->where('type', OTP::ACTION_FORGOT_PASSWORD)
    //            ->update([
    //                'status' => Otp::STATUS_USED,
    //            ]);
    //
    //        Otp::create([
    //            'otp' => $otp,
    //            'mobile' => $request->input('mobile'),
    //            'status' => Otp::STATUS_UNUSED,
    //            'type' => Otp::ACTION_FORGOT_PASSWORD,
    //        ]);
    //
    //        if ($request->input('mobile') && settings('sms_enabled')) {
    //            SendOTPSMS::dispatch($request->input('mobile'), $otp);
    //        }
    //
    //        if (env('APP_ENV') == 'production') {
    //            return response()->json(['status' => true, 'message' => 'OTP sent to you successfully']);
    //        } else {
    //            return response()->json(['status' => true, 'message' => "OTP($otp) sent to you successfully"]);
    //        }
    //    }

    //    public function getForgotPasswordOTPTime(Request $request): JsonResponse
    //    {
    //        $otpModel = Otp::where('mobile', $request->get('mobile'))
    //            ->where('type', Otp::ACTION_FORGOT_PASSWORD)
    //            ->orderByDesc('id')
    //            ->first();
    //
    //        $otpEligibleTime = now();
    //        if ($otpModel) {
    //            $otpEligibleTime = $otpModel->created_at->addMinutes(2);
    //        }
    //
    //        return response()->json([
    //            'status' => true,
    //            'otpEligibleTime' => $otpEligibleTime->utc()->format('Y-m-d H:i:s'),
    //        ]);
    //    }
}
