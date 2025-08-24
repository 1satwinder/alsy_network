@extends('website.layouts.master')

@section('title',':: Products | '.settings('company_name').' ::')

@section('content')
    <section class="wrapper bg-soft-primary">
        <div class="container pt-10 pb-10 pt-md-14 pb-md-16 text-center">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="display-1 mb-3"> {{ $product->name }}</h1>
                    <nav class="d-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('website.home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> {{ $product->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="wrapper bg-light">
        <div class="container py-7 py-md-8">
            <div class="row mt-6">
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
                        <h3>{{ $product->name }}</h3>
                        <div class="product_price">
                            <span class="price"><i class="uil uil-rupee-sign"></i>{{ $product->dp }}</span>
                            <del>र {{ $product->mrp }}</del>
                            <span class="text-success">{{ round($product->bv,2) }} BV</span>
                        </div>
                        <div class="pr_footer mt-2 mb-0">
                            <ul class="product_meta list-unstyled">
                                <li><span>Product Code:</span> <span>{{ $product->sku }}</span></li>
                                <li><span>Category:</span><span>{{ $product->category->name }}</span></li>
                            </ul>
                            <ul class="list-unstyled social-links">
                                <li class="d-flex"><span>Share:</span>{!! $socialMediaLinks !!}</li>
                            </ul>
                        </div>
                        <div class="product-buy">
                            @if ($product->company_stock>0)
                                <button class="btn btn-sm btn-primary rounded font-weight-bold"
                                        onclick="addToCart({{ $product->id }});">
                                    Add To Cart
                                </button>
                            @else
                                <button class="btn btn-sm btn-danger rounded">
                                    Out Of Stock
                                </button>
                            @endif
                        </div>
                        <div id="accordion-1" class="accordion-wrapper">
                            <div class="card">
                                <div class="card-header" id="accordion-heading-1-1">
                                    <button class="collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#accordion-collapse-1-1" aria-expanded="true"
                                            aria-controls="accordion-collapse-1-1">
                                        Description
                                    </button>
                                </div>
                                <div id="accordion-collapse-1-1" class="collapse show"
                                     aria-labelledby="accordion-heading-1-1" data-bs-target="#accordion-1">
                                    <div class="card-body">
                                        {!! $product->description !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="wrapper bg-light wrapper-border">
        <div class="container py-14 py-md-16">
            <h2 class="display-5 mb-5 text-center">Related Products</h2>
            <div class="carousel owl-carousel gap-small" data-margin="0" data-dots="true" data-autoplay="true"
                 data-autoplay-timeout="5000"
                 data-responsive='{"0":{"items": "1"}, "768":{"items": "2"}, "992":{"items": "3"}, "1400":{"items": "4"}}'>
                @foreach($relatedProducts as $product)
                    <div class="item">
                        <div class="product_wrap">
                            <a href="{{ route('website.product.detail', $product) }}">
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
@endsection
@push('page-css')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endpush
@push('page-javascript')
    <script type="text/javascript" src="{{ asset('js/xzoom.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.owl-carousel').owlCarousel();
        });
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
    </script>
@endpush
