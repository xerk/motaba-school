<template>
    <div>
        <modal v-if="showModal" @close="showModal = false">
            <div slot="body">
            <hr>
                <div class="row">
                    <div :class="{'form-group col-md-6': true, 'has-error': errors.has('stage') }">
                        <label for="stage">{{ trans('fab.Stage Education')}}</label>
                        <select id="m_stage" v-validate="'required'" class="form-control" v-model="stageSelect" @change="changeStage" name="stage">
                            <option value="" selected="selected">{{ trans('fab.Choose Stage')}}</option>
                            <option v-for="(stage, key) in model.stageEdu" :key="key" :value="stage.id">{{ stage.name }}</option>
                        </select>
                        <span v-show="errors.has('stage')" class="help-block" style="color:#f96868">{{ errors.first('stage') }}</span>
                    </div>
                    
                    <div :class="{'form-group col-md-6': true, 'has-error': errors.has('class') }">
                        <label for="class">{{ trans('fab.Class Education')}}</label>
                        <select id="m_class" v-validate="'required'" class="form-control" v-model="classSelect" @change="changeClass" name="class">
                            <option value="" selected="selected">{{ trans('fab.Choose Class')}}</option>
                            <option v-for="(classItem, key) in classEduFilter" :key="key" :value="classItem.id">{{ classItem.name }}</option>
                        </select>
                        <span v-show="errors.has('class')" class="help-block" style="color:#f96868">{{ errors.first('class') }}</span>
                    </div>

                    <div :class="{'form-group col-md-6': true, 'has-error': errors.has('classroom') }">
                        <label for="classroom">{{ trans('fab.Class-Room')}}</label>
                        <select id="m_classroom" v-validate="'required'" class="form-control" v-model="classRoomSelect" name="classroom">
                            <option value="" selected="selected">{{ trans('fab.Choose Class-Room')}}</option>
                            <option v-for="(classRoom, key) in classRoomEduFilter" :key="key" :value="classRoom.id">{{ classRoom.name }}</option>
                        </select>
                        <span v-show="errors.has('classroom')" class="help-block" style="color:#f96868">{{ errors.first('classroom') }}</span>
                    </div>

                    <div :class="{'form-group col-md-6': true, 'has-error': errors.has('exam') }">                    
                        <label for="exam">{{ trans('fab.Exam')}}</label>
                        <select id="m_exam" v-validate="'required'" @change="examChange" class="form-control" v-model="examSelect" name="exam">
                            <option value="" selected="selected">{{ trans('fab.Choose Exam')}}</option>
                            <option v-for="(exam, key) in model.exams" :key="key" :value="exam.id">{{ exam.name }}</option>
                        </select>
                        <span v-show="errors.has('exam')" class="help-block" style="color:#f96868">{{ errors.first('exam') }}</span>
                    </div>

                    <div :class="{'form-group col-md-6': true, 'has-error': errors.has('type-exam') }">                    
                        <label for="type-exam">{{ trans('fab.Type Exam')}}</label>
                        <select id="m_type-exam" v-validate="'required'" @change="examChange" class="form-control" v-model="typeExamSelect" name="type-exam">
                            <option value="" selected="selected">{{ trans('fab.Choose Type Exam')}}</option>
                            <option v-for="(typeExam, key) in model.typeExams" :key="key" :value="typeExam.id">{{ typeExam.name }}</option>
                        </select>
                        <span v-show="errors.has('type-exam')" class="help-block" style="color:#f96868">{{ errors.first('type-exam') }}</span>
                    </div>

                    <div :class="{'form-group col-md-6': true, 'has-error': errors.has('subject') }">                    
                        <label for="subject">{{ trans('fab.Subject')}}</label>
                        <select id="m_subject" v-validate="'required'" class="form-control" v-model="supSubjectSelect" name="subject">
                            <option value="" selected="selected">{{ trans('fab.Choose Subject')}}</option>
                            <option v-for="(subject, key) in subjectFilter" :key="key" :value="subject.id">{{ subject.subjects.name }}</option>
                        </select>
                        <span v-show="errors.has('subject')" class="help-block" style="color:#f96868">{{ errors.first('subject') }}</span>
                    </div>
                </div>
            </div>
            <h3 slot="header"><i class="voyager-tree"></i> <span style="margin-left: 10px;vertical-align: text-bottom;">{{ trans('fab.Select student filter')}}.</span></h3>                        
            <button slot="button" @click="parsist" class="btn btn-success">{{ trans('table.Yes, Save it!')}}</button>
        </modal>
    <fab :actions="fabActions" :bg-color="bgColor" :main-tooltip="mainTooltip" :icon-size="iconSize" @system="showModal = true"></fab>
    </div>
</template>

<script>
    import fab from 'vue-fab'
    import Modal from '../modal/SelectSystem'
    export default {
        components: {
            fab,
            Modal
        },
        data() {
            return {
                stageSelect: '',
                classSelect: '',
                classRoomSelect: '',
                supSubjectSelect: '',
                examSelect: '',
                typeExamSelect: '',
                showModal: false,   
                bgColor: '#22A7F0',
                position: 'top-right',
                iconSize: 'small',
                mainTooltip: 'Display Student',
                fabActions: [
                    {
                        name: 'system',
                        icon: 'create_new_folder',
                        tooltip: 'ClassRoom',
                        color: '#000000',
                    },
                    {
                        name: 'system',
                        icon: 'book',
                        tooltip: 'Class',
                        color: '#000000',
                    },
                    {
                        name: 'system',
                        icon: 'school',
                        tooltip: 'Stage',
                        color: '#000000',
                    },
                ],
                get: {
                    apiURL: 'system-configs',
                },
                model: {
                    stageEdu: [],
                    classEdu: [],
                    classRoom: [],
                    supsubjects: [],
                    exams: [],
                    typeExams: [],
                },
                stagelog: [],
            }
        },
        mounted() {
            this.fetchSystem()
        },
        computed: {
            classEduFilter() {
                if (this.stageSelect == '') {
                    this.classSelect = ''
                } else {
                    return this.model.classEdu.filter(item => {
                        return item.stage_edu_id == this.stageSelect
                    })
                }
            },
            classRoomEduFilter() {
                if (this.classSelect == '') {
                    this.classRoomSelect = ''
                } else {
                    return this.model.classRoom.filter(item => {
                        return item.class_edu_id == this.classSelect
                    })
                }
            },
            subjectFilter() {
                if (this.classSelect == '' || this.examSelect == '') {
                    this.supSubjectSelect = ''
                } else {
                    return this.model.supsubjects.filter(item => {
                        return item.subjects.class_edu_id == this.classSelect && item.type_exam_id == this.typeExamSelect && item.exam_id == this.examSelect
                    })
                }
            }
        },
        methods: {
            fetchSystem() {
                this.$store.dispatch('retriveOptions', this.get)
                    .then(response => {
                        this.model.stageEdu = response.data.stageEduPerm
                        this.model.classEdu = response.data.classEduPerm
                        this.model.classRoom = response.data.classRoomEduPerm
                        this.model.supsubjects = response.data.supsubjects
                        this.model.exams = response.data.exams
                        this.model.typeExams = response.data.typeExams
                    })
                if (localStorage.stageEdu) {
                    this.stageSelect = localStorage.stageEdu;
                }
                if (localStorage.classEdu) {
                    this.classSelect = localStorage.classEdu;
                }
                if (localStorage.classRoom) {
                    this.classRoomSelect = localStorage.classRoom;
                }
                if (localStorage.exam) {
                    this.examSelect = localStorage.exam;
                }
                if (localStorage.typeExam) {
                    this.typeExamSelect = localStorage.typeExam;
                }
                if (localStorage.supSubject) {
                    this.supSubjectSelect = localStorage.supSubject;
                }
            },
            parsist() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.$emit('parsist', this.stageSelect, this.classSelect, this.classRoomSelect, this.examSelect, this.typeExamSelect, this.supSubjectSelect)
                        localStorage.stageEdu = this.stageSelect;
                        localStorage.classEdu = this.classSelect;
                        localStorage.classRoom = this.classRoomSelect;
                        localStorage.exam = this.examSelect;
                        localStorage.typeExam = this.typeExamSelect;
                        localStorage.supSubject = this.supSubjectSelect;
                        this.showModal = false
                    }
                })
            },
            changeStage() {
                this.$emit('changeS')
                this.classSelect = ''
                this.classRoomSelect = ''
            },
            changeClass() {
                this.classRoomSelect = ''
            },
            examChange() {
                this.supSubjectSelect = ''
            }
        }
    }

</script>
