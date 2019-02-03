<template>
    <div class="page-content browse container-fluid">
        <div class="lecture-select-box">
            <router-link @click.native="next" style="padding: 5px 10px;" :title="trans('reports.Next')" class="btn btn-sm  btn-primary pull-right edit" tag="a" :to="{path: '/admin/absent_employees', query: {'day': day+1,}}">
                <span class="hidden-xs hidden-sm"></span> <i class="voyager-double-right"></i>
            </router-link>
            <router-link @click.native="prev" style="padding: 5px 10px;" :title="trans('reports.Prev')" class="btn btn-sm  btn-primary pull-right edit" tag="a" :to="{path: '/admin/absent_employees', query: {'day': day-1,}}">
                <i class="voyager-double-left"></i> <span class="hidden-xs hidden-sm"></span>
            </router-link>
            <button class="btn btn-sm disabled" style="padding: 4px 15px;">{{ new Date() | moment("add", day+" days", "dddd, Do MM YY") }}</button>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover dataTable no-footer display nowrap" id="users-table">
                                <thead>
                                    <tr>
                                        <th>{{ trans('reports.Employee Name')}}أسم الموظف</th>
                                        <th>{{ trans('reports.Last Name')}}الأسم الاخير</th>
                                        <th>{{ trans('reports.Date')}}التاريخ</th>
                                        <th>{{ trans('reports.Status')}}الحالة</th>
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
            day: 0,
        }
    },
    mounted() {
        this.fetch()
    },
    methods: {
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
                    ajax: `https://kamel-ouda.com/admin/get-employee-absent?day=${day}`,
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
