@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.'System Configs')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="icon voyager-settings"></i> System Configs
        </h1>
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
<div id="app">
    <system-configs :link="'{{ Request::root() }}'"></system-configs>    
</div>
@stop

@section('javascript')
<script src="{{ mix('js/app.js') }}"></script>
@stop