<template>
    <div class="page-content browse container-fluid">
        <div class="lecture-select-box">
            <router-link @click.native="next" style="padding: 5px 10px;" :title="trans('reports.Next')" class="btn btn-sm  btn-primary pull-right edit" tag="a" :to="{path: '/admin/absent_employees_month', query: {'month': month+1,}}">
                <span class="hidden-xs hidden-sm"></span> <i class="voyager-double-right"></i>
            </router-link>
            <router-link @click.native="prev" style="padding: 5px 10px;" :title="trans('reports.Prev')" class="btn btn-sm  btn-primary pull-right edit" tag="a" :to="{path: '/admin/absent_employees_month', query: {'month': month-1,}}">
                <i class="voyager-double-left"></i> <span class="hidden-xs hidden-sm"></span>
            </router-link>
            <button class="btn btn-sm disabled" style="padding: 4px 15px;">{{ new Date() | moment("add", month+" months", "(MM) MMMM - YYYY") }}</button>
        </div>
        <div class="content-header" style="display: none">
            <div class="row">
                <div class="col-print-4 col-sm-4 pull-left" style="padding-left: 10px">
                    <img src="https://kamel-ouda.com/images/logo/PNG-24.png" alt="Logo" style="width:100px" class='img-responsive' />
                </div>
                <div class="col-print-4 col-sm-4 text-center">
                    <!-- <h3><span v-if="classRoom != ''">{{user.class_room.name}} من</span> <span v-if="classEdu != ''">{{user.class_edu.name}}</span> عام {{ new Date() | moment("YYYY") }}/{{ new Date() | moment("add", "1 year","YYYY") }} م</h3> -->
                </div>
                <div class='col-print-4 col-sm-4' style="padding-right: 10px">
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
                <div class="col-print-6 col-sm-6 text-center" style="padding-left: 10px">
                    <ul class="list-unstyled">
                        <li>عميد المعهد</li>
                        <li>أ/سعيد عيسي</li>
                    </ul>
                </div>
                <div class='col-print-6 col-sm-6 text-center' style="padding-right: 10px">
                    <ul class="list-unstyled">
                        <li>شئون العاملين</li>
                        <li>أ/عبير السيد</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover dataTable no-footer display nowrap" id="users-table">
                                <thead>
                                    <tr>
                                        <th>أسم الموظف</th>
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
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            month: 0,
        }
    },
    mounted() {
        this.fetch()
    },
    methods: {
        fetch() {
            var classEdu = this.classEdu
            var classRoom = this.classRoom
            var month = this.month
            $(function() {
                $('#users-table').DataTable({
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
                        visible: false
                    } ],
                    processing: false,
                    serverSide: false,
                    ajax: `https://kamel-ouda.com/admin/get-employee-absent-month?month=${month}`,
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
            this.month++
            $('#users-table').DataTable().destroy();
            this.fetch()
        },
        prev() {
            this.month--
            $('#users-table').DataTable().destroy();
            this.fetch()
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
