<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ListBuilders\Admin\SubPhotoGalleryListBuilder;
use App\Models\PhotoGallery;
use App\Models\SubPhotoGallery;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Throwable;

class SubPhotoGalleryController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request, PhotoGallery $photoGallery): Renderable|JsonResponse|RedirectResponse
    {
        return SubPhotoGalleryListBuilder::render([
            'photoGallery_id' => $photoGallery->id,
        ]);
    }

    public function create(PhotoGallery $photoGallery): Factory|View
    {
        return view('admin.sub-photo-gallery.create', ['photoGallery' => $photoGallery]);
    }

    /**
     * @throws ValidationException
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(Request $request, PhotoGallery $photoGallery): RedirectResponse
    {
        $this->validate($request, [
            'sub_image' => 'required',
        ]);

        if ($request->get('sub_image')) {
            foreach ($request->get('sub_image') as $subImageName) {
                if ($subImageName != null) {
                    $subPhotoGallery = SubPhotoGallery::Create([
                        'photo_gallery_id' => $photoGallery->id,
                    ]);

                    $subPhotoGallery->addMediaFromDisk($subImageName)
                        ->toMediaCollection(SubPhotoGallery::SUB_IMAGE);
                }
            }
        }

        return redirect()->route('admin.sub-photo-gallery.index', ['photoGallery' => $photoGallery])
            ->with(['success' => 'Sub image added successfully']);
    }

    public function edit(SubPhotoGallery $subPhotoGallery): Factory|View
    {
        return view('admin.sub-photo-gallery.edit', [
            'subPhotoGallery' => $subPhotoGallery,
        ]);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws ValidationException
     */
    public function update(Request $request, SubPhotoGallery $subPhotoGallery): RedirectResponse
    {
        $this->validate($request, [
            'sub_image' => 'required',
            'status' => 'required',
        ]);

        $subPhotoGallery->status = $request->status;
        $subPhotoGallery->save();

        if ($fileName = $request->get('sub_image')) {

            $subPhotoGallery->clearMediaCollection(SubPhotoGallery::SUB_IMAGE);

            $subPhotoGallery->addMediaFromDisk($fileName)
                ->toMediaCollection(SubPhotoGallery::SUB_IMAGE);
        }

        return redirect()->route('admin.sub-photo-gallery.index', [
            'photoGallery' => $subPhotoGallery->photoGallery,
        ])->with(['success' => 'Sub image updated successfully']);

    }

    /**
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function delete(SubPhotoGallery $subPhotoGallery)
    {
        try {
            $subPhotoGallery->delete();
        } catch (Throwable $e) {
            return redirect()->back()->with(['error' => 'Something went wrong. Please try again']);
        }

        return redirect()->back()->with(['success' => 'Sub Image deleted successfully']);
    }
}
