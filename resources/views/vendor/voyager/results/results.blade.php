@extends('voyager::master')
@include('vendor.layout.layout')
@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="icon voyager-bell"></i> {{__('Results')}}
        </h1>
        <form method="POST" class="form-group" enctype="multipart/form-data" action="{{ route('import.results') }}">
            {{ csrf_field() }}
            <input id="upload" name="file" type="file"/>
            <button type="submit" id="upload_link" class="btn btn-success btn-add-new">
                <i class="voyager-plus"></i> <span>{{ __('Import') }}</span>
            </button>
        </form>
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
    <div id="app">
        <results></results>
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
// $(function(){
//     $("#upload_link").on('click', function(e){
//         e.preventDefault();
//         $("#upload:hidden").trigger('click');
//     });
// });
</script>
@stop
