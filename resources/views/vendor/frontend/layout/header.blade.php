<title>School - @yield('title', '')</title>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" href="/wave/favicon.png" type="image/x-icon">
<meta name="robots" content="index,follow">
<meta name="googlebot" content="index,follow">

<link href="{{ asset('themes/uikit/css/app.css') }}" rel="stylesheet">

@if (Session::get('locale') != 'en')
<link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/droid-arabic-kufi" type="text/css"/>

<style>
* {
    font-family: 'Droid Arabic Kufi', '-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,sans-serif';
}

.uk-navbar-item, .uk-navbar-nav>li>a, .uk-navbar-toggle {
    font-family: 'Droid Arabic Kufi', '-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,sans-serif';    
}
</style>
@endif