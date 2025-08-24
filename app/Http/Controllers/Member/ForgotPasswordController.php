<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Jobs\Member\SendForgotPasswordSMS;
use App\Mail\SendGeneralMail;
use App\Models\Member;
use App\Models\Otp;
use Carbon\Carbon;
use Hash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Mail;

class ForgotPasswordController extends Controller
{
    public function create(): Factory|View
    {
        return view('member.auth.forget');
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'member_code' => 'required|exists:members,code|bail',
            'mobile' => 'required|regex:/^[6789][0-9]{9}$/|exists:users,mobile|bail',
            //            'otp' => 'required|bail',
        ], [
            'otp.required' => 'The otp is required',
            'member_code.required' => 'Member ID is required',
            'member_code.exists' => 'Member ID is incorrect',
            'mobile.numeric' => 'The mobile number must be a number',
            'mobile.required' => 'The mobile number is required',
            'mobile.regex' => 'The mobile number format is invalid',
            'mobile.unique' => 'The mobile number has already been taken',
        ]);

        if (settings('sms_enabled')) {
            if (Otp::where('mobile', $request->input('mobile'))
                ->where('type', Otp::ACTION_FORGOT_PASSWORD)
                ->where('otp', $request->input('otp'))
                ->where('status', Otp::STATUS_UNUSED)
                ->orderByDesc('id')
                ->doesntExist()) {
                return redirect()->back()->with('error', 'OTP is invalid')->withInput();
            }
        }

        $member = Member::whereCode($request->get('member_code'))->first();

        if ($member->user->mobile != $request->input('mobile')) {
            return response()->json(['status' => false, 'message' => 'Member Not Found']);
        }

        if ($member) {
            if ($member->isBlocked()) {
                return redirect()->back()->with('error', 'Member ID is blocked')->withInput();
            }
            $password = mt_rand(11111111, 99999999);

            $member->user->update(['password' => Hash::make($password)]);

            if (settings('sms_enabled')) {
                SendForgotPasswordSMS::dispatch($member, $password);
            }

            if (settings('email_enabled')) {
                $title = 'Forgot Password';
                $body = sprintf(
                    'We have received a reset password request. Please login with your new password %s',
                    $password,
                );
                $user = [
                    'name' => $member->user->name,
                    'email' => $member->user->email,
                ];

                Mail::to($user['email'])->send(new SendGeneralMail($user, $title, $body));
            }

            Otp::where('mobile', $request->input('mobile'))
                ->where('type', Otp::ACTION_FORGOT_PASSWORD)
                ->delete();

            $successMessage = 'Password sent successfully to your registered Mobile Number';

            if (env('APP_ENV') != 'production') {
                $successMessage .= ' (password : '.$password.')';
            }

            return redirect()
                ->route('member.login.create')
                ->with(['success' => $successMessage]);
        } else {
            return redirect()->back()->with('error', 'Member ID is invalid');
        }
    }

    public function sendOtp(Request $request): JsonResponse
    {
        $this->validate($request, [
            'code' => 'required|exists:members,code|bail',
            'mobile' => 'required|regex:/^[6789][0-9]{9}$/|exists:users,mobile|bail',
        ], [
            'code.required' => 'The Sponsor ID is required',
            'code.exists' => 'Member not found',
            'mobile.numeric' => 'The mobile number must be a number',
            'mobile.required' => 'The mobile number is required',
            'mobile.regex' => 'The mobile number format is invalid',
            'mobile.unique' => 'The mobile number has already been taken',
            'mobile.exists' => 'Entered Mobile Number is not registered   our system',
        ]);

        if (Otp::where('mobile', $request->input('mobile'))
            ->where('type', OTP::ACTION_FORGOT_PASSWORD)
            ->whereDate('created_at', today())
            ->count() >= 5
        ) {
            return response()->json(['status' => false, 'message' => 'You have reached the maximum number of OTP requests for today']);
        }

        $member = Member::where('code', $request->input('code'))->first();

        if ($member->user->mobile != $request->input('mobile')) {
            return response()->json(['status' => false, 'message' => 'Member Not Found']);
        }

        $user = [
            'code' => $request->input('code'),
            'mobile' => $request->input('mobile'),
        ];

        if (env('APP_ENV') !== 'production') {
            $otp = rand('100001', '999999');
        } else {
            $otp = '111111';
        }

        Otp::create([
            'otp' => $otp,
            'mobile' => $request->input('mobile'),
            'status' => Otp::STATUS_UNUSED,
            'type' => Otp::ACTION_FORGOT_PASSWORD,
        ]);

        if (settings('email_enabled')) {
            $title = 'Forgot Password OTP';
            $body = 'We have received a reset request. Please reset with your new OTP '.$otp;
            Mail::to($user['email'])->queue(new SendGeneralMail($user, $title, $body));
        }

        if ($request->input('mobile') && settings('sms_enabled')) {
            \App\Jobs\SendOTPSMS::dispatch($request->input('mobile'), $otp);
        }

        if (env('APP_ENV') == 'production') {
            return response()->json(['status' => true, 'message' => 'OTP sent to you successfully']);
        } else {
            return response()->json(['status' => true, 'message' => "OTP($otp) sent to you successfully"]);
        }
    }

    public function getOTPTime(Request $request): JsonResponse
    {
        $otpModel = Otp::where('mobile', $request->get('mobile'))
            ->where('type', Otp::ACTION_FORGOT_PASSWORD)
            ->orderByDesc('id')
            ->first();

        if ($otpModel->created_at->addMinutes(2)->lt(now())) {
            return response()->json([
                'status' => false,
            ]);
        }

        return response()->json([
            'status' => true,
            'startTimestamps' => $otpModel ? Carbon::parse($otpModel->created_at)->timestamp : null,
            'endTimestamps' => $otpModel ? Carbon::parse($otpModel->created_at)->addMinutes(2)->timestamp : null,
            'currentTimestamps' => now()->timestamp,
        ]);
    }
}
