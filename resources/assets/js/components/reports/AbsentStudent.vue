<template>
    <div class="page-content browse container-fluid">
        <div class="lecture-select-box">
            <router-link @click.native="next" style="padding: 5px 10px;" :title="trans('reports.Next')" class="btn btn-sm  btn-primary pull-right edit" tag="a" :to="{path: '/admin/absent_students', query: {'day': day+1,}}">
                <span class="hidden-xs hidden-sm"></span> <i class="voyager-double-right"></i>
            </router-link>
            <router-link @click.native="prev" style="padding: 5px 10px;" :title="trans('reports.Prev')" class="btn btn-sm  btn-primary pull-right edit" tag="a" :to="{path: '/admin/absent_students', query: {'day': day-1,}}">
                <i class="voyager-double-left"></i> <span class="hidden-xs hidden-sm"></span>
            </router-link>
            <button class="btn btn-sm disabled" style="padding: 4px 15px;">{{ new Date() | moment("add", day+" days", "dddd, Do MM YY") }}</button>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <h3 class="text-center"><span v-if="classEdu != ''">{{user.class_edu.name}}</span> - <span v-if="classRoom != ''">{{user.class_room.name}}</span></h3>
                        <div class="content-header" style="display: none">
                            <div class="row">
                                <div class="col-sm-4 pull-left">
                                    <img src="https://kamel-ouda.com/images/logo/PNG-24.png" alt="Logo" style="width:100px" class='img-responsive' />
                                </div>
                                <div class="col-sm-4 text-center">
                                    <h3 class="text-center"><span v-if="classEdu != ''">{{user.class_edu.name}}</span> - <span v-if="classRoom != ''">{{user.class_room.name}}</span></h3>
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
                                    <tr>
                                        <th>أسم الطالب</th>
                                        <th>الأسم الاخير</th>
                                        <th>التاريخ</th>
                                        <th>الحالة</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <fab @parsist="parsist"></fab>
        </div>
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
            day: 0,
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
                this.getUsers()
            },
            getUsers() {
            this.$store.dispatch('retriveUser', {
                get: this.get,
                classRoom: this.classRoom,
                classEdu: this.classEdu
            })
            .then(response => {
                this.user = response.data
            })
        },
        fetch() {
            var classEdu = this.classEdu
            var classRoom = this.classRoom
            var day = this.day
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
                            customize: function (win) {
                                    $(win.document.body)
                                    .css('font-size', '11px')
                                $(win.document.body).find('div').first()
                                    .prepend( $( ".content-header" ).css('display', 'inline') )

                                $(win.document.body).find('div').last()
                                    .prepend( $( ".content-footer" ).css('display', 'inline') )

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
                                $(wim.document+'table').find('div')
                                    .addClass('compact')

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
                        visible: false
                    } ],
                    processing: false,
                    serverSide: false,
                    paging: true,
                    ajax: `https://kamel-ouda.com/admin/get-student-absent?day=${day}&class=${classEdu}&classroom=${classRoom}`,
                    columns: [
                        { data: 'users', name: 'users.name' },
                        { data: 'users', name: 'users.last_name' },
                        { data: 'attend_date', name: 'attend_date' },
                        { data: 'status', name: 'status',
                        "render": function (val, type, row) {
                                if (val == 3) {
                                    return '<span class="label label-danger">غائب</span>';
                                }
                            }
                        },
                    ],
                    "columnDefs": [
                        {
                            // The `data` parameter refers to the data for the cell (defined by the
                            // `data` option, which defaults to the column being worked with, in
                            // this case `data: 0`.
                            "render": function ( data, type, row ) {
                                if (row.users.last_name == null) {
                                    return row.users.name;
                                } else {
                                    return row.users.name +' '+ row.users.last_name;
                                }
                            },
                            "targets": 0
                        },

                        { "visible": false,  "targets": [ 1 ] },
                    ],
                });
            });
        },
        next() {
            this.day++
            $('#users-table').DataTable().destroy();
            this.fetch()
        },
        prev() {
            this.day--
            $('#users-table').DataTable().destroy();
            this.fetch()
        }
    },
}
</script>
