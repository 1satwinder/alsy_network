<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="{{ settings('primary_color') }}">
    <meta name="msapplication-TileColor" content="{{ settings('primary_color') }}">
    <link rel="shortcut icon" href="{{ settings()->getFileUrl('favicon', asset(env('FAVICON', '/images/favicon.png'))) }}" type="image/x-icon">
    @stack('import-css')
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.1/css/select2.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/icons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/thicccboi.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" rel="stylesheet"
          type="text/css"/>
    @stack('page-css')
    <style>
        :root {
            --primary: {{ settings('primary_color') }};
            --primary-hover: {{ settings('primary_color_hover') }};
        }
    </style>
</head>
<body>
<div class="content-wrapper">
    @if(settings('is_ecommerce'))
        @include('website.layouts.header-ecommerce')
    @else
        @include('website.layouts.header')
    @endif
    @yield('content')
</div>
@if(settings('is_ecommerce'))
    @include('website.layouts.footer-ecommerce')
@else
    @include('website.layouts.footer')
@endif
@routes
@stack('import-javascript')
<script src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('js/jquery.min.js')}}"></script>
<script src="{{ asset('js/jquery-ui.min.js')}}"></script>
<script src="{{ asset('js/plugins.js')}}"></script>
<script src="{{ asset('js/svg-inject.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.1/js/select2.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>
<script src="{{ asset('js/theme.js')}}"></script>
<script>
    $('[data-toggle="select2"]').select2();
</script>

@if(Session::has('success'))
    <script>
        Swal.fire('Yay!!!', '{{ Session::get('success') }}', 'success')
    </script>
@endif

@if(Session::has('error'))
    <script>
        Swal.fire('Oops!!!', '{{ Session::get('error') }}', 'error')
    </script>
@endif

@if(settings('is_ecommerce'))
    <script>
        $(".tags").autocomplete({
            minLength: 1,
            maxLength: 5,
            source: '/getProductSuggestion',
            focus: function (event, ui) {
                $(".tags").val(ui.item.value);
                $("#tagsSlug").val(ui.item.slug);
                console.log('focus');
                return false;
            },
            select: function (event, ui) {
                $(".tags").val(ui.item.value);
                console.log('select');
                $("#tagsSlug").val(ui.item.slug);
                $("#searchForm").submit();
                return false;
            },
            onSelect: function () {
                $("#searchForm").submit();
            }
        })
    </script>
@endif
@stack('page-javascript')
</body>
</html>
