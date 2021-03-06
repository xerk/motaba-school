@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.'Expenses')

@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
@stop

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="icon voyager-bell"></i> {{ __('expenses.name') }}
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
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ route('assets.lang') }}"></script>
@stop