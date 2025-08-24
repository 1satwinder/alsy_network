<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;
use Validator;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        Validator::extend('without_spaces', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });

        return [
            'name' => 'required',
            'mobile' => 'required|regex:/^[6789][0-9]{9}$/',
            'email' => 'nullable|email:rfc,dns',
            'code' => 'required|exists:members,code',
            //            'otp' => 'required',
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
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name is required',
            'address.required' => 'The address is required',
            'code.required' => 'The Sponsor ID is required',
            'code.exists' => 'Member not found',
            'mobile.numeric' => 'The mobile number must be a number',
            'mobile.required' => 'The mobile number is required',
            'mobile.regex' => 'The mobile number format is invalid',
            'mobile.unique' => 'The mobile number has already been taken',
            'email.required' => 'The Email ID is required',
            'email.email' => 'The Email ID must be a valid format',
            'password.required' => 'The password is required',
            'password.confirmed' => 'The confirm password does not match',
            'password.without_spaces' => 'Space not allowed in password',
            'password.min' => 'The password must be at least 6 characters',
            'password_confirmation.required' => 'The confirm password is required',
            'password_confirmation.without_spaces' => 'Space not allowed in confirm password',
            'password_confirmation.min' => 'The confirm password must be at least 6 characters',
            'password.regex' => 'The password format is invalid',
            'password_confirmation.regex' => 'The confirm password format is invalid',
        ];
    }
}
