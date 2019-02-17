<template>
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="content-header" style="display: none">
                            <div class="row">
                                <div class="col-sm-4 pull-left">
                                    <img src="https://kamel-ouda.com/images/logo/PNG-24.png" alt="Logo" style="width:100px" class='img-responsive' />
                                </div>
                                <div class="col-sm-4 text-center">
                                    <!-- <h3>{{user.class_room.name}} من {{user.class_edu.name}} عام {{ new Date() | moment("YYYY") }}/{{ new Date() | moment("add", "1 year","YYYY") }} م</h3> -->
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
                                        <th>اسم الصف</th>
                                        <th>اسم الصف</th>
                                        <th>ذكر</th>
                                        <th>إنثى</th>
                                        <th>الأجمالى</th>
                                        <th>الفصول</th>
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
                    serverSide: false,
                    ajax: `https://kamel-ouda.com/admin/get-gender`,
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
