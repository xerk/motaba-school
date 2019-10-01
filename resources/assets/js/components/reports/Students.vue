<template>
    <div class="row">
    <div class="col-md-12">
        <div class="panel panel-bordered">
            <div class="panel-body">
                <h3 class="text-center">سجل الطلاب</h3>
                <h3 class="text-center"><span v-if="classEdu != ''">{{user.class_edu.name}}</span> <span v-if="classRoom != ''">- {{user.class_room.name}}</span></h3>
                <div class="content-header" style="display: none">
                    <div class="row">
                        <div class="col-sm-4 pull-left">
                            <img src="https://kame-ouda.com/images/logo/PNG-24.png" alt="Logo" style="width:100px" class='img-responsive' />
                        </div>
                        <div class="col-sm-4 text-center">
                            <h3 class="text-center">سجل الطلاب</h3>
                            <h3 class="text-center"><span v-if="classEdu != ''">{{user.class_edu.name}}</span> <span v-if="classRoom != ''">- {{user.class_room.name}}</span></h3>
                        </div>
                        <div class='col-sm-4' style="font-size: 18px">
                            <ul class="list-unstyled text-center pull-right">
                                <li>الأزهر الشريف</li>
                                <li>منطقة الجيزه الأزهريه</li>
                                <li>معهد كامل عودة الأزهري الخاص</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="content-footer" style="display:none">
                    <div class="row">
                        <div class="col-sm-4 text-center" style="font-size: 18px">
                            <ul class="list-unstyled">
                                <li>عميد المعهد</li>
                                <li>أ/سعيد عيسي</li>
                            </ul>
                        </div>
                        <div class="col-sm-4 text-center">
                        </div>
                        <div class='col-sm-4 text-center' style="font-size: 18px">
                            <ul class="list-unstyled">
                                <li>شئون الطلبة</li>
                                <li>أ/جيهان عبد الحميد&nbsp; أ/عطيلت عز الرجال</li>
                            </ul>
                        </div>
                    </div>
                </div>
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
                                <th>أسم الطالب</th>
                                <th>الأسم الاخير</th>
                                <th>تاريخ الميلاد</th>

                                <th>اليوم</th>
                                <th>الشهر</th>
                                <th>السنة</th>

                                <th>الحالة</th>
                                <th>الجنسية</th>
                                <th>تاريخ الالتحاق</th>
                                <th>النوع</th>
                                <th>العنوان</th>
                                <th>تليفون الأب</th>
                                <th>تليفون الأم</th>
                                <th>وظيفة الأب</th>

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
            get: {
                apiURL: 'report-users',
            },
            user: {
                class_room: {
                    name: ''
                },
                class_edu: {
                    name: ''
                }
            },
            stageEdu: localStorage.stageEdu,
            classEdu: localStorage.classEdu,
            classRoom: localStorage.classRoom,
        }
    },
    mounted() {
        this.fetch()
        this.getUsers()
    },
    methods: {
        parsist(stageEdu, classEdu, classRoom) {
                this.stageEdu = stageEdu
                this.classEdu = classEdu
                this.classRoom = classRoom
                $('#users-table').DataTable().destroy();
                this.fetch()
            },
        getUsers() {
            this.$store.dispatch('retriveUser', {
                get: this.get,
                classEdu: this.classEdu,
                classRoom: this.classRoom
            })
            .then(response => {
                this.user = response.data
            })
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
                            exportOptions: {
                                columns: ':visible'
                            },
                            customize: function (win) {
                                    $(win.document.body)
                                    .css('font-size', '11px')
                                $(win.document.body).find('div').first()
                                    .prepend( $( ".content-header" ).clone().css('display', 'block') )

                                $(win.document.body).find('div').last()
                                    .prepend( $( ".content-footer" ).clone().css('display', 'block') )

                                $(win.document.body).find('h1')
                                    .css('display', 'none')
                                $(win.document.body).find('th')
                                    .addClass('compact')
                                    .css('text-align', 'right')
                                $(win.document.body).find('td')
                                    .addClass('compact')
                                    .css('text-align', 'right')
                                $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('direction', 'rtl')

                            }
                        },
                        {
                            extend: 'copy',
                            text: '<i class="fa fa-clone" aria-hidden="true"></i> نسخ',
                            exportOptions: {
                                columns: ':visible'
                            },
                        },
                        {
                            extend: 'excel',
                            text: '<i class="fa fa-table" aria-hidden="true"></i> أكسيل',
                            exportOptions: {
                                columns: ':visible'
                            },
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
                    paging: false,
                    serverSide: false,
                    ajax: `https://kame-ouda.com/admin/get-students?class=${classEdu}&classroom=${classRoom}`,
                    columns: [
                        { data: length, defaultContent: '' },
                        { data: 'name', name: 'name' },
                        { data: 'last_name', name: 'last_name' },
                        { data: 'birth_date', name: 'birth_date' },
                        { data: 'birth_date', name: 'birth_date',
                        'render': function (val, type, row) {
                            var birth = new Date(val); // Year From BirthDate
                            var today = new Date();
                            var oct = new Date(today.getFullYear() + '/10/1');
                            return birth.getDate() - oct.getDate();
                        } },
                        { data: 'birth_date', name: 'birth_date',
                            'render': function (val, type, row) {
                                var birth = new Date(val); // Year From BirthDate
                                var today = new Date();
                                var oct = new Date(today.getFullYear() + '/10/1');
                                return Math.abs(oct.getMonth() - birth.getMonth());
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
                        { data: 'nationality', name: 'nationality' },
                        { data: 'joining_date', name: 'joining_date',
                            "render": function (val, type, row) {
                                var join = new Date(val);
                                return join.getFullYear();
                            } },
                        { data: "gender", name: 'gender',
                            "render": function (val, type, row) {
                                if (val == null) {
                                    return "Nothing";
                                } else {
                                    return val == 1 ? "ذكر" : "إنثى";
                                }
                            }
                        },
                        { data: 'address', name: 'address' },
                        { data: 'father_mobile', name: 'father_mobile' },
                        { data: 'mother_mobile', name: 'mother_mobile' },
                        { data: 'father_job', name: 'father_job' },


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
<style>
@media print {
    .content-header {
        display: block !important
    }
}
</style>


