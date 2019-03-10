<template>
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
                                    <th></th>
                                    <th>{{ trans('reports.Student Name')}}</th>
                                    <th>{{ trans('reports.Last Name')}}</th>
                                    <th>{{ trans('reports.Father Name')}}</th>
                                    <th>{{ trans('reports.Father Job')}}</th>
                                    <th>{{ trans('reports.Father Mobile')}}</th>
                                    <th>{{ trans('reports.Father Tel')}}</th>
                                    <th>{{ trans('reports.Qualified Father')}}</th>
                                    <th>{{ trans('reports.Mother Job')}}</th>
                                    <th>{{ trans('reports.Mother Mobile')}}</th>
                                    <th>{{ trans('reports.Mother Tel')}}</th>
                                    <th>{{ trans('reports.Qualified Mother')}}</th>
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
        components: {
            Fab
        },
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
                $(function () {
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
                        columnDefs: [{
                            visible: false,
                            targets: 0,
                        }],
                        processing: false,
                        serverSide: false,
                        ajax: `https://kamel-ouda.com/admin/get-students?class=${classEdu}&classroom=${classRoom}`,
                        columns: [
                            {
                                data: length,
                                defaultContent: ''
                            },
                            {
                                data: 'name',
                                name: 'name'
                            },
                            {
                                data: 'last_name',
                                name: 'last_name'
                            },
                            {
                                data: 'last_name',
                                name: 'last_name'
                            },
                            {
                                data: "father_job",
                                name: 'father_job'
                            },
                            {
                                data: 'father_mobile',
                                name: 'father_mobile'
                            },
                            {
                                data: 'father_tel',
                                name: 'father_tel'
                            },
                            {
                                data: 'father_qualified',
                                name: 'father_qualified'
                            },
                            {
                                data: 'mother_job',
                                name: 'mother_job'
                            },
                            {
                                data: 'mother_mobile',
                                name: 'mother_mobile'
                            },
                            {
                                data: 'mother_tel',
                                name: 'mother_tel'
                            },
                            {
                                data: 'mother_qualified',
                                name: 'mother_qualified'
                            },

                        ],
                        "columnDefs": [{
                                // The `data` parameter refers to the data for the cell (defined by the
                                // `data` option, which defaults to the column being worked with, in
                                // this case `data: 0`.
                                "render": function (data, type, row) {
                                    if (row.last_name == null) {
                                        return row.name;
                                    } else {
                                        return row.name + ' ' + row.last_name;
                                    }
                                },
                                "targets": 1
                            },

                            {
                                "visible": false,
                                "targets": [2]
                            },
                        ],
                    });
                    t.on('order.dt search.dt', function () {
                        t.column(0, {
                            search: 'applied',
                            order: 'applied'
                        }).nodes().each(function (cell, i) {
                            cell.innerHTML = i + 1;
                            t.cell(cell).invalidate('dom');
                        });
                    }).draw();
                });
            }
        },
    }

</script>
<style lang="postcss">
    @page {
        size: auto A4 landscape;
    }

     table.report-container {
        page-break-after:always;
    }
    thead.report-header {
        display:table-header-group;
    }
    tfoot.report-footer {
        display:table-footer-group;
    }

    @media print {
        .col-sm-1,
        .col-sm-2,
        .col-sm-3,
        .col-sm-4,
        .col-sm-5,
        .col-sm-6,
        .col-sm-7,
        .col-sm-8,
        .col-sm-9,
        .col-sm-10,
        .col-sm-11,
        .col-sm-12 {
            float: left;
        }

        .col-sm-12 {
            width: 100%;
        }

        .col-sm-11 {
            width: 91.66666667%;
        }

        .col-sm-10 {
            width: 83.33333333%;
        }

        .col-sm-9 {
            width: 75%;
        }

        .col-sm-8 {
            width: 66.66666667%;
        }

        .col-sm-7 {
            width: 58.33333333%;
        }

        .col-sm-6 {
            width: 50%;
        }

        .col-sm-5 {
            width: 41.66666667%;
        }

        .col-sm-4 {
            width: 33.33333333%;
        }

        .col-sm-3 {
            width: 25%;
        }

        .col-sm-2 {
            width: 16.66666667%;
        }

        .col-sm-1 {
            width: 8.33333333%;
        }
    }

</style>
