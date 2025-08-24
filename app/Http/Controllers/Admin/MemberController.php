<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ListBuilders\Admin\MemberListBuilder;
use App\ListBuilders\Admin\MemberStatusLogListBuilder;
use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class MemberController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(): Renderable|JsonResponse|RedirectResponse
    {
        return MemberListBuilder::render();
    }

    public function show(Member $member): Member
    {
        return $member->load('user');
    }

    public function edit(Member $member): Renderable
    {
        return view('admin.members.edit', ['member' => $member]);
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request, Member $member): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => [
                'nullable',
                'email:rfc,dns',
            ],
            'mobile' => 'required|regex:/^[6789][0-9]{9}$/',
            'gender' => 'in:'.implode(',', [User::GENDER_MALE, User::GENDER_FEMALE]),
            'dob' => Rule::requiredIf(function () use ($request) {
                return $request->get('dob');
            }),
        ], [
            'name.required' => 'The name is required',
            'mobile.required' => 'The mobile number is required',
            'mobile.regex' => 'The mobile number format is invalid',
            'email.email' => 'The Email ID must be a valid format',
        ]);

        if (User::whereMobile($request->get('mobile'))->count() >= 3) {
            return redirect()->back()->with('error', 'The same mobile can only be used three times');
        }

        $member->user->name = ucwords($request->get('name'));
        $member->user->email = $request->get('email');
        $member->user->mobile = $request->get('mobile');
        $member->user->gender = $request->get('gender');
        if ($request->get('dob')) {
            $member->user->dob = Carbon::parse(trim($request->get('dob')));
        } else {
            $member->user->dob = null;
        }

        $member->user->save();

        return redirect()->route('admin.members.index')->with(['success' => 'Member details updated successfully']);
    }

    /**
     * @throws Exception
     */
    public function memberLog(Request $request, Member $member): Renderable|JsonResponse|RedirectResponse
    {
        return MemberStatusLogListBuilder::render([
            'member_id' => $this->member->id,
        ]);
    }
}
