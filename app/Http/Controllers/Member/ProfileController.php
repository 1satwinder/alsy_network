<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Member;
use App\Models\State;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class ProfileController extends Controller
{
    public function show(): Renderable
    {
        return view('member.profile.show', [
            'member' => Auth::user()->member,
            'states' => State::all(),
            'cities' => City::whereStateId($this->member->user->state_id)->get(),
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request): RedirectResponse
    {

        $this->validate($request, [
            'dob' => Rule::requiredIf(function () use ($request) {
                return $request->get('dob');
            }),
            'email' => 'nullable|email:rfc,dns',
            'pincode' => 'nullable|digits:6',
        ], [
            'mobile.required' => 'The mobile number is required',
            'mobile.numeric' => 'The mobile number must be a number',
            'email.required' => 'The Email ID is required',
            'email.email' => 'The Email ID must be a valid format',
            'address.required' => 'The address is required',
            'pincode.digits' => 'The pincode must be 6 digits',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $this->user->state_id = $request->state_id;
                $this->user->city_id = $request->city_id;
                $this->user->gender = $request->gender;
                $this->user->email = $request->email;
                $this->user->address = $request->address;
                $this->user->pincode = $request->pincode;
                if ($request->dob) {
                    $date = Carbon::parse(trim($request->dob));
                    $this->user->dob = $date;
                } else {
                    $this->user->dob = null;
                }

                $this->user->save();

                if ($fileName = $request->get('profile_image')) {

                    $this->member->addMediaFromDisk($fileName)
                        ->toMediaCollection(Member::MC_PROFILE_IMAGE);
                } else {
                    if ($oldProfileImage = $this->member->media()->where('collection_name', 'profile_image')->first()) {
                        $this->member->deleteMedia($oldProfileImage->id);
                    }
                }

            });
        } catch (Throwable $e) {
            return $this->logExceptionAndRespond($e);
        }

        return redirect()->back()->with(['success' => 'Profile updated successfully']);
    }
}
