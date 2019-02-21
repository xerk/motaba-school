<template>
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <button type="button" class="close" @click="$emit('close')" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <div class="modal-header">
                        <slot name="header">
                            default header
                        </slot>
                    </div>
                    <div class="modal-body">
                        <slot name="body">
                                <div :class="{'form-group col-md-6': true, 'has-error': errors.has('stage') }">
                                    <label for="stage">{{ trans('linkTeacher.Stage Education')}}</label>
                                    <select id="stage" class="form-control" v-validate="'required'" v-model="list.stage_id" @change="changeStage" name="stage">
                                        <option value="" selected="selected">{{ trans('linkTeacher.Choose Stage')}}</option>
                                        <option v-for="(stage, key) in stageEdu" :key="key" :value="stage.id">{{ stage.name }}</option>
                                    </select>
                                    <span v-show="errors.has('stage')" class="help-block" style="color:#f96868">{{ errors.first('stage') }}</span>
                                </div>
                                <div :class="{'form-group col-md-6': true, 'has-error': errors.has('class') }">
                                    <label for="class">{{ trans('linkTeacher.Class Education')}}</label>
                                    <select id="class" class="form-control" v-validate="''" v-model="list.class_id" @change="changeClass" name="class">
                                        <option value="" selected="selected">{{ trans('linkTeacher.Choose Class')}}</option>
                                        <option v-for="(classItem, key) in classEduFilter" :key="key" :value="classItem.id">{{ classItem.name }}</option>
                                    </select>
                                    <span v-show="errors.has('class')" class="help-block" style="color:#f96868">{{ errors.first('class') }}</span>
                                </div>
                                <div :class="{'form-group col-md-6': true, 'has-error': errors.has('classroom') }">
                                    <label for="classroom">{{ trans('linkTeacher.Class-Room')}}</label>
                                    <select id="classroom" class="form-control" v-validate="''" v-model="list.classroom_id" name="classroom">
                                        <option value="" selected="selected">{{ trans('linkTeacher.Choose Class-Room')}}</option>
                                        <option v-for="(classRoom, key) in classRoomEduFilter" :key="key" :value="classRoom.id">{{ classRoom.name }}</option>
                                    </select>
                                    <span v-show="errors.has('classroom')" class="help-block" style="color:#f96868">{{ errors.first('classroom') }}</span>
                                </div>
                                <div :class="{'form-group col-md-6': true, 'has-error': errors.has('subject') }">
                                    <label for="subject">{{ trans('linkTeacher.Subject')}}</label>
                                    <select id="subject" class="form-control" v-validate="''" v-model="list.subject_id" name="subject">
                                        <option value="" selected="selected">{{ trans('linkTeacher.Choose Subject')}}</option>
                                        <option v-for="(subject, key) in subjectFilter" :key="key" :value="subject.id">{{ subject.name }}</option>
                                    </select>
                                    <span v-show="errors.has('subject')" class="help-block" style="color:#f96868">{{ errors.first('subject') }}</span>
                                </div>
                                <div :class="{'form-group col-md-12': true, 'has-error': errors.has('supervision') }">
                                    <label for="subject">{{ trans('linkTeacher.Supervision')}}</label>
                                    <input v-if="list.class_id != '' && list.classroom_id != '' && list.subject_id != ''" type="checkbox" v-model="list.supervision" v-validate="''" name="supervision" id="supervision">
                                    <input v-else type="checkbox" v-model="list.supervision" v-validate="'required'" name="supervision" id="supervision">
                                    <span v-show="errors.has('supervision')" class="help-block" style="color:#f96868">{{ errors.first('supervision') }}</span>
                                </div>
                        </slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer">
                            <button class="btn btn-default" @click="$emit('close')">
                                {{ trans('table.Cancel')}}
                            </button>
                            <!-- <slot tag="button" name="button" class="btn btn-danger delete-confirm" @click="submit">
                                Yest, Save it!
                            </slot> -->
                            <button slot="button" @click="submit" class="btn btn-success">{{ trans('table.Yes, Save it!')}}</button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    props: ['list'],
    data() {
        return {
            get: {
                apiURL: 'link-teacher'
            },
            post: {
                apiURL: 'link-teacher-update',
            },
            stageEdu: [],
            classEdu: [],
            classRoom: [],
            subjects: [],
            linkTeachers: [],
        }
    },
    mounted() {
        this.fetch()
    },
    computed: {
        classEduFilter() {
            if (this.list.stage_id == '') {
                this.list.class_id = ''
            } else {
                return this.classEdu.filter(item => {
                    return item.stage_edu_id == this.list.stage_id
                })
            }
        },
        classRoomEduFilter() {
            if (this.list.class_id == '') {
                this.list.classroom_id = ''
            } else {
                return this.classRoom.filter(item => {
                    return item.class_edu_id == this.list.class_id
                })
            }
        },
        subjectFilter() {
            if (this.list.class_id == '') {
                this.list.subject_id = ''
            } else {
                return this.subjects.filter(item => {
                    return item.class_edu_id == this.list.class_id
                })
            }
        }
    },
    methods: {
        fetch() {
                this.$store.dispatch('retriveAttendtion', {
                        get: this.get,
                        id: this.$route.params.id,
                    })
                    .then(response => {
                        this.linkTeachers = response.data.linkTeachers
                        this.stageEdu = response.data.stageEdu
                        this.classEdu = response.data.classEdu
                        this.classRoom = response.data.classRoom
                        this.subjects = response.data.subjects
                    })
            },
        submit() {
            this.$validator.validateAll().then((result) => {
                if (result) {
                    this.$store.dispatch('submitForm', {
                            post: this.post,
                            model: this.list,
                        })
                        .then(response => {
                            this.$toast.success({
                                title: response.data
                            })
                            this.$emit('close')
                            this.$emit('getUser')
                        })
                }
            })
        },
        changeStage() {
            this.$emit('changeS')
            this.list.class_id = ''
            this.list.classroom_id = ''
        },
        changeClass() {
            this.list.classroom_id = ''
            this.list.subject_id = ''
        },
    },
}
</script>


<style>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
        margin-bottom: 22px;
        border: 1px solid transparent;
        border-radius: 4px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
    }

    .close {
        color: #fff;
        opacity: 0.6;
    }

    .close:hover {
        color: #fff;
        opacity: 1;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        width: 600px;
        margin: 0px auto;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header {
        padding: 20px;
        background-color: #22A7F0;
    }

    .modal-header h3 {
        margin-top: 0;
        color: #fff;
        font-size: 18px;
        margin: 0;
        line-height: 1.42857143;
    }

    .modal-default-button {
        float: right;
    }

    .modal-footer button {
        margin: auto;
    }

    .close {
        margin: 15px 15px 0px
    }
    /*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }

</style>
