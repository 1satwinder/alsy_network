<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Banner;
use App\Models\BusinessPlan;
use App\Models\Category;
use App\Models\CategorySlider;
use App\Models\Country;
use App\Models\DirectSellerContract;
use App\Models\Faq;
use App\Models\Inquiry;
use App\Models\LegalDocument;
use App\Models\News;
use App\Models\Package;
use App\Models\PhotoGallery;
use App\Models\Product;
use App\Models\SubPhotoGallery;
use App\Models\TrendingProducts;
use App\Models\WebsitePopup;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::with('media')->whereStatus(Banner::STATUS_ACTIVE)->get();

        $news = News::whereStatus(1)->orderBy('id', 'desc')->get();

        $popups = WebsitePopup::with('media')->whereStatus(WebsitePopup::STATUS_ACTIVE)->get();

        $packages = Package::orderBy('id', 'desc')->whereStatus(Package::STATUS_ACTIVE)
            ->with('products')->take(2)->get();

        $trendingProducts = TrendingProducts::with('product.media')
            ->whereHas('product', function ($query) {
                return $query->where('status', Product::STATUS_ACTIVE);
            })
            ->whereHas('product.category', function ($query) {
                return $query->where('status', Category::STATUS_ACTIVE)
                    ->whereNotNull('parent_id')
                    ->whereHas('parent', function ($query) {
                        return $query->where('status', Category::STATUS_ACTIVE);
                    });
            })
            ->get();

        $categorySliders = CategorySlider::with([
            'category.product' => function ($query) {
                return $query->where('status', Product::STATUS_ACTIVE);
            },
            'category.product.media',
        ])
            ->whereStatus(CategorySlider::ACTIVE)
            ->whereHas('category', function ($query) {
                return $query->where('status', Category::STATUS_ACTIVE)
                    ->whereNotNull('parent_id')
                    ->whereHas('parent', function ($query) {
                        return $query->where('status', Category::STATUS_ACTIVE);
                    })
                    ->whereHas('product', function ($query) {
                        return $query->where('status', Product::STATUS_ACTIVE);
                    });
            })
            ->take('15')->get();

        if (settings('is_ecommerce')) {
            $viewName = 'website.index-ecommerce';
        } else {
            $viewName = 'website.index';
        }

        return view($viewName, [
            'banners' => $banners,
            'news' => $news,
            'popups' => $popups,
            'packages' => $packages,
            'trendingProducts' => $trendingProducts,
            'categorySliders' => $categorySliders,
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function contact(Request $request): Factory|View|RedirectResponse
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'country_id' => 'required',
                'name' => 'required',
                'email' => 'required|email:rfc,dns',
                'mobile' => 'required|numeric',
                'message' => 'required',
            ],
                [
                    'country_id.required' => 'The country is required',
                    'name.required' => 'The name is required',
                    'mobile.required' => 'The mobile number is required',
                    'mobile.regex' => 'The mobile number format is invalid',
                    'email.required' => 'The Email ID is required',
                    'email.email' => 'The Email ID must be a valid format',
                    'message.required' => 'The message is required',
                ]
            );

            $inquiry = Inquiry::create([
                'country_id' => $request->input('country_id'),
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'message' => $request->message,
            ]);

            return redirect()->back()->with(['success' => 'Our Team Will Reach You Shortly']);
        }

        return view('website.contact', [
            'countries' => Country::get(),
        ]);
    }

    public function about()
    {
        return view('website.about');
    }

    public function message()
    {
        return view('website.message');
    }

    public function terms()
    {
        return view('website.terms');
    }

    /**
     * @return Factory|View
     */
    public function legal()
    {
        $LegalDocuments = LegalDocument::with('media')->where('status', LegalDocument::STATUS_ACTIVE)->get();

        return view('website.legal', ['LegalDocuments' => $LegalDocuments]);
    }

    /**
     * @return Factory|View
     */
    public function package()
    {
        return view('website.package', [
            'packages' => Package::orderBy('id', 'desc')
                ->whereStatus(Package::STATUS_ACTIVE)
                ->with('products')->get(),
        ]);
    }

    public function faqs()
    {
        return view('website.faqs', [
            'faqs' => Faq::where('status', 1)
                ->orderBy('id', 'desc')
                ->get(),
        ]);
    }

    /**
     * @return Factory|View
     */
    public function gallery()
    {
        $photoGalleries = PhotoGallery::with('media')->where('status', PhotoGallery::STATUS_ACTIVE)->get();

        return view('website.gallery', ['photoGalleries' => $photoGalleries]);
    }

    public function galleryDetails(PhotoGallery $photoGallery)
    {
        return view('website.gallery-details', [
            'subPhotoGalleries' => $photoGallery->subImages()->with('media')->where('status', SubPhotoGallery::STATUS_ACTIVE)->get(),
            'photoGallery' => $photoGallery,
        ]);
    }

    public function plan()
    {
        $businessPlan = BusinessPlan::with('media')->where(['status' => true])->first();
        $planUrl = optional($businessPlan)->getFirstMediaUrl(BusinessPlan::MC_WEBSITE_PLAN);

        return view('website.plan', [
            'businessPlan' => $businessPlan,
            'planUrl' => $planUrl,
        ]);
    }

    public function banking()
    {
        $bankingDetails = Bank::active()->get();

        return view('website.bank', ['bankingDetails' => $bankingDetails]);
    }

    public function returnPolicy()
    {
        return view('website.return-policy');
    }

    public function privacyPolicy()
    {
        return view('website.privacy-policy');
    }

    public function shippingPolicy()
    {
        return view('website.shipping-policy');
    }

    public function directSellerContract()
    {
        $directSellerContract = DirectSellerContract::with('media')->where(['status' => true])->first();
        $planUrl = optional($directSellerContract)->getFirstMediaUrl(DirectSellerContract::MC_DIRECT_SELLER_CONTRACT);

        return view('website.direct-seller-contract', [
            'directSellerContract' => $directSellerContract,
            'planUrl' => $planUrl,
        ]);
    }
}
