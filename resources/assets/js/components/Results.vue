<template>
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <section>
                            <table id="example" class="display table" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="text-center">
                                        <th class="text-center" rowspan="2" width="5%"></th>
                                        <th class="text-center" style="    vertical-align: middle;" rowspan="2">{{ trans('results.Full Name') }}</th>
                                        <th class="text-center" rowspan="2">{{ trans('results.Last name') }}</th>
                                        <th class="text-center"> {{ typeExams.name }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">{{ supSubjectFetch.degree }}</th>
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
        <fab-result @parsist="parsist"></fab-result>
    </div>
</template>

<script>
import FabResult from './fab/FabResult'
    export default {
        components: {FabResult},
        data() {
            return {
                stageEdu: localStorage.stageEdu,
                classEdu: localStorage.classEdu,
                classRoom: localStorage.classRoom,
                exam: localStorage.exam,
                typeExam: localStorage.typeExam,
                supSubject: localStorage.supSubject,
                typeExams: {
                    name: '',
                },
                supSubjectFetch: {
                    degree: '',
                },
                get: {
                    apiURL: 'results',
                    params: {
                        typeExamId: localStorage.typeExam,
                        supSubjectId: localStorage.supSubject,
                    }
                },
            }
        },
        mounted() {
            this.getResults()
            this.fetch()
        },
        methods: {
            parsist(stageEdu, classEdu, classRoom, exam, typeExam, supSubject) {
                this.stageEdu = stageEdu
                this.classEdu = classEdu
                this.classRoom = classRoom
                this.exam = exam
                this.typeExam = typeExam
                this.supSubject = supSubject
                this.get.params.typeExamId = typeExam
                $('#example').DataTable().destroy();
                this.getResults()
            },
            getResults() {
                var stageEdu = this.stageEdu
                var classEdu = this.classEdu
                var classRoom = this.classRoom
                var exam = this.exam
                var typeExam = this.typeExam
                var supSubject = this.supSubject
                var editor; // use a global for the submit and return data rendering in the 
                $(document).ready(function () {
                    editor = new $.fn.dataTable.Editor({
                        ajax: {
                            url: `/control/model/results.php?stage=${stageEdu}&class=${classEdu}&classroom=${classRoom}&subject=${supSubject}&exam=${exam}`,
                            type: 'POST',
                        },
                        table: "#example",
                        fields: [
                            { label: "Degree:", name: "results.exam1" }, 
                            // { label: "Setting Number:", name: "setting_numbers.setting_number" },
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
                            url: `/control/model/results.php?stage=${stageEdu}&class=${classEdu}&classroom=${classRoom}`,
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
                            { data: "results.exam1"},
                            
                        ],
                        autoFill: {
                            columns: 3,
                            editor:  editor
                        },
                        keys: {
                            columns: 3,
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
                            { className: "text-center", "targets": [ 0,1,2,3 ] },
                        
                            { "visible": false,  "targets": [ 2 ] },
                        ],
                        buttons: [
                            { extend: "edit", editor: editor },
                        ]
                    });
                });
            },
            fetch() {
                this.$store.dispatch('retriveResults', this.get)
                    .then(response => {
                        this.typeExams = response.data.typeExams    
                        this.supSubjectFetch = response.data.supSubject    
                    })
            }
        }
    }
</script>