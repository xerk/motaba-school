@extends('vendor.frontend.layout.layout')
@section('title', __('About'))
@section('body-class', 'about')
@section('content')
<div class="uk-container uk-container-small uk-margin-medium-top">
    <article id="page-2" class="uk-article post-2 uk-text-center uk-margin-large-bottom">
        <meta property="name" content="About">
        <meta property="author" typeof="Person" content="admin">
        <meta property="dateModified" content="2018-03-30T03:04:51+00:00">
        <meta class="uk-margin-remove-adjacent" property="datePublished" content="2018-03-30T03:04:51+00:00">
        <div class="uk-margin-medium-bottom uk-text-left uk-margin-large-top">
            <h1 class="uk-heading-line uk-margin-remove-top uk-text-center"><span>{!! Session::get('locale') == 'en' ?  $page->title :  $page->title_ar !!}</span></h1>
            <p class="uk-text-center">{!! Session::get('locale') == 'en' ?  $page->excerpt :  $page->excerpt_ar !!}</p>
        </div>
        <div class="uk-margin-bottom">
            @if ($page->image)
            <img width="1200" height="640" src="{{ Voyager::image($page->image) }}" alt="{!! Session::get('locale') == 'en' ?  $page->title :  $page->title_ar !!}" srcset="{{ Voyager::image($page->image) }}">
            @endif
            </div>
        <div class="{{ Session::get('locale') == 'en' ? 'uk-text-left' : 'uk-text-right' }}">
            {!! Session::get('locale') == 'en' ?  $page->body :  $page->body_ar !!}
        </div>
        <hr>
        <p dir="{!! Session::get('locale') == 'en' ?  'ltr' :  'rtl' !!}" class="uk-text-meta uk-margin-remove-top" style="float: right;"><time datetime="2018-09-14 09:43:00" title="2018-09-14 09:43:00">{{__('Created at')}}: {{ \Carbon\Carbon::parse($page->created_at)->toFormattedDateString()}}</time></p>
        <p dir="{!! Session::get('locale') == 'en' ?  'ltr' :  'rtl' !!}" class="uk-text-meta uk-margin-remove-top" style="float: left;"><time datetime="2018-09-14 09:43:00" title="2018-09-14 09:43:00">{{__('Author')}}: {{$page->user->name}}</time></p>
    </article>
</div>
@endsection
