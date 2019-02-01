@extends('vendor.frontend.layout.layout')
@section('title', __('News'))
@section('content')
<div id="border-top"></div>
        <div dir="{!! Session::get('locale') == 'en' ?  'ltr' :  'rtl' !!}" class="uk-container uk-container-small">
            <div class="uk-text-center uk-margin-large-bottom uk-margin-medium-top">
                <h1 class="uk-heading-line"><span>{{__('News')}}</span></h1>
                <ul class="uk-subnav uk-subnav-divider" uk-margin>
                    <li class="first-cat">{{__('Categories')}}:</li>
                    @foreach ($categories as $category)    
                    <li class=""><a href="{{ route('frontend.news.category', $category->slug) }}">{!! Session::get('locale') == 'en' ?  $category->name :  $category->name_ar !!}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="uk-text-left" uk-grid>
                @foreach ($posts as $post)    
                <div class="uk-width-1-2@s uk-width-1-3@l">
                    <article id="post-5" class="uk-article uk-margin-medium-bottom" typeof="Article">
                        <meta property="name" content="{!! Session::get('locale') == 'en' ?  $post->title :  $post->title_ar !!}">
                        <meta property="author" typeof="Person" content="{{$post->user->name}}">
                        <meta property="dateModified" content="{{$post->updated_at}}">
                        <meta class="uk-margin-remove-adjacent" property="datePublished" content="{{ $post->created_at }}">
                        <div class="uk-margin-bottom">
                            <a href="{{ route('frontend.news.category.blog', [$post->category->slug, $post->slug]) }}"><img width="1200"
                                    height="800" src="{{ Voyager::image($post->image) }}" alt="{!! Session::get('locale') == 'en' ?  $post->title :  $post->title_ar !!}"
                                    srcset="{{ Voyager::image($post->image) }}"></a>
                        </div>
                        <div class="uk-margin-bottom uk-container uk-container-small">
                            <h2 class="uk-article-title uk-margin-remove-top"><a class="uk-link-reset" href="{{ route('frontend.news.category.blog', [$post->category->slug, $post->slug]) }}">{!! Session::get('locale') == 'en' ?  $post->title :  $post->title_ar !!}</a></h2>
                            <p class="uk-article-meta">{{__('Written on')}} <time datetime="2018-03-26T02:55:01+00:00">{{ \Carbon\Carbon::parse($post->created_at)->toFormattedDateString()}}</time>. {{__('Posted in')}} <a href="blog/category-1.html" rel="category">{{ $post->category->name }}</a>.</p>
                        </div>
                        <div class="uk-container uk-container-small">
                            <div property="text {{ Session::get('locale') == 'en' ? 'uk-text-left' : 'uk-text-right' }}">
                                {!! str_limit(Session::get('locale') == 'en' ?  $post->body :  $post->body_ar, 40, '...'); !!}
                            </div>
                            <p class="uk-margin-medium {{ Session::get('locale') == 'en' ? 'uk-text-left' : 'uk-text-right' }}">
                                <a class="uk-button uk-button-text" href="{{ route('frontend.news.category.blog', [$post->category->slug, $post->slug]) }}">{{__('Continue reading')}}</a>
                            </p>
                        </div>
                    </article>
                </div>
                @endforeach
            </div>
            <ul class="uk-pagination uk-margin-large uk-flex-center">
                    {{ $posts->links() }}
            </ul>
        </div>
@endsection
