@extends('admin.layouts.master')

@section('title')
    Dashboard
@endsection

@section('content')
    @include('admin.breadcrumbs', [
          'crumbs' => [
              'Dashboard'
          ]
     ])
    @if(!Gate::check('Dashboard-read'))
        <div class="col-lg-12 d-flex text-center justify-content-center">
            <div class="my-5">
                <img class="img-fluid"
                     src="{{ asset('images/get_started_bg.png') }}" alt="no-data">
                <div class="notfound-404 my-3">
                    <h3 class="text-body">
                        Welcome to
                        <span class="text-primary">{{ settings('company_name') }}</span>
                    </h3>
                </div>
            </div>
        </div>
    @endif
    @can('Dashboard-read')
        <div class="row">
            <div class="col-sm-12 col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-body statics">
                        <div class="row align-items-center">
                            <div class="col-sm-6 col-xl-2 col-6 mb-lg-0 mb-2">
                                <a href="{{ route('admin.members.index') }}">
                                    <div class="text-center">
                                        <i class="fa-duotone fa-users"></i>
                                        <h3 class="mb-1"><span data-plugin="counterup">{{ $totalMembers }}</span></h3>
                                        <p class="text-muted font-15 mb-0">Total Members</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-xl-2 col-6 mb-lg-0 mb-2">
                                <a href="{{ route('admin.members.index', ['is_paid' => \App\Models\Member::IS_PAID]) }}">
                                    <div class="text-center">
                                        <i class="fa-duotone fa-user-check text-success"></i>
                                        <h3 class="mb-1"><span data-plugin="counterup">{{ $paidMembers }}</span></h3>
                                        <p class="text-muted font-15 mb-0">Paid Members</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-xl-2 col-6 mb-lg-0 mb-2">
                                <a href="{{ route('admin.members.index', ['status' => \App\Models\Member::STATUS_BLOCKED]) }}">
                                    <div class="text-center">
                                        <i class="fa-duotone fa-user-slash text-danger"></i>
                                        <h3 class="mb-1"><span data-plugin="counterup">{{ $blockedMembers }}</span></h3>
                                        <p class="text-muted font-15 mb-0">Blocked Members</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-xl-2 col-6 mb-lg-0 mb-2">
                                <a href="{{ route('admin.members.index', ['from_activated_at' => today()->format('Y-m-d')]) }}">
                                    <div class="text-center">
                                        <i class="fa-duotone fa-calendar-circle-user text-warning"></i>
                                        <h3 class="mb-1"><span data-plugin="counterup">{{ $todayActivation }}</span>
                                        </h3>
                                        <p class="text-muted font-15 mb-0">Today's Activation</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-xl-2 col-6 mb-lg-0 mb-2">
                                <a href="{{ route('admin.support-ticket.get', ['status' => \App\Models\SupportTicket::STATUS_OPEN]) }}">
                                    <div class="text-center">
                                        <i class="fa-duotone fa-ticket text-warning"></i>
                                        <h3 class="mb-1"><span data-plugin="counterup">{{ $openSupportTicket }}</span>
                                        </h3>
                                        <p class="text-muted font-15 mb-0">Open Support Tickets</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-2">Overview</h5>
                        </div>
                    </div>
                    <div class="card-body gap-3">
                        <div class="row">
                            <div class="col-xl-3 col-sm-6 mb-3">
                                <a href="{{ route('admin.fund-requests.index') }}">
                                    <div class="d-flex gap-3">
                                        <div class="avatar">
                                            <div class="avatar-initial bg-label-primary rounded">
                                                <i class="fa-duotone fa-money-bill-trend-up"></i>
                                            </div>
                                        </div>
                                        <div class="card-info">
                                            <h4 class="mb-0">{{ $totalApproved }}</h4>
                                            <small class="text-muted">No. of Fund Request</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-3">
                                <a href="{{ route('admin.kycs.index', ['status' => \App\Models\KYC::STATUS_PENDING]) }}">
                                    <div class="d-flex gap-3">
                                        <div class="avatar">
                                            <div class="avatar-initial bg-label-primary rounded">
                                                <i class="fa-duotone fa-id-card"></i>
                                            </div>
                                        </div>
                                        <div class="card-info">
                                            <h4 class="mb-0">{{ $pendingKYCCount }}</h4>
                                            <small class="text-muted">Pending KYCs</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-3">
                                <a href="{{route('admin.reports.top-up')}}">
                                    <div class="d-flex gap-3">
                                        <div class="avatar">
                                            <div class="avatar-initial bg-label-primary rounded">
                                                <i class="fa-duotone fa-money-bill-trend-up"></i>
                                            </div>
                                        </div>
                                        <div class="card-info">
                                            <h4 class="mb-0">{{ $totalTurnOver }}</h4>
                                            <small class="text-muted">Total Turnover</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-3">
                                <a href="{{route('admin.reports.top-up',['from_created_at' => \Carbon\Carbon::now()->format('Y-m-d'),'to_created_at' => \Carbon\Carbon::now()->format('Y-m-d')])}}">
                                    <div class="d-flex gap-3">
                                        <div class="avatar">
                                            <div class="avatar-initial bg-label-warning rounded">
                                                <i class="mdi mdi-package"></i>
                                            </div>
                                        </div>
                                        <div class="card-info">
                                            <h4 class="mb-0">{{$todayTopUps}}</h4>
                                            <small class="text-muted">Today's Top Up</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-3">
                                <a href="{{route('admin.reports.top-up',['from_created_at' => \Carbon\Carbon::now()->subDay()->startOfDay()->format('Y-m-d'),'to_created_at' => \Carbon\Carbon::now()->subDay()->endOfDay()->format('Y-m-d')])}}">
                                    <div class="d-flex gap-3">
                                        <div class="avatar">
                                            <div class="avatar-initial bg-label-danger rounded">
                                                <i class="mdi mdi-package"></i>
                                            </div>
                                        </div>
                                        <div class="card-info">
                                            <h4 class="mb-0">{{$lastDayTopUps}}</h4>
                                            <small class="text-muted">Yesterday's Top Up</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-3">
                                <a href="{{route('admin.reports.top-up',['from_created_at' => \Carbon\Carbon::now()->subDays(6)->format('Y-m-d'),'to_created_at' => \Carbon\Carbon::now()->format('Y-m-d')])}}">
                                    <div class="d-flex gap-3">
                                        <div class="avatar">
                                            <div class="avatar-initial bg-label-success rounded">
                                                <i class="mdi mdi-package"></i>
                                            </div>
                                        </div>
                                        <div class="card-info">
                                            <h4 class="mb-0">{{$last7DayTopUps}}</h4>
                                            <small class="text-muted">Last 7 Days Top Up</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-3">
                                <a href="{{route('admin.reports.top-up',['from_created_at' => \Carbon\Carbon::now()->subDays(29)->format('Y-m-d'),'to_created_at' => \Carbon\Carbon::now()->format('Y-m-d')])}}">
                                    <div class="d-flex gap-3">
                                        <div class="avatar">
                                            <div class="avatar-initial bg-label-warning rounded">
                                                <i class="mdi mdi-package"></i>
                                            </div>
                                        </div>
                                        <div class="card-info">
                                            <h4 class="mb-0">{{$last30DayTopUps}}</h4>
                                            <small class="text-muted">Last 30 Days Top Up</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-3">
                                <a href="{{ route('admin.fund-requests.index') }}">
                                    <div class="d-flex gap-3">
                                        <div class="avatar">
                                            <div class="avatar-initial bg-label-primary rounded">
                                                <i class="fa-duotone fa-money-bill-trend-up"></i>
                                            </div>
                                        </div>
                                        <div class="card-info">
                                            <h4 class="mb-0">{{ $totalDeposits }}</h4>
                                            <small class="text-muted">Total Fund</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-3">
                                <a href="{{route('admin.fund-requests.index',['from_created_at' => \Carbon\Carbon::now()->format('Y-m-d'),'to_created_at' => \Carbon\Carbon::now()->format('Y-m-d'),'status' => \App\Models\FundRequest::STATUS_APPROVED])}}">
                                    <div class="d-flex gap-3">
                                        <div class="avatar">
                                            <div class="avatar-initial bg-label-warning rounded">
                                                <i class="mdi mdi-package"></i>
                                            </div>
                                        </div>
                                        <div class="card-info">
                                            <h4 class="mb-0">{{$todayDeposits}}</h4>
                                            <small class="text-muted">Today's Fund</small>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xl-3 col-sm-6 mb-3">
                                <a href="{{route('admin.fund-requests.index',['from_created_at' => \Carbon\Carbon::now()->subDays(6)->format('Y-m-d'),'to_created_at' => \Carbon\Carbon::now()->format('Y-m-d'),'status' => \App\Models\FundRequest::STATUS_APPROVED])}}">
                                    <div class="d-flex gap-3">
                                        <div class="avatar">
                                            <div class="avatar-initial bg-label-success rounded">
                                                <i class="mdi mdi-package"></i>
                                            </div>
                                        </div>
                                        <div class="card-info">
                                            <h4 class="mb-0">{{$last7DayDeposits}}</h4>
                                            <small class="text-muted">Last 7 Days Fund</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-3">
                                <a href="{{route('admin.fund-requests.index',['from_created_at' => \Carbon\Carbon::now()->subDays(29)->format('Y-m-d'),'to_created_at' => \Carbon\Carbon::now()->format('Y-m-d'),'status' => \App\Models\FundRequest::STATUS_APPROVED])}}">
                                    <div class="d-flex gap-3">
                                        <div class="avatar">
                                            <div class="avatar-initial bg-label-warning rounded">
                                                <i class="mdi mdi-package"></i>
                                            </div>
                                        </div>
                                        <div class="card-info">
                                            <h4 class="mb-0">{{$last30DayDeposits}}</h4>
                                            <small class="text-muted">Last 30 Days Fund</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-3">
                                <a href="{{route('admin.payouts.index')}}">
                                    <div class="d-flex gap-3">
                                        <div class="avatar">
                                            <div class="avatar-initial bg-label-primary rounded">
                                                <i class="fa-duotone fa-money-bill-trend-up"></i>
                                            </div>
                                        </div>
                                        <div class="card-info">
                                            <h4 class="mb-0">{{ $totalPayout }}</h4>
                                            <small class="text-muted">Total Payout</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-3">
                                <a href="{{route('admin.payouts.index',$totalLastWeekPayout ?  ['from_created_at' => $totalLastWeekPayout['created_at']->format('Y-m-d'),'to_created_at' => $totalLastWeekPayout['created_at']->format('Y-m-d')] : '')}}">
                                    <div class="d-flex gap-3">
                                        <div class="avatar">
                                            <div class="avatar-initial bg-label-info rounded">
                                                <i class="fa-duotone fa-money-bill-trend-up"></i>
                                            </div>
                                        </div>
                                        <div class="card-info">
                                            <h4 class="mb-0">{{ $totalLastWeekPayout ? $totalLastWeekPayout['payable_amount'] : 0 }}</h4>
                                            <small class="text-muted">Last Week Payout</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-3 col-sm-6 mb-3">
                                <a href="{{route('admin.payouts.index',['from_created_at' => \Carbon\Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d'),'to_created_at' => \Carbon\Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d')])}}">
                                    <div class="d-flex gap-3">
                                        <div class="avatar">
                                            <div class="avatar-initial bg-label-warning rounded">
                                                <i class="fa-duotone fa-money-bill-trend-up"></i>
                                            </div>
                                        </div>
                                        <div class="card-info">
                                            <h4 class="mb-0">{{ $totalLastMonthPayout }}</h4>
                                            <small class="text-muted">Last Month Payout</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0 me-2">Last 5 Registration</h5>
                    </div>
                    <div class="card-body pt-2">
                        <ul class="p-0 m-0">
                            @foreach($lastFiveRegisterMembers as $key => $member)
                                <li class="d-flex mb-3 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <img src="{{ $member->present()->profileImage() }}" alt="avatar"
                                             class="rounded">
                                    </div>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0 fw-semibold">
                                                {{ $member->user->name }}
                                                (
                                                <button class="btn btn-link p-0 font-weight-bold" type="button"
                                                        data-clipboard-text="{{ $member->code }}"
                                                        data-bs-original-title="Click To Copy" data-bs-toggle="tooltip"
                                                        data-bs-placement="bottom">
                                                    {{ $member->code }}
                                                </button>
                                                )
                                            </h6>
                                            <small class="text-muted">
                                                <i class="mdi mdi-calendar-blank-outline mdi-14px"></i>
                                                <span>{{ $member->created_at->dateFormat() }}</span>
                                            </small>
                                        </div>
                                        <div>
                                            <button class="btn btn-link p-0 font-weight-bold text-danger" type="button"
                                                    data-clipboard-text=" {{ (optional($member->sponsor)->code) ? optional($member->sponsor)->code : "N/A" }}"
                                                    data-bs-original-title="Click To Copy Sponsor ID"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom">
                                                {{ (optional($member->sponsor)->code) ? optional($member->sponsor)->code : "N/A" }}
                                            </button>
                                            <br>
                                            <small class="d-none d-sm-block">Sponsor ID</small>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0 me-2">Last 5 Activation</h5>
                    </div>
                    <div class="card-body pt-2">
                        <ul class="p-0 m-0">
                            @foreach($lastFiveActivation as $key => $member)
                                <li class="d-flex mb-3 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <img src="{{ $member->present()->profileImage() }}" alt="avatar"
                                             class="rounded">
                                    </div>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0 fw-semibold">
                                                {{ $member->user->name }}
                                                (
                                                <button class="btn btn-link p-0 font-weight-bold" type="button"
                                                        data-clipboard-text="{{ $member->code }}"
                                                        data-bs-original-title="Click To Copy" data-bs-toggle="tooltip"
                                                        data-bs-placement="bottom">
                                                    {{ $member->code }}
                                                </button>
                                                )
                                            </h6>
                                            <small class="text-muted">
                                                <i class="mdi mdi-calendar-blank-outline mdi-14px"></i>
                                                <span>{{ $member->activated_at->dateFormat() }}</span>
                                            </small>
                                        </div>
                                        <div>
                                            <button class="btn btn-link p-0 font-weight-bold text-danger" type="button"
                                                    data-clipboard-text=" {{ (optional($member->sponsor)->code) ? optional($member->sponsor)->code : "N/A" }}"
                                                    data-bs-original-title="Click To Copy Sponsor ID"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom">
                                                {{ (optional($member->sponsor)->code) ? optional($member->sponsor)->code : "N/A" }}
                                            </button>
                                            <br>
                                            <small class="d-none d-sm-block">Sponsor ID</small>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body" dir="ltr">
                        <h5 class="header-title mb-3">Company Daily Turnover</h5>
                        <canvas id="dailyTurnOverChart" height="350vw" width="500vw"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body" dir="ltr">
                        <h5 class="header-title mb-3">Daily Joining</h5>
                        <canvas id="dailyJoining" height="350vw" width="500vw"></canvas>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection

@push('page-javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
    @can('Dashboard-read')
        @if($fundRequestCount)
            <script>
                Swal.fire('Yay!!!', '{{ $fundRequestCount ? 'You have '.$fundRequestCount.' new fund request' : ""}} ', 'success')
            </script>
        @endif
    @endcan
    <script>
        let ctx = document.getElementById('dailyTurnOverChart');

        ctx.height = 350;

        var dailyTurnOverChart = new Chart(ctx, {
            responsive: true,
            type: 'line',
            data: {
                labels: {!! json_encode($dayWisePackageSubscriptions->pluck('day')) !!},
                datasets: [{
                    label: 'Daily Turn Over',
                    data: {!! json_encode($dayWisePackageSubscriptions->pluck('amount')) !!},
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

        ctx = document.getElementById('dailyJoining');

        ctx.height = 350;

        var dailyJoining = new Chart(ctx, {
            responsive: true,
            type: 'bar',
            data: {
                labels: {!! json_encode($dayCountMembersJoins->pluck('day')) !!},
                datasets: [{
                    label: 'Daily Joining',
                    data: {!! json_encode($dayCountMembersJoins->pluck('total_member')) !!},
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
    </script>
@endpush
