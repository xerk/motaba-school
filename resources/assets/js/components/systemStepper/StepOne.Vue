<template>
    <div style="padding: 2rem 3rem; text-align: left;">
        <div href.prevent="" v-if="!showStage" @click="showStage = true" class="btn btn-sm btn-primary justify-content-md-center">Open Stage</div>
        <div v-if="showStage" class="row">
            <transition name="list" mode="in-out">
                <div>
                    <div :class="['form-group col-md-12', ($v.form.stageAdd.name.$error) ? 'has-error' : '']">
                        <input required="" type="text" class="form-control" v-model.trim="$v.form.stageAdd.name.$model" :placeholder="trans('configs.Stage education')" value="">
                         <span v-if="$v.form.stageAdd.name.$error" class="help-block" style="color:#f96868">{{ trans('configs.This stage is invalid')}}</span>
                    </div>
                    <div class="form-group col-md-12">
                        <textarea class="form-control" v-model.trim="$v.form.stageAdd.description.$model" placeholder="Type description." value=""></textarea>
                    </div>
                </div>
            </transition>
            <div class="form-group col-md-12">
                <a @click="saveOption" class="btn btn-primary" :disabled="save" >{{ trans('configs.Save')}}</a>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Body</th>
                                <th>Created At</th>
                                <th class="actions text-right">{{ trans('table.Actions') }}</th>
                            </tr>
                        </thead>
                        <transition-group tag="tbody" name="list" mode="in-out">
                            <tr v-for="(option, key) in $v.form.options.$each.$iter" :key="key">
                            <td>{{ option.$model.name }}</td>
                            <td>{{ option.$model.description }}</td>
                            <td>{{ option.$model.created_at }}</td>
                            <td class="actions">
                                <a href.prevent="" @click="sopenModal(option.$model)" class="btn btn-sm btn-danger pull-right" style="display:inline; margin-right:10px;">
                                    <i class="voyager-trash"></i> {{ trans('table.Delete') }}
                                </a>
                                <a href.prevent="" @click="stageModalFun(option)" class="btn btn-sm btn-primary pull-right" style="display:inline; margin-right:10px;">
                                    <i class="voyager-edit"></i> {{ trans('salary.Modify') }}
                                </a>
                            </td>
                            </tr>
                        </transition-group>
                    </table>
                </div>
            </div>
        </div>
        <modal-system :selectRow="selectRow" @confirm="removeOption" v-if="showModal" @close="showModal = false"></modal-system>
        <stage-modal :itemStage="itemStage" v-if="stageModal" @close="stageModal = false"></stage-modal>
    </div>
</template>

<script>
    import ModalSystem from '../modal/ModalSystem'
    import StageModal from '../modal/StageModal'
    import {
        validationMixin
    } from 'vuelidate'
    import {
        required,
        email
    } from 'vuelidate/lib/validators'

    export default {
        components: {
            ModalSystem,
            StageModal,
        },
        props: {
            clickedNext: '',
            currentStep: '',
        },
        mixins: [validationMixin],
        data() {
            return {
                showModal: false,
                stageModal: false,
                showStage: false,
                itemStage: '',
                get: {
                    apiURL : 'system-configs'
                },
                post: {
                    apiURL: 'system-configs/add'
                },
                delete: {
                    apiURL: 'system-configs'
                },
                form: {
                    options: [{
                        name: '',
                        description: '',
                    }],
                    stageAdd: {
                        name: '',
                        description: '',
                    }
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
                        description: '',
                    }
                },
                stageAdd: {
                    name: {
                        required,
                    },
                    description: '',
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
                            value: true
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
                    value: true
                });
            }
            this.$store.dispatch('retriveOptions', this.get)
                .then(response => {
                    this.form.options = response.data.stageEdu
                })
        },
        methods: {
            openModal(value) {
                this.showModal = true
                this.selectRow = value
            },
            stageModalFun(value) {
                this.stageModal = true
                this.itemStage = value
            },
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
                            title: response.data
                        })
                    })
                }
            },
            saveOption() {
                // this.$v.form.$touch()
                // if(!this.$v.$invalid && this.save == false) {
                    // this.save = true
                    this.$store.dispatch('submitForm', {
                        post: this.post,
                        stage: this.form.stageAdd,
                    })
                    .then(response => {
                        this.$toast.success({
                            title: response.data,
                        })
                        this.form.stageAdd.name = ''
                        this.form.stageAdd.description = ''
                    })
                    this.$store.dispatch('retriveOptions', this.get)
                    .then(response => {
                        this.form.options = response.data.stageEdu
                    })
                // }
            }
        }
    }

</script>
