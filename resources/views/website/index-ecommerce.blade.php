@extends('website.layouts.master')

@section('title',''.settings('company_name').'')

@section('content')
    @if($banners->count() > 0)
        <div class="hero-slider-wrapper bg-dark" data-cue="fadeIn">
            <div class="hero-slider owl-carousel dots-over" data-nav="true" data-dots="true" data-autoplay="true">
                @foreach( $banners as $key=>$banner)
                    <div class="owl-slide d-flex align-items-center"
                         style="background-image: url({{ $banner->getFirstMediaUrl(\App\Models\Banner::MC_BANNER) }});">
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="hero-slider-wrapper bg-dark" data-cue="fadeIn">
            <div class="hero-slider owl-carousel dots-over" data-nav="true" data-dots="true" data-autoplay="true">
                @for($i=1;$i<=3;$i++)
                    <div class="owl-slide d-flex align-items-center"
                         style="background-image: url({{ $banner->getFirstMediaUrl(\App\Models\Banner::MC_BANNER) }});">
                    </div>
                @endfor
            </div>
        </div>
    @endif
    @if(count($trendingProducts))
        <section class="wrapper bg-light wrapper-border" data-cue="fadeIn">
            <div class="container py-14 py-md-8">
                <h2 class="display-5 mb-5 text-center">Trending Products</h2>
                <div class="carousel owl-carousel gap-small" data-nav="true"  data-margin="0" data-dots="false" data-autoplay="true"
                     data-autoplay-timeout="5000"
                     data-responsive='{"0":{"items": "1"}, "768":{"items": "2"}, "992":{"items": "3"}, "1400":{"items": "4"}}'>
                    @foreach($trendingProducts as $key=>$trending)
                        <div class="item">
                            <div class="product_wrap">
                                <a href="{{ route('website.product.detail',$trending->product->slug) }}">
                                    <span class="pr_flash">{{ round($trending->product->bv,2) }} BV</span>
                                    <div class="product_img">
                                        <img
                                            src="{{ $trending->product->getFirstMediaUrl(\App\Models\Product::MC_PRODUCT_IMAGE) }}"
                                            alt="el_img1">
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title">
                                            {{ $trending->product->name }}
                                        </h6>
                                        <div class="product_price">
                                        <span class="price">
                                            <i class="uil uil-rupee-sign"></i>{{ round($trending->product->dp,2) }}
                                        </span>
                                            <del>र {{ round($trending->product->mrp,2) }}</del>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    @foreach($categorySliders as $slider)
        @if(count($categorySliders) > 0)
            <section class="wrapper bg-light wrapper-border" data-cue="fadeIn">
                <div class="container py-14 py-md-8">
                    <h2 class="display-5 mb-5 text-center">{{ $slider->category->name }}</h2>
                    <div class="carousel owl-carousel gap-small" data-margin="0" data-dots="false" data-nav="true"
                         data-responsive='{"0":{"items": "1"}, "768":{"items": "2"}, "992":{"items": "3"}, "1400":{"items": "4"}}'>
                        @foreach($slider->category->product as $product)
                            <div class="item">
                                <div class="product_wrap">
                                    <a href="{{ route('website.product.detail',$product->slug) }}">
                                        <span class="pr_flash">{{ round($product->bv,2) }} BV</span>
                                        <div class="product_img">
                                            <img
                                                src="{{ $product->getFirstMediaUrl(\App\Models\Product::MC_PRODUCT_IMAGE) }}"
                                                alt="el_img1">
                                        </div>
                                        <div class="product_info">
                                            <h6 class="product_title">
                                                {{ $product->name }}
                                            </h6>
                                            <div class="product_price">
                                        <span class="price">
                                            <i class="uil uil-rupee-sign"></i>{{ round($product->dp,2) }}
                                        </span>
                                                <del>र {{ round($product->mrp,2) }}</del>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endforeach
    <section class="wrapper bg-light">
        <div class="container pt-14 pt-md-18">
            <div class="row text-center">
                <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                    <h2 class="fs-16 text-uppercase text-muted mb-3">What We Do?</h2>
                    <h3 class="display-4 mb-10 px-xl-10">The service we offer is specifically to your
                        needs.</h3>
                </div>
            </div>
            <!-- /.row -->
            <div class="position-relative">
                <div class="shape rounded-circle bg-soft-blue rellax w-16 h-16" data-rellax-speed="1"
                     style="bottom: -0.5rem; right: -2.2rem; z-index: 0;"></div>
                <div class="shape bg-dot primary rellax w-16 h-17" data-rellax-speed="1"
                     style="top: -0.5rem; left: -2.5rem; z-index: 0;"></div>
                <div class="row gx-md-5 gy-5 text-center">
                    <div class="col-md-6 col-xl-3">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <img src="{{ asset('images/icons/search-1.svg') }}"
                                     class="svg-inject icon-svg icon-svg-md text-yellow mb-3" alt=""/>
                                <h4>100% Secure Payments</h4>
                                <p class="mb-2 fs-16">
                                    Moving your card details to a much more secured place
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <img src="{{ asset('images/icons/browser.svg') }}"
                                     class="svg-inject icon-svg icon-svg-md text-red mb-3" alt=""/>
                                <h4>TrustPay</h4>
                                <p class="mb-2 fs-16">
                                    100% Payment Protection. Easy Return Policy
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <img src="{{ asset('images/icons/chat-2.svg') }}"
                                     class="svg-inject icon-svg icon-svg-md text-green mb-3" alt=""/>
                                <h4>Help Center</h4>
                                <p class="mb-2 fs-16">
                                    Got a question? Look no further.Submit your query here.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <img src="{{ asset('images/icons/user.svg') }}"
                                     class="svg-inject icon-svg icon-svg-md text-blue mb-3" alt=""/>
                                <h4>Shop on the Go</h4>
                                <p class="mb-2 fs-16">
                                    Search the products and get exciting products at your fingertips
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix">&nbsp;</div>
                </div>
            </div>
        </div>
    </section>

    <section class="wrapper bg-gradient-primary">
        <div class="container pt-10 pt-md-14 pb-8 text-center">
            <div class="row gx-lg-8 gx-xl-12 gy-10 align-items-center">
                <div class="col-lg-7">
                    <figure>
                        <img class="w-auto" src="{{ asset('images/concept2.png') }}"
                             srcset={{ asset('images/concept2.png') }} 2x" alt=""/>
                    </figure>
                </div>
                <div class="col-md-10 offset-md-1 offset-lg-0 col-lg-5 text-center text-lg-start">
                    <h1 class="display-1 mb-5 mx-md-n5 mx-lg-0">Grow Your Business with Our Solutions.</h1>
                    <p class="lead fs-lg mb-7">
                        A better experience for your customers. You'll be set up in minutes.
                    </p>
                    <span>
                        <a class="btn btn-primary rounded-pill me-2" href="{{ route('member.register.create') }}">
                            Get Started
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </section>

    @if($packages)
        <section class="wrapper bg-light angled upper-end">
            <div class="container py-8 pt-md-8">
                <div class="row gy-6">
                    <div class="col-lg-4">
                        <h2 class="fs-16 text-uppercase text-muted mt-lg-18 mb-3">Our Package</h2>
                        <h3 class="display-4 mb-3">We offer great and premium Packages.</h3>
                        <a href="{{ route('website.package') }}" class="btn btn-primary rounded-pill mt-2">See All
                            Packages</a>
                    </div>
                    <!--/column -->
                    <div class="col-lg-7 offset-lg-1 pricing-wrapper">
                        <div class="row gy-6 position-relative mt-5 match-height">
                            <div class="shape bg-dot red rellax w-16 h-18" data-rellax-speed="1"
                                 style="bottom: -0.5rem; right: -1.6rem;"></div>
                            @foreach($packages as $key => $package)
                                <div class="col-md-6 popular">
                                    <div class="pricing card shadow-lg">
                                        <div class="card-body pb-12">
                                            <div class="prices text-dark">
                                                <div class="price price-show">
                                                    <span class="price-currency">र </span>
                                                    <span class="price-value">{{ round($package->amount,2) }}</span>
                                                    <span class="price-duration">{{ round($package->pv,2) }} PV</span>
                                                </div>
                                            </div>
                                            <h4 class="card-title mt-2">{{ $package->name }}</h4>
                                            <ul class="icon-list bullet-soft-primary mt-8 mb-9">
                                                @foreach($package->products as $product)
                                                    <li>
                                                        <b class="text-primary">
                                                            {{ $product->name }}
                                                        </b>
                                                        <div class="mt-2">
                                                            <b>HSN :</b> {{ $product->hsn_code }} |
                                                            <b>GST:</b> {{ $product->present()->gstSlab() }} |
                                                            <b>Price :</b>र {{ round($product->price,2) }}
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <a href="{{ route('member.register.create') }}"
                                               class="btn btn-primary rounded-pill">
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
    @endif

    <section class="wrapper bg-light">
        <div class="container ">
            <div class="row gx-lg-8 gx-xl-12 gy-10 align-items-center">
                @if(settings('grievance_name'))
                    <div class="col-lg-6 py-8 py-md-8">
                        <h2 class="fs-15 text-uppercase text-line text-primary text-center mb-3">Get In Touch</h2>
                        <h3 class="display-5 mb-7">
                            Grievance Redressal
                        </h3>
                        <div class="d-flex flex-row">
                            <div>
                                <div class="icon text-primary fs-28 me-4 mt-n1"><i class="uil uil-user"></i></div>
                            </div>
                            <div>
                                <h5 class="mb-1">Name</h5>
                                <address>{{ settings('grievance_name') }}</address>
                            </div>
                        </div>
                        @if(settings('grievance_mobile'))
                            <div class="d-flex flex-row">
                                <div>
                                    <div class="icon text-primary fs-28 me-4 mt-n1"><i class="uil uil-phone-volume"></i>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="mb-1">Mobile Number</h5>
                                    <p>{{ settings('grievance_mobile') }}</p>
                                </div>
                            </div>
                        @endif
                        @if(settings('grievance_email'))
                            <div class="d-flex flex-row">
                                <div>
                                    <div class="icon text-primary fs-28 me-4 mt-n1"><i class="uil uil-envelope"></i>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="mb-1">Email ID</h5>
                                    <p class="mb-0"><a href="mailto:{{ settings('grievance_email') }}"
                                                       class="link-body">{{ settings('grievance_email') }}</a></p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
                @if(settings('nodal_name'))
                    <div class="col-lg-6">
                        <h2 class="fs-15 text-uppercase text-line text-primary text-center mb-3">Get In Touch</h2>
                        <h3 class="display-5 mb-7">Nodal Officer</h3>
                        <div class="d-flex flex-row">
                            <div>
                                <div class="icon text-primary fs-28 me-4 mt-n1"><i class="uil uil-user"></i></div>
                            </div>
                            <div>
                                <h5 class="mb-1">Name</h5>
                                <address>{{ settings('nodal_name') }}</address>
                            </div>
                        </div>
                        @if(settings('nodal_mobile'))
                            <div class="d-flex flex-row">
                                <div>
                                    <div class="icon text-primary fs-28 me-4 mt-n1"><i class="uil uil-phone-volume"></i>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="mb-1">Mobile Number</h5>
                                    <p>{{ settings('nodal_mobile') }}</p>
                                </div>
                            </div>
                        @endif
                        @if(settings('nodal_email'))
                            <div class="d-flex flex-row">
                                <div>
                                    <div class="icon text-primary fs-28 me-4 mt-n1"><i class="uil uil-envelope"></i>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="mb-1">Email ID</h5>
                                    <p class="mb-0">
                                        <a href="mailto:{{ settings('nodal_email') }}"
                                           class="link-body">{{ settings('nodal_email') }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </section>


    @if(count($popups))
        @foreach($popups as $popup)
            <div class="modal fade popupModal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-body p-0">
                            <img
                                src="{{ $popup->getFirstMediaUrl(\App\Models\WebsitePopup::MEDIA_COLLECTION_IMAGE_WEBSITE_POPUP) }}"
                                alt="{{ $popup->name }}" width="100%" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection
@push('page-css')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endpush
@push('page-javascript')
    <script>
        $(window).on("load", function () {
            $('.popupModal').modal('toggle');
        });
    </script>
@endpush


