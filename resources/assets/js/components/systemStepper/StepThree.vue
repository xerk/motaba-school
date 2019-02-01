<template>
    <div style="padding: 2rem 3rem; text-align: left;">
        <div href.prevent="" v-if="!showClassRoom" @click="showClassRoom = true" class="btn btn-sm btn-primary justify-content-md-center">Open Class Room</div>
        <div v-if="showClassRoom" class="row">
            <transition name="list" mode="in-out">
                <div>
                    <div :class="['form-group col-md-3', ($v.form.classRoomAdd.class_edu_id.$error) ? 'has-error' : '']">
                        <select required class="form-control select2" v-model="$v.form.classRoomAdd.class_edu_id.$model">
                            <option value="">{{ trans('configs.Choose Class')}}</option>
                            <option v-for="(item,key) in classEdu" :key="key" :value="item.id">{{ item.name }}</option>
                        </select>
                        <span v-if="$v.form.classRoomAdd.class_edu_id.$error" class="help-block" style="color:#f96868">{{ trans('configs.This class is invalid')}}</span>
                    </div>
                    <div :class="['form-group col-md-4', ($v.form.classRoomAdd.name.$error) ? 'has-error' : '']">
                        <input required="" type="text" class="form-control" v-model.trim="$v.form.classRoomAdd.name.$model"  :placeholder="trans('configs.Type class-room name')" value="">
                        <span v-if="$v.form.classRoomAdd.name.$error" class="help-block" style="color:#f96868">{{ trans('configs.This class-room is invalid')}}</span>
                    </div>
                </div>
            </transition>
            <div class="form-group col-md-12">
                <a @click="saveOptionRoom" class="btn btn-primary" :disabled="save" >{{ trans('configs.Save')}}</a>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Class Education</th>
                                <th>Created At</th>
                                <th class="actions text-right">{{ trans('table.Actions') }}</th>
                            </tr>
                        </thead>
                        <transition-group tag="tbody" name="list" mode="in-out">
                            <tr v-for="(option, key) in $v.form.options.$each.$iter" :key="key">
                            <td>{{ option.$model.name }}</td>
                            <td>{{ option.$model.class_edu ? option.$model.class_edu.name : trans('table.Empty please modify') }}</td>
                            <td>{{ option.$model.created_at }}</td>
                            <td class="actions">
                                <a href.prevent="" @click="openModal(option.$model)" class="btn btn-sm btn-danger pull-right" style="display:inline; margin-right:10px;">
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
        <class-room-modal @update="updateClassRoom" :itemClassRoom="itemClassRoom" v-if="classRoomModal" @close="classRoomModal = false"></class-room-modal>
    </div>
</template>

<script>
    import ModalSystem from '../modal/ModalSystem'
    import ClassRoomModal from '../modal/ClassRoomModal'
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
            ClassRoomModal,
        },
        props: ['clickedNext', 'currentStep'],
        mixins: [validationMixin],
        data() {
            return {
                showModal: false,
                showClassRoom: false,
                classRoomModal: false,
                itemClassRoom: '',
                get: {
                    apiURL: 'system-configs',
                },
                post: {
                    apiURL: 'system-configs/add'
                },
                delete: {
                    apiURL: 'class-room-configs'
                },
                classEdu: [],
                form: {
                    options: [{
                        name: '',
                        class_edu_id: '',
                    }],
                    classRoomAdd: {
                        name: '',
                        class_edu_id: '',
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
                        class_edu_id: {
                            required
                        }
                    }
                },
                classRoomAdd: {
                    name: {
                        required,
                    },
                    class_edu_id: {
                        required
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
            this.fetch()
        },
        methods: {
            openModal(value) {
                this.showModal = true
                this.selectRow = value
            },
            updateClassRoom() {
                this.fetch()
            },
            fetch() {
                this.$store.dispatch('retriveOptions', this.get)
                .then(response => {
                    this.form.options = response.data.classRoom
                    this.classEdu = response.data.classEdu
                })
            },
            stageModalFun(value) {
                this.classRoomModal = true
                this.itemClassRoom = value
            },
            removeOption() {
                this.showModal = false
                let index = this.form.options.indexOf(this.selectRow);
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
            saveOptionRoom() {
                // this.$v.form.$touch()
                // if(!this.$v.$invalid) {
                    // this.save = true
                    this.$store.dispatch('submitForm', {
                        post: this.post,
                        classRoom: this.form.classRoomAdd,
                    })
                    .then(response => {
                        this.$toast.success({
                            title: response.data,
                        })
                        this.form.classRoomAdd.name = ''
                        this.form.classRoomAdd.class_edu_id = ''
                    })
                    this.$store.dispatch('retriveOptions', this.get)
                    .then(response => {
                        this.form.options = response.data.classRoom
                        this.classEdu = response.data.classEdu
                    })
                // }
            }
        }
    }

</script>
