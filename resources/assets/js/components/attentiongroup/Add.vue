<template>
    <div class="page-content browse container-fluid" dir="rtl">
        <div class="row">
            <div class="col-md-3 pull-right">
                <form @submit.prevent="validateBeforeSubmit" action="">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <h4 class="text-center"><i class="icon voyager-pie-graph"></i> {{ trans('attentions.Student State') }}</h4>
                            <hr>
                            <div v-if="stageEduShow" class="panel-body" style="padding: 0px;">
                                <div class="row">
                                    <div class="col-md-6 text-center pull-right">
                                        <span class="show-field">{{ trans('linkTeacher.Stage') }}:</span>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="show-result">
                                            {{ stageEduShow.name }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div v-if="classEduShow" class="panel-body" style="padding: 0px;">
                                <div class="row">
                                    <div class="col-md-6 text-center pull-right">
                                        <span class="show-field">{{ trans('linkTeacher.Class') }}:</span>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="show-result">
                                            {{ classEduShow.name }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div v-if="classRoomShow" class="panel-body" style="padding: 0px;">
                                <div class="row">
                                    <div class="col-md-6 text-center pull-right">
                                        <span class="show-field">{{ trans('linkTeacher.ClassRoom') }}:</span>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="show-result">
                                            {{ classRoomShow.name }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div v-if="StudentCount != ''" class="panel-body" style="padding: 0px;">
                                <div class="row">
                                    <div class="col-md-6 text-center pull-right">
                                        <span class="show-field">{{ trans('attentions.Student Amount') }}:</span>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="show-result">
                                            {{ StudentCount }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-9">
                <form @submit.prevent="validateBeforeSubmit" action="">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6 pull-right">
                                    <div :class="{'form-group': true, 'has-error': errors.has('type') }">
                                        <label for="type">{{ trans('attentions.Attention Type') }}</label>
                                        <select name="type-error" v-validate="'required'" v-model="type" @change="setType" id="type" class="form-control">
                                            <option value="">{{ trans('attentions.Choose the type') }}</option>
                                            <option :value="item" v-for="(item, index) in types" :key="index">{{ item.name }}</option>
                                        </select>
                                        <span v-show="errors.has('type-error')" class="help-block" style="color:#f96868">{{ errors.first('type-error') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_date">{{ trans('attentions.End Date') }}</label>
                                        <datetime :input-class="'form-control'" :auto="true" type="datetime" id="end_date" v-model="end_date"></datetime>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email">{{ trans('attentions.Body') }}</label>
                                <vue-editor v-model="body">
                                </vue-editor>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary">{{ trans('attentions.Submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12" v-if="attentions != ''">
                <div class="panel panel-bordered">
                    <div class="panel-title">
                        <h3><i class="icon voyager-bell"></i> {{ trans('attentions.Attentions') }}</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox"></th>
                                        <th class="text-right">{{ trans('attentions.Student Amount') }}</th>
                                        <th class="text-right">{{ trans('linkTeacher.Stage')}}</th>
                                        <th class="text-right">{{ trans('linkTeacher.Class')}}</th>
                                        <th class="text-right">{{ trans('linkTeacher.ClassRoom')}}</th>
                                        <th class="text-right">{{ trans('attentions.Author') }}</th>
                                        <th class="text-right">{{ trans('attentions.Attention Type') }}</th>
                                        <th class="text-right">{{ trans('attentions.End Date') }}</th>
                                        <th class="actions text-left">{{ trans('table.Actions') }}</th>
                                    </tr>
                                </thead>
                                <transition-group tag="tbody" name="list" mode="in-out">
                                        <tr v-for="(item, index) in attentions" :key="index">
                                            <td><input type="checkbox"></td>
                                            <td>{{item.amount ? item.amount : trans('table.None') }}</td>
                                            <td>{{item.stage_edu ? item.stage_edu.name : trans('table.None') }}</td>
                                            <td>{{item.class_edu ? item.class_edu.name : trans('table.None') }}</td>
                                            <td>{{item.class_room ? item.class_room.name : trans('table.None') }}</td>
                                            <td><span class="label label-primary">{{ item.author ? (item.author.name + ' ' + item.author.last_name) : trans('table.None') }}</span></td>
                                            <td><span class="label label-info">{{item.attention_type ? item.attention_type.name : trans('table.None') }}</span></td>
                                            <td>{{ item.end_date ? item.end_date : trans('table.None') }}</td>
                                            <td class="no-sort no-click" id="bread-actions">
                                                <a href.prevent="" @click="openModal(item)" class="btn btn-sm btn-danger pull-left" style="display:inline;">
                                                    <i class="voyager-trash"></i> {{ trans('table.Delete') }}
                                                </a>

                                                    <router-link tag="a" :to="{ name: 'gattentionsEdit', params: {edit: item.id} }" title="edit attention" style="margin-right:5px;" class="btn btn-sm btn-primary pull-left edit"
                                                        data-id="2" id="edit-2">
                                                            <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">{{ trans('table.Edit') }}</span>
                                                    </router-link>
                                                    <router-link tage="a" :to="{ name: 'gattentionsShow', params: { id: item.id } }" :title="trans('View')" class="btn btn-sm btn-warning pull-left view">
                                                        <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">{{ trans('table.View') }}</span>
                                                    </router-link>
                                            </td>
                                        </tr>
                                </transition-group>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal-system :selectRow="selectRow" @confirm="removeOption" v-if="showModal" @close="showModal = false"></modal-system>
        <fab @parsist="parsist"></fab>
    </div>
</template>

<script>
    import {
        VueEditor
    } from "vue2-editor";
    import ModalSystem from '../modal/ModalSystem'
    import { DateTime } from 'luxon';
    import Fab from '../fab/Fab'
    export default {
        components: {
            ModalSystem,
            VueEditor,
            Fab,
        },
        props: {
            link: '',
        },
        data() {
            return {
                showModal: false,
                get: {
                    apiURL: 'gattention',
                },
                post: {
                    apiURL: 'gattention',
                },
                postTwo: {
                    apiURL: 'gattention-post',
                },
                delete: {
                    apiURL: 'gattention',
                },
                end_date: '',
                types: [],
                type: {
                },
                body: '',
                attentions: [],
                stageEdu: localStorage.stageEdu,
                classEdu: localStorage.classEdu,
                classRoom: localStorage.classRoom,
                stageEduShow: {},
                classEduShow: {},
                classRoomShow: {},
                StudentCount: '',
            }
        },
        computed: {
        },
        mounted() {
            this.fetch()
        },
        methods: {
            openModal(value) {
                this.showModal = true
                this.selectRow = value
            },
            parsist(stageEdu, classEdu, classRoom) {
                this.stageEdu = stageEdu
                this.classEdu = classEdu
                this.classRoom = classRoom
                this.fetch()
            },
            fetch() {
                this.$store.dispatch('retriveFilterSchool', {
                        get: this.get,
                        stageEdu: this.stageEdu,
                        classEdu: this.classEdu,
                        classRoom: this.classRoom,
                    })
                    .then(response => {
                        this.types = response.data.types
                        this.attentions = response.data.attentions
                        this.stageEduShow = response.data.stageEduShow
                        this.classEduShow = response.data.classEduShow
                        this.classRoomShow = response.data.classRoomShow
                        this.StudentCount = response.data.StudentCount
                    })
            },
            validateBeforeSubmit() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.submit()
                    }
                })
            },
            submit() {
                this.$store.dispatch('submitForm', {
                        post: this.postTwo,
                        stage_id: this.stageEdu,
                        class_id: this.classEdu,
                        classroom_id: this.classRoom,
                        type: this.type.id,
                        body: this.body,
                        amount: this.StudentCount,
                        end_date: DateTime.fromISO(this.end_date).toFormat('yyyy-MM-dd hh:mm:ss'),
                    })
                    .then(response => {
                        this.$toast.success({
                            title: response.data
                        })
                        this.fetch()
                        this.type = {}
                        this.body = ''
                        this.errors.clear();
                    })
            },
            setType() {
                this.body = this.type.body
            },
            removeOption() {
                this.showModal = false
                let index = this.attentions.indexOf(this.selectRow);
                this.$store.dispatch('delete', {
                        delete: this.delete,
                        id: this.selectRow.id
                    })
                    .then(response => {
                        this.$toast.success({
                            title: response.data,
                        })
                        this.fetch()
                    })
                    this.attentions.splice(index, 1)
                    this.selectRow = null;
            },
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
    .max-length {
        position: absolute;
        right: 30px;
        font-size: 14px;
        bottom: 50px;
        color: #fa2a00;
        font-weight: 500;
    }
</style>
