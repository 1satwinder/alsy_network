<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ListBuilders\Admin\PhotoGalleryListBuilder;
use App\Models\PhotoGallery;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class PhotoGalleryController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request): Renderable|JsonResponse|RedirectResponse
    {
        return PhotoGalleryListBuilder::render();
    }

    public function create(): Renderable|RedirectResponse
    {
        return view('admin.photo-gallery.create');
    }

    /**
     * @throws ValidationException
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(Request $request): Renderable|RedirectResponse
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'main_image' => 'required',
        ], [
            'title.required' => 'The title is required',
            'title.max' => 'The title must not be greater than 255 characters',
        ]);

        $lastInsertId = PhotoGallery::Create([
            'title' => $request->get('title'),
        ]);

        if ($fileName = $request->get('main_image')) {

            $lastInsertId->addMediaFromDisk($fileName)
                ->toMediaCollection(PhotoGallery::MAIN_IMAGE);
        }

        return redirect()->route('admin.photo-gallery.index')->with(['success' => 'Photo added successfully']);
    }

    public function edit(PhotoGallery $photoGallery): Renderable|RedirectResponse
    {
        return view('admin.photo-gallery.edit', [
            'photoGallery' => $photoGallery,
            'main_image' => optional($photoGallery)->getFirstMediaUrl(PhotoGallery::MAIN_IMAGE),
        ]);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws ValidationException
     */
    public function update(Request $request, PhotoGallery $photoGallery): Renderable|RedirectResponse
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'main_image' => [
                ($photoGallery && $photoGallery->hasMedia(PhotoGallery::MAIN_IMAGE)) ? 'nullable' : 'required',
            ],
            'status' => 'required',
        ], [
            'title.required' => 'The title is required',
            'title.max' => 'The title must not be greater than 255 characters',
        ]);

        $photoGallery->title = $request->title;
        $photoGallery->status = $request->status;
        $photoGallery->save();

        if ($fileName = $request->get('main_image')) {

            $photoGallery->addMediaFromDisk($fileName)
                ->toMediaCollection(PhotoGallery::MAIN_IMAGE);
        }

        return redirect()->route('admin.photo-gallery.index')->with(['success' => 'Photo gallery updated successfully']);
    }
}
