<template>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <h4 class=""><img :src="link + '/storage/' + user.avatar" class="img-avatar"> {{ user.name }} {{ user.last_name }}</h4>
                        <hr>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <span class="show-field">{{ trans('linkTeacher.Qualification')}}:</span>                                
                                </div>
                                <div class="col-md-5">
                                    {{ user.qualification }}
                                </div>
                            </div>
                        </div><!-- panel-body -->

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <span class="show-field">{{ trans('linkTeacher.Specialty')}}:</span>                                
                                </div>
                                <div class="col-md-5">
                                    {{ user.specialty }}
                                </div>
                            </div>
                        </div><!-- panel-body -->

                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div>
                    <a class="btn btn-new-relationship" @click="linkTeacherModal" v-if="linkTeachers != ''" title="make a payment"><i class="voyager-heart"></i> {{ trans('linkTeacher.Add Link Teacher')}}</a>
                </div>
                <div class="panel panel-bordered" >
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover dataTable no-footer" v-if="linkTeachers != ''">
                                <thead>
                                    <tr>
                                        <th>{{ trans('table.Created At')}}</th>
                                        <th>{{ trans('linkTeacher.Subject')}}</th>
                                        <th>{{ trans('linkTeacher.Stage')}}</th>
                                        <th>{{ trans('linkTeacher.Class')}}</th>
                                        <th>{{ trans('linkTeacher.ClassRoom')}}</th>
                                        <th class="actions text-right">{{ trans('table.Actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in linkTeachers" :key="index">
                                        <td>{{ item.created_at }}</td>
                                        <td>{{ item.subject.name }}</td>
                                        <td>{{ item.stage_edu.name }}</td>
                                        <td>{{ item.class_edu.name }}</td>
                                        <td>{{ item.class_room.name }}</td>
                                        <td class="actions">
                                            <a href.prevent="" @click="showModalPayment = true" class="btn btn-sm btn-danger pull-right" style="display:inline; margin-right:10px;">
                                                <i class="voyager-edit"></i> Delete
                                            </a>
                                            <a href.prevent="" @click="editAdd(item)" class="btn btn-sm btn-primary pull-right" style="display:inline; margin-right:10px;">
                                                <i class="voyager-edit"></i> Edit
                                            </a>
                                        </td>
                                        <modal v-if="showModalPayment" @close="showModalPayment = false">
                                            <!--
                                            you can use custom content here to overwrite
                                            default content
                                            -->
                                            <h3 slot="header"><i class="voyager-trash"></i> {{ trans('linkTeacher.Are you sure you want to delete this Payment?')}}</h3>                        
                                            <button slot="button" @click.once="deletePayment(item.id, index)" class="btn btn-danger delete-confirm">{{ trans('table.Yes, Delete it!')}}</button>
                                        </modal>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-center" v-else>
                                <h3 >{{ trans('linkTeacher.Please, add one link a teacher!')}}.</h3>
                                <a class="btn btn-new-relationship" @click="linkTeacherModal" title="make a payment"><i class="voyager-heart"></i> {{ trans('linkTeacher.Add Link Teacher')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <link-teacher-add :list="list" v-if="linkTeacherAddModal" @close="linkTeacherAddModal = false">
            <div slot="body">
                <div :class="{'form-group col-md-6': true, 'has-error': errors.has('subject') }">
                    <label for="subject">{{ trans('linkTeacher.Subject')}}</label>
                    <select id="subject" class="form-control" v-validate="'required'" v-model="model.subjectSelect" name="subject">
                        <option value="" selected="selected">{{ trans('linkTeacher.Choose Subject')}}</option>
                        <option v-for="(subject, key) in subjects" :key="key" :value="subject.id">{{ subject.name }}</option>
                    </select>
                    <span v-show="errors.has('subject')" class="help-block" style="color:#f96868">{{ errors.first('subject') }}</span>
                </div>
                <div :class="{'form-group col-md-6': true, 'has-error': errors.has('stage') }">
                    <label for="stage">{{ trans('linkTeacher.Stage Education')}}</label>
                    <select id="stage" class="form-control" v-validate="'required'" v-model="model.stageSelect" @change="changeStage" name="stage">
                        <option value="" selected="selected">{{ trans('linkTeacher.Choose Stage')}}</option>
                        <option v-for="(stage, key) in stageEdu" :key="key" :value="stage.id">{{ stage.name }}</option>
                    </select>
                    <span v-show="errors.has('stage')" class="help-block" style="color:#f96868">{{ errors.first('stage') }}</span>                    
                </div>
                <div :class="{'form-group col-md-6': true, 'has-error': errors.has('class') }">
                    <label for="class">{{ trans('linkTeacher.Class Education')}}</label>
                    <select id="class" class="form-control" v-validate="'required'" v-model="model.classSelect" @change="changeClass" name="class">
                        <option value="" selected="selected">{{ trans('linkTeacher.Choose Class')}}</option>
                        <option v-for="(classItem, key) in classEduFilter" :key="key" :value="classItem.id">{{ classItem.name }}</option>
                    </select>
                    <span v-show="errors.has('class')" class="help-block" style="color:#f96868">{{ errors.first('class') }}</span>                    
                </div>
                <div :class="{'form-group col-md-6': true, 'has-error': errors.has('classroom') }">
                    <label for="classroom">{{ trans('linkTeacher.Class-Room')}}</label>
                    <select id="classroom" class="form-control" v-validate="'required'" v-model="model.classRoomSelect" name="classroom">
                        <option value="" selected="selected">{{ trans('linkTeacher.Choose Class-Room')}}</option>
                        <option v-for="(classRoom, key) in classRoomEduFilter" :key="key" :value="classRoom.id">{{ classRoom.name }}</option>
                    </select>
                    <span v-show="errors.has('classroom')" class="help-block" style="color:#f96868">{{ errors.first('classroom') }}</span>                    
                </div>
            </div>
            <div slot="header" class="modal-header" style="background-color: #F2435C;">
                <h3 slot="header"><i class="voyager-heart"></i> <span style="margin-left: 10px;vertical-align: text-bottom;">{{ trans('linkTeacher.Add Link Teacher')}}.</span></h3>                        
            </div>
            <button slot="button" @click="parsist" class="btn btn-new-relationship">{{ trans('table.Yes, Save it!')}}</button>
        </link-teacher-add>
        <link-teacher @getUser="fetch" :list="list" v-if="showModal" @close="showModal = false">
            <h3 slot="header"><i class="voyager-tree"></i> <span style="margin-left: 10px;vertical-align: text-bottom;">{{ trans('linkTeacher.Make Payment')}} ({{ list.attend_date }}). </span></h3>                        
        </link-teacher>
    </div>
</template>

<script>
    import LinkTeacher from '../modal/LinkTeacher'
    import LinkTeacherAdd from '../modal/LinkTeacherAdd'
    import Modal from '../modal/Modal'

    export default {
        components: {
            LinkTeacher,
            LinkTeacherAdd,
            Modal,
        },
        props: {
            link: '',
            id: '',
        },
        data() {
            return {
                linkTeacherAddModal: false,
                showModal: false,
                get: {
                    apiURL: 'link-teacher',
                },
                post: {
                    apiURL: 'link-teacher',
                },
                delete: {
                    apiURL: 'link-teacher',
                },
                showModalPayment: false,
                user: {},
                list: {},
                model: {
                    stageSelect: '',
                    classSelect: '',
                    classRoomSelect: '',
                    subjectSelect: ''
                },
                makePayments: [],
                linkTeachers: [],
                stageEdu: [],
                classEdu: [],
                classRoom: [],
                subjects: [],
            }
        },
        mounted() {
            this.fetch()
        },
        computed: {
            classEduFilter() {
                if (this.model.stageSelect == '') {
                    this.model.classSelect = ''
                } else {
                    return this.classEdu.filter(item => {
                        return item.stage_edu_id == this.model.stageSelect
                    })
                }
            },
            classRoomEduFilter() {
                if (this.model.classSelect == '') {
                    this.model.classRoomSelect = ''
                } else {
                    return this.classRoom.filter(item => {
                        return item.class_edu_id == this.model.classSelect
                    })
                }
            }
        },
        methods: {
            linkTeacherModal() {
                this.linkTeacherAddModal = true
            },
            fetch() {
                this.$store.dispatch('retriveAttendtion', {
                        get: this.get,
                        id: this.$route.params.id,
                    })
                    .then(response => {
                        this.user = response.data.user
                        this.linkTeachers = response.data.linkTeachers
                        this.stageEdu = response.data.stageEdu
                        this.classEdu = response.data.classEdu
                        this.classRoom = response.data.classRoom
                        this.subjects = response.data.subjects
                    })
            },
            validateBeforeSubmit() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.parsist()
                    }
                })
            },
            parsist() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.linkTeacherAddModal = false
                        this.$store.dispatch('submitForm', {
                                user_id: this.$route.params.id,
                                post: this.post,
                                model: this.model,
                            })
                            .then(response => {
                                this.$toast.success({
                                    title: response.data
                                })
                                this.fetch()
                            })
                    }
                })
            },
            removeOption(id, index) {
                this.$store.dispatch('delete', {
                        delete: this.delete,
                        id: id
                    })
                    .then(response => {
                        this.$toast.success({
                            title: response.data
                        })
                        this.attentions.splice(index, 1)
                        this.showModal = false
                    })
            },
            editAdd(list) {
                this.list = list
                this.$emit('edit', list)
                this.showModal = true
            },
            deletePayment(id, key) {
                this.showModalPayment = false
                this.linkTeachers.splice(key, 1);
                this.$store.dispatch('delete', {
                    delete: this.delete,
                    id: id
                })
                .then(response => {
                    this.$toast.success({
                        title: response.data
                    })
                    this.fetch()
                })
            },
            removeOption(key) {
                this.links.splice(key, 1);
            },
            addOption() {
                this.links.push({
                    subject_id: '',
                    stage_id: '',
                    class_id: '',
                    classroom_id: '',
                });
            },
            changeStage() {
                this.$emit('changeS')
                this.classSelect = ''
                this.classRoomSelect = ''
            },
            changeClass() {
                this.classRoomSelect = ''
            }
        }
    };

</script>

<style>
    .img-avatar {
        width: 35px;
        margin-right: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.16);
        border-radius: 100%;
    }
        .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
        opacity: 0
    }
    .list-item {
    display: inline-block;
    margin-right: 3px;
    }
    .list-enter-active, .list-leave-active {
    transition: all 0.5s;
    }
    .list-enter, .list-leave-to /* .list-leave-active below version 2.1.8 */ {
    opacity: 0;
    transform: translateY(30px);
    }
    .show-field {
        font-weight: 400;
    }
    .show-result {
        font-weight: 600;

    }
    .lecture-select-box {
        /* width: 300px; */
        margin-bottom: 5px;
        float: right;
    }
    .row>[class*=col-] {
        margin-bottom: 0px;
    }
    /* .panel-body {
        border-bottom:1px solid #eee;
    } */
</style>
