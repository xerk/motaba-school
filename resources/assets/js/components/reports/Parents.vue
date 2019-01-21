<template>
    <div class="row">
    <div class="col-md-12">
        <div class="panel panel-bordered">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover dataTable no-footer display nowrap" id="users-table">
                        <thead>
                            <tr>
                                <th>{{ trans('reports.Student Name')}}</th>
                                <th>{{ trans('reports.Last Name')}}</th>
                                <th>{{ trans('reports.Father Name')}}</th>
                                <th>{{ trans('reports.Father Job')}}</th>
                                <th>{{ trans('reports.Father Mobile')}}</th>
                                <th>{{ trans('reports.Father Tel')}}</th>
                                <th>{{ trans('reports.Qualified Father')}}</th>
                                <th>{{ trans('reports.Mother Name')}}</th>
                                <th>{{ trans('reports.Mother Job')}}</th>
                                <th>{{ trans('reports.Mother Mobile')}}</th>
                                <th>{{ trans('reports.Mother Tel')}}</th>
                                <th>{{ trans('reports.Qualified Mother')}}</th>
                                <th>{{ trans('reports.Mobile')}}</th>
                                <th>{{ trans('reports.Tel')}}</th>
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
                        visible: false
                    } ],
                    processing: false,
                    serverSide: true,
                    ajax: `https://kamel-ouda.com/admin/get_students?class=${classEdu}&classroom=${classRoom}`,
                    columns: [
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
                        { data: 'mobile', name: 'mobile' },
                        { data: 'tel', name: 'tel' },

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
                            "targets": 0
                        },
                    
                        { "visible": false,  "targets": [ 1 ] },
                    ],
                });
            });
        }
    },
}
</script>
