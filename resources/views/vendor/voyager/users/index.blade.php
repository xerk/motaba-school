@extends('voyager::master')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.6/css/select.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/keytable/2.4.0/css/keyTable.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/autofill/2.3.0/css/autoFill.dataTables.min.css">
<link rel="stylesheet" href="/plugins/editor/css/dataTables.editor.css">
<link rel="stylesheet" href="/plugins/editor/css/editor.bootstrap.css">
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>

@stop
@section('content')
    <div class="container">
        {{$dataTable->table(['id' => 'users'])}}
        {{__('voyager::generic.viewing')}}
    </div>
    @stop

@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.4/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/keytable/2.4.0/js/dataTables.keyTable.min.js"></script>
<script src="https://cdn.datatables.net/autofill/2.3.0/js/dataTables.autoFill.min.js"></script>
<script src="{{asset('plugins/editor/js/dataTables.editor.js')}}"></script>

<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.bootstrap.min.js"></script>

<script src="{{asset('plugins/editor/js/editor.bootstrap.min.js')}}"></script>
<script>
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        });

        var editor = new $.fn.dataTable.Editor({
            ajax: "/admin/users-2",
            table: "#users",
            display: "bootstrap",
            fields: [
                {label: "Name:", name: "name"},
                {label: "Email:", name: "email"},
                {label: "Password:", name: "password", type: "password"}
            ]
        });

        $('#users').on('click', 'tbody td:not(:first-child)', function (e) {
            editor.inline(this);
        });

        {{$dataTable->generateScripts()}}
    })
</script>
@stop