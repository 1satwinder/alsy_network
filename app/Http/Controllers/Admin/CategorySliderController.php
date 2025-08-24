<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategorySlider;
use DataTables;
use DB;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

class CategorySliderController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax() || $request->has('export')) {
            $categorySlider = QueryBuilder::for(CategorySlider::class)
                ->defaultSort('-id')
                ->allowedFilters([
                    'created_at', 'category.name',
                    AllowedFilter::exact('status'),
                ])->with('category')
                ->getEloquentBuilder();

            if ($request->ajax()) {
                return DataTables::of($categorySlider)
                    ->editColumn('created_at', function (CategorySlider $categorySlider) {
                        return $categorySlider->created_at->dateTimeFormat();
                    })
                    ->addColumn('status', 'admin.category-slider.datatable.status')
                    ->addColumn('action', 'admin.category-slider.datatable.action')
                    ->addColumn('create-date', 'admin.category-slider.datatable.checkbox')
                    ->rawColumns(['status', 'create-date', 'action'])
                    ->addIndexColumn()
                    ->toJson();
            }

        }
        $category = Category::whereNull('parent_id')->where('status', Category::STATUS_ACTIVE)->latest()->get();

        return view('admin.category-slider.category-slider', ['category' => $category]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'sub_id' => 'required|unique:category_sliders,category_id',
            'category' => 'required',
        ], [
            'sub_id.required' => 'The sub category is required',
            'sub_id.unique' => 'Selected sub category has already been taken',
            'category.required' => 'The main category is required',
        ]);
        if ($request->get('sub_id')) {
            CategorySlider::create([
                'category_id' => $request->get('sub_id'),
                'status' => CategorySlider::ACTIVE,
            ]);
        } else {
            CategorySlider::create([
                'category_id' => $request->get('category'),
                'status' => CategorySlider::ACTIVE,
            ]);

        }

        return redirect()->back()->with(['success' => 'Category slider added successfully']);
    }

    public function updateStatus(Request $request)
    {
        if ($request->get('change_status') && count($request->get('change_status')) > 0) {
            CategorySlider::whereIn('id', $request->get('change_status'))->update(['status' => $request->get('status')]);

            return redirect()->back()->with('success', 'Status Changed Successfully');
        } else {
            return redirect()->back()->with('error', 'Please Select at-least one item');
        }
    }

    /**
     * @throws Exception
     */
    public function delete(CategorySlider $categorySlider): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($categorySlider) {
                $categorySlider->delete();

                return redirect()->back()->with(['success' => 'Category slider deleted successfully']);
            });
        } catch (Throwable $e) {
            return redirect()->back()->with(['error' => 'Something went wrong. Please try again']);
        }
    }
}
