<template>
    <div style="padding: 2rem 3rem; text-align: left;">
        <div href.prevent="" v-if="!showClass" @click="showClass = true" class="btn btn-sm btn-primary justify-content-md-center">Open Class Education</div>
        <div v-if="showClass" class="row">
            <transition name="list" mode="in-out">
                <div>
                    <div :class="['form-group col-md-3', ($v.form.classAdd.stage_edu_id.$error) ? 'has-error' : '']">
                        <select required class="form-control select2" v-model="$v.form.classAdd.stage_edu_id.$model">
                            <option value="">{{ trans('configs.Choose stage')}}</option>
                            <option v-for="(item,key) in stageEdu" :key="key" :value="item.id">{{ item.name }}</option>
                        </select>
                        <span v-if="$v.form.classAdd.stage_edu_id.$error" class="help-block" style="color:#f96868">{{ trans('configs.This stage is invalid')}}</span>
                    </div>
                    <div :class="['form-group col-md-4', ($v.form.classAdd.egy_edu_system_id.$error) ? 'has-error' : '']">
                        <select required class="form-control select2" v-model="$v.form.classAdd.egy_edu_system_id.$model">
                            <option value="">{{ trans('configs.Choose education system')}}</option>
                            <option v-for="(item,key) in eduSystem" :key="key" :value="item.id">{{ item.name }}</option>
                        </select>
                        <span v-if="$v.form.classAdd.egy_edu_system_id.$error" class="help-block" style="color:#f96868">{{ trans('configs.This education system is invalid')}}</span>
                    </div>
                    <div :class="['form-group col-md-4', ($v.form.classAdd.name.$error) ? 'has-error' : '']">
                        <input required="" type="text" class="form-control" v-model.trim="$v.form.classAdd.name.$model"  :placeholder="trans('configs.Type name of class edu')" value="">
                        <span v-if="$v.form.classAdd.name.$error" class="help-block" style="color:#f96868">{{ trans('configs.This class education is invalid')}}</span>
                    </div>
                </div>
            </transition>
            <div class="form-group col-md-12">
                <a @click="saveOptionClass" class="btn btn-primary" :disabled="save" >{{ trans('configs.Save')}}</a>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Stage Education</th>
                                <th>Education System</th>
                                <th>Created At</th>
                                <th class="actions text-right">{{ trans('table.Actions') }}</th>
                            </tr>
                        </thead>
                        <transition-group tag="tbody" name="list" mode="in-out">
                            <tr v-for="(option, key) in $v.form.options.$each.$iter" :key="key">
                                <td>{{ option.$model.name }}</td>
                                <td>{{ option.$model.stage_edu ? option.$model.stage_edu.name : trans('table.Empty please modify') }}</td>
                                <td>{{ option.$model.egy_edu_system ? option.$model.egy_edu_system.name : trans('table.Empty please modify') }}</td>
                                <td>{{ option.$model.created_at }}</td>
                                <td class="actions">
                                    <a href.prevent="" @click="openModal(option.$model)" class="btn btn-sm btn-danger pull-right" style="display:inline; margin-right:10px;">
                                        <i class="voyager-trash"></i> {{ trans('table.Delete') }}
                                    </a>
                                    <a href.prevent="" @click="classModalFun(option)" class="btn btn-sm btn-primary pull-right" style="display:inline; margin-right:10px;">
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
        <class-modal @update="updateClass" :itemClass="itemClass" v-if="classModal" @close="classModal = false"></class-modal>
    </div>
</template>

<script>
    import ModalSystem from '../modal/ModalSystem'
    import ClassModal from '../modal/ClassModal'
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
            ClassModal,
        },
        props: ['clickedNext', 'currentStep'],
        mixins: [validationMixin],
        data() {
            return {
                showModal: false,
                showClass: false,
                classModal: false,
                itemClass: '',
                selectRow: null,
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
                    classAdd: {
                        name: '',
                        stage_edu_id: '',
                        egy_edu_system_id: '',
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
                        stage_edu_id: {
                            required
                        },
                        egy_edu_system_id: {
                            required
                        },
                    }
                },
                classAdd: {
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
            }
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
            this.fetch()
        },
        methods: {
            openModal(value) {
                this.showModal = true
                this.selectRow = value
            },
            updateClass(value) {
                this.fetch()
            },
            fetch() {
                this.$store.dispatch('retriveOptions', this.get)
                    .then(response => {
                        this.form.options = response.data.classEdu
                        this.stageEdu = response.data.stageEdu
                        this.eduSystem = response.data.eduSystem
                    })
            },
            classModalFun(value) {
                this.classModal = true
                this.itemClass = value
            },
            removeOption() {
                this.showModal = false;
                let index = this.form.options.indexOf(this.selectRow);
                this.form.options.splice(index, 1);
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
                    this.selectRow = null;
            },
            saveOptionClass() {
                // this.$v.form.$touch()
                // if(!this.$v.$invalid) {
                    // this.save = true
                    this.$store.dispatch('submitForm', {
                        post: this.post,
                        class: this.form.classAdd,
                    })
                    .then(response => {
                        this.$toast.success({
                            title: response.data,
                        })
                        this.form.classAdd.name = ''
                        this.form.classAdd.stage_edu_id = ''
                        this.form.classAdd.egy_edu_system_id = ''
                    })
                    this.$store.dispatch('retriveOptions', this.get)
                    .then(response => {
                        this.form.options = response.data.classEdu
                        this.stageEdu = response.data.stageEdu
                        this.eduSystem = response.data.eduSystem
                    })
                // }
            }
        }
    }

</script>
