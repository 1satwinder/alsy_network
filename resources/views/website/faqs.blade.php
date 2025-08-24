@extends('website.layouts.master')

@section('title',':: FAQs | '.settings('company_name').' ::')

@section('content')
    <section class="wrapper bg-soft-primary">
        <div class="container pt-10 pb-10 pt-md-14 pb-md-16 text-center">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="display-1 mb-3"> FAQs</h1>
                    <nav class="d-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('website.home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> FAQs</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    @if(count($faqs)>0)
        <section class="wrapper bg-light wrapper-border">
            <div class="container py-6 py-md-10">
                <div class="row gx-lg-8 gx-xl-12 gy-10 align-items-center mb-5">
                    <div class="col-lg-10">
                        <div id="accordion-1" class="accordion-wrapper">
                            @foreach($faqs as $key => $faq)
                                <div class="card">
                                    <div class="card-header" id="accordion-heading-1-{{ $key }}">
                                        <button class="collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#accordion-collapse-1-{{ $key }}" aria-expanded="false"
                                                aria-controls="accordion-collapse-1-{{ $key }}">
                                            {{ $faq->question }}
                                        </button>
                                    </div>
                                    <div id="accordion-collapse-1-{{ $key }}" class="collapse"
                                         aria-labelledby="accordion-heading-1-{{ $key }}" data-bs-target="#accordion-{{ $key }}">
                                        <div class="card-body">
                                            <p>{!! $faq->answer !!}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
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
                            <span class="text-body">FAQs Not Found</span>
                        </h1>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection


