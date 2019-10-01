@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '. (Auth::user()->settings['locale'] == 'ar' ? $dataType->display_name_ar_plural : $dataType->display_name_plural))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> {{ Auth::user()->settings['locale'] == 'ar' ? $dataType->display_name_ar_plural : $dataType->display_name_plural }}
        </h1>
        @can('add',app($dataType->model_name))
            <a href="{{ route('voyager.'.$dataType->slug.'.create') }}" class="btn btn-success btn-add-new">
                <i class="voyager-plus"></i> <span>{{ __('voyager::generic.add_new') }}</span>
            </a>
        @endcan
        @can('delete',app($dataType->model_name))
            @include('voyager::partials.bulk-delete')
        @endcan
        @can('edit',app($dataType->model_name))
        @if(isset($dataType->order_column) && isset($dataType->order_display_column))
            <a href="{{ route('voyager.'.$dataType->slug.'.order') }}" class="btn btn-primary">
                <i class="voyager-list"></i> <span>{{ __('voyager::bread.order') }}</span>
            </a>
        @endif
        @endcan
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
<div id="app">
    <router-view name="content-viewport" :link="'{{ Request::root() }}'"></router-view>    
</div>
@stop

@section('javascript')
<script src="{{ mix('js/app.js') }}"></script>
@stop
