@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.'Attentions')

@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
<link rel="stylesheet" href="{{ asset('css/buttons.dataTables.min.css') }}">
@stop

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="icon voyager-bell"></i> Attentions
        </h1>
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
<div id="app">
    {{-- <attention :link="'{{ Request::root() }}'"></attention> --}}
    <router-view name="content-viewport" :link="'{{ Request::root() }}'"></router-view>    
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
<script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
@stop