<header class="wrapper">
    <nav class="navbar classic navbar-expand-lg navbar-light navbar-bg-light">
        <div class="container-fluid flex-lg-row flex-nowrap align-items-center">
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
                    @if(settings('product_module'))
                        @foreach($categories as $key => $category)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#!">{{ $category->name }}</a>
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
                    @endif
                </ul>
            </div>
            <div class="navbar-other ms-lg-4">
                <ul class="navbar-nav flex-row align-items-center ms-auto" data-sm-skip="true">
                    <li class="nav-item">
                        <form method="get" action="{{ route('website.search-product') }}"
                              id="searchForm">
                        <div class="collapse position-absolute w-100 px-3" id="searchForm">
                            <div class="d-flex align-items-center ui-widget">
                                <input  name="searchProduct" type="text" class="form-control form-control-lg bg-light flex-grow-1 searchForm tags"
                                       placeholder="search with product name & category" />
                                <input type="hidden" name="searchProductSlug" id="tagsSlug">
                                <a class="nav-link py-2 bg-light"
                                       href="#searchForm"
                                       data-bs-target="#searchForm"
                                       data-bs-toggle="collapse">
                                        <i class="uil uil-times"></i>
                                    </a>
                            </div>
                        </div>
                        </form>
                        <a class="nav-link ml-auto"
                           href="javascript:void(0)"
                           aria-expanded="false"
                           data-bs-target="#searchForm"
                           data-bs-toggle="collapse">
                            <i class="uil uil-search"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block">
                        <a class="nav-link" href="{{ route('website.cart.index') }}">
                            <i class="uil uil-shopping-bag"></i>
                            <span class="cartCount">{{ $cart }}</span>
                        </a>
                    </li>
                    <li class="nav-item ms-lg-0">
                        <div class="navbar-hamburger d-lg-none d-xl-none ms-auto"><button class="hamburger animate plain" data-toggle="offcanvas-nav"><span></span></button></div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
