@extends('member.layouts.master')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row gy-4 mb-4">
        @if(count($news) > 0)
            <div class="col-lg-12">
                <div class="card mb-0 overflow-hidden">
                    <div class="card-body">
                        <div class="ticker-wrap">
                            <div class="ticker-heading"><i class="uil uil-newspaper"></i> Latest News</div>
                            <div class="ticker">
                                @foreach( $news as $key=>$data)
                                    <div class="ticker__item">{{ $data->title }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-lg-3">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="user-avatar-section">
                        <div class=" d-flex align-items-center flex-column">
                            <img class="img-fluid rounded mb-3 mt-4" src="{{ $member->present()->profileImage() }}"
                                 height="120"
                                 width="120" alt="User avatar"/>
                            <div class="user-info text-center">
                                <h4>{{ $member->user->name }}</h4>
                                @if($member->kyc && $member->kyc->isApproved())
                                    <span class="badge bg-label-success">
                                        Verified
                                    </span>
                                @else
                                    <span class="badge bg-label-danger">
                                         @if($member->kyc->isNotApplied())
                                            Not Uploaded
                                        @else
                                            Not Verified
                                        @endif
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap my-2 py-3">
                        @if ($member->package)
                            <div class="d-flex align-items-center me-4 mt-3 gap-3">
                                <div class="avatar">
                                    <div class="avatar-initial bg-label-primary rounded">
                                        <i class='fa-duotone fa-hand-holding-box'></i>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold">{{ $member->package->pv }} PV</h5>
                                    <span>{{ $member->package->name }}</span>
                                </div>
                            </div>
                        @endif
                        <div class="d-flex align-items-center mt-3 gap-3">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded">
                                    <i class="fa-duotone fa-hashtag"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold"> @include('copy-text', ['text' => $member->code]) </h5>
                                <span>Member ID</span>
                            </div>
                        </div>
                    </div>
                    <h5 class="pb-3 border-bottom mb-3">Details</h5>
                    <div class="info-container">
                        <small class="card-text text-uppercase text-muted">Contact Details</small>
                        <ul class="list-unstyled mt-2 mb-3">
                            <li class="d-flex align-items-center mb-3">
                                <i class="me-2 fa-duotone fa-phone-volume text-success"></i>
                                <span class="fw-semibold mx-1">Contact :</span>
                                <span>{{ $member->user->mobile }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="me-2 fa-duotone fa-envelope text-danger"></i>
                                <span class="fw-semibold mx-1">Email :</span>
                                <span>{{ $member->user->email }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="me-2 fa-duotone fa-chart-tree-map text-pink"></i>
                                <span class="fw-semibold mx-1">Status :</span>
                                <span>
                                    @if($member->status == \App\Models\Member::STATUS_FREE_MEMBER)
                                        Free <i class="uil uil-snowflake text-danger"></i>
                                    @else
                                        Active <i class="uil uil-comment-verify text-success"></i>
                                    @endif
                                </span>
                            </li>
                        </ul>
                        <small class="card-text text-uppercase text-muted">Registration Details</small>
                        <ul class="list-unstyled mb-0 mt-2 pt-1">
                            <li class="d-flex align-items-center mb-3">
                                <i class="fa-duotone fa-registered text-primary me-2"></i>
                                <div class="d-flex flex-wrap">
                                    <span class="fw-semibold mx-1">Registration Date :</span>
                                    <span>{{ date('d M Y', strtotime($member->user->created_at)) }}</span>
                                </div>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="fa-duotone fa-calendar-days text-warning me-2"></i>
                                <div class="d-flex flex-wrap">
                                    <span class="fw-semibold mx-1">Activation Date :</span>
                                    <span>{{ $member->activated_at ? date('d M Y', strtotime($member->activated_at)) : '---' }}</span>

                                </div>
                            </li>
                        </ul>
                        @if($member->reward_bonus_id)
                            <small class="card-text text-uppercase text-muted">Reward Details</small>
                            <ul class="list-unstyled mb-0 mt-2 pt-1">
                                <li class="d-flex align-items-center mb-3">
                                    <i class="fa-duotone fa-award text-primary me-2"></i>
                                    <div class="d-flex flex-wrap">
                                        <span class="fw-semibold mx-1">Reward :</span>
                                        <span>{{ $member->rewardBonus->reward}}</span>
                                    </div>
                                </li>
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="form-section text-capitalize">
                        <i class="fa-duotone fa-building me-2"></i> Business Plan
                    </h5>
                </div>
                <div class="card-body">
                    @if($planUrl)
                        <a href="{{ $planUrl }}" class="btn btn-primary w-100" download>
                            Download Business Plan
                        </a>
                    @else
                        <h4 class="text-primary text-center">Business plan not available..!!</h4>
                    @endif
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="form-section text-capitalize">
                        <i class="fa-duotone fa-share-all me-2"></i> Referral Link
                    </h5>
                </div>
                <div class="card-body custom-pad">
                    <div class="input-group">
                        <input type="text" class="form-control"
                               value="{{ $member->present()->referralLink() }}"
                               readonly>
                        <button class="btn btn-outline-secondary" type="button"
                                data-clipboard-text="{{ $member->present()->referralLink() }}">
                            <i class="fa-duotone fa-copy"></i>
                        </button>
                    </div>

                    <div class="social">
                        <span class="title">Share This Link:</span>
                        {!! $socialMediaLinks !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="row match-height">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-2">Statistics Overview</h5>
                            </div>
                        </div>
                        <div class="card-body gap-3">
                            <div class="row">
                                <div class="col-xl-3 col-md-4 col-sm-6 mb-3">
                                    <a href="{{ route('member.fund-wallet-transactions.index') }}">
                                        <div class="d-flex gap-3">
                                            <div class="avatar">
                                                <div class="avatar-initial bg-label-primary rounded">
                                                    <i class="fa-duotone fa-wallet mdi-24px"></i>
                                                </div>
                                            </div>
                                            <div class="card-info">
                                                <h4 class="mb-0">{{ round(Auth::user()->member->fund_wallet_balance,2) }}</h4>
                                                <small class="text-muted">Fund Wallet Balance</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xl-3 col-md-4 col-sm-6 mb-3">
                                    <a href="{{ route('member.wallet-transactions.index') }}">
                                        <div class="d-flex gap-3">
                                            <div class="avatar">
                                                <div class="avatar-initial bg-label-primary rounded">
                                                    <i class="fa-duotone fa-wallet mdi-24px"></i>
                                                </div>
                                            </div>
                                            <div class="card-info">
                                                <h4 class="mb-0">{{ round(Auth::user()->member->wallet_balance,2) }}</h4>
                                                <small class="text-muted">Income Wallet Income</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-3 col-md-4 col-sm-6 mb-3">
                                    <a href="{{ route('member.reports.direct') }}">
                                        <div class="d-flex gap-3">
                                            <div class="avatar">
                                                <div class="avatar-initial bg-label-warning rounded">
                                                    <i class="fa-duotone fa-chart-network"></i>
                                                </div>
                                            </div>
                                            <div class="card-info">
                                                <h4 class="mb-0">{{ $myDirects  }}</h4>
                                                <small class="text-muted">My Directs</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-3 col-md-4 col-sm-6 mb-3">
                                    <a href="{{ route('member.reports.downline') }}">
                                        <div class="d-flex gap-3">
                                            <div class="avatar">
                                                <div class="avatar-initial bg-label-info rounded">
                                                    <i class="fa-duotone fa-arrow-down-small-big"></i>
                                                </div>
                                            </div>
                                            <div class="card-info">
                                                <h4 class="mb-0">{{ $myDownLine  }}</h4>
                                                <small class="text-muted">My Downline</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-3 col-md-4 col-sm-6 mb-3">
                                    <a href="{{ route('member.wallet-transactions.index') }}">
                                        <div class="d-flex gap-3">
                                            <div class="avatar">
                                                <div class="avatar-initial bg-label-instagram rounded">
                                                    <i class="fa-duotone fa-money-bill-trend-up"></i>
                                                </div>
                                            </div>
                                            <div class="card-info">
                                                <h4 class="mb-0">{{ $totalEarning  }}</h4>
                                                <small class="text-muted">Total Earning</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-3 col-md-4 col-sm-6 mb-3 mb-lg-0">
                                    <a href="{{ route('member.payouts.index') }}">
                                        <div class="d-flex gap-3">
                                            <div class="avatar">
                                                <div class="avatar-initial bg-label-facebook rounded">
                                                    <i class="fa-duotone fa-money-bills"></i>
                                                </div>
                                            </div>
                                            <div class="card-info">
                                                <h4 class="mb-0">{{ $totalPayout  }}</h4>
                                                <small class="text-muted">Total Payout</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-3 col-md-4 col-sm-6 mb-3 ">
                                    <a href="{{route('member.wallet-transactions.index',['from_created_at' => \Carbon\Carbon::now()->format('Y-m-d'),'to_created_at' => \Carbon\Carbon::now()->format('Y-m-d')])}}">
                                        <div class="d-flex gap-3">
                                            <div class="avatar">
                                                <div class="avatar-initial bg-label-warning rounded">
                                                    <i class="mdi mdi-currency-rupee mdi-24px"></i>
                                                </div>
                                            </div>
                                            <div class="card-info">
                                                <h4 class="mb-0">{{$todayIncome}}</h4>
                                                <small class="text-muted">Today's Income</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-3 col-md-4 col-sm-6 mb-3 ">
                                    <a href="{{route('member.wallet-transactions.index',['from_created_at' => \Carbon\Carbon::now()->subDay()->startOfDay()->format('Y-m-d'),'to_created_at' => \Carbon\Carbon::now()->subDay()->endOfDay()->format('Y-m-d')])}}">
                                        <div class="d-flex gap-3">
                                            <div class="avatar">
                                                <div class="avatar-initial bg-label-danger rounded">
                                                    <i class="mdi mdi-currency-rupee mdi-24px"></i>
                                                </div>
                                            </div>
                                            <div class="card-info">
                                                <h4 class="mb-0">{{$lastDayIncome}}</h4>
                                                <small class="text-muted">Yesterday's Income</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-3 col-md-4 col-sm-6 mb-3 ">
                                    <a href="{{route('member.wallet-transactions.index',['from_created_at' => \Carbon\Carbon::now()->subDays(6)->format('Y-m-d'),'to_created_at' => \Carbon\Carbon::now()->format('Y-m-d')])}}">
                                        <div class="d-flex gap-3">
                                            <div class="avatar">
                                                <div class="avatar-initial bg-label-success rounded">
                                                    <i class="mdi mdi-currency-rupee mdi-24px"></i>
                                                </div>
                                            </div>
                                            <div class="card-info">
                                                <h4 class="mb-0">{{$last7DayIncome}}</h4>
                                                <small class="text-muted">Last 7 Days Income</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-3 col-md-4 col-sm-6 mb-3">
                                    <a href="{{route('member.wallet-transactions.index',['from_created_at' => \Carbon\Carbon::now()->subDays(29)->format('Y-m-d'),'to_created_at' => \Carbon\Carbon::now()->format('Y-m-d')])}}">
                                        <div class="d-flex gap-3">
                                            <div class="avatar">
                                                <div class="avatar-initial bg-label-warning rounded">
                                                    <i class="mdi mdi-currency-rupee mdi-24px"></i>
                                                </div>
                                            </div>
                                            <div class="card-info">
                                                <h4 class="mb-0">{{$last30DayIncome}}</h4>
                                                <small class="text-muted">Last 30 Days Income</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-3 col-md-4 col-sm-6 mb-3">
                                    <a href="{{route('member.incomes.referral-bonus-income')}}">
                                        <div class="d-flex gap-3">
                                            <div class="avatar">
                                                <div class="avatar-initial bg-label-success rounded">
                                                    <i class="mdi mdi-currency-rupee mdi-24px"></i>
                                                </div>
                                            </div>
                                            <div class="card-info">
                                                <h4 class="mb-0">{{$referralBonusIncome}}</h4>
                                                <small class="text-muted">Referral Bonus Income</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-3 col-md-4 col-sm-6 mb-3">
                                    <a href="{{route('member.incomes.team-bonus-income')}}">
                                        <div class="d-flex gap-3">
                                            <div class="avatar">
                                                <div class="avatar-initial bg-label-info rounded">
                                                    <i class="mdi mdi-currency-rupee mdi-24px"></i>
                                                </div>
                                            </div>
                                            <div class="card-info">
                                                <h4 class="mb-0">{{$teamBonusIncome}}</h4>
                                                <small class="text-muted">Team Bonus Income</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-3 col-md-4 col-sm-6 mb-3">
                                    <a href="{{route('member.incomes.magic-pool-bonus-income')}}">
                                        <div class="d-flex gap-3">
                                            <div class="avatar">
                                                <div class="avatar-initial bg-label-warning rounded">
                                                    <i class="mdi mdi-currency-rupee mdi-24px"></i>
                                                </div>
                                            </div>
                                            <div class="card-info">
                                                <h4 class="mb-0">{{$magicPoolBonusIncome}}</h4>
                                                <small class="text-muted">Magic Pool Bonus Income</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @if(count($bankDetails) > 0)
                    <h5 class="mb-2">Bank Details</h5>
                    @foreach($bankDetails as $key => $detail)
                        <div class="col-xl-4 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="mb-75 text-primary">{{ $detail->name}}</h5>
                                    <div class="mt-2">
                                        <h6  class="mb-0">Account Holder Name </h6>
                                        <p class="card-text">{{ $detail->account_holder_name }}</p>
                                    </div>
                                    <div class="row justify-content-between mt-3">
                                        <div class="col mt-1">
                                            <h6  class="mb-0">Branch</h6>
                                            <p class="card-text">{{ $detail->branch_name }}</p>
                                        </div>
                                        <div class="col mt-1">
                                            <h6  class="mb-0">Type</h6>
                                            <p class="card-text">{{ $detail->ac_type == \App\Models\Bank::ACCOUNT_TYPE_SAVING ? 'Saving' : 'Current' }}</p>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between mt-3">
                                        <div class="col mt-1">
                                            <h6  class="mb-0">Account Number</h6>
                                            <p class="card-text">{{ $detail->ac_number }}</p>
                                        </div>
                                        <div class="col mt-1">
                                            <h6  class="mb-0">IFSC code</h6>
                                            <p class="card-text">{{ $detail->ifsc }}</p>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between mt-3">
                                        <div class="col mt-1">
                                            <h6  class="mb-0">QR Code</h6>
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
                                        <div class="col mt-1">
                                            <h6  class="mb-0">UPI ID</h6>
                                            <p class="card-text">{{ $detail->upi_id ? : 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <div class="col mt-3">
                                        <h6  class="mb-0">Phone Pe/Google Pay/Paytm Mobile number </h6>
                                        <p class="card-text">{{ $detail->upi_number ? : 'N/A'}}</p>
                                    </div>
                                    <div class=" col mt-3">
                                        <h6  class="mb-0">Mobile Number of Company Payment Department </h6>
                                        <p class="card-text">{{ $detail->company_payment_department ? : 'N/A'}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body" dir="ltr">
                            <h5 class="header-title mb-3">Last 7 Days Earning Graph</h5>
                            <canvas id="dailyEarningChart" height="350vw" width="500vw"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body" dir="ltr">
                            <h5 class="header-title mb-3">Last 7 Days Downline Members</h5>
                            <canvas id="dailyDownliners" height="350vw" width="500vw"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            @if(count($rewardAchievers) > 0)
                <div class="col-lg-12">
                    <div class="card mb-0 overflow-hidden">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-2"><i class="uil uil-award"></i> Reward Achievers</h5>
                                <a href="{{route('member.reports.reward-achiever')}}" target="_blank"
                                   class="">See All
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="swiper mySwiper">
                                <div class="swiper-wrapper">
                                    @foreach( $rewardAchievers as $key=>$data)
                                        <div class="swiper-slide">
                                            <div class="d-flex">
                                                <div class="avatar flex-shrink-0 me-3">
                                                    <img src="{{ $data['image'] }}" alt="avatar" class="rounded">
                                                </div>
                                                <div
                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                    <div class="me-2">
                                                        <h6 class="mb-0 fw-semibold">
                                                            @if(strlen($data['reward']) < 12)
                                                                {{ $data['reward'] }}
                                                            @else
                                                                {{ substr($data['reward'], 0, 12). ".." }}
                                                            @endif
                                                        </h6>
                                                        <small class="text-muted">
                                                            {{ $data['name'] }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endif
    </div>
    @if(count($popups))
        @foreach($popups as $popup)
            <div class="modal fade popupModal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content modal-xl">
                        <div class="modal-header">
                            @if($popup->name)
                                <h4 class="mb-0">{{ $popup->name }}</h4>
                            @endif
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if($popup->getFirstMediaUrl(\App\Models\MemberPopup::MEDIA_COLLECTION_IMAGE_MEMBER_POPUP))
                                <img
                                    src="{{ $popup->getFirstMediaUrl(\App\Models\MemberPopup::MEDIA_COLLECTION_IMAGE_MEMBER_POPUP) }}"
                                    alt="{{ $popup->name }}" width="100%" class="img-fluid">
                            @else
                                <article class="col-xl-6 col-lg-6 col-md-6 text-center hover-up mb-30 animated"
                                         style="width: 100%">
                                    <div class="post-thumb">
                                        <div class="js-player" data-plyr-provider="youtube"
                                             data-plyr-embed-id="{{ $popup->link }}"></div>
                                    </div>
                                </article>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection
@push('page-css')
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css"/>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
@endpush
@push('page-javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.plyr.io/3.6.12/plyr.polyfilled.js"></script>

    <script>
        const players = Array.from(document.querySelectorAll('.js-player')).map((p) => new Plyr(p));
        for (let index = 0; index < players.length; index++) {
            $(".btn-close").on('click', function () {
                players[index].pause(); // Pause other plyr instances
            })
        }
    </script>
    <script>
        $(window).on("load", function () {
            $('.popupModal').modal('toggle');
        });

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
        /**
         * Daily Earning Graph
         * @type {HTMLElement}
         */
        let ctx = document.getElementById('dailyEarningChart');

        ctx.height = 350;

        let dailyEarningChart = new Chart(ctx, {
            responsive: true,
            type: 'line',
            data: {
                labels: {!! json_encode($dayWiseEarnings->pluck('day')) !!},
                datasets: [{
                    label: 'Daily Earning',
                    data: {!! json_encode($dayWiseEarnings->pluck('amount')) !!},
                    backgroundColor: 'rgba(244, 53, 52, 0.5)',
                    borderColor: 'rgba(244, 53, 52, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Date'
                        },
                        ticks: {
                            major: {
                                fontStyle: 'bold',
                                fontColor: '#FF0000'
                            }
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function (value) {
                                if (value % 1 === 0) {
                                    return value;
                                }
                            },
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Amount'
                        }
                    }]
                }
            }
        });

        ctx = document.getElementById('dailyDownliners');

        ctx.height = 350;

        let dailyTurnOverChart = new Chart(ctx, {
            responsive: true,
            type: 'bar',
            data: {
                labels: {!! json_encode($dayWiseDownline->pluck('day')) !!},
                datasets: [{
                    label: 'Daily Downline',
                    data: {!! json_encode($dayWiseDownline->pluck('count')) !!},
                    backgroundColor: 'rgba(244, 53, 52, 0.5)',
                    borderColor: 'rgba(244, 53, 52, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Date'
                        },
                        ticks: {
                            major: {
                                fontStyle: 'bold',
                                fontColor: '#FF0000'
                            }
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function (value) {
                                if (value % 1 === 0) {
                                    return value;
                                }
                            },
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Members'
                        }
                    }]
                }
            }
        });

        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 40,
                },
                1024: {
                    slidesPerView: 5,
                    spaceBetween: 50,
                },
                1200: {
                    slidesPerView: 8,
                    spaceBetween: 50,
                },
            },
        });

    </script>
@endpush

