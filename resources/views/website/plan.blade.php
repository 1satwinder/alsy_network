@extends('website.layouts.master')

@section('title',':: Business Plan | '.settings('company_name').' ::')

@section('content')
    <section class="wrapper bg-soft-primary">
        <div class="container pt-10 pb-10 pt-md-14 pb-md-16 text-center">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="display-1 mb-3"> Business Plan</h1>
                    <nav class="d-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('website.home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Business Plan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    @if($planUrl)
        <section class="wrapper bg-light wrapper-border">
            <div class="container py-6 py-md-10">
                <div class="row gx-lg-8 gx-xl-12 gy-10 align-items-center mb-5 justify-content-center">
                    <div class="col-lg-8">
                        <iframe src="{{ $planUrl }}" width="100%" height="800px" allowtransparency="false"></iframe>
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
                            <span class="text-body">Business Plan Not Found</span>
                        </h1>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
