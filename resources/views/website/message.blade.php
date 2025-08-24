@extends('website.layouts.master')

@section('title',':: Founder Message | '.settings('company_name').' ::')

@section('content')
    <section class="wrapper bg-soft-primary">
        <div class="container pt-10 pb-10 pt-md-14 pb-md-16 text-center">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="display-1 mb-3"> Founder Message</h1>
                    <nav class="d-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('website.home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Founder Message</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="wrapper bg-light wrapper-border">
        <div class="container py-6 py-md-10">
            <div class="row gx-lg-8 gx-xl-12 gy-10 align-items-center mb-5">
                <div class="col-lg-12">
                    <p class="mb-6">
                        @if(settings('founder_message'))
                            {!! settings('founder_message') !!}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection


