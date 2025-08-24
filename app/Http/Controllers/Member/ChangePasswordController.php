<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Validator;

class ChangePasswordController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function update(Request $request): RedirectResponse
    {
        Validator::extend('without_spaces', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });

        $this->validate($request, [
            'old_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (! Hash::check($value, Auth::user()->password)) {
                        $fail('The old password is invalid');
                    }
                },
            ],
            'password' => [
                'bail',
                'required',
                'min:6',
                'confirmed',
                'without_spaces',
                function ($attribute, $value, $fail) {
                    if (! preg_match('/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d!@#$%^&*()_+\-=\[\]{};:\'"\\|,.<>\/?]*$/', $value)) {
                        $fail('The '.$attribute.' must contain at least one letter and one number');
                    }
                }],
            'password_confirmation' => [
                'bail',
                'required',
                'min:6',
                'without_spaces',
            ],
        ], [
            'old_password.required' => 'The old password is required',
            'password.required' => 'The password is required',
            'password.confirmed' => 'The confirm password does not match',
            'password.without_spaces' => 'Space not allowed in password',
            'password.min' => 'The password must be at least 6 characters',
            'password_confirmation.required' => 'The confirm password is required',
            'password_confirmation.without_spaces' => 'Space not allowed in confirm password',
            'password_confirmation.min' => 'The confirm password must be at least 6 characters',
            'password.regex' => 'The password format is invalid',
            'password_confirmation.regex' => 'The confirm password format is invalid',
        ]);

        if (Hash::check($request->get('password'), $this->member->user->password)) {
            return redirect()->back()->with(['error' => 'The new password cannot be the same as the previous password. Please choose a different password']);
        }

        $this->user->update([
            'password' => Hash::make($request->get('password')),
        ]);

        return redirect()->back()->with(['success' => 'Password changed successfully']);
    }
}
