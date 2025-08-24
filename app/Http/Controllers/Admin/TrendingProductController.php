<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\TrendingProducts;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TrendingProductController extends Controller
{
    public function index()
    {
        $trendingProducts = TrendingProducts::with('product')
            ->get();

        $products = Product::orderBy('id', 'desc')
            ->where('status', Product::STATUS_ACTIVE)
            ->whereNotIn('id', $trendingProducts->pluck('product_id'))
            ->get();

        return view('admin.trending-product.index', [
            'products' => $products,
            'trendingProducts' => $trendingProducts,
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->hasFile('csv_file')) {
            $this->validate($request, [
                'csv_file' => 'required|max:1000000',
            ]);

        } else {
            $this->validate($request, [
                'product_id' => 'required',
            ], [
                'product_id.required' => 'Select at least one product',
            ]);
        }

        if ($request->hasFile('csv_file')) {
            if ($request->file('csv_file')->isValid()) {
                $csvMimes = ['text/x-comma-separated-values',
                    'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel',
                    'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv',
                    'application/excel', 'application/vnd.msexcel', 'text/plain'];
                if (! empty($_FILES['csv_file']['name']) && in_array($_FILES['csv_file']['type'], $csvMimes)) {
                    //open uploaded csv file with read only mode
                    $csvFile = fopen($_FILES['csv_file']['tmp_name'], 'r');

                    //parse data from csv file line by line
                    while (($line = fgetcsv($csvFile)) !== false) {
                        if ($line[0] != '') {
                            foreach ($line as $prId) {
                                $sequenceCount = TrendingProducts::count();
                                TrendingProducts::create([
                                    'product_id' => $prId,
                                ]);
                            }
                        }
                    }
                    //close opened csv file
                    fclose($csvFile);

                }
            }
        } else {
            $productIds = $request->get('product_id');
            foreach ($productIds as $productID) {
                $sequenceCount = TrendingProducts::count();
                if (Product::find($productID) && ! TrendingProducts::whereProductId($productID)->first()) {
                    TrendingProducts::create([
                        'product_id' => $productID,
                    ]);
                }
            }
        }

        return redirect()->back()->with(['success' => 'Trending Product created successfully']);
    }

    /**
     * @throws Exception
     */
    public function delete(Request $request): RedirectResponse
    {
        if ($request->get('trendingProductIds') && ! empty($request->get('trendingProductIds'))) {
            TrendingProducts::whereIn('id', $request->get('trendingProductIds'))->delete();

            return redirect()->back()->with('success', 'Trending Product deleted successfully');

        } else {
            return redirect()->back()->with('error', 'Please Select Trending Product');
        }
    }

    public function sequenceUpdate(Request $request): RedirectResponse
    {
        $productIDs = explode(',', $request->get('sequenceProductIds'));

        foreach ($productIDs as $key => $productId) {
            TrendingProducts::where('product_id', $productId)
                ->update([
                    'sequence' => $key + 1,
                ]);
        }

        return redirect()->back()->with('success', 'Trending Product sequence successfully updated');
    }
}
