<title>{{__('Kamel Ouda')}} - @yield('title', '')</title>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" href="/wave/favicon.png" type="image/x-icon">
<meta name="robots" content="index,follow">
<meta name="googlebot" content="index,follow">

<link href="{{ asset('themes/uikit/css/app.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

@if (Session::get('locale') != 'en')
<link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/droid-arabic-kufi" type="text/css"/>
{{-- <link rel="stylesheet" media="screens" href="{{ asset('css/uikit-rtl.css') }}" type="text/css"/> --}}
<style>
* {
    font-family: 'Droid Arabic Kufi', '-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,sans-serif';
}

.uk-navbar-item, .uk-navbar-nav>li>a, .uk-navbar-toggle {
    font-family: 'Droid Arabic Kufi', '-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,sans-serif';    
}
.uk-h1, .uk-h2, .uk-h3.uk-h1, h1, h1.uk-h1, h2.uk-h1, h3 {
    font-family: 'Droid Arabic Kufi', '-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,sans-serif' !important;    
}
</style>
@endif