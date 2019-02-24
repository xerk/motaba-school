<template>
    <div class="page-content browse container-fluid" dir="rtl">
        <div class="row">
            <div class="col-md-9">
                <form @submit.prevent="validateBeforeSubmit" action="">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6 pull-right">
                                    <div :class="{'form-group': true, 'has-error': errors.has('type') }">
                                        <label for="type">{{ trans('attentions.Attention Type') }}</label>
                                            <select name="type-error" v-validate="'required'" v-model="attention.attention_group_type_id" id="type" class="form-control">
                                                <option value="">{{ trans('attentions.Choose the type') }}</option>
                                                <option  v-for="(item, index) in types" :value="item.id" :key="index">{{ item.name }}</option>
                                            </select>
                                            <span v-show="errors.has('type-error')" class="help-block" style="color:#f96868">{{ errors.first('type-error') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_date">{{ trans('attentions.End Date') }}</label>
                                        <datetime :input-class="'form-control'" :auto="true" type="datetime" id="end_date" v-model="attention.end_date"></datetime>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="body">{{ trans('attentions.Body') }}</label>
                                <vue-editor v-model="attention.body">
                                </vue-editor>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary">{{ trans('attentions.Update & Continue Editing') }}</button>
                            <router-link :to="{ name: 'gattentionsShow', params: {id: $route.params.edit} }" @click.native="validateBeforeSubmit" type="submit" class="btn btn-primary">
                                {{ trans('attentions.Update Attention') }}
                            </router-link>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-3">
                <form @submit.prevent="validateBeforeSubmit" action="">
                    <div class="panel panel-bordered" style="margin-bottom: 0px;">
                        <div class="panel-body">
                            <h4 class="text-center"><i class="icon voyager-pie-graph"></i> {{ trans('attentions.Attention Details') }}</h4>
                            <hr>
                            <div v-if="attention.stage_edu" class="panel-body" style="padding: 0px;">
                                <div class="row">
                                    <div class="col-md-6 text-center pull-right">
                                        <span class="show-field">{{ trans('linkTeacher.Stage') }}:</span>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="show-result">
                                            {{ attention.stage_edu.name }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div v-if="attention.class_edu" class="panel-body" style="padding: 0px;">
                                <div class="row">
                                    <div class="col-md-6 text-center pull-right">
                                        <span class="show-field">{{ trans('linkTeacher.Class') }}:</span>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="show-result">
                                            {{ attention.class_edu.name }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div v-if="attention.class_room" class="panel-body" style="padding: 0px;">
                                <div class="row">
                                    <div class="col-md-6 text-center pull-right">
                                        <span class="show-field">{{ trans('linkTeacher.ClassRoom') }}:</span>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="show-result">
                                            {{ attention.class_room.name }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div v-if="attention.amount != ''" class="panel-body" style="padding: 0px;">
                                <div class="row">
                                    <div class="col-md-6 text-center pull-right">
                                        <span class="show-field">{{ trans('attentions.Student Amount') }}:</span>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="show-result">
                                            {{ attention.amount }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div v-if="attention.end_date != ''" class="panel-body" style="padding: 0px;">
                                <div class="row">
                                    <div class="col-md-6 text-center pull-right">
                                        <span class="show-field">{{ trans('attentions.End Date') }}:</span>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="show-result">
                                            {{ attention.end_date }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div v-if="attention.author != ''" class="panel-body" style="padding: 0px;">
                                <div class="row">
                                    <div class="col-md-6 text-center pull-right">
                                        <span class="show-field">{{ trans('attentions.Author') }}:</span>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="show-result">
                                            {{ attention.author.name }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-3">
                <form @submit.prevent="validateBeforeSubmit" action="">
                    <div class="panel panel-bordered" style="margin-bottom: 0px;">
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
        </div>
        <fab @parsist="parsist"></fab>
    </div>
</template>

<script>
    import {
        VueEditor
    } from "vue2-editor";
    import { DateTime } from 'luxon';
    import Fab from '../fab/Fab'
    export default {
        components: {
            VueEditor,
            Fab,
        },
        props: {
            link: '',
            edit: '',
        },
        data() {
            return {
                get: {
                    apiURL: 'gattention/show',
                },
                post: {
                    apiURL: 'gattention',
                },
                postTwo: {
                    apiURL: 'gattention-post',
                },
                stageEdu: localStorage.stageEdu,
                classEdu: localStorage.classEdu,
                classRoom: localStorage.classRoom,
                stageEduShow: {},
                classEduShow: {},
                classRoomShow: {},
                StudentCount: '',
                types: [],
                type: '',
                attention: {
                    end_date: '',
                    attention_group_type_id: '',
                    stageEdu: {name:''},
                    author: {name:''},
                    classEdu: {name: ''},
                    classRoom: {name: ''},
                },
            }
        },
        computed: {
        },
        mounted() {
            this.fetch()
            setTimeout(() => {
                this.dateEnd()
            }, 3000);
        },
        methods: {
            parsist(stageEdu, classEdu, classRoom) {
                this.stageEdu = stageEdu
                this.classEdu = classEdu
                this.classRoom = classRoom
                this.fetch()
            },
            fetch() {
                this.$store.dispatch('retriveFilterSchoolEdit', {
                        get: this.get,
                        stageEdu: this.stageEdu,
                        classEdu: this.classEdu,
                        classRoom: this.classRoom,
                        edit: this.$route.params.edit
                    })
                    .then(response => {
                        this.types = response.data.types
                        this.attention = response.data.attention
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
                        id: this.attention.id,
                        post: this.post,
                        stage_id: this.stageEdu,
                        class_id: this.classEdu,
                        classroom_id: this.classRoom,
                        type: this.attention.attention_group_type_id,
                        body: this.attention.body,
                        amount: this.StudentCount,
                        end_date: DateTime.fromISO(this.attention.end_date).toFormat('yyyy-MM-dd hh:mm:ss'),
                    })
                    .then(response => {
                        this.$toast.success({
                            title: response.data
                        })
                        this.fetch()
                        setTimeout(() => {
                            this.dateEnd()
                        }, 1000);
                    })
            },
            dateEnd() {
                this.attention.end_date = DateTime.fromString(this.attention.end_date, 'yyyy-MM-dd hh:mm:ss').toISO()
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
</style>
