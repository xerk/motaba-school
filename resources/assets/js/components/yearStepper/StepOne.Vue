<template>
    <div style="padding: 2rem 3rem; text-align: left;">
        <div class="row">
            <transition-group name="list" mode="in-out">
            <div v-for="(option, key) in $v.form.options.$each.$iter" :key="key">
                <div :class="['form-group col-md-8', (option.$error) ? 'has-error' : '']">
                        <input required="" type="text" class="form-control" v-model.trim="option.name.$model"  :placeholder="trans('configs.Type new year ex: 2018/2019')" value="">
                        <span v-if="option.$error" class="help-block" style="color:#f96868">{{ trans('configs.This year is invalid')}}</span>
                </div>
                <div class="form-group col-md-2">
                    <div class="btn btn-danger delete-row" @click="showModal = true">
                        <i class="voyager-trash"></i>
                    </div>
                    <!-- use the modal component, pass in the prop -->
                    <modal v-if="showModal" @close="showModal = false">
                        <!--
                        you can use custom content here to overwrite
                        default content
                        -->
                        <h3 slot="header"><i class="voyager-trash"></i> {{ trans('configs.Are you sure you want to delete this year?')}}</h3>
                        <button slot="button" @click="removeOption(key, option.id.$model)" class="btn btn-danger delete-confirm">{{ trans('table.Yes, Delete it!')}}</button>
                    </modal>
                </div>
            </div>
            </transition-group>
            <div class="form-group col-md-12">
                <a @click="saveOption" class="btn btn-primary" :disabled="save" >{{ trans('configs.Save')}}</a>
                <a @click="addOption" class="btn btn-success">+ {{ trans('configs.Add New Year')}}</a>
            </div>
        </div>
    </div>
</template>

<script>
    import Modal from '../modal/Modal'
    import {
        validationMixin
    } from 'vuelidate'
    import {
        required,
        email
    } from 'vuelidate/lib/validators'

    export default {
        components: {
            Modal,
        },
        props: {
            clickedNext: '',
            currentStep: '',
        },
        mixins: [validationMixin],
        data() {
            return {
                showModal: false,
                get: {
                    apiURL : 'year-configs'
                },
                post: {
                    apiURL: 'year-configs/add'
                },
                delete: {
                    apiURL: 'year-configs'
                },
                form: {
                    options: [{
                        name: ''
                    }],
                },
                save: false
            }
        },
        validations: {
            form: {
                options: {
                    required,
                    $each: {
                        id: '',
                        name: {
                            required,
                        }
                    }
                }
            },
        },
        watch: {
            $v: {
                handler: function (val) {
                    if (!val.$invalid) {
                        this.$emit('can-continue', {
                            value: true
                        });
                    } else {
                        this.$emit('can-continue', {
                            value: false
                        });
                    }
                },
                deep: true
            },
            clickedNext(val) {
                if (val === true) {
                    this.$v.form.$touch();
                }
            },
        },
        mounted() {
            if (!this.$v.$invalid) {
                this.$emit('can-continue', {
                    value: true
                });
            } else {
                this.$emit('can-continue', {
                    value: false
                });
            }
            this.$store.dispatch('retriveOptions', this.get)
                .then(response => {
                    this.form.options = response.data.yearConfig
                })
        },
        methods: {
            removeOption(key, id) {
                this.showModal = false
                this.form.options.splice(key, 1);
                if(id) {
                    this.$store.dispatch('delete', {
                        delete: this.delete,
                        id: id
                    })
                    .then(response => {
                        this.$toast.success({
                            title: 'Successfully',
                            message: response.data
                        })
                    })
                }
            },
            addOption() {
                this.save = false
                this.form.options.push({
                    name: ''
                });
            },
            saveOption() {
                this.$v.form.$touch()
                if(!this.$v.$invalid && this.save == false) {
                    this.save = true
                    this.$store.dispatch('submitForm', {
                        post: this.post,
                        year: this.form.options,
                    })
                    .then(response => {
                        this.$toast.success({
                            title: 'Successfully',
                            message: response.data
                        })
                    })
                    this.$store.dispatch('retriveOptions', this.get)
                    .then(response => {
                        this.form.options = response.data.yearConfig
                    })
                }
            }
        }
    }

</script>
