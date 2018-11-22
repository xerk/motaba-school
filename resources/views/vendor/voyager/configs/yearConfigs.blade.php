@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.'Year Configs')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="icon voyager-settings"></i> Year Configs
        </h1>
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
<div id="app">
    <year-configs :link="'{{ Request::root() }}'"></year-configs>    
</div>
@stop

@section('javascript')
<script src="{{ mix('js/app.js') }}"></script>
@stop