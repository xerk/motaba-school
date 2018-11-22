@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.'Students Attendance')

@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
@stop

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="icon voyager-check"></i> Students Attendance
        </h1>
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
<div id="app">
    <attendance :link="'{{ Request::root() }}'"></attendance>
</div>
@stop

@section('javascript')
<script src="{{ mix('js/app.js') }}"></script>
@stop