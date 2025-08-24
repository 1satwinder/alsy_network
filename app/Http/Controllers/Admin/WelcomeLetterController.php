<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Str;

class WelcomeLetterController extends Controller
{
    public function create(): Factory|View
    {
        return view('admin.welcome-letter.create', [
            'companySetting' => CompanySetting::get(),
        ]);
    }

    /**
     * @throws ValidationException
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'welcomeLetter.title' => 'required',
            'welcomeLetter.body' => 'required',
            'welcomeLetter.greeting' => 'required',
        ]);

        foreach ($request->welcomeLetter as $key => $value) {

            $companySetting = CompanySetting::firstOrCreate([
                'key' => $key,
                'value' => $value,
            ]);
        }
        if ($fileName = $request->welcomeLetter['logo']) {
            $companySetting->clearMediaCollection(CompanySetting::WELCOME_LETTER_LOGO);
            $filePath = 'tmp/'.Str::beforeLast($fileName, '.');

            $companySetting->addMediaFromDisk($filePath)
                ->usingFileName($fileName)
                ->toMediaCollection(CompanySetting::WELCOME_LETTER_LOGO);
        }

        return redirect()->route('admin.welcome-letter.create')->with(['success' => 'Detail Updated Successfully']);
    }
}
