<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\RegisterRequest;
use App\Jobs\Member\SendRegisteredSMS;
use App\Jobs\SendOTPSMS;
use App\Mail\SendGeneralMail;
use App\Models\Member;
use App\Models\Otp;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Hash;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Mail;
use Throwable;

class RegisterController extends Controller
{
    public function create(): Renderable
    {
        return view('member.auth.register', [
            'states' => State::get(),
        ]);
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $sponsor = Member::whereCode($request->get('code'))->first();

        if ($sponsor->isBlocked()) {
            return redirect()->back()->with('error', 'Sponsor ID is blocked')->withInput();
        }

        if ($request->get('mobile') !== '9469284544') {
            if (User::whereMobile($request->get('mobile'))->count() >= 3) {
                return redirect()->back()->with('error', 'The same mobile can only be used three times')->withInput();
            }
        }

        if (settings('sms_enabled')) {
            if (Otp::where('mobile', $request->input('mobile'))
                ->where('type', Otp::ACTION_REGISTER)
                ->where('otp', $request->input('otp'))
                ->orderByDesc('id')
                ->doesntExist()) {
                return redirect()->back()->with('error', 'OTP is invalid')->withInput();
            }
        }

        try {
            /** @var Member $member */
            $member = DB::transaction(function () use ($sponsor, $request) {

                $user = User::create([
                    'name' => ucwords($request->get('name')),
                    'email' => $request->get('email'),
                    'mobile' => $request->get('mobile'),
                    'password' => Hash::make($request->get('password')),
                    'financial_password' => Hash::make($request->get('password')),
                ]);

                $user->assignRole('member');

                $member = Member::create([
                    'user_id' => $user->id,
                    'sponsor_id' => $sponsor->id,
                    'level' => $sponsor->level + 1,
                    'status' => Member::STATUS_FREE_MEMBER,
                ]);

                if (settings('email_enabled')) {
                    $users = [
                        'email' => $member->user->email,
                        'name' => $member->user->name,
                    ];
                    $title = 'Register';

                    $body = 'You have been successfully registered in '.settings('company_name').". Your Member ID: $member->code , Password: $request->get('password').";

                    Mail::to($users['email'])->queue(new SendGeneralMail($users, $title, $body));
                }

                if (settings('sms_enabled')) {
                    SendRegisteredSMS::dispatch($member, $request->get('password'));
                }

                Otp::where('mobile', $request->input('mobile'))->delete();

                return $member;
            });
        } catch (Throwable $e) {
            return $this->logExceptionAndRespond($e);
        }

        return redirect()
            ->route('member.register.create')
            ->with(['success' => 'Member Added Successfully. Member ID : '.$member->code.' , Password : '.$request->get('password')]);
    }

    public function sendOtp(Request $request): JsonResponse
    {
        $this->validate($request, [
            'mobile' => 'required|regex:/^[6789][0-9]{9}$/',
        ], [
            'mobile.numeric' => 'The mobile number must be a number',
            'mobile.required' => 'The mobile number is required',
            'mobile.regex' => 'The mobile number format is invalid',
            'mobile.unique' => 'The mobile number has already been taken',
        ]);

        if (Otp::where('mobile', $request->input('mobile'))->whereDate('created_at', today())->count() >= 5) {
            return response()->json(['status' => false, 'message' => 'You have reached the maximum number of OTP requests for today. Please try again tomorrow']);
        }

        if ($request->get('mobile') !== '9469284544') {
            if (User::whereMobile($request->get('mobile'))->count() >= 3) {
                return response()->json(['status' => false, 'message' => 'The same mobile can only be used by three members for registration']);
            }
        }

        $user = [
            'name' => $request->input('name'),
            'mobile' => $request->input('mobile'),
        ];

        if (env('APP_ENV') !== 'production') {
            $otp = rand('100001', '999999');
        } else {
            $otp = rand('100001', '999999');
        }

        Otp::create([
            'otp' => $otp,
            'mobile' => $request->input('mobile'),
            'status' => Otp::STATUS_UNUSED,
            'type' => Otp::ACTION_REGISTER,
        ]);

        if (settings('email_enabled')) {
            $title = 'Register OTP';
            $body = 'We have received a register request. Please register with your new OTP '.$otp;
            Mail::to($user['email'])->queue(new SendGeneralMail($user, $title, $body));
        }

        if ($request->input('mobile') && settings('sms_enabled')) {
            SendOTPSMS::dispatch($request->input('mobile'), $otp);
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
            ->where('type', Otp::ACTION_REGISTER)
            ->orderByDesc('id')
            ->first();

        if ($otpModel && $otpModel->created_at->addMinutes(2)->lt(now())) {
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
