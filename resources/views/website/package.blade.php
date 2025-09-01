@extends('website.layouts.master')

@section('title',':: Packages | '.settings('company_name').' ::')

@section('content')
    <section class="wrapper bg-soft-primary">
        <div class="container pt-10 pb-10 pt-md-14 pb-md-16 text-center">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="display-1 mb-3"> Packages</h1>
                    <nav class="d-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('website.home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Packages</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="wrapper bg-light">
        <div class="container py-14 pt-md-14">
            <div class="row gy-6 mb-14 ">
                <div class="col-lg-12 pricing-wrapper">
                    <div class="row gy-6 match-height position-relative mt-5">
                        @foreach($packages as $key => $package)
                            <div class="col-md-4 popular package-card">
                                <a href="{{ optional($package)->getFirstMediaUrl(\App\Models\Package::MC_PACKAGE_IMAGE) ?: '/images/no_image.png' }}"
                                   class='image-popup gallery' data-toggle='tooltip'
                                   data-original-title='Click here to zoom image'>
                                    <img src="{{ optional($package)->getFirstMediaUrl(\App\Models\Package::MC_PACKAGE_IMAGE) ?: '/images/no_image.png' }}"
                                         class="img-fluid" alt="">
                                </a>
                                <div class="pricing card shadow-lg">
                                    <div class="card-body p-0">
                                        <div class="prices text-dark">
                                            <div class="price price-show">
                                                <span class="price-currency">र </span>
                                                <span class="price-value">{{ round($package->amount,2) }}</span>
                                                <span class="price-duration">{{ round($package->pv,2) }} PV</span>
                                            </div>
                                        </div>
                                        <h4 class="card-title my-4">{{ $package->name }}</h4>
                                        <ul class="icon-list bullet-soft-primary">
                                            @foreach($package->products as $product)
                                                <li>
                                                    <b class="text-primary">
                                                        {{ $product->name }}
                                                    </b>
                                                    <div class="mt-2">
                                                        <b>HSN : </b> {{ $product->hsn_code }} |
                                                        <b>GST : </b> {{ $product->present()->gstSlab() }} % |
                                                        <b>Price : </b>र {{ round($product->price,2) }}
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <a href="{{ route('member.register.create') }}"
                                           class="btn btn-primary rounded-pill my-3 text-center ">
                                            Get Started
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('page-javascript')
    <script src="{{ asset('js/lightbox.js') }}"></script>
    <script>
        $(".image-popup").magnificPopup({
            type: "image",
            closeOnContentClick: !1,
            closeBtnInside: !1,
            mainClass: "mfp-with-zoom mfp-img-mobile",
            image: {
                verticalFit: !0, titleSrc: function (e) {
                    return e.el.attr("title")
                }
            },
            gallery: {enabled: !0},
            zoom: {
                enabled: !0, duration: 300, opener: function (e) {
                    return e.find("img")
                }
            }
        });
    </script>
@endpush

@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/lightbox.css') }}">
    <link rel="stylesheet" href="{{ asset('css/package-images.css') }}">
@endsection

