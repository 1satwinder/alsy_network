<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ListBuilders\Admin\VideoListBuilder;
use App\Models\Video;
use DB;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(): Renderable|JsonResponse|RedirectResponse
    {
        return VideoListBuilder::render();
    }

    public function create(Video $video): Factory|View|Application
    {
        return view('admin.video.create', [
            'video' => $video,
        ]);
    }

    public function edit(Video $video): Factory|View|Application
    {
        return view('admin.video.edit', [
            'video' => $video,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'title' => 'required',
            'link' => 'required|url',
            'description' => 'required',
        ], [
            'title.required' => 'The title is required',
            'link.required' => 'The link is required',
            'link.url' => 'The link must be a valid URL',
            'description.required' => 'The description is required',
        ]);

        if (! str_contains($request->get('link'), 'https://www.youtube.com/embed')) {
            return redirect()->back()->with('error', 'Please enter only YouTube link with embedded link, ex. https://www.youtube.com/embed')->withInput();
        }

        Video::create([
            'title' => $request->get('title'),
            'link' => $request->get('link'),
            'description' => $request->get('description'),
        ]);

        return redirect()->route('admin.video.index')->with(['success' => 'Video added successfully']);
    }

    public function update(Request $request, Video $video): RedirectResponse
    {
        $this->validate($request, [
            'title' => 'required',
            'link' => 'required|url',
            'description' => 'required',
        ], [
            'title.required' => 'The title is required',
            'link.required' => 'The link is required',
            'link.url' => 'The link must be a valid URL',
            'description.required' => 'The description is required',
        ]);

        if (! str_contains($request->get('link'), 'https://www.youtube.com/embed')) {
            return redirect()->back()->with('error', 'Please Enter Only Youtube Link with embed exp https://www.youtube.com/embed')->withInput();
        }

        $video->title = $request->get('title');
        $video->link = $request->get('link');
        $video->description = $request->get('description');
        $video->save();

        return redirect()->route('admin.video.index')->with(['success' => 'Video Data Update successfully']);
    }

    public function statusUpdate(Request $request): RedirectResponse
    {
        if ($request->get('video') == null) {
            return redirect()->back()->with(['error' => 'Please select videos']);
        }

        if ($request->input('changeStatus')) {
            if (count($request->input('video')) > 0) {
                DB::transaction(function () use ($request) {
                    Video::whereIn('id', $request->input('video'))
                        ->update(['status' => $request->input('changeStatus')]);
                });

                return redirect()->back()->with(['success' => 'Video status changed successfully']);
            }

            return redirect()->back()->with(['error' => 'Please select video']);
        }

        return redirect()->back()->with(['error' => 'Please select status']);
    }
}
