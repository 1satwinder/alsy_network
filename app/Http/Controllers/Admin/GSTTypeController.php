<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ListBuilders\Admin\GSTTypeListBuilder;
use App\Models\GSTType;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GSTTypeController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request): Renderable|JsonResponse|RedirectResponse
    {
        return GSTTypeListBuilder::render();
    }

    public function create(Request $request): Renderable
    {
        return view('admin.gstTypes.create');
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): Renderable|RedirectResponse
    {
        $this->validate($request, [
            'hsn_code' => 'required|unique:g_s_t_types,hsn_code',
            'sgst' => 'required|gte:0',
            'cgst' => 'required|gte:0',
        ], [
            'hsn_code.required' => 'The hsn code is required',
            'sgst.min' => 'The SGST must be greater than or equal to 0',
            'cgst.min' => 'The CGST must be greater than or equal to 0',
        ]
        );

        GSTType::create([
            'hsn_code' => $request->get('hsn_code'),
            'sgst' => $request->get('sgst'),
            'cgst' => $request->get('cgst'),
            'gst' => $request->get('sgst') + $request->get('cgst'),
        ]);

        return redirect()->route('admin.gst-types.index')->with(['success' => 'Gst Type added successfully']);
    }

    public function edit(GSTType $gstTypes): Renderable
    {
        return view('admin.gstTypes.edit', ['gstTypes' => $gstTypes]);
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request, GSTType $gstTypes): Renderable|RedirectResponse
    {
        $this->validate($request, [
            'hsn_code' => 'required|unique:g_s_t_types,hsn_code,'.$gstTypes->id,
            'sgst' => 'required|gte:0',
            'cgst' => 'required|gte:0',
        ], [
            'hsn_code.required' => 'The hsn code is required',
            'sgst.min' => 'The SGST must be greater than or equal to 0',
            'cgst.min' => 'The CGST must be greater than or equal to 0',
        ]);

        $gstTypes->hsn_code = $request->get('hsn_code');
        $gstTypes->sgst = $request->get('sgst');
        $gstTypes->cgst = $request->get('cgst');
        $gstTypes->gst = $request->get('sgst') + $request->get('cgst');
        $gstTypes->save();

        return redirect()->route('admin.gst-types.index')->with(['success' => 'Gst Type updated successfully']);
    }
}
