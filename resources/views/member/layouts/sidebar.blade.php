<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal  menu bg-menu-theme flex-grow-0">
    <div class="container-fluid d-flex h-100">
        <ul class="menu-inner">

            <li class="menu-item">
                <a href="{{ route('member.dashboard.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-duotone fa-house-user"></i>
                    <div data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('member.sponsor-genealogy.show') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-duotone fa-sitemap"></i>
                    <div data-i18n="Genealogy Tree">Sponsor Genealogy Tree</div>
                </a>
            </li>
            @if(env('APP_ENV') != 'production')
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons mdi mdi-family-tree"></i>
                        <div data-i18n="View">Magic Pool Genealogy</div>
                    </a>
                    <ul class="menu-sub">
                        @foreach(\App\Models\MagicPool::get() as $magicPool)
                            <li class="menu-item">
                                <a href="{{ route('member.autopool.show',$magicPool) }}" class="menu-link">
                                    <div data-i18n="Collapsed menu">
                                        {{$magicPool->name}}
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
            <li class="menu-item">
                <a href="{{ route('member.kycs.show') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-duotone fa-id-card"></i>
                    <div data-i18n="KYC">KYC</div>
                </a>
            </li>
            @if(settings('is_ecommerce'))
                <li class="menu-item ">
                    <a href="javascript:void(0)" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons fa-duotone fa-bags-shopping"></i>
                        <div data-i18n="Ecommerce">Ecommerce</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{ route('member.product.index') }}" class="menu-link">
                                <div data-i18n="Products">Products</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('member.orders.index') }}" class="menu-link">
                                <div data-i18n="Order">Order</div>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            <li class="menu-item">
                <a href="{{ route('member.payouts.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-duotone fa-money-bills"></i>
                    <div data-i18n="Payout">Payout</div>
                </a>
            </li>
            <li class="menu-item ">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons mdi mdi-wallet-bifold"></i>
                    <div data-i18n="Wallet Transaction">Fund Wallet</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('member.fund-wallet-transactions.index') }}">
                            <div data-i18n="Transactions">Transactions</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('member.fund-requests.index') }}">
                            <div data-i18n="Requests">Requests</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('member.fund-wallet-transfer.index') }}">
                            <div data-i18n="Transfer">Transfer</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="{{ route('member.topups.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-duotone fa-rocket-launch"></i>
                    <div data-i18n="Top Up">Top Up</div>
                </a>
            </li>
            <li class="menu-item ">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons mdi mdi-wallet-bifold"></i>
                    <div data-i18n="Reports">Income Wallet</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('member.wallet-transactions.index') }}">
                            <div data-i18n="My Direct">Transactions</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('member.income-wallet-transfer.index') }}">
                            <div data-i18n="My Direct">Transfer</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons fa-duotone fa-coins"></i>
                    <div data-i18n="Income">Income</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('member.incomes.referral-bonus-income') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Referral Bonus Income</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('member.incomes.team-bonus-income') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Team Bonus Income</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('member.incomes.reward-bonus-income') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Reward Bonus income</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('member.incomes.magic-pool-bonus-income') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Magic Pool Bonus Income</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item ">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons fa-duotone fa-file-chart-pie"></i>
                    <div data-i18n="Reports">Reports</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('member.reports.direct') }}">
                            <div data-i18n="My Direct">My Direct</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('member.reports.downline') }}">
                            <div data-i18n="My Downline">My Downline</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('member.reports.tds') }}">
                            <div data-i18n="TDS Report">TDS Report</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('member.reports.reward') }}">
                            <div data-i18n="TDS Report">Reward Report</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('member.reports.my-team') }}">
                            <div data-i18n="My Team">My Team (Level Wise)</div>
                        </a>
                    </li>
                    @if(Auth::user()->member->status != \App\Models\Member::STATUS_FREE_MEMBER)
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('member.reports.magic-pool') }}">
                                <div data-i18n="My Team">Magic Pool Report</div>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            <li class="menu-item">
                <a href="{{ route('member.video.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons mdi mdi-cloud-download"></i>
                    <div data-i18n="Export">Videos</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('member.exports.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-duotone fa-download"></i>
                    <div data-i18n="Export">Export</div>
                </a>
            </li>
        </ul>
    </div>
</aside>
