@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.'Employee Salary')

@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
@stop

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="icon voyager-bell"></i> Employee Salary
        </h1>
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
<div id="app">
    <router-view name="content-viewport" :link="'{{ Request::root() }}'"></router-view>    
</div>
@stop

@section('javascript')
<script src="{{ asset('js/lang.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
@stop