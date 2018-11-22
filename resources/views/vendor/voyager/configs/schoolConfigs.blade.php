@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.'School Configs')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="icon voyager-settings"></i> School Configs
        </h1>
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
<div id="app">
    <school-configs :link="'{{ Request::root() }}'"></school-configs>
    @include('voyager::fab.fab')
</div>
@stop

@section('javascript')
<script src="{{ mix('js/app.js') }}"></script>
@stop