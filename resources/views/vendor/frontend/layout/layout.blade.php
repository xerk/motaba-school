<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('vendor.frontend.layout.header')
        @yield('extra-css')
    </head>


<body class="@yield('body-class', '')">
    <div id="app" data-sticky-wrap>
        {!! menu('main', 'vendor.frontend.layout.navbar') !!}
        @yield('content')
    </div>

    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    @include('vendor.frontend.layout.footer')

    @yield('extra-js')
</body>
</html>
