@extends('website.layouts.master')

@section('title',':: Shipping Policy | '.settings('company_name').' ::')

@section('content')
    <section class="breadcrumb_area wow fadeInUp" data-wow-delay="0.1s">
        <img class="breadcrumb_shap" src="{{ asset('images/banner_bg.png') }}" alt="">
        <div class="container">
            <div class="breadcrumb_content text-center">
                <h1 class="f_p f_700 f_size_50 w_color l_height50  text-uppercase">Shipping Policy</h1>
            </div>
        </div>
    </section>
    <section class="seo_service_area sec_pad">
        <div class="container">
            <div class="seo_sec_title mb_70 wow fadeInUp" data-wow-delay="0.3s">
                <div class="section-title text-center">
                    <h2>Shipping Policy </h2>
                    <div class="bar"></div>
                </div>
                @if(settings('shipping_policy'))
                    <p> {!! settings('shipping_policy') !!}</p>
                @else
                    <p>No Shipping Policy</p>
                @endif
            </div>
        </div>
    </section>
@endsection


