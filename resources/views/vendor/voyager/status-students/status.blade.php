@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.'Link Teachers')

@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
<link rel="stylesheet" href="{{asset('css/listbox.css')}}">
@stop

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="icon voyager-bell"></i> Link Teachers
        </h1>
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
<div id="app">
    <status-students :link="'{{ Request::root() }}'"></status-students>    
</div>
@stop

@section('javascript')
<script src="{{ mix('js/app.js') }}"></script>
@stop