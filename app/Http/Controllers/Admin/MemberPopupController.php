<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberPopup;
use DB;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

class MemberPopupController extends Controller
{
    public function create(): Factory|View
    {
        return view('admin.member-popup.show', [
            'popups' => MemberPopup::with('media')->get(),
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

        if ($request->get('popup_type') == MemberPopup::TYPE_IMAGE) {
            $this->validate($request, [
                'image' => 'required',
            ]);
        }

        if ($request->get('popup_type') == MemberPopup::TYPE_VIDEO) {
            $this->validate($request, [
                'link' => 'required',
            ]);
        }

        try {
            return DB::transaction(function () use ($request) {
                $popup = MemberPopup::create([
                    'name' => $request->get('name'),
                    'link' => $request->get('link'),
                    'status' => MemberPopup::STATUS_ACTIVE,
                ]);

                if ($request->get('popup_type') == MemberPopup::TYPE_IMAGE) {
                    $fileName = $request->get('image');

                    $popup->addMediaFromDisk($fileName)
                        ->toMediaCollection(MemberPopup::MEDIA_COLLECTION_IMAGE_MEMBER_POPUP);
                }

                return redirect()->back()->with(['success' => 'Member popup added successfully']);
            });
        } catch (Throwable $e) {
            return redirect()->back()->with(['error' => 'Something went wrong. Please try again']);
        }
    }

    /**
     * @return RedirectResponse|mixed
     *
     * @throws ValidationException
     */
    public function update(MemberPopup $popup, Request $request): mixed
    {
        $this->validate($request, [
            //            'images.*' => 'required',
            'popupNames.*' => 'required',
            'popupStatuses.*' => 'required|in:'.implode(',', [MemberPopup::STATUS_ACTIVE, MemberPopup::STATUS_INACTIVE]),
        ], [
            'popupNames.*.required' => 'The popup name is required',
        ]);

        try {
            return DB::transaction(function () use ($request, $popup) {
                $popup->status = $request->input('status');

                if ($request->input('name')) {
                    $popup->name = $request->input('name');
                }

                if ($request->input('links')) {
                    $popup->links = $request->input('links');
                }

                $popup->save();

                $popup->addMediaFromDisk($request->input('image'))
                    ->toMediaCollection(MemberPopup::MEDIA_COLLECTION_IMAGE_MEMBER_POPUP);

                return redirect()->back()->with(['success' => 'Website Popup updated successfully']);
            });
        } catch (Throwable $e) {
            return redirect()->back()->with(['error' => 'Something went wrong. Please try again.']);
        }
    }

    /**
     * @return RedirectResponse
     */
    public function destroy(MemberPopup $popup): mixed
    {
        try {
            return DB::transaction(function () use ($popup) {
                $popup->delete();

                return redirect()->back()->with(['success' => 'Member popup deleted successfully']);
            });
        } catch (Throwable $e) {
            return redirect()->back()->with(['error' => 'Something went wrong. Please try again']);
        }
    }
}
