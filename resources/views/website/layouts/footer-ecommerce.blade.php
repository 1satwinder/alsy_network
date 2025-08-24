<footer class="bg-navy text-inverse">
    <div class="container pt-15 pt-md-17 pb-13 pb-md-15">
        <div class="row gy-6 gy-lg-5">
            <div class="col-md-4 col-lg-4">
                <div class="widget">
                    <h4 class="widget-title text-white mb-3">Get in Touch</h4>
                    @if(settings('address_enabled'))
                        <address class="pe-xl-15 pe-xxl-17">
                            {{ settings('address_line_1') }} <br>
                            {{ settings('address_line_2') }} <br>
                            {{ settings('city') ? settings('city')."," : "" }} {{ settings('state') ?settings('state')."," : "" }} {{ settings('country') ? settings('country') : ""}}
                            {{ settings('pincode') ? "-".settings('pincode') : ""}}
                        </address>
                    @endif
                    @if(settings('email'))
                        <a href="mailto:{{ settings('email') }}">{{ settings('email') }}</a>
                    @endif
                    @if(settings('mobile'))
                        <br/> {{ settings('mobile') }}
                    @endif
                </div>
            </div>
            <div class="col-md-2 col-lg-2">
                <div class="widget">
                    <h4 class="widget-title text-white mb-3">Links</h4>
                    <ul class="list-unstyled mb-0">
                        <li><a href="{{ route('website.terms') }}">Terms & Conditions</a></li>
                        <li><a href="{{ route('website.faqs') }}">FAQs</a></li>
                        <li><a href="{{ route('website.privacy-policy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('website.return-policy') }}">Return Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-lg-3">
                <div class="widget">
                    <h4 class="widget-title text-white mb-3">Menus</h4>
                    <ul class="list-unstyled mb-0">
                        <li><a href="{{ route('website.about') }}">About Us</a></li>
                        <li><a href="{{ route('website.contact') }}">Contact Us</a></li>
                        <li><a href="{{ route('website.message') }}">Founder Message</a></li>
                        <li><a href="{{ route('website.legal') }}">Legals</a></li>
                        <li><a href="{{ route('website.gallery') }}">Gallery</a></li>

                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-lg-3">
                <div class="widget">
                    <p class="mb-4">
                        &copy; Copyright {{ date('Y') }} All rights reserved by <a
                            href="{{ env('APP_URL') }}">{{ settings('company_name') }}</a>
                    </p>
                    <nav class="nav social social-white">
                        @if(settings('social_link'))
                            @if(settings('facebook_url'))
                                <a target="_blank" href="{{ settings('facebook_url') }}"
                                   title="Facebook">
                                    <i class="uil uil-facebook"></i>
                                </a>
                            @endif
                            @if(settings('instagram_url'))
                                <a target="_blank" href="{{ settings('instagram_url') }}"
                                   title="Instagram">
                                    <i class="uil uil-instagram-alt"></i>
                                </a>
                            @endif
                            @if(settings('youtube_url'))
                                <a target="_blank" href="{{ settings('youtube_url') }}"
                                   title="Youtube">
                                    <i class="uil uil-youtube"></i>
                                </a>
                            @endif
                            @if(settings('twitter_url'))
                                <a target="_blank" href="{{ settings('twitter_url') }}"
                                   title="Twitter">
                                    <i class="uil uil-twitter"></i>
                                </a>
                            @endif
                            @if(settings('telegram_url'))
                                <a target="_blank" href="{{ settings('telegram_url') }}"
                                   title="Telegram">
                                    <i class="uil uil-telegram"></i>
                                </a>
                            @endif
                            @if(settings('zoom_url'))
                                <a target="_blank" href="{{ settings('zoom_url') }}"
                                   title="Zoom Url">
                                    <i class='bx bxs-video'></i>
                                </a>
                            @endif
                            @if(settings('telegram_group_url'))
                                <a target="_blank" href="{{ settings('telegram_group_url') }}"
                                   title="Telegram Group">
                                    <i class="uil uil-telegram"></i>
                                </a>
                            @endif
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
    </svg>
</div>
<div class="d-lg-none d-md-none bottom-fix-button">
    <div class="row text-center justify-content-center">
        @if(!Auth::check())
            <div class="col">
                <a class="btn btn-sm btn-primary rounded w-100" href="{{ route('member.login.create') }}">Login</a>
            </div>
            <div class="col">
                <a class="btn btn-sm btn-danger rounded w-100" href="{{ route('member.register.create') }}">
                    Sign Up
                </a>
            </div>
        @else
            <div class="col">
                <a class="btn btn-sm btn-primary rounded w-100" href="{{ route('member.dashboard.index') }}">
                    User Panel
                </a>
            </div>
        @endif

    </div>
</div>
