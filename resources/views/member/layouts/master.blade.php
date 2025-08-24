<!DOCTYPE html>
<html lang="en" class="@if(Auth::user()->isDarKTheme()) dark-style @else light-style @endif layout-navbar-fixed layout-menu-fixed " dir="ltr" data-theme="theme-default"
      data-assets-path="/" data-template="horizontal-menu-template">
<head>
    <title>@yield('title') | {{ settings('company_name') }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta content="{{ settings('company_name') }}" name="description"/>
    <meta content="{{ settings('company_name') }}" name="author"/>
    <link rel="shortcut icon" href="{{ settings()->getFileUrl('favicon', asset(env('FAVICON', '/images/favicon.png'))) }}">
    @stack('import-css')
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.5.4/flatpickr.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.bootstrap5.css') }}"/>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda-themeless.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/select2.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/perfect-scrollbar.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/node-waves.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/typeahead.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/icons.min.css') }}">
    @if(Auth::user()->isDarKTheme())
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core-dark.css') }}" class="template-customizer-core-css"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/theme-default-dark.css') }}" class="template-customizer-theme-css"/>
    @else
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core.css') }}" class="template-customizer-core-css"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/theme-default.css') }}" class="template-customizer-theme-css"/>
    @endif
    <script src="{{ asset('assets/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <style>
        :root {
            --primary: {{ settings('primary_color') }};
            --primary-hover: {{ settings('primary_color_hover') }};
        }
    </style>
    @stack('page-css')
</head>
<body>
<div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
    <div class="layout-container">
        @include('member.layouts.header')
        <div class="layout-page">
            <div class="content-wrapper">
                @include('member.layouts.sidebar')
                <div class="container-fluid flex-grow-1 container-p-y">
                    <div class="layout-demo-wrapper">
                        @yield('content')
                    </div>
                </div>
                <!-- Footer -->
                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-fluid">
                        <div
                            class="footer-container d-flex align-items-center justify-content-between py-3 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                © Copyright {{ date('Y') }}. All Rights Reserved by
                                <a href="{{ env('APP_URL') }}" target="_blank">{{ settings('company_name') }}</a>
                            </div>
                            <div>
                                Last Login :
                                @if($lastLoginLog)
                                    {{ $lastLoginLog->created_at->dateTimeFormat() }} from <span
                                        class="text-primary">{{ $lastLoginLog->ip }}</span>
                                @else
                                    N/A
                                @endif
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- / Footer -->
                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>
</div>
<div class="layout-overlay layout-menu-toggle"></div>
<div class="drag-target"></div>
@stack('import-javascript')
@routes
<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script src="{{ asset('assets/js/popper.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/js/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/js/node-waves.js') }}"></script>
<script src="{{ asset('assets/js/hammer.js') }}"></script>
<script src="{{ asset('assets/js/i18n.js') }}"></script>
<script src="{{ asset('assets/js/typeahead.js') }}"></script>
<script src="{{ asset('assets/js/menu.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.5.4/flatpickr.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.18/sweetalert2.all.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.4/clipboard.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/spin.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>
<script src="{{ asset('assets/js/datatables-bootstrap5.js') }}"></script>
<script src="{{ asset('assets/js/select2.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
@if (env('APP_ENV') === 'production')
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>
@else
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
@endif
@if(Session::has('success'))
    <script>
        Swal.fire('Yay!!!', '{{ Session::get('success') }}', 'success')
    </script>
@endif
@if(Session::has('success-export'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Yay!!!',
            text: '{{ Session::get('success-export') }}',
            footer: '<a href="{{ route('member.exports.index') }}" class="text-primary">Go To Exports</a>'
        });
    </script>
@endif
@if(Session::has('error'))
    <script>
        Swal.fire('Oops!!!', '{{ Session::get('error') }}', 'error')
    </script>
@endif
@stack('page-javascript')
</body>
</html>
