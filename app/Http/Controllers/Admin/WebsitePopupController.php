<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsitePopup;
use DB;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

class WebsitePopupController extends Controller
{
    public function create(): Factory|View
    {
        return view('admin.website-popup.show', [
            'popups' => WebsitePopup::with('media')->get(),
        ]);
    }

    /**
     * @return RedirectResponse|mixed
     *
     * @throws ValidationException
     * @throws Throwable
     */
    public function store(Request $request): mixed
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ], [
            'name.required' => 'The popup name is required',
            'name.max' => 'The name must not be greater than 255 characters',
        ]);

        if ($request->get('popup_type') == WebsitePopup::TYPE_IMAGE) {
            $this->validate($request, [
                'image' => 'required',
            ]);
        }

        if ($request->get('popup_type') == WebsitePopup::TYPE_VIDEO) {
            $this->validate($request, [
                'link' => 'required',
            ]);
        }

        try {
            return DB::transaction(function () use ($request) {
                $popup = WebsitePopup::create([
                    'name' => $request->get('name'),
                    'link' => $request->get('link'),
                    'status' => WebsitePopup::STATUS_ACTIVE,
                ]);

                if ($request->get('popup_type') == WebsitePopup::TYPE_IMAGE) {
                    $fileName = $request->get('image');

                    $popup->addMediaFromDisk($fileName)
                        ->toMediaCollection(WebsitePopup::MEDIA_COLLECTION_IMAGE_WEBSITE_POPUP);
                }

                return redirect()->back()->with(['success' => 'Website popup added successfully']);
            });
        } catch (Throwable $e) {
            return redirect()->back()->with(['error' => 'Something went wrong. Please try again']);
        }
    }

    /**
     * Show the form for editing the specified popup.
     */
    public function edit(WebsitePopup $websitePopup): Factory|View
    {
        return view('admin.website-popup.edit', [
            'popup' => $websitePopup,
        ]);
    }

    /**
     * @return RedirectResponse|mixed
     *
     * @throws ValidationException
     */
    public function update(WebsitePopup $websitePopup, Request $request): mixed
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'status' => 'required|in:'.implode(',', [WebsitePopup::STATUS_ACTIVE, WebsitePopup::STATUS_INACTIVE]),
        ], [
            'name.required' => 'The popup name is required',
            'name.max' => 'The name must not be greater than 255 characters',
        ]);

        try {
            return DB::transaction(function () use ($request, $websitePopup) {
                $websitePopup->name = $request->input('name');
                $websitePopup->status = $request->input('status');
                
                if ($request->input('link')) {
                    $websitePopup->link = $request->input('link');
                }

                $websitePopup->save();

                // Handle image update if provided
                if ($request->input('image')) {
                    // Clear existing media
                    $websitePopup->clearMediaCollection(WebsitePopup::MEDIA_COLLECTION_IMAGE_WEBSITE_POPUP);
                    
                    // Add new image
                    $websitePopup->addMediaFromDisk($request->input('image'))
                        ->toMediaCollection(WebsitePopup::MEDIA_COLLECTION_IMAGE_WEBSITE_POPUP);
                }

                return redirect()->back()->with(['success' => 'Website Popup updated successfully']);
            });
        } catch (Throwable $e) {
            return redirect()->back()->with(['error' => 'Something went wrong. Please try again.']);
        }
    }

    /**
     * @return RedirectResponse
     */
    public function destroy(WebsitePopup $websitePopup): mixed
    {
        try {
            return DB::transaction(function () use ($websitePopup) {
                // Clear media before deleting
                $websitePopup->clearMediaCollection(WebsitePopup::MEDIA_COLLECTION_IMAGE_WEBSITE_POPUP);
                
                $websitePopup->delete();

                return redirect()->back()->with(['success' => 'Website popup deleted successfully']);
            });
        } catch (Throwable $e) {
            return redirect()->back()->with(['error' => 'Something went wrong. Please try again']);
        }
    }
}
