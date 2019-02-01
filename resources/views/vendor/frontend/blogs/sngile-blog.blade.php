@extends('vendor.frontend.layout.layout')
@section('title', __('News'))
@section('content')


<div dir="auto" class="breadcrumb-nav uk-margin-bottom">
    <div class="uk-container">
        <ul class="uk-breadcrumb">
            <li><a href="{{ route('frontend.news') }}">{{__('News')}}</a></li>
            <li><a href="{{ route('frontend.news.category', $post->category->slug) }}">{!! Session::get('locale') == 'en' ?  $post->category->name :  $post->category->name_ar !!}</a></li>
            <li><span>{!! Session::get('locale') == 'en' ?  $post->title :  $post->title_ar !!}</span></li>
        </ul>
    </div>
</div>
<div class="uk-container uk-container-small">
    <article id="post-5" class="uk-article post-5 uk-text-center uk-margin-large-bottom">
        <meta property="name" content="{!! Session::get('locale') == 'en' ?  $post->title :  $post->title_ar !!}">
        <meta property="author" typeof="Person" content="{{$post->user->name}}">
        <meta property="dateModified" content="{{$post->updated_at}}">
        <meta class="uk-margin-remove-adjacent" property="datePublished" content="{{$post->created_at}}">
        <div class="uk-margin-large-bottom">
            <img width="1200" height="640" src="{{ Voyager::image($post->image) }}"
                alt="{!! Session::get('locale') == 'en' ?  $post->title :  $post->title_ar !!}" srcset="{{ Voyager::image($post->image) }}">
        </div>
        <div class="uk-margin-medium-bottom uk-container uk-container-small uk-text-center">
            <h1 class="uk-article-title uk-margin-remove-top">{!! Session::get('locale') == 'en' ?  $post->title :  $post->title_ar !!}</h1>
            <p class="uk-article-meta">{{__('Written on')}} <time datetime="2018-03-26T02:55:01+00:00">{{ \Carbon\Carbon::parse($post->created_at)->toFormattedDateString()}}</time>.
                {{__('Posted in')}} <a href="{{ route('frontend.news.category', $post->category->slug) }}" rel="category">{!! Session::get('locale') == 'en' ?  $post->category->name :  $post->category->name_ar !!}</a>.</p>
        </div>
        <div class="uk-container uk-container-small {{ Session::get('locale') == 'en' ? 'uk-text-left' : 'uk-text-right' }}">
            {!! Session::get('locale') == 'en' ?  $post->body :  $post->body_ar !!}
        </div>
    </article>
</div>
@endsection
