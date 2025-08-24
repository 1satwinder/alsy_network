@extends('member.layouts.master')

@section('title') Product Detail @endsection

@section('content')
    @include('member.breadcrumbs', [
          'crumbs' => [
              'Product Detail'
          ]
     ])
    <div class="content-body">
        <section class="app-ecommerce-details">
            <div class="card">
                <div class="card-body">
                    <div class="row my-2">
                        <div class="col-lg-5">
                            <div class="product-box-image">
                                <div class="xzoom-container">
                                    <img alt="" class="xzoom" id="xzoom-default"
                                         src="{{ $product->getFirstMediaUrl(\App\Models\Product::MC_PRODUCT_IMAGE) }}"
                                         xoriginal="{{ $product->getFirstMediaUrl(\App\Models\Product::MC_PRODUCT_IMAGE) }}"/>
                                </div>

                                <div class="xzoom-thumbs">
                                    <a href="{{ $product->getFirstMediaUrl(\App\Models\Product::MC_PRODUCT_IMAGE) }}">
                                        <img alt="" class="xzoom-gallery" width="80"
                                             src="{{ $product->getFirstMediaUrl(\App\Models\Product::MC_PRODUCT_IMAGE) }}"
                                             xpreview="{{ $product->getFirstMediaUrl(\App\Models\Product::MC_PRODUCT_IMAGE) }}">
                                    </a>
                                    @foreach($product->getMedia(\App\Models\Product::MC_PRODUCT_SUB_IMAGE) as $key => $image)
                                        <a href="{{ $image->getUrl() }}">
                                            <img alt="" class="xzoom-gallery" width="80" src="{{ $image->getUrl() }}"
                                                 xpreview="{{ $image->getUrl() }}">
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-7">
                            <div class="pr_details">
                                <h2>{{ $product->name }}</h2>
                                <h3 class="product_price">
                                    <span class="price"><i class="uil uil-rupee-sign"></i>{{ round($product->dp,2)  }}</span>
                                    <del class="text-muted mx-3">र {{ round($product->mrp,2) }}</del>
                                    <span class="text-success">{{ round($product->bv,2) }} BV</span>
                                </h3>
                                <ul class="list-unstyled my-3 py-1">
                                    <li class="d-flex align-items-center mb-3"><span class="fw-semibold mx-2">Product Code:</span> <span>{{ $product->sku }}</span></li>
                                    <li class="d-flex align-items-center mb-3"><span class="fw-semibold mx-2">Category:</span> <span>{{ $product->category->name }}</span></li>
                                    <li class="d-flex align-items-center mb-3"><span class="fw-semibold mx-2">Share:</span> <span>{!! $socialMediaLinks !!}</span></li>
                                </ul>
                                <div class="product-buy">
                                    @if ($product->company_stock>0)
                                        <button class="btn btn-primary rounded" onclick="addToCart({{ $product->id }});">
                                            Add To Cart
                                        </button>
                                    @else
                                        <button class="btn btn-danger rounded">
                                            Out Of Stock
                                        </button>
                                    @endif
                                </div>
                                <div class="accordion accordion-popout mt-3" id="accordionPopout">
                                    <div class="accordion-item active">
                                        <h2 class="accordion-header" id="headingPopoutOne">
                                            <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionPopoutOne" aria-expanded="true" aria-controls="accordionPopoutOne">
                                                Description
                                            </button>
                                        </h2>

                                        <div id="accordionPopoutOne" class="accordion-collapse collapse show" aria-labelledby="headingPopoutOne" data-bs-parent="#accordionPopout">
                                            <div class="accordion-body">
                                                {!! $product->description !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('page-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
@endpush
@push('page-javascript')
    <script type="text/javascript" src="{{ asset('js/xzoom.min.js') }}"></script>
    <script>
        var url = "{{ route('website.cart.products.update') }}";
        var csrfToken = "{{ csrf_token() }}";
        var cartCountEl = $('.cartCount');

        function addToCart(productId) {
            var productEl = $('#product_' + productId);
            var quantity = 1;

            if (quantity > 0) {
                $.ajax({
                    url: url,
                    data: {"_token": csrfToken, "product_id": productId, "quantity": quantity},
                    type: "POST",
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == 404) {
                            window.location.href = "{{ route('member.login.create')}}";
                        } else {
                            cartCountEl.html(response.cartCount);
                            productEl.data('quantity', 0);
                            productEl.html('(0)');
                            Swal.fire('Yay', response.message, 'success');
                        }
                    }
                });
            }
        }

        (function ($) {
            $(document).ready(function () {
                $('.xzoom, .xzoom-gallery').xzoom({zoomWidth: 500, title: true, tint: '#333', Xoffset: 15});
                $('.xzoom2, .xzoom-gallery2').xzoom({position: '#xzoom2-id', tint: '#ffa200'});
                $('.xzoom3, .xzoom-gallery3').xzoom({
                    position: 'lens',
                    lensShape: 'circle',
                    sourceClass: 'xzoom-hidden'
                });
                $('.xzoom4, .xzoom-gallery4').xzoom({tint: '#006699', Xoffset: 15});
                $('.xzoom5, .xzoom-gallery5').xzoom({tint: '#006699', Xoffset: 15});

//Integration with hammer.js
                var isTouchSupported = 'ontouchstart' in window;

                if (isTouchSupported) {
//If touch device
                    $('.xzoom, .xzoom2, .xzoom3, .xzoom4, .xzoom5').each(function () {
                        var xzoom = $(this).data('xzoom');
                        xzoom.eventunbind();
                    });

                    $('.xzoom, .xzoom2, .xzoom3').each(function () {
                        var xzoom = $(this).data('xzoom');
                        $(this).hammer().on("tap", function (event) {
                            event.pageX = event.gesture.center.pageX;
                            event.pageY = event.gesture.center.pageY;
                            var s = 1, ls;

                            xzoom.eventmove = function (element) {
                                element.hammer().on('drag', function (event) {
                                    event.pageX = event.gesture.center.pageX;
                                    event.pageY = event.gesture.center.pageY;
                                    xzoom.movezoom(event);
                                    event.gesture.preventDefault();
                                });
                            }

                            xzoom.eventleave = function (element) {
                                element.hammer().on('tap', function (event) {
                                    xzoom.closezoom();
                                });
                            }
                            xzoom.openzoom(event);
                        });
                    });

                    $('.xzoom4').each(function () {
                        var xzoom = $(this).data('xzoom');
                        $(this).hammer().on("tap", function (event) {
                            event.pageX = event.gesture.center.pageX;
                            event.pageY = event.gesture.center.pageY;
                            var s = 1, ls;

                            xzoom.eventmove = function (element) {
                                element.hammer().on('drag', function (event) {
                                    event.pageX = event.gesture.center.pageX;
                                    event.pageY = event.gesture.center.pageY;
                                    xzoom.movezoom(event);
                                    event.gesture.preventDefault();
                                });
                            }

                            var counter = 0;
                            xzoom.eventclick = function (element) {
                                element.hammer().on('tap', function () {
                                    counter++;
                                    if (counter == 1) setTimeout(openfancy, 300);
                                    event.gesture.preventDefault();
                                });
                            }

                            function openfancy() {
                                if (counter == 2) {
                                    xzoom.closezoom();
                                    $.fancybox.open(xzoom.gallery().cgallery);
                                } else {
                                    xzoom.closezoom();
                                }
                                counter = 0;
                            }

                            xzoom.openzoom(event);
                        });
                    });

                    $('.xzoom5').each(function () {
                        var xzoom = $(this).data('xzoom');
                        $(this).hammer().on("tap", function (event) {
                            event.pageX = event.gesture.center.pageX;
                            event.pageY = event.gesture.center.pageY;
                            var s = 1, ls;

                            xzoom.eventmove = function (element) {
                                element.hammer().on('drag', function (event) {
                                    event.pageX = event.gesture.center.pageX;
                                    event.pageY = event.gesture.center.pageY;
                                    xzoom.movezoom(event);
                                    event.gesture.preventDefault();
                                });
                            }

                            var counter = 0;
                            xzoom.eventclick = function (element) {
                                element.hammer().on('tap', function () {
                                    counter++;
                                    if (counter == 1) setTimeout(openmagnific, 300);
                                    event.gesture.preventDefault();
                                });
                            }

                            function openmagnific() {
                                if (counter == 2) {
                                    xzoom.closezoom();
                                    var gallery = xzoom.gallery().cgallery;
                                    var i, images = new Array();
                                    for (i in gallery) {
                                        images[i] = {src: gallery[i]};
                                    }
                                    $.magnificPopup.open({items: images, type: 'image', gallery: {enabled: true}});
                                } else {
                                    xzoom.closezoom();
                                }
                                counter = 0;
                            }

                            xzoom.openzoom(event);
                        });
                    });

                } else {
//If not touch device

//Integration with fancybox plugin
                    $('#xzoom-fancy').bind('click', function (event) {
                        var xzoom = $(this).data('xzoom');
                        xzoom.closezoom();
                        $.fancybox.open(xzoom.gallery().cgallery, {padding: 0, helpers: {overlay: {locked: false}}});
                        event.preventDefault();
                    });

//Integration with magnific popup plugin
                    $('#xzoom-magnific').bind('click', function (event) {
                        var xzoom = $(this).data('xzoom');
                        xzoom.closezoom();
                        var gallery = xzoom.gallery().cgallery;
                        var i, images = new Array();
                        for (i in gallery) {
                            images[i] = {src: gallery[i]};
                        }
                        $.magnificPopup.open({items: images, type: 'image', gallery: {enabled: true}});
                        event.preventDefault();
                    });
                }
            });
        })(jQuery);
    </script>
@endpush
