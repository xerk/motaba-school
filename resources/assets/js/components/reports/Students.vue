<template>
    <div class="row">
    <div class="col-md-12">
        <div class="panel panel-bordered">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover dataTable no-footer display nowrap" id="users-table">
                        <thead>
                            <tr style="display:none">
                                <th>{{ trans('reports.Student Name')}}</th>
                                <th>{{ trans('reports.Last Name')}}</th>
                                <th>{{ trans('reports.Situation')}}</th>
                                <th>{{ trans('reports.National')}}</th>
                                <th>{{ trans('reports.Gender')}}</th>
                                <th>{{ trans('reports.Birth')}}</th>
                                <th colspan="3">{{ trans('reports.Data Oct')}}</th>
                                <th>{{ trans('reports.Address')}}</th>
                                <th>{{ trans('reports.National ID')}}</th>
                            </tr>
                            <tr>
                                <th>{{ trans('reports.Student Name')}}</th>
                                <th>{{ trans('reports.Last Name')}}</th>
                                <th>{{ trans('reports.Situation')}}</th>
                                <th>{{ trans('reports.National')}}</th>
                                <th>{{ trans('reports.Gender')}}</th>
                                <th>{{ trans('reports.Birth')}}</th>

                                <th>{{ trans('reports.Day')}}</th>
                                <th>{{ trans('reports.Month')}}</th>
                                <th>{{ trans('reports.Year')}}</th>
                               
                                <th>{{ trans('reports.Address')}}</th>
                                <th>{{ trans('reports.National ID')}}</th>
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
                    ajax: `http://localhost:8000/admin/get_students?class=${classEdu}&classroom=${classRoom}`,
                    columns: [
                        { data: 'name', name: 'name' },
                        { data: 'last_name', name: 'last_name' },
                        { data: 'status', name: 'status',
                            "render": function (val, type, row) {
                                if (val == 1) {
                                    return "New";
                                } else if (val == 2) {
                                    return "Transported";                                    
                                } else if (val == 3) {
                                    return "Newcomer";                                    
                                }
                            }
                        },
                        { data: 'nationality', name: 'nationality' },
                        { data: "gender", name: 'gender',
                            "render": function (val, type, row) {
                                if (val == null) {
                                    return "Nothing";
                                } else {
                                    return val == 1 ? "Male" : "Female";
                                }
                            }
                        },
                        { data: 'birth_date', name: 'birth_date' },
                        { data: 'birth_date', name: 'birth_date',
                        'render': function (val, type, row) {
                            var birth = new Date(val); // Year From BirthDate
                            var today = new Date();    
                            var oct = new Date(today.getFullYear() + '-10-1');
                            return oct.getDay() - (birth.getDay() - 3);
                        } },
                        { data: 'birth_date', name: 'birth_date',
                            'render': function (val, type, row) {
                                var birth = new Date(val); // Year From BirthDate
                                var today = new Date();    
                                var oct = new Date(today.getFullYear() + '-10-1');
                                console.log(birth.getDay());
                                return (oct.getMonth() + 1) - (birth.getMonth() + 1);
                            } },
                        { data: 'birth_date', name: 'birth_date',
                            'render': function (val, type, row) {
                                var birth = new Date(val); // Year From BirthDate
                                var today = new Date()    
                                var oct = new Date(today.getFullYear() + '-10-1')
                                return oct.getFullYear() - birth.getFullYear();
                            } },
                        
                        { data: 'address', name: 'address' },
                        { data: 'national_id', name: 'national_id' },

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
