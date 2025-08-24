@extends('website.layouts.master')

@section('title',':: Gallery | '.settings('company_name').' ::')

@section('content')
    <section class="wrapper bg-soft-primary">
        <div class="container pt-10 pb-10 pt-md-14 pb-md-16 text-center">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="display-1 mb-3"> Gallery</h1>
                    <nav class="d-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('website.home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Gallery</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    @if(count($photoGalleries)>0)
        <section class="wrapper bg-light wrapper-border">
            <div class="container py-6 py-md-10">
                <div class="row gx-lg-8 gx-xl-12 gy-10 align-items-center mb-5">
                    @foreach($photoGalleries as $photoGallery)
                        <div class="col-md-4">
                            <a href="{{ route('website.gallery-details',[$photoGallery]) }}">
                                <div class="card">
                                    <figure class="lift rounded gallery mb-0">
                                        <img class="card-img-top"
                                             src="{{ $photoGallery->getFirstMediaUrl(\App\Models\PhotoGallery::MAIN_IMAGE) }}"
                                             alt=""/>
                                    </figure>
                                    <div class="card-header px-4">
                                        <h4 class="text-title-truncate mb-0">{{ $photoGallery->title }}</h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @else
        <section class="wow fadeInUp py-6" data-wow-delay="0.3s">
            <div class="col-lg-12 d-flex text-center justify-content-center">
                <div class="error-content">
                    <img class="img-fluid"
                         src="{{ asset('images/empty_item.svg') }}" alt="no-data">
                    <div class="notfound-404">
                        <h1 class="text-primary">
                            <i class="uil uil-sad-squint"></i> Oops!
                            <span class="text-body">Gallery Not Found</span>
                        </h1>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection


