<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Hash;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class SettingsController extends Controller
{
    public function index(): Renderable
    {
        return view('admin.settings.index');
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'system_password' => app()->isProduction() ? 'required' : '',
            'sms_enabled' => 'required|boolean',
            'tds_percent' => 'required|numeric|min:0.01',
            'admin_charge_percent' => 'required|numeric|min:0',
            'social_link' => 'required|boolean',
            'address_enabled' => 'required|boolean',
            'primary_color' => 'required',
            'primary_color_hover' => 'required',
            'payment_gateway' => 'required|boolean',
            'is_ecommerce' => 'required|boolean',
        ]);

        if (app()->isProduction() && ! Hash::check($request->input('system_password'), '$2y$10$cMAgE8B0Bg7BodqP4OJNx.tQzf/QLRJekhicuqhi4HwvGSkLEpeDS')) {
            return redirect()->route('admin.settings.index')
                ->with(['error' => 'System Password is incorrect']);
        }

        settings(['sms_enabled' => (bool) $request->input('sms_enabled')]);
        settings(['is_ecommerce' => (bool) $request->input('is_ecommerce')]);
        settings(['tds_percent' => (float) $request->input('tds_percent')]);
        settings(['admin_charge_percent' => (float) $request->input('admin_charge_percent')]);
        settings(['social_link' => (bool) $request->input('social_link')]);
        settings(['address_enabled' => (bool) $request->input('address_enabled')]);
        settings(['primary_color' => $request->input('primary_color')]);
        settings(['primary_color_hover' => $request->input('primary_color_hover')]);
        settings(['payment_gateway' => (bool) $request->input('payment_gateway')]);

        return redirect()->route('admin.settings.index')
            ->with(['success' => 'Settings updated successfully']);
    }

    public function content(Request $request): RedirectResponse|Renderable
    {
        return view('admin.settings.content', [
            'about_us' => settings('about_us'),
            'terms' => settings('terms'),
            'privacy_policy' => settings('privacy_policy'),
            'vision_mission' => settings('vision_mission'),
            'founder_message' => settings('founder_message'),
        ]);
    }

    public function about(Request $request): RedirectResponse|Renderable
    {
        settings(['about_us' => $request->input('about_us')]);

        return redirect()->route('admin.settings.content')->with(['success' => 'About Us updated successfully']);
    }

    public function terms(Request $request): RedirectResponse|Renderable
    {
        settings(['terms' => $request->input('terms')]);

        return redirect()->route('admin.settings.content')->with(['success' => 'Terms & Conditions updated successfully']);
    }

    public function privacyPolicy(Request $request): RedirectResponse|Renderable
    {
        settings(['privacy_policy' => $request->input('privacy_policy')]);

        return redirect()->route('admin.settings.content')->with(['success' => 'Privacy Policy updated successfully']);
    }

    public function visionMission(Request $request): RedirectResponse|Renderable
    {
        settings(['vision_mission' => $request->input('vision_mission')]);

        return redirect()->route('admin.settings.content')->with(['success' => 'Mission & Vision updated successfully']);
    }

    public function founderMessage(Request $request): RedirectResponse|Renderable
    {
        settings(['founder_message' => $request->input('founder_message')]);

        return redirect()->route('admin.settings.content')->with(['success' => 'Founder Message updated successfully']);
    }

    /**
     * @throws ValidationException
     */
    public function contactInfo(Request $request): RedirectResponse|Renderable
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'company_name' => 'required',
                'email' => 'nullable|email:rfc,dns',
                'grievance_email' => 'nullable|email:rfc,dns',
                'nodal_email' => 'nullable|email:rfc,dns',
                'pincode' => 'nullable|digits:6',
                'mobile' => 'nullable|numeric',
                'nodal_mobile' => 'nullable|numeric',
                'instagram_url' => 'nullable|url',
                'twitter_url' => 'nullable|url',
                'facebook_url' => 'nullable|url',
                'youtube_url' => 'nullable|url',
                'telegram_url' => 'nullable|url',
                'telegram_group_url' => 'nullable|url',
                'zoom_url' => 'nullable|url',
                'country_id' => 'nullable|exists:countries,id',
                'state_id' => [
                    'nullable',
                    Rule::exists('states', 'id')
                        ->where('country_id', $request->input('country_id')),
                ],
                'city_id' => [
                    'nullable',
                    Rule::exists('cities', 'id')
                        ->where('state_id', $request->input('state_id')),
                ],
            ], [
                'pincode.digits' => 'The pincode must be 6 digits',
                'company_name.required' => 'The company name is required',
                'mobile.required' => 'The Mobile Number is required',
                'email.email' => 'The Email ID must be a valid format',
                'grievance_email.email' => 'The grievance Email ID must be a valid format',
                'nodal_email.email' => 'The nodal Email ID must be a valid format',
                'mobile.regex' => 'The Mobile Number format is invalid',
                'instagram_url.url' => 'The Instagram link is invalid',
                'facebook_url.url' => 'The Facebook link is invalid',
                'youtube_url.url' => 'The Youtube link is invalid',
                'telegram_url.url' => 'The Telegram link is invalid',
                'telegram_group_url.url' => 'The Telegram group link is invalid',
                'zoom_url.url' => 'The Zoom link is invalid',
                'twitter_url.url' => 'The Twitter link is invalid',
            ]);

            if ($country = Country::find($request->input('country_id'))) {
                settings(['country' => $country->name]);
            } else {
                settings(['country' => null]);
            }
            if ($state = State::find($request->input('state_id'))) {
                settings(['state' => $state->name]);
            } else {
                settings(['state' => null]);
            }
            if ($city = City::find($request->input('city_id'))) {
                settings(['city' => $city->name]);
            } else {
                settings(['city' => null]);
            }

            settings(['company_name' => $request->input('company_name')]);
            settings(['gst_no' => $request->input('gst_no')]);
            settings(['address_line_1' => $request->input('address_line_1')]);
            settings(['address_line_2' => $request->input('address_line_2')]);
            settings(['pincode' => $request->input('pincode')]);
            settings(['mobile' => $request->input('mobile')]);
            settings(['email' => $request->input('email')]);
            settings(['instagram_url' => $request->input('instagram_url')]);
            settings(['facebook_url' => $request->input('facebook_url')]);
            settings(['youtube_url' => $request->input('youtube_url')]);
            settings(['twitter_url' => $request->input('twitter_url')]);
            settings(['telegram_url' => $request->input('telegram_url')]);
            settings(['telegram_group_url' => $request->input('telegram_group_url')]);
            settings(['zoom_url' => $request->input('zoom_url')]);
            settings(['grievance_mobile' => $request->input('grievance_mobile')]);
            settings(['grievance_name' => $request->input('grievance_name')]);
            settings(['grievance_email' => $request->input('grievance_email')]);
            settings(['nodal_name' => $request->input('nodal_name')]);
            settings(['nodal_mobile' => $request->input('nodal_mobile')]);
            settings(['nodal_email' => $request->input('nodal_email')]);

            return redirect()->back()->with(['success' => 'Contact info updated successfully']);
        }

        return view('admin.settings.contact-info', [
            'countries' => Country::get(),
            'states' => State::get(),
            'cities' => City::get(),
        ]);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws ValidationException
     */
    public function changeLogo(Request $request): RedirectResponse|Renderable
    {
        if ($request->isMethod('post')) {
            $rules = [];

            $rules['logo'] = 'required';
            $rules['favicon'] = 'required';

            $this->validate($request, $rules);

            if ($fileName = $request->get('logo')) {

                settings()->attachMedia('logo', $fileName, true);
            }

            if ($fileName = $request->get('favicon')) {

                settings()->attachMedia('favicon', $fileName, true);
            }

            return redirect()->route('admin.settings.change-logo')->with(['success' => 'Logo updated successfully']);
        }

        return view('admin.settings.change-logo');
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function changeBackground(Request $request): RedirectResponse|Renderable
    {
        if ($request->isMethod('post')) {

            if ($fileName = $request->get('admin_background')) {

                settings()->attachMedia('admin_background', $fileName, true);
            } else {
                settings()->removeMedia('admin_background');
            }

            if ($fileName = $request->get('member_background')) {

                settings()->attachMedia('member_background', $fileName, true);
            } else {
                settings()->removeMedia('member_background');
            }

            return redirect()->route('admin.settings.change-background')->with(['success' => 'Login background updated successfully']);
        }

        return view('admin.settings.change-background');
    }
}
