@extends('website.layouts.master')

@section('title',':: '.$photoGallery->title.' | '.settings('company_name').' ::')

@section('content')
    <section class="wrapper bg-soft-primary">
        <div class="container pt-10 pb-10 pt-md-14 pb-md-16 text-center">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="display-1 mb-3"> Gallery Details</h1>
                    <nav class="d-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('website.home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> {{ $photoGallery->title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    @if($subPhotoGalleries->count() > 0)
        <section id="lightbox" class="wrapper pt-16 pb-2">
            <div class="container py-6 py-md-10">
                <div class="row gy-10 light-gallery-wrapper">
                    @foreach($subPhotoGalleries  as $subPhotoGallery)
                        <div class="item col-md-4">
                            <figure class="lift rounded mb-4 gallery">
                                <a href="{{ $subPhotoGallery->getFirstMediaUrl(\App\Models\SubPhotoGallery::SUB_IMAGE) }}"
                                   class="lightbox">
                                    <img class="gallery-img"
                                        src="{{ $subPhotoGallery->getFirstMediaUrl(\App\Models\SubPhotoGallery::SUB_IMAGE) }}"
                                        alt=""/>
                                </a>
                            </figure>
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
                            <span class="text-body">Gallery Images Not Found</span>
                        </h1>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
