<template>
    <div class="row">
        <div class="header">
            <div class='lhs'>
                <img src="images/JPGE.jpg" alt="Logo" class='img-responsive' />
            </div>
            <div class='center'>
                <p>الصف الثاني من رياض الأطفال بنين عام 2018/2019م</p>
            </div>
            <div class='rhs'>
                <ul class='list-unstyled'>
                    <li>الأزهر الشريف</li>
                    <li>منطقة الجيزه الأزهريه</li>
                    <li>معهد كامل عودة الأزهري الخاص</li>
                </ul>
            </div>
        </div>
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
    <div class="footer">
            <div class='lhs'>
                <ul class="list-unstyled">
                    <li>عميد المعهد</li>
                    <li>أ/سعيد عيسي</li>
                </ul>
            </div>
            <div class='rhs'>
                <ul class="list-unstyled">
                    <li>شئون الطلبة</li>
                    <li>أ/جيهان عبد الحميد&nbsp; أ/عطيلت عز الرجال</li>
                </ul>
            </div>
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
                    paging: false,
                    serverSide: false,
                    ajax: `http://localhost:8000/admin/get-students?class=${classEdu}&classroom=${classRoom}`,
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
        * {
            font-family: 'Droid Arabic Kufi', 'Open Sans';
            direction: rtl
        }

        .form-control {
            height: auto;
        }

        .btn,
        .modal .modal-dialog .modal-header {
            font-family: 'Droid Arabic Kufi', 'Open Sans', sans-serif;
        }

        section {
            width: 100%;
            overflow: hidden
        }

        .panel-body {
            padding: 0 20px 0px !important
        }

        table {
            page-break-inside: auto;
        }

        thead th {
            text-align: center
        }

        tr {
            page-break-inside: avoid;
        }

        tr td {
            padding: 8px 18px !important;
            text-align: center;
            padding: 2px 18px !important
        }

        tr th {
            padding: 2px 18px !important
        }

        .header {
            overflow: hidden;
            padding: 10px 40px 0;
            display: none
        }

        .header .lhs {
            width: 100px;
            float: left;
            margin-right: 130px;
        }

        .header .center {
            position: absolute;
            top: 20px;
            left: 50%;
            margin-left: -125px;
        }

        .header .rhs {
            margin-left: 130px;
            float: right;
            text-align: center
        }
        .header2 {margin: 0 0 40px 0;}
        .header2 ul {display: flex;justify-content: space-around;font-weight: bold;font-size: 1/2}
        .footer {
            overflow: hidden;
            padding: 0 40px;
            display: none
        }

        .footer>div.lhs {
            float: left;
        }

        .footer>div.rhs {
            float: right;
            text-align: right
        }

        .footer .flex-boxs ul {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap
        }

        .footer .flex-boxs ul li {
            background: #F2F2F2;
            padding: 12px;
            margin: 3px 10px;
            font-size: 1rem;
            text-align: center
        }
        .printing-date {padding: 5px 20px;font-size: .70rem;display: none}
        @media print {
            .header {
                display: block
            }

            .footer {
                display: block
            }


            body {
                transform: scale(1)
            }

/*
            table {
                page-break-inside: avoid;
            }
*/
            .printing-date{display: block}
        }
        @page { size: auto;  margin: 0mm; }
    </style>