<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form @submit.prevent="validateBeforeSubmit" action="">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <h4 class=""><img :src="link + '/storage/' + user.avatar" class="img-avatar"> {{ user.name }} {{ user.last_name }}</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
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
                            <div :class="{'form-group': true, 'has-error': errors.has('sms-text') }">
                                <label for="email">{{ trans('attentions.SMS') }}</label>
                                <textarea  v-model="sms" class="form-control" name="sms-text"  maxlength="70" v-validate="'max:70'" rows="2"></textarea>
                                <span v-if="sms" class="max-length"><span v-if="sms.length >= 50">{{ maxCount - sms.length }}</span></span>
                                <span v-show="errors.has('sms-text')" class="help-block" style="color:#f96868">{{ errors.first('sms-text') }}</span>
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
                                        <th>{{ trans('attentions.Students') }}</th>
                                        <th>{{ trans('attentions.Author') }}</th>
                                        <th>{{ trans('attentions.Attention Type') }}</th>
                                        <th>{{ trans('attentions.End Date') }}</th>
                                        <th class="actions text-right">{{ trans('table.Actions') }}</th>
                                    </tr>
                                </thead>
                                <transition-group tag="tbody" name="list" mode="in-out">
                                        <tr v-for="(item, index) in attentions" :key="index">
                                            <td><input type="checkbox"></td>
                                            <td><img :src="link + '/storage/' + item.users.avatar" class="img-avatar"> {{ item.users.name }} {{ item.users.last_name }}</td>
                                            <td><span class="label label-primary">{{ item.authors.name }} {{ item.authors.last_name }}</span></td>
                                            <td><span class="label label-info">{{ item.attention_types.name }}</span></td>
                                            <td>{{ item.end_date }}</td>
                                            <td class="no-sort no-click" id="bread-actions">                                
                                                    <a @click="showModal = true" title="delete attention" class="btn btn-sm btn-danger pull-right delete"
                                                        data-id="2" id="delete-2">
                                                            <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Delete</span>
                                                    </a>

                                                    <modal v-if="showModal" @close="showModal = false">
                                                        <h3 slot="header"><i class="voyager-trash"></i> Are you sure you want to delete this attention?</h3>                        
                                                        <button slot="button" @click="removeOption(item.id, index)" class="btn btn-danger delete-confirm">Yes, Delete it!</button>
                                                    </modal>

                                                    <router-link tag="a" :to="{ name: 'attentionsEdit', params: {id: $route.params.id, edit: item.id} }" title="edit attention" class="btn btn-sm btn-primary pull-right edit"
                                                        data-id="2" id="edit-2">
                                                            <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">{{ trans('table.Edit') }}</span>
                                                    </router-link>
                                                    <router-link tage="a" :to="{ name: 'attentionsShow', params: { id: item.id } }" :title="trans('View')" class="btn btn-sm btn-warning pull-right view">
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
    </div>
</template>

<script>
    import {
        VueEditor
    } from "vue2-editor";
    import { DateTime } from 'luxon';
    import Modal from '../modal/Modal'
    export default {
        components: {
            VueEditor,
            Modal,
        },
        props: {
            link: '',
            id: '',
        },
        data() {
            return {
                maxCount: '70',
                showModal: false,
                get: {
                    apiURL: 'attention',
                },
                post: {
                    apiURL: 'attention',
                },
                postTwo: {
                    apiURL: 'attention-post',
                },
                delete: {
                    apiURL: 'attention',
                },
                user: {},
                content: 'Type what is in your mind...',
                end_date: '',
                types: [],
                type: {
                },
                sms: '',
                body: '',
                attentions: [],
                author: {},
            }
        },
        computed: {
        },
        mounted() {
            this.fetch()
        },
        methods: {
            fetch() {
                this.$store.dispatch('retriveAttendtion', {
                        get: this.get,
                        id: this.$route.params.id
                    })
                    .then(response => {
                        this.user = response.data.user
                        this.types = response.data.types
                        this.attentions = response.data.attentions
                        this.auther = response.data.auther
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
                        user_id: this.$route.params.id,
                        post: this.postTwo,
                        type: this.type.id,
                        body: this.body,
                        sms: this.sms,
                        end_date: DateTime.fromISO(this.end_date).toFormat('yyyy-MM-dd hh:mm:ss'),
                    })
                    .then(response => {
                        this.$toast.success({
                            title: response.data
                        })
                        this.fetch()
                        this.type = {}
                        this.body = ''
                        this.sms = ''
                        this.errors.clear();
                    })
            },
            setType() {
                this.body = this.type.body
                this.sms = this.type.sms
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
    .max-length {
        position: absolute;
        right: 30px;
        font-size: 14px;
        bottom: 50px;
        color: #fa2a00;
        font-weight: 500;
    }
</style>
