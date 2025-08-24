@php $member = \Auth::user()->member; @endphp

<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="container-fluid">
        <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
            <a href="{{ route('member.dashboard.index') }}" class="app-brand-link gap-2 app-brand-logo">
                <img src="{{ settings()->getFileUrl('logo', asset(env('LOGO', '/images/logo.png'))) }}"
                     alt="{{ settings('company_name') }}">
            </a>
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                <i class="mdi mdi-close align-middle"></i>
            </a>
        </div>
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0  d-xl-none  ">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="mdi mdi-menu mdi-24px"></i>
            </a>
        </div>
        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <div id="google_translate_element" class="me-3"></div>
{{--                <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-2 me-xl-1">--}}
{{--                    <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"--}}
{{--                       href="{{ route('member.support.index') }}">--}}
{{--                        <i class="fa-duotone fa-comments-question-check"></i>--}}
{{--                        @if(\App\Models\SupportTicketMessage::where('messageable_type',\App\Models\Admin::class)->where('is_read',0)->count())--}}
{{--                            <span--}}
{{--                                class="position-absolute top-0 start-50 translate-middle-y badge badge-dot bg-danger mt-2 border"></span>--}}
{{--                        @endif--}}
{{--                    </a>--}}
{{--                </li>--}}

                @if(settings('product_module'))
                    <li class="nav-item me-1 me-xl-0">
                        <a
                            class="nav-link btn btn-text-secondary rounded-pill btn-icon hide-arrow waves-effect waves-light"
                            href="{{ route('website.cart.index') }}">
                            <i class='mdi mdi-shopping-outline mdi-24px'></i>
                        </a>
                    </li>
                @endif
{{--                <li class="nav-item me-1 me-xl-0">--}}
{{--                    <a class="nav-link btn btn-text-secondary rounded-pill btn-icon style-switcher-toggle hide-arrow waves-effect waves-light"--}}
{{--                       href="{{ route('member.toggle-theme') }}" data-bs-toggle="tooltip" title=""--}}
{{--                       data-original-title="{{ Auth::user()->isDarkTheme() ? 'Switch to Light Mode': 'Switch to Dark Mode' }}">--}}
{{--                        <i class="fa-duotone {{ Auth::user()->isDarkTheme() ? 'fa-sun': 'fa-moon' }}"></i>--}}
{{--                    </a>--}}
{{--                </li>--}}

                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                       data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            <img src="{{ Auth::user()->member->present()->profileImage() }}" alt
                                 class="w-px-40 h-px-40 rounded-circle">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="javascript:void(0)">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="{{ Auth::user()->member->present()->profileImage() }}" alt
                                                 class="w-px-40 h-px-40 rounded-circle">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                                        <small
                                            class="text-muted">@include('copy-text', ['text' => Auth::user()->member->code])</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                               href="{{ route('member.profile.show') }}">
                                <i class="fa-duotone fa-user-pen me-2"></i>
                                <span class="align-middle">My Profile</span>
                            </a>
                        </li>
                        @if($member->package_id)
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                   href="{{ route('member.invoice.index') }}">
                                    <i class="fa-duotone fa-receipt me-2"></i>
                                    <span class="align-middle">Invoices</span>
                                </a>
                            </li>
                        @endif
                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                               href="{{ route('member.support.index') }}">
                                <i class="fa-duotone fa-comments-question-check me-2"></i>
                                <span class="align-middle">Support Ticket</span>
                                <div class="badge bg-primary rounded-pill ms-auto">
                                    {{ \App\Models\SupportTicketMessage::where('messageable_type',\App\Models\Admin::class)
                                          ->whereHas('supportTicket',function (\Illuminate\Database\Eloquent\Builder $q){
                                              $q->where('member_id',Auth::user()->member->id)
                                              ->where('status',\App\Models\SupportTicket::STATUS_OPEN);
                                          })
                                          ->where('is_read',0)
                                          ->count() }}
                                </div>
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('member.banks.index') }}">
                                <i class="fa-duotone fa-building-columns me-2"></i>
                                <span class="align-middle">Banking Partner</span>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                               href="{{ route('member.login.destroy') }}">
                                <i class="fa-duotone fa-arrow-right-from-bracket me-2"></i>
                                <span class="align-middle">Log Out</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="navbar-search-wrapper search-input-wrapper container-fluid d-none">
            <input type="text" class="form-control search-input  border-0" placeholder="Search..."
                   aria-label="Search...">
            <i class="mdi mdi-close search-toggler cursor-pointer"></i>
        </div>
    </div>
</nav>
