@extends('website.layouts.master')

@section('title',':: Bank Details | '.settings('company_name').' ::')

@section('content')
    <section class="wrapper bg-soft-primary">
        <div class="container pt-10 pb-10 pt-md-14 pb-md-16 text-center">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="display-1 mb-3">Bank Details</h1>
                    <nav class="d-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('website.banking') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Bank Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    @if(count($bankingDetails) > 0)
        <div class="page-content py-5">
            <div class="container">
                <div class="row">
                    @foreach($bankingDetails as $key => $detail)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="mb-30 text-brand">{{ $detail->name}}</h5>
                                    <div class="mb-1">
                                        <p class="mb-1">Account Holder Name </p>
                                        <h6 class="card-text">{{ $detail->account_holder_name }}</h6>
                                    </div>
                                    <div class="row justify-content-between">
                                        <div class="col my-2">
                                            <p class="mb-1">Account Number</p>
                                            <h6 class="card-text">{{ $detail->ac_number }}</h6>
                                        </div>
                                        <div class="col my-2">
                                            <p class="mb-1">IFSC code</p>
                                            <h6 class="card-text">{{ $detail->ifsc }}</h6>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between">
                                        <div class="col my-2">
                                            <p class="mb-1">Branch</p>
                                            <h6 class="card-text">{{ $detail->branch_name }}</h6>
                                        </div>
                                        <div class="col my-2">
                                            <p class="mb-1">Type</p>
                                            <h6 class="card-text">{{ $detail->ac_type == \App\Models\Bank::ACCOUNT_TYPE_SAVING ? 'Saving' : 'Current' }}</h6>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between">
                                            <div class="col mt-1">
                                                <p class="mb-1">QR Code</p>
                                                @if(optional($detail)->getFirstMediaUrl(\App\Models\Bank::MC_QR_CODE))
                                                <a href="{{ optional($detail)->getFirstMediaUrl(\App\Models\Bank::MC_QR_CODE) }}"
                                                   class="image-popup" data-toggle="tooltip" title=""
                                                   data-original-title="Click here to zoom image">
                                                    <img
                                                        src="{{ optional($detail)->getFirstMediaUrl(\App\Models\Bank::MC_QR_CODE) }}"
                                                        class="img-fluid avatar-lg " alt="" style="width: 30%">
                                                </a>
                                                @else
                                                    N/A
                                                @endif

                                            </div>
                                        <div class="col my-2">
                                            <p class="mb-1">UPI ID</p>
                                            <h6 class="card-text">{{ $detail->upi_id ? : 'N/A'}}</h6>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <h5 class="mb-0">Phone Pe/Google Pay/Paytm Mobile number </h5>
                                        <p class="card-text">{{ $detail->upi_number ? : 'N/A'}}</p>
                                    </div>
                                    <div class="mt-2">
                                        <h5 class="mb-0">Mobile Number of Company Payment Department </h5>
                                        <p class="card-text">{{ $detail->company_payment_department ? : 'N/A'}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="page-content pt-50 pb-60">
            <div class="container">
                <div class="row d-flex text-center justify-content-center">
                    <div class="col-lg-6">
                        <div class="error-content">
                            <img class="img-fluid"
                                 src="{{ asset('images/empty_item.svg') }}" alt="no-data">
                            <div class="notfound-404">
                                <h4 class="text-brand">
                                    <i class="uil uil-sad-squint"></i> Oops!
                                    <span class="text-body">Banking Details not Found</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@push('page-javascript')
    <script src="{{ asset('js/lightbox.js') }}"></script>
    <script>
        $(".image-popup").magnificPopup({
            type: "image",
            closeOnContentClick: !1,
            closeBtnInside: !1,
            mainClass: "mfp-with-zoom mfp-img-mobile",
            image: {
                verticalFit: !0, titleSrc: function (e) {
                    return e.el.attr("title")
                }
            },
            gallery: {enabled: !0},
            zoom: {
                enabled: !0, duration: 300, opener: function (e) {
                    return e.find("img")
                }
            }
        });
    </script>
@endpush

@section('page-css')
    <script src="{{ asset('css/lightbox.css') }}"></script>
@endsection
