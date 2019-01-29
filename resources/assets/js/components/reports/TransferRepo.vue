<template>
    <div class="row">
    <div class="col-md-12">
        <div class="panel panel-bordered">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover dataTable no-footer display nowrap" id="users-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>{{ trans('reports.Student Name')}}أسم الطالب</th>
                                <th>{{ trans('reports.Last Name')}} الأسم الاخير</th>
                                <th>{{ trans('reports.Father Name')}}الجنسية</th>
                                <th>{{ trans('reports.Father Job')}}تاريخ الميلاد</th>
                                <th>{{ trans('reports.Father Mobile')}}الرقم الفومى</th>
                                <th>{{ trans('reports.Father Tel')}}العنوان</th>
                                <th>{{ trans('reports.Father Tel')}}المرحلة</th>
                                <th>{{ trans('reports.Father Tel')}}الصف</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <fab @parsist="parsist"></fab>
</div>
</template>

<script>
import Fab from '../fab/Fab'
export default {
    components: {Fab},
    data() {
        return {
            stageEdu: localStorage.stageEdu,
            classEdu: localStorage.classEdu,
            classRoom: localStorage.classRoom,
        }
    },
    mounted() {
        this.fetch()
    },
    methods: {
        parsist(stageEdu, classEdu, classRoom) {
                this.stageEdu = stageEdu
                this.classEdu = classEdu
                this.classRoom = classRoom
                $('#users-table').DataTable().destroy();
                this.fetch()
            },
        fetch() {
            var classEdu = this.classEdu  
            var classRoom = this.classRoom  
            $(function() {
                var t = $('#users-table').DataTable({
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
                    ajax: `http://localhost:8000/admin/get-transfer?class=${classEdu}&classroom=${classRoom}`,
                    columns: [
                        { data: length, defaultContent: '' },
                        { data: 'name', name: 'name' },
                        { data: 'last_name', name: 'last_name' },
                        { data: "nationality", name: 'nationality'},
                        { data: 'birth_date', name: 'birth_date' },
                        { data: 'national_id', name: 'national_id' },
                        { data: 'address', name: 'address' },
                        { data: 'stage_edu.name', name: 'stage_edu.name' },
                        { data: 'class_edu.name', name: 'class_edu.name' },

                    ],
                    "columnDefs": [
                        {
                            // The `data` parameter refers to the data for the cell (defined by the
                            // `data` option, which defaults to the column being worked with, in
                            // this case `data: 0`.
                            "render": function ( data, type, row ) {
                                if (row.last_name == null) {
                                    return row.name;
                                } else {
                                    return row.name +' '+ row.last_name;
                                }
                            },
                            "targets": 1
                        },
                    
                        { "visible": false,  "targets": [ 2 ] },
                    ],
                });
                t.on( 'order.dt search.dt', function () {
                    t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                        cell.innerHTML = i+1;
                        t.cell(cell).invalidate('dom'); 
                    } );
                } ).draw();
            });
        }
    },
}
</script>
