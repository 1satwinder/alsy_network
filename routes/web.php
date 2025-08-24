<?php

use App\Models\City;
use App\Models\Member;
use App\Models\Pin;
use App\Models\State;
use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Website',
    'as' => 'website.',
], function () {
    Route::any('/', 'HomeController@index')->name('home');
    Route::any('contact', 'HomeController@contact')->name('contact');
    Route::get('about', 'HomeController@about')->name('about');
    Route::get('message', 'HomeController@message')->name('message');
    Route::get('terms', 'HomeController@terms')->name('terms');
    Route::get('legal', 'HomeController@legal')->name('legal');
    Route::get('package', 'HomeController@package')->name('package');
    Route::get('faqs', 'HomeController@faqs')->name('faqs');
    Route::get('gallery', 'HomeController@gallery')->name('gallery');
    Route::get('gallery-details/{photoGallery}', 'HomeController@galleryDetails')->name('gallery-details');
    Route::get('plan', 'HomeController@plan')->name('plan');
    Route::get('banking', 'HomeController@banking')->name('banking');
    Route::get('return-policy', 'HomeController@returnPolicy')->name('return-policy');
    Route::get('privacy-policy', 'HomeController@privacyPolicy')->name('privacy-policy');
    Route::get('shipping-policy', 'HomeController@shippingPolicy')->name('shipping-policy');
    Route::get('direct-seller-contract', 'HomeController@directSellerContract')->name('direct-seller-contract');

    //Search Products
    Route::get('getProductSuggestion', 'ProductSearchController@getProductSuggestion')->name('getProductSuggestion');
    Route::get('search-product', 'ProductSearchController@searchProduct')->name('search-product');

    Route::group([
        'prefix' => 'product',
        'as' => 'product.',
    ], function () {
        Route::any('list/{category_prefix}', 'ProductController@index')->name('index');
        Route::get('detail/{product}', 'ProductController@detail')->name('detail');
    });

    Route::group([
        'prefix' => 'cart',
        'as' => 'cart.',
    ], function () {
        Route::post('products', 'CartController@update')->name('products.update');
        Route::any('/payment', 'CartController@payment')->name('payment')->middleware(['guard:member', 'memberAuth']);
        Route::post('products/delivered-type', 'CartController@deliveredType')->name('products.delivered-type');
        Route::post('products/remove', 'CartController@destroy')->name('products.remove');
        Route::any('/', 'CartController@index')->name('index')->middleware(['guard:member', 'memberAuth']);
    });

    Route::group([
        'prefix' => 'orders',
        'as' => 'orders.',
    ], function () {
        Route::group([
            'middleware' => ['guard:member', 'memberAuth'],
        ], function () {
            Route::post('', 'OrderController@store')->name('store');
            Route::get('{order}/show', 'OrderController@show')->name('show');
            Route::get('{order}/update', 'OrderController@update')->name('update');
            Route::get('{order}/thanks', 'OrderController@thanks')->name('thanks');
            Route::any('payment-process/{order}', 'RazorPayController@index')->name('payment-process');
        });
    });
});

Route::get('member/{member}/name', function (Member $member) {
    return response()->json([
        'user' => [
            'name' => optional($member->user)->name,
        ],
    ]);
})->name('members.show');

Route::get('pin/{code}/name', function ($code = null) {
    return response()->json([
        'pin' => Pin::with('package')->whereCode($code)->first(),
    ]);
})->name('packageName');

Route::get('district/{state_id}', function ($state_id) {
    $districts = City::where('state_id', $state_id)->get();

    return response()->json($districts);
})->name('district.show');

Route::get('state', function () {
    return response()->json([
        'states' => State::with('cities')->get(),
    ]);
})->name('state');

Route::get('city/{state_id?}', function (Illuminate\Http\Request $request) {
    if ($request->get('state_id')) {
        $city = City::where('state_id', $request->get('state_id'))->get();
    } else {
        $city = City::get();
    }

    return response()->json(['cities' => $city]);
})->name('city');

Route::post('uploads/process', 'UploadController@process');
