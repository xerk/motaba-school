<template>
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <section>
                            <table id="example" class="display table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>{{ trans('salary.Full Name') }}</th>
                                        <th>{{ trans('salary.Last name') }}</th>
                                        <th>{{ trans('salary.Cost') }}</th>
                                        <th>{{ trans('salary.Absent Per Day') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </section>
                    </div>
                </div>
            </div>
            <div>
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
            this.getSetting()
        },
        methods: {
            getSetting() {
                var classEdu = this.classEdu
                var editor; // use a global for the submit and return data rendering in the 
                $(document).ready(function () {
                    editor = new $.fn.dataTable.Editor({
                        ajax: {
                            url: `/control/model/addSalary.php`,
                            type: 'POST',
                        },
                        table: "#example",
                        fields: [
                            { label: "Cost:", name: "add_salaries.cost" },
                            { label: "Cost:", name: "add_salaries.absent_day" },
                        ]
                    });

                    var table = $('#example').DataTable({
                        dom: "Bfrtip",
                        ajax: {
                            url: `/control/model/addSalary.php`,
                            type: 'GET',
                        },
                        order: [[1 , 'asc']],
                        pageLength: 50,
                        columns: [
                            {
                                data: null,
                                defaultContent: '',
                                className: 'select-checkbox',
                                orderable: false
                            },
                            { data: "users.name" },
                            { data: "users.last_name" },
                            { data: "add_salaries.cost", render: $.fn.dataTable.render.number( ',', '.', 0, '$' ) },
                            { data: "add_salaries.absent_day", render: $.fn.dataTable.render.number( ',', '.', 0, '$' ) },
                            
                        ],
                        autoFill: {
                            columns: [3,4],
                            editor:  editor
                        },
                        keys: {
                            columns: [3,4],
                            editor:  editor
                        },
                        select: {
                            style: 'os',
                            selector: 'td:first-child',
                            blurable: true
                        },
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
                                "targets": 1
                            },
                        
                            { "visible": false,  "targets": [ 2 ] },
                        ],
                        buttons: [
                            { extend: "edit", editor: editor },
                        ]
                    });
                });
            }
        }
    }
</script>