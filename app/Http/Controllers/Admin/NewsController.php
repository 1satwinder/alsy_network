<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ListBuilders\Admin\NewsListBuilder;
use App\Models\News;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NewsController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request): RedirectResponse|Renderable|JsonResponse
    {
        return NewsListBuilder::render();
    }

    public function create(): Renderable
    {
        return view('admin.news.create');
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse|Renderable
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'title' => 'required|max:255',
            ], [
                'title.required' => 'The title is required',
                'title.max' => 'The title must not be greater than 255 characters',
            ]);

            News::create([
                'title' => $request->input('title'),
            ]);

            return redirect()->route('admin.news.index')->with([
                'success' => 'News added successfully',
            ]);
        }

        return view('admin.news.create');
    }

    public function edit(News $news): RedirectResponse|Renderable
    {
        return view('admin.news.edit', [
            'news' => $news,
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request, News $news): RedirectResponse|Renderable
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'title' => 'required|max:255',
            ], [
                'title.required' => 'The title is required',
                'title.max' => 'The title must not be greater than 255 characters',
            ]);

            $news->update([
                'title' => $request->input('title'),
                'status' => $request->input('status'),
            ]);

            return redirect()->route('admin.news.index')->with(['success' => 'News updated successfully']);
        }
    }
}
