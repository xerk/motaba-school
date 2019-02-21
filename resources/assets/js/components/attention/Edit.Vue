<template>
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form @submit.prevent="validateBeforeSubmit" action="">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <h4 v-if="$auth.gender == 1"><img :src="link + '/storage/' + (user.mask == 1 ? 'users/default.png' : user.avatar)" class="img-avatar"> {{ user.name }} {{ user.last_name }}</h4>
                            <h4 v-else><img :src="link + '/storage/' + user.avatar" class="img-avatar"> {{ user.name }} {{ user.last_name }}</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div :class="{'form-group': true, 'has-error': errors.has('type') }">
                                        <label for="type">{{ trans('attentions.Attention Type') }}</label>
                                            <select name="type-error" v-validate="'required'" v-model="attention.attention_type_id" id="type" class="form-control">
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
                            <router-link :to="{ name: 'attentionsShow', params: {id: $route.params.edit} }" @click.native="validateBeforeSubmit" type="submit" class="btn btn-primary">
                                {{ trans('attentions.Update Attention') }}
                            </router-link>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        VueEditor
    } from "vue2-editor";
    import { DateTime } from 'luxon';
    export default {
        components: {
            VueEditor,
        },
        props: {
            link: '',
            id: '',
            edit: '',
        },
        data() {
            return {
                get: {
                    apiURL: 'attention',
                },
                post: {
                    apiURL: 'attention',
                },
                postTwo: {
                    apiURL: 'attention-post',
                },
                user: {},
                content: 'Type what is in your mind...',
                end_date: '2018-09-12 23:15:03',
                types: [],
                type: '',
                author: {},
                attention: {
                    end_date: '',
                    attention_type_id: ''
                },
            }
        },
        computed: {
        },
        mounted() {
            this.fetch()
            setTimeout(() => {
                this.dateEnd()
            }, 1000);
        },
        methods: {
            fetch() {
                this.$store.dispatch('retriveAttendtionEdit', {
                        get: this.get,
                        id: this.$route.params.id,
                        edit: this.$route.params.edit
                    })
                    .then(response => {
                        this.user = response.data.user
                        this.types = response.data.types
                        this.auther = response.data.auther
                        this.attention = response.data.attention
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
                        user_id: this.$route.params.id,
                        post: this.post,
                        type: this.attention.attention_type_id,
                        body: this.attention.body,
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
