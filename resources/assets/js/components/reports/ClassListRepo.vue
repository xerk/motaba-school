<template>
    <div class="row">
    <div class="col-md-12">
        <div class="panel panel-bordered">
            <div class="panel-body">
                <h3 class="text-center"><span v-if="classEdu != ''">{{user.class_edu.name}}</span> - <span v-if="classRoom != ''">{{user.class_room.name}}</span></h3>
                <div class="content-header" style="display: none">
                    <div class="row">
                        <div class="col-print-4 pull-left" style="padding-left: 10px">
                            <img src="https://kamel-ouda.com/images/logo/PNG-24.png" alt="Logo" style="width:100px" class='img-responsive' />
                        </div>
                        <div class="col-print-4 text-center">
                            <h3 class="text-center"><span v-if="classEdu != ''">{{user.class_edu.name}}</span> - <span v-if="classRoom != ''">{{user.class_room.name}}</span></h3>
                        </div>
                        <div class='col-print-4' style="padding-right: 10px">
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
                        <div class="col-print-6 text-center" style="padding-left: 10px">
                            <ul class="list-unstyled">
                                <li>عميد المعهد</li>
                                <li>أ/سعيد عيسي</li>
                            </ul>
                        </div>
                        <div class='col-print-6 text-center' style="padding-right: 10px">
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
                                <th></th>
                                <th>أسم الطالب</th>
                                <th>الأسم الاخير</th>
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
                                    .prepend( $( ".content-header" ).clone().css('display', 'inline') )

                                $(win.document.body).find('div').last()
                                    .prepend( $( ".content-footer" ).clone().css('display', 'inline') )

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
                    paging: false,
                    serverSide: false,
                    ajax: `https://kamel-ouda.com/admin/get-students?class=${classEdu}&classroom=${classRoom}`,
                    columns: [
                        { data: length, defaultContent: '' },
                        { data: 'name', name: 'name' },
                        { data: 'last_name', name: 'last_name' },

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
<style lang="postcss">
@media print {
    * {
        font-size: 14px;
    }
    table {
        border: 2px solid #000;
        padding: 20px;
    }
    .col-print-1 {width:8%;  float:left;}
    .col-print-2 {width:16%; float:left;}
    .col-print-3 {width:25%; float:left;}
    .col-print-4 {width:33%; float:left;}
    .col-print-5 {width:42%; float:left;}
    .col-print-6 {width:50%; float:left;}
    .col-print-7 {width:58%; float:left;}
    .col-print-8 {width:66%; float:left;}
    .col-print-9 {width:75%; float:left;}
    .col-print-10{width:83%; float:left;}
    .col-print-11{width:92%; float:left;}
    .col-print-12{width:100%; float:left;}
}
</style>
