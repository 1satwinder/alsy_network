@extends('website.layouts.master')

@section('title','About Us | '.settings('company_name').'')

@section('content')
    <section class="wrapper bg-soft-primary">
        <div class="container pt-10 pb-12 pt-md-14 pb-md-16 text-center">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="display-1 mb-3">About Us</h1>
                    <nav class="d-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('website.home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">About Us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="wrapper bg-light wrapper-border">
        <div class="container py-14 py-md-16">
            <div class="row gx-lg-8 gx-xl-12 gy-10 align-items-center mb-5">
                <div class="col-md-8 col-lg-6 col-xl-5 order-lg-2 position-relative">
                    <div class="shape bg-soft-primary rounded-circle rellax w-20 h-20" data-rellax-speed="1"
                         style="top: -2rem; right: -1.9rem;"></div>
                    <figure class="rounded">
                        <img src="{{ asset('images/about-us-bg.png') }}"
                             srcset="{{ asset('images/about-us-bg.png') }} 2x" alt="">
                    </figure>
                </div>
                <div class="col-lg-6">
                    <h2 class="display-4 mb-3">Who Are We?</h2>
                    <p class="mb-6">
                        @if(settings('about_us'))
                            {!! settings('about_us') !!}
                        @endif
                    </p>
                </div>
            </div>
            <div class="row gx-xl-10 gy-6">
                @if(settings('vision_mission'))
                    <div class="col-md-6">
                        <div class="d-flex flex-row">
                            <div>
                                <img src="{{ asset('images/icons/target.svg') }}"
                                     class="svg-inject icon-svg icon-svg-sm me-4" alt=""/>
                            </div>
                            <div>
                                <h4 class="mb-1">Our Mission & Vision</h4>
                                <p class="mb-0">
                                    {!! settings('vision_mission') !!}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-6">
                    <div class="d-flex flex-row">
                        <div>
                            <img src="{{ asset('images/icons/handshake.svg') }}"
                                 class="svg-inject icon-svg icon-svg-sm me-4" alt=""/>
                        </div>
                        <div>
                            <h4 class="mb-1">Our Commitment</h4>
                            <p class="mb-0">
                                At {{ settings('company_name') }}, we are committed to provide a life of healthy living,
                                financial independence and the freedom to live on your terms. We provide the tools, training and experience based
                                knowledge to help you build a successful business.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


