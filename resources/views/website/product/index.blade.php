@extends('website.layouts.master')

@section('title',':: '.$category->name.' | '.settings('company_name').' ::')

@section('content')
    <section class="wrapper bg-soft-primary">
        <div class="container pt-10 pb-10 pt-md-14 pb-md-16 text-center">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="display-1 mb-3"> {{ $category->name }}</h1>
                    <nav class="d-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('website.home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> {{ $category->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="wrapper bg-light">
        <div class="container py-14 py-md-16">
            <div class="row mt-6">
                <aside class="col-xl-3 sidebar">
                    <div id="accordion-1" class="accordion-wrapper">
                        <div class="card">
                            <div class="card-header" id="accordion-heading-1-1">
                                <button class="collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#accordion-collapse-1-1" aria-expanded="false"
                                        aria-controls="accordion-collapse-1-1">
                                    Categories
                                </button>
                            </div>
                            <div id="accordion-collapse-1-1" class="collapse {{ Agent::isMobile() ? '' : 'show'}}"
                                 aria-labelledby="accordion-heading-1-1" data-bs-target="#accordion-1">
                                <div class="card-body">
                                    <nav>
                                        <ul class="nav list-unstyled lh-lg text-reset d-block">
                                            @foreach($sideCategories as $key => $category)
                                                <li class="nav-item">
                                                    <a class="nav-link"
                                                       href="{{ route('website.product.index', ['category_prefix' => $category->prefix]) }}">
                                                        {{ $category->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
                <div class="col-lg-9">
                    <div class="row">
                        @if($products->count() > 0)
                            @foreach ($products as $product)
                                <div class="col-xl-4">
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
                        @else
                            <div class="col-lg-12 d-flex text-center justify-content-center">
                                <div class="error-content">
                                    <img class="img-fluid"
                                         src="{{ asset('images/empty_item.svg') }}" alt="no-data">
                                    <div class="notfound-404">
                                        <h1 class="text-primary">
                                            <i class="uil uil-sad-squint"></i> Oops!
                                            <span class="text-body">Product not Found</span>
                                        </h1>
                                        <h4>We're sorry, Please try another Category.</h4>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-12">
                            {{ $products->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('page-css')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endpush

@push('page-javascript')
    <script>
        var url = "{{ route('website.cart.products.update') }}";
        var csrfToken = "{{ csrf_token() }}";
        var cartCountEl = $('.cartCount');

        function increaseProductQuantity(product_id) {
            var productEl = $('#product_' + product_id);
            var newQuantity = productEl.data('quantity') + 1;
            productEl.data('quantity', newQuantity);
            productEl.html('(' + newQuantity + ')');
        }

        function decreaseProductQuantity(product_id) {
            var productEl = $('#product_' + product_id);
            var newQuantity = productEl.data('quantity') - 1;
            if (newQuantity < 0) {
                return false;
            }
            productEl.data('quantity', newQuantity);
            productEl.html('(' + newQuantity + ')');
        }

        function addToCart(productId) {
            var productEl = $('#product_' + productId);
            var quantity = productEl.data('quantity');

            if (quantity > 0) {
                $.ajax({
                    url: url,
                    data: {"_token": csrfToken, "product_id": productId, "quantity": quantity},
                    type: "POST",
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == false) {
                            Swal.fire('Yay', response.message, 'error');
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
