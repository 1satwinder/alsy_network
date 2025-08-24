@extends('website.layouts.master')

@section('title',':: Legals | '.settings('company_name').' ::')

@section('content')
    <section class="wrapper bg-soft-primary">
        <div class="container pt-10 pb-10 pt-md-14 pb-md-16 text-center">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="display-1 mb-3"> Legals</h1>
                    <nav class="d-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('website.home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Legals</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    @if(count($LegalDocuments)>0)
        <section id="lightbox" class="wrapper pt-5 pb-2">
            <div class="container py-6 py-md-10">
                <div class="row gy-10 light-gallery-wrapper">
                    @foreach($LegalDocuments as $legalDocument)
                        <div class="col-md-4 mb-3">
                            <a class="lightbox"
                               href="{{ $legalDocument->getFirstMediaUrl(\App\Models\LegalDocument::MC_LEGAL_DOCUMENTS) }}">
                                <div class="card">
                                    <figure class="rounded gallery mb-0">
                                        <img
                                            src="{{ $legalDocument->getFirstMediaUrl(\App\Models\LegalDocument::MC_LEGAL_DOCUMENTS) }}"
                                            alt=""/>
                                    </figure>
                                    @if($legalDocument->name)
                                        <div class="card-header px-4 ">
                                            <h4 class="text-title-truncate mb-0">{{ $legalDocument->name }}</h4>
                                        </div>
                                    @endif
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
                            <span class="text-body">Legals Not Found</span>
                        </h1>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
