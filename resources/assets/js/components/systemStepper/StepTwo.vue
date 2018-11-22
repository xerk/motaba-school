<template>
    <div style="padding: 2rem 3rem; text-align: left;">
        <div class="row">
            <transition-group name="list" mode="in-out">
            <div v-for="(option, key) in $v.form.options.$each.$iter" :key="key">
                <div :class="['form-group col-md-3', (option.$error) ? 'has-error' : '']">
                    <select required class="form-control select2" v-model="option.stage_edu_id.$model">
                        <option value="">Choose stage</option>
                        <option v-for="(item,key) in stageEdu" :key="key" :value="item.id">{{ item.name }}</option>
                    </select>
                    <span v-if="option.$error" class="help-block" style="color:#f96868">This stage is invalid</span>
                </div>
                <div :class="['form-group col-md-4', (option.$error) ? 'has-error' : '']">
                    <select required class="form-control select2" v-model="option.egy_edu_system_id.$model">
                        <option value="">Choose education system</option>
                        <option v-for="(item,key) in eduSystem" :key="key" :value="item.id">{{ item.name }}</option>
                    </select>
                    <span v-if="option.$error" class="help-block" style="color:#f96868">This education system is invalid</span>
                </div>
                <div :class="['form-group col-md-4', (option.$error) ? 'has-error' : '']">
                    <input required="" type="text" class="form-control" v-model.trim="option.name.$model"  placeholder="Type name of class edu." value="">
                    <span v-if="option.$error" class="help-block" style="color:#f96868">This class education is invalid</span>
                </div>
                <div class="form-group col-md-1">
                    <div class="btn btn-danger delete-row" @click="showModal = true">
                        <i class="voyager-trash"></i>
                    </div>
                    <!-- use the modal component, pass in the prop -->
                    <modal v-if="showModal" @close="showModal = false">
                        <!--
                        you can use custom content here to overwrite
                        default content
                        -->
                        <h3 slot="header"><i class="voyager-trash"></i> Are you sure you want to delete this class?</h3>                        
                        <button slot="button" @click="removeOption(key, option.id.$model)" class="btn btn-danger delete-confirm">Yes, Delete it!</button>
                    </modal>
                </div>
                <div style="clear: both;"></div>
            </div>
            </transition-group>
            <div class="form-group col-md-12">
                <a @click="saveOption" class="btn btn-primary" :disabled="save">Save</a>
                <a @click="addOption" class="btn btn-success">+ Add New Class Edu</a>
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
        props: ['clickedNext', 'currentStep'],
        mixins: [validationMixin],
        data() {
            return {
                showModal: false,
                get: {
                    apiURL: 'system-configs',
                },
                post: {
                    apiURL: 'system-configs/add'
                },
                delete: {
                    apiURL: 'class-configs'
                },
                stageEdu: [],
                eduSystem: [],
                form: {
                    options: [{
                        name: '',
                        stage_edu_id: '',
                        egy_edu_system_id: '',
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
                        },
                        stage_edu_id: {
                            required
                        },
                        egy_edu_system_id: {
                            required
                        },
                    }
                }
            }
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
            }
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
                    this.form.options = response.data.classEdu
                    this.stageEdu = response.data.stageEdu
                    this.eduSystem = response.data.eduSystem
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
                    name: '',
                    stage_edu_id: '',
                    egy_edu_system_id: '',
                });
            },
            saveOption() {
                this.$v.form.$touch()
                if(!this.$v.$invalid && this.save == false) {
                    this.save = true
                    this.$store.dispatch('submitForm', {
                        post: this.post,
                        class: this.form.options,
                    })
                    .then(response => {
                        this.$toast.success({
                            title: 'Successfully',
                            message: response.data
                        })
                    })
                    this.$store.dispatch('retriveOptions', this.get)
                    .then(response => {
                        this.form.options = response.data.classEdu
                        this.stageEdu = response.data.stageEdu
                        this.eduSystem = response.data.eduSystem
                    })
                }
            }
        }
    }

</script>
