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
                                <th>{{ trans('reports.Father Name')}} أسم الأب</th>
                                <th>{{ trans('reports.Father Job')}} وظيفة الأب</th>
                                <th>{{ trans('reports.Father Mobile')}} محمول الأب</th>
                                <th>{{ trans('reports.Father Tel')}} تليقون الأب</th>
                                <th>{{ trans('reports.Qualified Father')}} مؤهل الأب</th>
                                <th>{{ trans('reports.Mother Name')}}أسم الأم</th>
                                <th>{{ trans('reports.Mother Job')}}وظيفة الأم</th>
                                <th>{{ trans('reports.Mother Mobile')}} محمول الأم</th>
                                <th>{{ trans('reports.Mother Tel')}}تليفون الأم</th>
                                <th>{{ trans('reports.Qualified Mother')}} مؤهل الأم</th>
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
                    ajax: `http://localhost:8000/admin/get-students?class=${classEdu}&classroom=${classRoom}`,
                    columns: [
                        { data: null },
                        { data: 'name', name: 'name' },
                        { data: 'last_name', name: 'last_name' },
                        { data: 'last_name', name: 'last_name' },
                        { data: "father_job", name: 'father_job'},
                        { data: 'father_mobile', name: 'father_mobile' },
                        { data: 'father_tel', name: 'father_tel'},
                        { data: 'father_qualified', name: 'father_qualified'},
                        { data: 'father_qualified', name: 'father_qualified'},
                        { data: 'mother_job', name: 'mother_job'},
                        { data: 'mother_mobile', name: 'mother_mobile' },
                        { data: 'mother_tel', name: 'mother_tel' },
                        { data: 'mother_qualified', name: 'mother_qualified' },

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
                    } );
                } ).draw();
            });
        }
    },
}
</script>
