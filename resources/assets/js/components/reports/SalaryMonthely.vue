<template>
<div class="page-content browse container-fluid">
    <div class="lecture-select-box">
        <router-link @click.native="next" class="btn btn-sm  btn-primary pull-right edit" style="padding: 5px 10px;" tag="a" :to="{path: '/admin/salary_reports', query: {'month': month+1,}}" :title="trans('table.Next')">
            <span class="hidden-xs hidden-sm"></span> <i class="voyager-double-right"></i>
        </router-link>
        <router-link @click.native="prev" class="btn btn-sm  btn-primary pull-right edit" style="padding: 5px 10px;" :title="trans('table.Prev')" tag="a" :to="{path: '/admin/salary_reports', query: {'month': month-1,}}">
            <span class="hidden-xs hidden-sm"></span> <i class="voyager-double-left"></i>
        </router-link>
        <button class="btn btn-sm disabled" style="padding: 4px 15px;">{{ new Date() | moment("add", month+" months", "dddd, Do MM YY") }}</button>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-bordered">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover dataTable no-footer display nowrap" id="users-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>أسم الموظف</th>
                                    <th> الأسم الاخير</th>
                                    <th>أجر اساسى</th>
                                    <th>منحة مايو</th>
                                    <th>اجور متغيرة</th>
                                    <th>علاوات اعوام سابقة</th>
                                    <th>علاوة</th>
                                    <th>حصة صاحب العمل</th>
                                    <th>جملة المستحق</th>
                                    <th>سلفيات</th>
                                    <th>غياب</th>
                                    <th>تأخيرات</th>
                                    <th>جملة المستقطع</th>
                                    <th>الصافى</th>
                                    <th>التوقيع</th>
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
            var month = this.month
            $(function() {
                var t = $('#users-table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'print',
                            text: '<i class="fa fa-print" aria-hidden="true"></i> طباعة',
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
                    ajax: `https://kamel-ouda.com/admin/get-salary?month=${month}`,
                    columns: [
                        { data: length, defaultContent: '' },
                        { data: 'name', name: 'name' },
                        { data: 'last_name', name: 'last_name' },
                        { data: "add_salary.cost", name: 'add_salary.cost'},
                        { data: 'add_salary.may_grant', name: 'add_salary.may_grant' },
                        { data: 'add_salary.variable_wages', name: 'add_salary.variable_wages'},
                        { data: 'add_salary.prev_year_bonus', name: 'add_salary.prev_year_bonus'},
                        { data: 'add_salary.share_employer', name: 'add_salary.share_employer'},
                        { data: 'add_salary.bonus', name: 'add_salary.bonus' },
                        { data: length },
                        { data: 'sum_discount', name: 'sum_discount' },
                        { data: 'count_absent', name: 'count_absent', 'render': function (val, type, row) {
                            return row.add_salary.absent_day * val;
                        } },
                        { data: 'count_late', name: 'count_late', 'render': function (val, type, row) {
                            return row.add_salary.late_day * val;
                        } },
                        { data: length },
                        { data: length },
                        { "defaultContent": "" },

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
                        {
                            // The `data` parameter refers to the data for the cell (defined by the
                            // `data` option, which defaults to the column being worked with, in
                            // this case `data: 0`.
                            "render": function ( data, type, row ) {
                                return +row.add_salary.cost + +row.add_salary.may_grant + +row.add_salary.variable_wages + +row.add_salary.prev_year_bonus + +row.add_salary.share_employer + +row.add_salary.bonus
                            },
                            "targets": 9,

                        },
                        {
                            // The `data` parameter refers to the data for the cell (defined by the
                            // `data` option, which defaults to the column being worked with, in
                            // this case `data: 0`.
                            "render": function ( data, type, row ) {
                                return +row.sum_discount + (+row.count_late * row.add_salary.late_day) + (+row.count_absent * row.add_salary.absent_day)
                            },
                            "targets": 13,

                        },
                        {
                            // The `data` parameter refers to the data for the cell (defined by the
                            // `data` option, which defaults to the column being worked with, in
                            // this case `data: 0`.
                            "render": function ( data, type, row ) {
                                return (+row.add_salary.cost + +row.add_salary.may_grant + +row.add_salary.variable_wages + +row.add_salary.prev_year_bonus + +row.add_salary.share_employer + +row.add_salary.bonus) - (+row.sum_discount + (+row.count_absent * +row.add_salary.absent_day) + (+row.count_late * +row.add_salary.late_day))
                            },
                            "targets": 14,

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
