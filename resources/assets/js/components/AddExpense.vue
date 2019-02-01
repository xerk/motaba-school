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
                                        <th>{{trans('expenses.Class Name') }}</th>
                                        <th>{{trans('expenses.Expenses Cost') }}</th>
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
        mounted() {
            this.getSetting()
        },
        methods: {
            getSetting() {
                var editor; // use a global for the submit and return data rendering in the 
                $(document).ready(function () {
                    editor = new $.fn.dataTable.Editor({
                        ajax: {
                            url: `/control/model/addExpenses.php`,
                            type: 'POST',
                        },
                        table: "#example",
                        fields: [
                            { label: "Expenses Cost:", name: "class_edus.expenses_cost" },
                        ]
                    });

                    var table = $('#example').DataTable({
                        dom: "Bfrtip",
                        ajax: {
                            url: `/control/model/addExpenses.php`,
                            type: 'GET',
                        },
                        order: false,
                        pageLength: 100,
                        columns: [
                            {
                                data: null,
                                defaultContent: '',
                                className: 'select-checkbox',
                                orderable: false
                            },
                            { data: "class_edus.name" },
                            { data: "class_edus.expenses_cost"},
                            
                        ],
                        autoFill: {
                            columns: 2,
                            editor:  editor
                        },
                        keys: {
                            columns: 2,
                            editor:  editor
                        },
                        select: {
                            style: 'os',
                            selector: 'td:first-child',
                            blurable: true
                        },
                        buttons: [
                            { extend: "edit", editor: editor },
                        ]
                    });
                });
            }
        }
    }
</script>