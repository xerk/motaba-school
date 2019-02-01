@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.'Employee Attendance')

@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
@stop

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="icon voyager-check"></i> Employee Attendance
        </h1>
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
<div id="app">
    <e-attendance :link="'{{ Request::root() }}'"></e-attendance>
</div>
@stop

@section('javascript')
<script src="{{ mix('js/app.js') }}"></script>
@stop