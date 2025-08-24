<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegalDocument;
use DB;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Throwable;

class LegalDocumentController extends Controller
{
    /**
     * @throws Throwable
     */
    public function store(Request $request): mixed
    {
        $this->validate($request, [
            'image' => 'required',
            'name' => 'max:100',
        ], [
            'name.max' => 'The Document name must not be greater than 100 characters',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $legalDocument = LegalDocument::create([
                    'name' => $request->get('name'),
                    'status' => LegalDocument::STATUS_ACTIVE,
                ]);

                if ($fileName = $request->get('image')) {
                    $legalDocument->addMediaFromDisk($fileName)
                        ->toMediaCollection(LegalDocument::MC_LEGAL_DOCUMENTS);
                }

                return redirect()->back()->with(['success' => 'Legal document added successfully']);
            });
        } catch (Throwable $e) {
            return redirect()->back()->with(['error' => 'Something went wrong. Please try again']);
        }
    }

    public function create(): Renderable
    {
        return view('admin.legal.create', [
            'legalDocuments' => LegalDocument::with('media')->get(),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function update(LegalDocument $legalDocument, Request $request): mixed
    {
        $this->validate($request, [
            'legalDocumentStatuses.*' => 'required|in:'.implode(',', [
                LegalDocument::STATUS_ACTIVE, LegalDocument::STATUS_INACTIVE,
            ]
            ),
            'images.*' => 'required',
            'documentNames.*' => 'max:100',
        ], [
            'images.*.required' => 'The image is required',
            'documentNames.*.max' => 'The Document name must not be greater than 100 characters',
        ]);

        try {
            return DB::transaction(function () use ($request, $legalDocument) {
                $legalDocument->status = $request->input('status');

                if ($request->input('name')) {
                    $legalDocument->name = $request->input('name');
                }

                $legalDocument->save();

                $legalDocument->addMediaFromDisk($request->input('image'))
                    ->toMediaCollection(LegalDocument::MC_LEGAL_DOCUMENTS);

                return redirect()->back()->with(['success' => 'Legal Document updated successfully']);
            });
        } catch (Throwable $e) {
            return redirect()->back()->with(['error' => 'Something went wrong. Please try again.']);
        }
    }

    /**
     * @throws Throwable
     */
    public function destroy(LegalDocument $legalDocument): mixed
    {
        try {
            return DB::transaction(function () use ($legalDocument) {
                $legalDocument->delete();

                return redirect()->back()->with(['success' => 'Legal document deleted successfully']);
            });
        } catch (Throwable $e) {
            return redirect()->back()->with(['error' => 'Something went wrong. Please try again']);
        }
    }
}
