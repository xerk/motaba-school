<template>
    <div class="row">
    <div class="col-md-12">
        <div class="panel panel-bordered">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover dataTable no-footer display nowrap" id="users-table">
                        <thead>
                            <tr style="display:none">
                                <th>{{ trans('reports.Student Name')}}أسم الطالب</th>
                                <th>{{ trans('reports.Last Name')}}الأسم الاخير</th>
                                <th>{{ trans('reports.Birth')}}تاريخ الميلاد</th>
                                <th colspan="3">{{ trans('reports.Data Oct')}}السن في أول اكتوبر</th>
                                <th>{{ trans('reports.Situation')}}الحالة</th>
                                <th>{{ trans('reports.National')}}الجنسية</th>
                                <th>{{ trans('reports.Gender')}}النوع</th>
                                <th>{{ trans('reports.Address')}}العنوان</th>
                                <th>{{ trans('reports.Father Mobile')}}تليفون الأب</th>
                                <th>{{ trans('reports.Mother Mobile')}}تليفون الأم</th>
                                <th>{{ trans('reports.Joining Date')}}وظيفة الأب</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>{{ trans('reports.Student Name')}}أسم الطالب</th>
                                <th>{{ trans('reports.Last Name')}}الأسم الأخير</th>
                                <th>{{ trans('reports.Birth')}}تاريخ الميلاد</th>

                                <th>{{ trans('reports.Day')}}يوم</th>
                                <th>{{ trans('reports.Month')}}شهر</th>
                                <th>{{ trans('reports.Year')}}سنة</th>

                                <th>{{ trans('reports.Situation')}}الحالة</th>
                                <th>{{ trans('reports.National')}}سنة الألتحاق</th>
                                <th>{{ trans('reports.Joining Date')}}الجنسية</th>
                                <th>{{ trans('reports.Gender')}}النوع</th>
                                <th>{{ trans('reports.Address')}}العنوان</th>
                                <th>{{ trans('reports.Father Mobile')}}تليفون الأب</th>
                                <th>{{ trans('reports.Mother Mobile')}}تليفون الأم</th>
                                <th>{{ trans('reports.Joining Date')}}وظيفة الأب</th>
                               
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
                    ajax: `https://kamel-ouda.com/admin/get-students?class=${classEdu}&classroom=${classRoom}`,
                    columns: [
                        { data: length, defaultContent: '' },
                        { data: 'name', name: 'name' },
                        { data: 'last_name', name: 'last_name' },
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
                                return (oct.getMonth() + 1) - (birth.getMonth() + 1);
                            } },
                        { data: 'birth_date', name: 'birth_date',
                            'render': function (val, type, row) {
                                var birth = new Date(val); // Year From BirthDate
                                var today = new Date()    
                                var oct = new Date(today.getFullYear() + '-10-1')
                                return oct.getFullYear() - birth.getFullYear();
                            } },
                        { data: 'status', name: 'status',
                            "render": function (val, type, row) {
                                if (val == 1) {
                                    return "مستجد";
                                } else if (val == 2) {
                                    return "منقول";                                    
                                } else if (val == 3) {
                                    return "وافد";                                    
                                } else if (val == 4) {
                                    return "محول";                                    
                                } else if (val == 5) {
                                    return "راسب";                                    
                                }
                            }
                        },
                        { data: 'joining_date', name: 'joining_date',
                            "render": function (val, type, row) {
                                var join = new Date(val);
                                return join.getFullYear();
                            } },
                        { data: 'nationality', name: 'nationality' },
                        { data: "gender", name: 'gender',
                            "render": function (val, type, row) {
                                if (val == null) {
                                    return "Nothing";
                                } else {
                                    return val == 1 ? "ذكر" : "إنثى";
                                }
                            }
                        },
                        { data: 'father_mobile', name: 'father_mobile' },
                        { data: 'mother_mobile', name: 'mother_mobile' },
                        { data: 'father_job', name: 'father_job' },
                        
                        { data: 'address', name: 'address' },

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
