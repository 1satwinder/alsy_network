@extends('member.layouts.master')

@section('title')
    Create Topup
@endsection

@section('content')
    @include('member.breadcrumbs', [
         'crumbs' => [
             'Create Topup'
         ]
    ])
    <form method="post" action="{{route('member.topups.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <p style="color: red">Fund Wallet Balance : <span
                                class="text-success">{{ env('APP_CURRENCY')." ".$member->fund_wallet_balance}}</p>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="deliveryType">
                                    <div class="form-group">
                                        <label for="Package" class="required">TopUp For</label><br>
                                        <div class="form-check form-check-inline mt-1">
                                            <input class="form-check-input topup_type" type="radio"
                                                   name="topup_type"
                                                   id="self"
                                                   value="{{\App\Models\TopUp::TYPE_SELF}}"
                                                   {{ old('topup_type',request()->get('topup_type')) == \App\Models\TopUp::TYPE_SELF ? 'checked' : '' }}
                                                   {{ request()->get('topup_type') ? 'disabled' : '' }} checked
                                                   required>
                                            <label class="form-check-label" for="self">Self</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input topup_type" type="radio"
                                                   name="topup_type"
                                                   id="other"
                                                   value="{{\App\Models\TopUp::TYPE_OTHER}}"
                                                   {{ old('topup_type',request()->get('topup_type')) == \App\Models\TopUp::TYPE_OTHER ? 'checked' : '' }}
                                                   {{ request()->get('topup_type') ? 'disabled' : '' }} required>
                                            <label class="form-check-label" for="other">Other</label>
                                        </div>
                                        @foreach($errors->get('topup_type') as $error)
                                            <div class="text-danger">{{ $error }}</div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group memberBlock" style="display: none">
                                    <div class="form-floating form-floating-outline">
                                        <input id="member" type="text" name="code" class="form-control memberCodeInput"
                                               placeholder="Enter Member ID" value="{{ old('code') }}">
                                        <label for="member">Member ID <span class="text-danger">*</span></label>
                                    </div>
                                    @foreach($errors->get('code') as $error)
                                        <span class="text-danger memberName">{{ $error }}</span>
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <div class="form-floating form-floating-outline">
                                        <select id="package_id" class="form-select" data-toggle="select2"
                                                name="package_id" required>
                                            <option value="">Select Package</option>
                                            @foreach($packages as $package)
                                                <option
                                                    value="{{ $package->id }}" {{ old('package_id', $package->package_id) == $package->id ? 'selected' : ''}}
                                                >
                                                    {{ $package->present()->nameAndAmount() }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @foreach($errors->get('package_id') as $error)
                                        <span class="error text-danger packageName">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary" type="submit">
                                <i class="uil uil-message me-1"></i> Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row">
                    @foreach($packages as $key => $package)
                        <div class="col-md-4">
                            <div class="pricing card shadow-lg">
                                <a href="{{ optional($package)->getFirstMediaUrl(\App\Models\Package::MC_PACKAGE_IMAGE) ?: '/images/no_image.png' }}"
                                   class='image-popup gallery' data-toggle='tooltip'
                                   data-original-title='Click here to zoom image'>
                                    <img
                                        src="{{ optional($package)->getFirstMediaUrl(\App\Models\Package::MC_PACKAGE_IMAGE) ?: '/images/no_image.png' }}"
                                        class="img-fluid" alt="">
                                </a>
                                <div class="card-body pb-12">
                                    <div class="text-center">
                                        <h1 class="fw-semibold display-3 mb-0 text-primary">
                                            र {{ round($package->amount,2) }} <span class="display-6 text-dark">/ {{ round($package->pv,2) }} PV</span>
                                        </h1>
                                        <h4 class="card-title mt-2">{{ $package->name }}</h4>
                                    </div>
                                    <ul class="mt-4">
                                        @foreach($package->products as $product)
                                            <li class="mb-3">
                                                <b class="text-primary">
                                                    {{ $product->name }}
                                                </b>
                                                <div>
                                                    <b>HSN :</b> {{ $product->hsn_code }} |
                                                    <b>GST : </b> {{ $product->present()->gstSlab() }} % |
                                                    <b>Price : </b>र {{ round($product->price,2) }}
                                                </div>
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
        <form>
            @endsection
            @push('page-javascript')
                <script>
                    $(document).ready(function () {
                        if ('{{ old('topup_type') == '2' }}') {
                            $('.memberBlock').css('display', 'block');
                            $("#member").prop('required', true);
                        } else {
                            $('.memberBlock').css('display', 'none');
                            $("#member").prop('required', false);
                        }
                    });

                    $('.topup_type').change(function () {
                        var topUpTYpe = $(this).val();
                        if (topUpTYpe == 2) {
                            $('.memberBlock').css('display', 'block');
                            $("#member").prop('required', true);
                        } else {
                            $('.memberBlock').css('display', 'none');
                            $("#member").prop('required', false);
                        }
                    })

                </script>
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



