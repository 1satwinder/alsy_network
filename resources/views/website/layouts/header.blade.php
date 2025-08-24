<header class="wrapper bg-soft-primary">
    <nav class="navbar navbar-expand-lg center-nav navbar-dark navbar-bg-dark">
        <div class="container flex-lg-row flex-nowrap align-items-center">
            <div class="navbar-brand w-100">
                <a href="{{ route('website.home') }}">
                    <img src="{{ settings()->getFileUrl('logo', asset(env('LOGO', '/images/logo.png'))) }}" srcset="{{ settings()->getFileUrl('logo', asset(env('LOGO', '/images/logo.png'))) }} 2x"
                         alt=""/>
                </a>
            </div>
            <div class="navbar-collapse offcanvas-nav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('website.home') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Company</a>
                        <ul class="dropdown-menu">
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ route('website.about') }}">
                                    About Us
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ route('website.gallery') }}">
                                    Gallery
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ route('website.message') }}">
                                    Founder message
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ route('website.plan') }}">
                                    Business Plan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ route('website.faqs') }}">
                                    FAQs
                                </a>
                            </li>
                        </ul>
                    </li>
                    @if(settings('product_module'))
                        <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#!">Products</a>
                            <ul class="dropdown-menu">
                                @foreach($categories as $key => $category)
                                    <li class="dropdown">
                                        <a class="dropdown-item dropdown-toggle"
                                           href="javascript:void(0)">{{ $category->name }}
                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach($category->children as $child_category)
                                                <li class="nav-item">
                                                    <a class="dropdown-item"
                                                       href="{{ route('website.product.index',$child_category->prefix) }}">
                                                        {{ $child_category->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('website.legal') }}">Legals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('website.contact') }}">Contact</a>
                    </li>
                    @if(Auth::check())
                        <li class="nav-item d-lg-none d-md-none">
                            <a class="nav-link" href="{{ route('member.dashboard.index') }}">User Panel</a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="navbar-other w-100 d-flex ms-auto">
                <ul class="navbar-nav flex-row align-items-center ms-auto" data-sm-skip="true">
                    @if(Auth::check())
                        <li class="nav-item d-none d-lg-block d-xl-block">
                            <a class="btn btn-sm btn-primary rounded" href="{{ route('member.dashboard.index') }}">
                                User Panel
                            </a>
                        </li>
                        <li class="nav-item d-none d-sm-block d-xl-block">
                            <a class="btn btn-sm btn-danger rounded" href="{{ route('member.register.create') }}">
                                Sign Up
                            </a>
                        </li>
                    @else
                        <li class="nav-item d-none d-lg-block d-xl-block">
                            <a class="nav-link" href="{{ route('member.login.create') }}">Log In</a>
                        </li>
                        <li class="nav-item d-none d-md-block">
                            <a class="btn btn-sm btn-primary rounded" href="{{ route('member.register.create') }}">
                                Sign Up
                            </a>
                        </li>
                    @endif
                    <li class="nav-item d-lg-none">
                        <div class="navbar-hamburger">
                            <button class="hamburger animate plain" data-toggle="offcanvas-nav"><span></span></button>
                        </div>
                    </li>
                    @if(settings('product_module'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('website.cart.index') }}">
                                <i class="uil uil-shopping-bag"></i>
                                <span class="cartCount">{{ $cart }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>
