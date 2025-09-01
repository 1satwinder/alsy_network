@extends('website.layouts.master')

@section('title',''.settings('company_name').'')

@section('content')
    @if($banners->count() > 0)
        <div class="hero-slider-wrapper bg-dark">
            <div class="hero-slider owl-carousel dots-over" data-nav="true" data-dots="true" data-autoplay="true">
                @foreach( $banners as $key=>$banner)
                    <div class="owl-slide d-flex align-items-center"
                         style="background-image: url({{ $banner->getFirstMediaUrl(\App\Models\Banner::MC_BANNER) }});">
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="hero-slider-wrapper bg-dark">
            <div class="hero-slider owl-carousel dots-over" data-nav="true" data-dots="true" data-autoplay="true">
                @for($i=1;$i<=3;$i++)
                    <div class="owl-slide d-flex align-items-center"
                         style="background-image: url({{ asset('images/slider/slider'.$i.'.jpg') }});">
                    </div>
                @endfor
            </div>
        </div>
    @endif
    <!-- /header -->
    <section class="wrapper">
        <div class="container py-8 py-md-8 text-center">
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
    <!-- /section -->
    <section class="wrapper bg-light">
        <div class="container py-8 py-md-14">
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
                                <h4>Get Benefit?</h4>
                                <p class="mb-2 fs-16">
                                    With our software you don't need any skills, just an idle connection and a computer
                                    and you are on your way to making a decent income.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <img src="{{ asset('images/icons/browser.svg') }}"
                                     class="svg-inject icon-svg icon-svg-md text-red mb-3" alt=""/>
                                <h4>Make Better Career</h4>
                                <p class="mb-2 fs-16">
                                    We sincerely hope you make the most of the Income info Opportunity and we welcome
                                    your valuable, long-term participation.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <img src="{{ asset('images/icons/chat-2.svg') }}"
                                     class="svg-inject icon-svg icon-svg-md text-green mb-3" alt=""/>
                                <h4>We Built A Platform</h4>
                                <p class="mb-2 fs-16">
                                    {{ settings('company_name') }} is a best experienced people's community where they
                                    can
                                    build
                                    social platform and gives best opportunity.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <img src="{{ asset('images/icons/user.svg') }}"
                                     class="svg-inject icon-svg icon-svg-md text-blue mb-3" alt=""/>
                                <h4>Privacy</h4>
                                <p class="mb-2 fs-16">
                                    When you join us it becomes on interest bearing asset that provides strong privacy
                                    protections.You can now avail a of funds transfer services.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="wrapper bg-light angled upper-start lower-start">
        <div class="container py-8 py-md-8">
            <div class="row gx-lg-8 gx-xl-12 gy-10 align-items-center">
                <div class="col-lg-7">
                    <figure>
                        <img class="w-auto" src="{{ asset('images/concept17.png') }}" alt=""/>
                    </figure>
                </div>
                <div class="col-lg-5">
                    <h3 class="display-4 mt-xxl-8 mb-3">Why Choose Us?</h3>
                    <p class="lead fs-lg lh-sm mb-6">Find out everything you need to know about creating a business
                        process model.</p>
                    <div class="accordion accordion-wrapper" id="accordionExample">
                        <div class="card plain accordion-item">
                            <div class="card-header" id="headingOne">
                                <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                        aria-expanded="true" aria-controls="collapseOne"> Joining Options
                                </button>
                            </div>
                            <!--/.card-header -->
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                 data-bs-parent="#accordionExample">
                                <div class="card-body">
                                    <p>
                                        We create dynamic entrepreneurs through the promotion of high quality
                                        products...
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card plain accordion-item">
                            <div class="card-header" id="headingTwo">
                                <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                        aria-expanded="false" aria-controls="collapseTwo">Business Opportunity
                                </button>
                            </div>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                 data-bs-parent="#accordionExample">
                                <div class="card-body">
                                    <p>
                                        The biggest opportunity that you have today is the Direct Selling Model of
                                        Success...
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card plain accordion-item">
                            <div class="card-header" id="headingThree">
                                <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                        aria-expanded="false" aria-controls="collapseThree"> Customer Care
                                </button>
                            </div>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                 data-bs-parent="#accordionExample">
                                <div class="card-body">
                                    <p>
                                        We would love to hear from you so why not drop us an email. We will get back to
                                        you as soon as possible...
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
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

                            @foreach($packages as $key => $package)
                                <div class="col-md-6 popular package-card">
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
                                               class="btn btn-primary rounded-pill my-3">
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
                            @if($popup->getFirstMediaUrl(\App\Models\WebsitePopup::MEDIA_COLLECTION_IMAGE_WEBSITE_POPUP))
                                <img
                                    src="{{ $popup->getFirstMediaUrl(\App\Models\WebsitePopup::MEDIA_COLLECTION_IMAGE_WEBSITE_POPUP) }}"
                                    alt="{{ $popup->name }}" width="100%" class="img-fluid">
                            @else
                                <article class="col-xl-6 col-lg-6 col-md-6 text-center hover-up mb-30 animated" style="width: 100%">
                                    <div class="post-thumb">
                                        <div class="js-player" data-plyr-provider="youtube"
                                             data-plyr-embed-id="{{ $popup->link }}"></div>
                                    </div>
                                </article>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection

@push('page-css')
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css"/>

@endpush
@push('page-javascript')
    <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
    <script>
        const players = Array.from(document.querySelectorAll('.js-player')).map((p) => new Plyr(p));
        for (let index = 0; index < players.length; index++) {
            $(".btn-close").on('click', function () {
                players[index].pause(); // Pause other plyr instances
            })
        }
    </script>
    <script>
        $(window).on("load", function () {
            $('.popupModal').modal('toggle');
        });

        $('#searchForm').on('shown.bs.collapse', function () {
            // focus input on collapse
            $("#search").focus()
        })

        $('#searchForm').on('hidden.bs.collapse', function () {
            // focus input on collapse
            $("#search").blur()
        })
    </script>
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
@endpush


