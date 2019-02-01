@extends('vendor.frontend.layout.layout')
@section('title', __('Homepage'))
@section('body-class', 'home')
@section('content')
<div class="uk-section-default uk-section uk-flex uk-flex-middle uk-padding-small uk-padding-remove-bottom uk-margin-small-top"
style="box-sizing: border-box;">
   <div class="uk-width-1-1">
       <div class="uk-container">
           <div class="uk-grid-large uk-flex-middle uk-grid-margin-large uk-grid uk-padding-bottom@m" uk-grid="">
               <div class="uk-width-expand@m uk-first-column uk-animation-slide-left-small">
                   <h1 class="uk-text-left@m uk-text-center uk-h6 uk-scrollspy-inview uk-animation-slide-left-medium"
                    uk-scrollspy-class="">{{ Session::get('locale') == 'en' ? setting('site.home_headline') : setting('site.home_headline_ar') }}</h1>
                   <h2 class="uk-width-xlarge uk-margin-auto uk-text-left@m uk-text-center uk-h1 uk-scrollspy-inview uk-animation-slide-left-medium"
                    uk-scrollspy-class="">{{ Session::get('locale') == 'en' ? setting('site.homepage_subheadline') : setting('site.homepage_subheadline_ar') }}</h2>
                   <div class="uk-margin uk-text-left@m uk-text-center uk-scrollspy-inview uk-animation-slide-left-medium"
                    uk-scrollspy-class="">{{ Session::get('locale') == 'en' ? setting('site.home_description') : setting('site.home_description_ar') }}</div>
                   <div class="uk-margin-medium uk-text-left@m uk-text-center uk-scrollspy-inview uk-animation-slide-left-medium"
                    uk-scrollspy-class="" style="">
                       <a class="el-content uk-button uk-button-primary" href="{{ route(setting('site.home_cta_url')) }}" title="{{ Session::get('locale') == 'en' ? setting('site.home_cta') : setting('site.home_cta_ar') }}">
                            {{ Session::get('locale') == 'en' ? setting('site.home_cta') : setting('site.home_cta_ar') }}
                       </a>
                   </div>
               </div>
               <div class="uk-width-expand@m uk-animation-slide-right-small">
                   <div class="uk-margin uk-text-center uk-scrollspy-inview uk-animation-slide-right" uk-scrollspy-class="uk-animation-slide-right"
                    style="">
                       <img src="{{ Voyager::image(setting('site.home_promo_image')) }}" class="el-image" alt="" style="max-height:550px">
                   </div>
               </div>
           </div>
       </div>
   </div>
</div>
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
y="0px" viewBox="0 0 1440 126" style="enable-background:new 0 0 1440 126;" xml:space="preserve">
   <style type="text/css">
       .wave-svg {
           fill: #1683FB;
       }
   </style>
   <g id="wave" transform="translate(720.000000, 75.000000) scale(1, -1) translate(-720.000000, -75.000000) " fill-rule="nonzero">
       <path class="wave-svg" d="M694,94.437587 C327,161.381336 194,153.298248 0,143.434189 L2.01616501e-13,44.1765618 L1440,27 L1440,121 C1244,94.437587 999.43006,38.7246898 694,94.437587 Z"
        id="Shape" fill="#0069FF" opacity="0.519587054"></path>
       <path class="wave-svg" d="M686.868924,95.4364002 C416,151.323752 170.73341,134.021565 1.35713663e-12,119.957876 L0,25.1467017 L1440,8 L1440,107.854321 C1252.11022,92.2972893 1034.37894,23.7359827 686.868924,95.4364002 Z"
        id="Shape" fill="#0069FF" opacity="0.347991071"></path>
       <path class="wave-svg" d="M685.6,30.8323303 C418.7,-19.0491687 170.2,1.94304528 0,22.035593 L0,118 L1440,118 L1440,22.035593 C1252.7,44.2273621 1010,91.4098622 685.6,30.8323303 Z"
        id="Shape" fill="url(#linearGradient-1)" transform="translate(720.000000, 59.000000) scale(1, -1) translate(-720.000000, -59.000000) "></path>
   </g>
</svg>
<div class="uk-width-1-1" id="features">
   <div class="uk-container">
       <h2>{{ Session::get('locale') == 'en' ? setting('site.title_school_definitions') : setting('site.title_school_definitions_ar') }}</h2>
       <p class="uk-text-center uk-margin-remove-top uk-align-center uk-margin-remove-bottom" style="color:#ffffff; opacity:0.8;">{{ Session::get('locale') == 'en' ? setting('site.body_school_definitions') : setting('site.body_school_definitions_ar') }}</p>
       <div class="uk-grid">
           @foreach ($schoolDefi as $item)    
            <div class="uk-width-1-3@m uk-width-1-2@s uk-width-1-1 uk-margin-large-top uk-text-center" uk-scrollspy="cls:uk-animation-slide-bottom">
                <img src="{{ Voyager::image($item->icon) }}">
                <h4>{{ Session::get('locale') == 'en' ? $item->title : $item->title_ar }}</h4>
                <p>{{ Session::get('locale') == 'en' ? $item->body : $item->body_ar }}</p>
            </div>
           @endforeach
       </div>
   </div>
</div>
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
y="0px" viewBox="0 0 1440 156" style="enable-background:new 0 0 1440 126;" xml:space="preserve">
   <style type="text/css">
       .wave-svg {
           fill: #1683FB;
       }
   </style>
   <g id="wave" fill-rule="nonzero">
       <path class="wave-svg" d="M694,94.437587 C327,161.381336 194,153.298248 0,143.434189 L2.01616501e-13,44.1765618 L1440,27 L1440,121 C1244,94.437587 999.43006,38.7246898 694,94.437587 Z"
        id="Shape" fill="#0069FF" opacity="0.519587054"></path>
       <path class="wave-svg" d="M686.868924,95.4364002 C416,151.323752 170.73341,134.021565 1.35713663e-12,119.957876 L0,25.1467017 L1440,8 L1440,107.854321 C1252.11022,92.2972893 1034.37894,23.7359827 686.868924,95.4364002 Z"
        id="Shape" fill="#0069FF" opacity="0.347991071"></path>
       <path class="wave-svg" d="M685.6,30.8323303 C418.7,-19.0491687 170.2,1.94304528 0,22.035593 L0,118 L1440,118 L1440,22.035593 C1252.7,44.2273621 1010,91.4098622 685.6,30.8323303 Z"
        id="Shape" fill="url(#linearGradient-1)" transform="translate(720.000000, 59.000000) scale(1, -1) translate(-720.000000, -59.000000) "></path>
   </g>
</svg>
<div id="testimonials">
   <div class="uk-container uk-margin-small-top">
       <h2>{{ Session::get('locale') == 'en' ? setting('site.title_testimonials') : setting('site.title_testimonials_ar') }}</h2>
       <p class="uk-text-center uk-margin-remove-top">{{ Session::get('locale') == 'en' ? setting('site.body_testimonials') : setting('site.body_testimonials_ar') }}</p>
       <div class="uk-position-relative uk-visible-toggle uk-dark" uk-slider="autoplay: true;">
           <ul class="uk-slider-items uk-child-width-1-1">
               @foreach ($testimonials as $item)    
                <li class="testimonial uk-text-center">
                    <img src="{{ Voyager::image($item->image) }}" alt="Testimonial 1" uk-slider-parallax="x: 200,-200">
                    <p uk-slider-parallax="x: 200,-200">{{ Session::get('locale') == 'en' ? $item->title : $item->title_ar }}</p>
                    <blockquote uk-slider-parallax="x: 100,-100">{{ Session::get('locale') == 'en' ? $item->body : $item->body_ar }}</blockquote>
                </li>
               @endforeach
           </ul>
           <a class="uk-position-center-left uk-position-small" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
           <a class="uk-position-center-right uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
           <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
       </div>
   </div>
</div>
@endsection