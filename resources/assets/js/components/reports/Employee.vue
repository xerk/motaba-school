<template>
    <div class="page-content browse container-fluid">
        <div class="content-header" style="display: none">
            <div class="row">
                <div class="col-print-4 col-sm-4 pull-left" style="padding-left: 10px">
                    <img src="https://kamel-ouda.com/images/logo/PNG-24.png" alt="Logo" style="width:100px" class='img-responsive' />
                </div>
                <div class="col-print-4 col-sm-4 text-center">
                    <h3 class="text-center">{{reportName}}</h3>
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
            <!-- <div class="row">
                <div class="col-print-6 col-sm-6 text-center" style="padding-left: 10px">
                    <ul class="list-unstyled">
                        <li>عميد المعهد</li>
                        <li>أ/{{seg1}}</li>
                    </ul>
                </div>
                <div class='col-print-6 col-sm-6 text-center' style="padding-right: 10px">
                    <ul class="list-unstyled">
                        <li>شئون العاملين</li>
                        <li>أ/{{seg2}}</li>
                    </ul>
                </div>
            </div> -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group  col-md-4">
                    <label for="name">اسم الكشف</label>                                            
                    <input @keyup="segenSave" required="" type="text" v-model="reportName" class="form-control" name="title" placeholder="اسم الكشف" value="">
                </div>
                <div class="form-group  col-md-4">
                    <label for="name">توقيع العميد</label>                                            
                    <input @keyup="segenSave" required="" type="text" v-model="seg1" class="form-control" name="title" placeholder="توقيع العميد" value="">
                </div>
                <div class="form-group  col-md-4">
                    <label for="name">التوقيع الثاني</label>                                            
                    <input @keyup="segenSave" required="" type="text" v-model="seg2" class="form-control" name="title" placeholder="التوقيع الثاني" value="">
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <h3 class="text-center">{{reportName}}</h3>
                        <div class="table-responsive">
                            <table class="table table-hover dataTable no-footer display nowrap" id="users-table">
                                <thead>
                                    <tr>
                                        <th>أسم الموظف</th>
                                        <th>الأسم الاخير</th>
                                        <th>المؤهل وتاريخه</th>
                                        <th>الوظيفة</th>
                                        <th>تاريخ التعيين</th>
                                        <th>تاريخ الميلاد</th>
                                        <th>الرقم القومى</th>
                                        <th>محل الأقامة</th>
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
            reportName: '',
            seg1: '',
            seg2: '',
        }
    },
    mounted() {
        this.fetch()

        if (localStorage.reportName) {
            this.reportName = localStorage.reportNameEmployee;
        }
        if (localStorage.seg1Employee) {
            this.seg1 = localStorage.seg1Employee;
        }
        if (localStorage.seg2Employee) {
            this.seg2 = localStorage.seg2Employee;
        }
    },
    methods: {
        segenSave() {
            localStorage.reportNameEmployee = this.reportName
            localStorage.seg1Employee = this.seg1
            localStorage.seg2Employee = this.seg2
        },
        fetch() {
            var classEdu = this.classEdu
            var classRoom = this.classRoom
            $(function() {
                $('#users-table').DataTable({
                    dom: 'Bfrtip',
                    "lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],
                    "order": [[ 3 , 'asc' ], [ 0, 'asc' ], [ 1, 'asc' ]],
                    buttons: [
                        {
                            extend: 'print',
                            text: '<i class="fa fa-check" aria-hidden="true"></i> طباعة المحدد',
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
                            extend: 'print',
                            text: '<i class="fa fa-print" aria-hidden="true"></i> طباعة',
                            exportOptions: {
                                columns: ':visible',
                                modifier: {
                                    selected: null
                                }
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
                    select: true,
                    ajax: `https://kamel-ouda.com/admin/get-employee`,
                    columns: [
                        { data: 'name', name: 'name' },
                        { data: 'last_name', name: 'last_name' },
                        { data: 'qualification', name: 'qualification' },
                        { data: 'specialty', name: 'specialty' },
                        { data: 'date_receipt', name: 'date_receipt' },
                        { data: 'birth_date', name: 'birth_date' },
                        { data: 'national_id', name: 'national_id' },
                        { data: 'address', name: 'address' },
                    ],
                    "columnDefs": [
                        {
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
        },
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
    .col-print-10 {width:83%; float:left;}
    .col-print-11 {width:92%; float:left;}
    .col-print-12 {width:100%; float:left;}
}
</style>
