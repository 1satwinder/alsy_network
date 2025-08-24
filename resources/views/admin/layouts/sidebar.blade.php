<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo ">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img class="logo-lg" src="{{ settings()->getFileUrl('logo', asset(env('LOGO', '/images/logo.png'))) }}"
                     alt="">
                <img class="logo-sm"
                     src="{{ settings()->getFileUrl('favicon', asset(env('FAVICON', '/images/favicon.png'))) }}" alt="">
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M11.4854 4.88844C11.0081 4.41121 10.2344 4.41121 9.75715 4.88844L4.51028 10.1353C4.03297 10.6126 4.03297 11.3865 4.51028 11.8638L9.75715 17.1107C10.2344 17.5879 11.0081 17.5879 11.4854 17.1107C11.9626 16.6334 11.9626 15.8597 11.4854 15.3824L7.96672 11.8638C7.48942 11.3865 7.48942 10.6126 7.96672 10.1353L11.4854 6.61667C11.9626 6.13943 11.9626 5.36568 11.4854 4.88844Z"
                    fill="currentColor" fill-opacity="0.6"/>
                <path
                    d="M15.8683 4.88844L10.6214 10.1353C10.1441 10.6126 10.1441 11.3865 10.6214 11.8638L15.8683 17.1107C16.3455 17.5879 17.1192 17.5879 17.5965 17.1107C18.0737 16.6334 18.0737 15.8597 17.5965 15.3824L14.0778 11.8638C13.6005 11.3865 13.6005 10.6126 14.0778 10.1353L17.5965 6.61667C18.0737 6.13943 18.0737 5.36568 17.5965 4.88844C17.1192 4.41121 16.3455 4.41121 15.8683 4.88844Z"
                    fill="currentColor" fill-opacity="0.38"/>
            </svg>
        </a>
    </div>
    {{--    for icon : https://fontawesome.com/search?o=r&s=duotone--}}

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons fa-duotone fa-house-user"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>
        @can('Admins-read')
            <li class="menu-item">
                <a href="{{ route('admin.admins.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-duotone fa-user-group-crown"></i>
                    <div data-i18n="Dashboards">Admins</div>
                </a>
            </li>
        @endcan
        @can('Members-read')
            <li class="menu-item">
                <a href="{{ route('admin.members.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-duotone fa-users"></i>
                    <div data-i18n="Members">Members</div>
                </a>
            </li>
        @endcan
        @can('KYCS-read')
            <li class="menu-item">
                <a href="{{ route('admin.kycs.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-duotone fa-id-card"></i>
                    <div data-i18n="KYCs">KYCs</div>
                </a>
            </li>
        @endcan
        @can('Packages-read')
            <li class="menu-item">
                <a href="{{ route('admin.packages.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-duotone fa-hand-holding-box"></i>
                    <div data-i18n="Packages">Packages</div>
                </a>
            </li>
        @endcan
        @if(settings('is_ecommerce'))
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons fa-duotone fa-bags-shopping"></i>
                    <div data-i18n="Ecommerce">Ecommerce</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('admin.gst-types.index') }}" class="menu-link">
                            <div data-i18n="GST Types">GST Types</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.categories.index') }}" class="menu-link">
                            <div data-i18n="Category"> Category</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.products.index') }}" class="menu-link">
                            <div data-i18n="Products"> Products</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.orders.index') }}" class="menu-link">
                            <div data-i18n="Orders"> Orders</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        @can('Sponsor Genealogy Tree-read')
            <li class="menu-item">
                <a href="{{ route('admin.sponsor-genealogy.show') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-duotone fa-sitemap"></i>
                    <div data-i18n="Genealogy Tree">Sponsor Genealogy Tree</div>
                </a>
            </li>
        @endcan
        @can('Magic Pool Genealogy Tree-read')
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons mdi mdi-family-tree"></i>
                    <div data-i18n="View">Magic Pool Genealogy</div>
                </a>
                <ul class="menu-sub">
                    @foreach(\App\Models\MagicPool::get() as $magicPool)
                        <li class="menu-item">
                            <a href="{{ route('admin.autoPool.show',$magicPool) }}" class="menu-link">
                                <div data-i18n="Collapsed menu">
                                    {{$magicPool->name}}
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endcan
        @can('Member TDS Report-read')
            <li class="menu-item">
                <a href="{{ route('admin.tds.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-duotone fa-badge-percent"></i>
                    <div data-i18n=" Member TDS Report "> Member TDS Report</div>
                </a>
            </li>
        @endcan
        @can('Income Wallet-read')
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons fa-duotone fa-wallet"></i>
                    <div data-i18n="Wallet">Income Wallet</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('admin.wallet-transactions.index') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Transactions</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.wallet-transactions.create') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Credit & Debits</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.wallet-transactions.transfer') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Transfers</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        @can('Fund Wallet-read')
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons fa-duotone fa-wallet"></i>
                    <div data-i18n="Wallet">Fund Wallet</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('admin.fund-wallet-transactions.index') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Transactions</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.fund-wallet-transactions.create') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Credit & Debits</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.fund-requests.index') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Requests</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.fund-wallet-transactions.transfer') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Transfers</div>
                        </a>
                    </li>

                </ul>
            </li>
        @endcan
        @can('Incomes-read')
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons fa-duotone fa-coins"></i>
                    <div data-i18n="Income">Incomes</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('admin.incomes.referral-bonus-income') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Referral Bonus Income</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.incomes.team-bonus-income') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Team Bonus Income</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.incomes.reward-bonus-income') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Reward Bonus Income</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.incomes.magic-pool-bonus-income') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Magic Pool Bonus Income</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan
        @can('Reports-read')
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons fa-duotone fa-file-chart-pie"></i>
                    <div data-i18n="Report">Reports</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('admin.reports.top-earners') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Top Earners</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.reports.most-active-user') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Most Active Member</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.reports.top-up') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Top Up</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.reports.reward') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Reward Report</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.reports.level') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Level Report</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        @can('Reward Bonus-read')
            <li class="menu-item">
                <a href="{{ route('admin.reward-bonus.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-duotone fa-award"></i>
                    <div data-i18n="Exports">Reward Bonus Detail</div>
                </a>
            </li>
        @endif
        @can('Payouts-read')
            <li class="menu-item">
                <a href="{{ route('admin.payouts.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-duotone fa-money-bills"></i>
                    <div data-i18n="Payouts">Payouts</div>
                </a>
            </li>
        @endcan
        @can('Exports-read')
            <li class="menu-item">
                <a href="{{ route('admin.exports.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-duotone fa-download"></i>
                    <div data-i18n="Exports">Exports</div>
                </a>
            </li>
        @endif
        @can('GST Manager-read')
            <li class="menu-item">
                <a href="{{ route('admin.gst.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-duotone fa-memo-circle-info"></i>
                    <div data-i18n=" GST Manager"> GST Manager</div>
                </a>
            </li>
        @endcan
        @can('Contact Inquiries-read')
            <li class="menu-item">
                <a href="{{ route('admin.contactInquires.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-duotone fa-address-book"></i>
                    <div data-i18n="Contact Inquiries"> Contact Inquiries</div>
                    <span class="badge bg-success rounded-pill ms-auto">
                            {{ \App\Models\Inquiry::whereIsRead(false)->count() }}
                        </span>
                </a>
            </li>
        @endcan
        @can('Support Ticket-read')
            <li class="menu-item">
                <a href="{{ route('admin.support-ticket.get') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-duotone fa-comments-question-check"></i>
                    <div data-i18n="Support Ticket"> Support Ticket</div>
                    <div class="badge bg-primary rounded-pill ms-auto">
                        {{ \App\Models\SupportTicketMessage::where('messageable_type',\App\Models\Member::class)->where('is_read',0)->count() }}
                    </div>
                </a>
            </li>
        @endcan
        @can('Banking Partner-read')
            <li class="menu-item">
                <a href="{{ route('admin.banking.show') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-duotone fa-building-columns"></i>
                    <div data-i18n="Banking Partner"> Banking Partner</div>
                </a>
            </li>
        @endcan
        @can('Website Settings-read')
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons fa-duotone fa-gears"></i>
                    <div data-i18n="Website Setting ">Website Settings</div>
                </a>

                <ul class="menu-sub">
                    @if(settings('logo_changes'))
                        <li class="menu-item">
                            <a href="{{ route('admin.settings.change-logo') }}" class="menu-link">
                                <div data-i18n="Collapsed menu">Change Logo</div>
                            </a>
                        </li>
                    @endif
                    <li class="menu-item">
                        <a href="{{ route('admin.video.index') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Videos</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.settings.change-background') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Login Background</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.settings.content') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Website Content</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ route('admin.settings.contact-info') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Contact Info</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ route('admin.news.index') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">News Feed</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.faqs.index') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">FAQs</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.photo-gallery.index') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Photo Gallery</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.website-banner.create') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Banners</div>
                        </a>
                    </li>
                    @if(settings('is_ecommerce'))
                        <li class="menu-item">
                            <a href="{{ route('admin.trending-products.index') }}" class="menu-link">
                                <div data-i18n="Collapsed menu">Trending Products</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('admin.category-sliders.show') }}" class="menu-link">
                                <div data-i18n="Collapsed menu">Category Slider</div>
                            </a>
                        </li>
                    @endif
                    <li class="menu-item">
                        <a href="{{ route('admin.legal.create') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Legal Documents</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.website-pop.create') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Website Popup</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.member-pop.create') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Member Popup</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.business-plan.show') }}" class="menu-link">
                            <div data-i18n="Collapsed menu">Business Plan</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
</aside>
