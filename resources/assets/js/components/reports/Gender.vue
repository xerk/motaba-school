<template>
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover dataTable no-footer display nowrap" id="users-table">
                                <thead>
                                    <tr>
                                        <th>{{ trans('reports.Class Name')}}اسم الصف</th>
                                        <th>{{ trans('reports.Class Name')}}اسم الصف</th>
                                        <th>{{ trans('reports.Male')}}ذكر</th>
                                        <th>{{ trans('reports.Female')}}إنثى</th>
                                        <th>{{ trans('reports.Total')}}الأجمالى</th>
                                        <th>{{ trans('reports.Class Room')}}الفصول</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
        }
    },
    mounted() {
        this.fetch()
    },
    methods: {
        fetch() {
            $(function() {
                $('#users-table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'print',
                            text: '<i class="fa fa-print" aria-hidden="true"></i> طباعة',
                            html: '<i></i>',
                            exportOptions: {
                                columns: ':visible'
                            },
                        },
                        {
                            extend: 'copy',
                            text: '<i class="fa fa-clone" aria-hidden="true"></i> نسخ',
                        },
                        {
                            extend: 'excel',
                            text: '<i class="fa fa-table" aria-hidden="true"></i> أكسيل',
                        },
                        {
                            extend: 'colvis',
                            text: '<i class="fa fa-check-square" aria-hidden="true"></i> أختيار العمود',
                        }
                    ],
                    columnDefs: [ {
                        visible: false,
                        targets: 0,
                    } ],
                    processing: false,
                    serverSide: false,
                    ajax: `http://localhost:8000/admin/get-gender`,
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'name', name: 'name' },
                        { data: 'maleStudents', name: 'maleStudents' },
                        { data: 'femaleStudents', name: 'femaleStudents' },
                        { data: null },
                        { data: 'classRoomCount', name: 'classRoomCount' },
                    ],
                    "columnDefs": [
                        {
                            // The `data` parameter refers to the data for the cell (defined by the
                            // `data` option, which defaults to the column being worked with, in
                            // this case `data: 0`.
                            "render": function ( data, type, row ) {
                                return +row.maleStudents + +row.femaleStudents;
                            },
                            "targets": 4
                        },
                        { "visible": false,  "targets": [ 0 ] },
                    
                    ],
                });
            });
        },
    },
}
</script>
