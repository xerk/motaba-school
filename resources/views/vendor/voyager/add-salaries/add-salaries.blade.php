@extends('voyager::master')
@include('vendor.layout.layout')
@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="icon voyager-bell"></i> Add Salaries
        </h1>
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
    <div id="app">
        <add-salary></add-salary>
    </div>
@stop

@section('javascript')
<script src="{{ asset('js/lang.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.17/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.6/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/keytable/2.4.0/js/dataTables.keyTable.min.js"></script>
<script src="https://cdn.datatables.net/autofill/2.3.0/js/dataTables.autoFill.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="{{asset('plugins/editor/js/dataTables.editor.min.js')}}"></script>

<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.bootstrap.min.js"></script>
<script src="{{asset('plugins/editor/js/dataTables.editor.min.js')}}"></script>
{{-- <script src="{{asset('plugins/editor/js/editor.bootstrap.min.js')}}"></script> --}}
<script type="text/javascript" language="javascript" src="{{ asset('control/examples/resources/syntax/shCore.js') }}"></script>
<script type="text/javascript" language="javascript" src="{{ asset('control/examples/resources/demo.js') }}"></script>
{{-- <script type="text/javascript" language="javascript" src="{{ asset('control/examples/resources/editor-demo.js') }}"></script> --}}

<script type="text/javascript" language="javascript" class="init">
        // var editor;

    </script>
@stop