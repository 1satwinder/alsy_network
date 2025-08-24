@extends('member.layouts.master')

@section('title')
    Products
@endsection

@section('content')
    @include('member.breadcrumbs', [
          'crumbs' => [
              'Products'
          ]
     ])
    @if($total > 0)
        <div class="content-body">
            <div class="ecommerce-application">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-header">
                                <h4>Categories</h4>
                            </div>
                            <div class="card-body p-0">
                                <div class="accordion mt-3" id="accordionExample">
                                    @foreach($categories as $key => $category)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading{{$key}}">
                                                <button type="button" class="accordion-button collapsed"
                                                        data-bs-toggle="collapse" data-bs-target="#accordion{{$key}}"
                                                        aria-expanded="false" aria-controls="accordion{{$key}}">
                                                    {{ $category->name }}
                                                </button>
                                            </h2>
                                            <div id="accordion{{$key}}" class="accordion-collapse collapse"
                                                 aria-labelledby="heading{{$key}}" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <ul class="list-unstyled categories-list">
                                                        @foreach($category->children as $child_category)
                                                            <li>
                                                                <a href="{{ route('member.product.index', ['category_prefix' => $child_category->prefix]) }}">{{ $child_category->name }}</a>

                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <section id="ecommerce-header" class="mt-1">
                            {{ $products->links('pagination::bootstrap-5') }}
                        </section>
                        <section id="ecommerce-products" class="grid-view">
                            @foreach($products as $product)
                                <div class="card ecommerce-card">
                                    <div class="item-img text-center">
                                        <a href="{{ route('member.product.detail',$product) }}">
                                            <img class="img-fluid card-img-top"
                                                 src="{{ $product->getFirstMediaUrl(\App\Models\Product::MC_PRODUCT_IMAGE) }}"
                                                 alt="{{ $product->name }}"/>
                                            <div class="flash">
                                                <span class="onnew">{{ round($product->bv,2) }} BV</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="item-name">
                                            <a class="text-body"
                                               href="{{ route('member.product.detail',$product) }}">{{ $product->name }}</a>
                                        </h6>
                                    </div>
                                    <div class="text-center">
                                        <div class="product_price">
                                                <span
                                                    class="price">{{ env('APP_CURRENCY', ' र ') }}{{ round($product->dp, 2) }}</span>
                                            <del>{{ env('APP_CURRENCY', ' र ') }}{{ round($product->mrp, 2) }}</del>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </section>
                        <section class="pagination my-5 float-right">
                            <div class="col-12">
                                {{ $products->links('pagination::bootstrap-5') }}
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-12 d-flex text-center justify-content-center">
                <div class="error-content">
                    <img class="img-fluid"
                         src="{{ asset('images/empty_item.svg') }}" alt="no-data">
                    <div class="notfound-404">
                        <h1 class="text-primary">
                            <i class="uil uil-sad-squint"></i> Oops!
                            <span class="text-body">No Product Found</span>
                        </h1>
                        <p class="mb-2">We're sorry, Please try another Category.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/app-ecommerce.min.css') }}">
@endpush

@push('page-javascript')
    <script src="{{ asset('assets/js/app-ecommerce.min.js') }}"></script>
@endpush
