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
                                        <th>{{ trans('results.Full Name') }}</th>
                                        <th>{{ trans('results.Last name') }}</th>
                                        <th>{{ trans('results.Gender') }}</th>
                                        <th>{{ trans('results.ClassRoom') }}</th>
                                        <th>{{ trans('results.Setting Number') }}</th>
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
        <fab-class @parsist="parsist"></fab-class>
    </div>
</template>

<script>
import FabClass from './fab/FabClass'
    export default {
        components: {FabClass},
        data() {
            return {
                stageEdu: localStorage.stageEdu,
                classEdu: localStorage.classEdu,
            }
        },
        mounted() {
            this.getSetting()
        },
        methods: {
            parsist(stageEdu, classEdu) {
                this.stageEdu = stageEdu
                this.classEdu = classEdu
                $('#example').DataTable().destroy();
                this.getSetting()
            },
            getSetting() {
                var classEdu = this.classEdu
                var editor; // use a global for the submit and return data rendering in the 
                $(document).ready(function () {
                    editor = new $.fn.dataTable.Editor({
                        ajax: {
                            url: `/control/model/setting.php?class=${classEdu}`,
                            type: 'POST',
                        },
                        table: "#example",
                        fields: [
                            // { label: "First name:", name: "users.full_name" }, 
                            { label: "Setting Number:", name: "setting_numbers.setting_number" },
                            // {
                            //     label: 'Created At:',
                            //     name: 'setting_numbers.created_at',
                            //     type: "datetime",
                            //     def:  function () { return new Date(); }
                            // }
                        ]
                    });

                    var table = $('#example').DataTable({
                        dom: "Bfrtip",
                        ajax: {
                            url: `/control/model/setting.php?class=${classEdu}`,
                            type: 'GET',
                        },
                        order: [[3 , 'asc'],[1 , 'asc'],[2 , 'asc']],
                        pageLength: 100,
                        columns: [
                            {
                                data: null,
                                defaultContent: '',
                                className: 'select-checkbox',
                                orderable: false
                            },
                            { data: "users.name" },
                            { data: "users.last_name" },
                            { data: "users.gender",
                                "render": function (val, type, row) {
                                    if (val == null) {
                                        return "Nothing";
                                    } else {
                                        return val == 1 ? "Male" : "Female";
                                    }
                                }
                            },
                            { data: "class_rooms.name" },
                            { data: "setting_numbers.setting_number" },
                            
                        ],
                        autoFill: {
                            columns: 5,
                            editor:  editor
                        },
                        keys: {
                            columns: 5,
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