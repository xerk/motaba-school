@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '. (Auth::user()->settings['locale'] == 'ar' ? $dataType->display_name_ar_plural : $dataType->display_name_plural))

@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@stop

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> {{ Auth::user()->settings['locale'] == 'ar' ? $dataType->display_name_ar_plural : $dataType->display_name_plural }}
        </h1>
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
<div id="app">
    <timetables :link="'{{ Request::root() }}'"></timetables>
</div>
@stop

@section('javascript')
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('js/lang.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script>
</script>
@stop
