<template>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <form @submit.prevent="" action="">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <h4><img :src="link + '/storage/' + 'users/default.png'" class="img-avatar"> {{duePayments.supplier.name}}</h4>
                            <hr>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <span class="show-field">{{ trans('salary.Company') }}:</span>                                
                                    </div>
                                    <div class="col-md-8">
                                        <span style="font-size:14px" class="show-result">
                                            {{ duePayments.supplier.company }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <span class="show-field">{{ trans('salary.Phone') }}:</span>                                
                                    </div>
                                    <div class="col-md-8">
                                        <span style="font-size:14px" class="show-result">
                                            {{ duePayments.supplier.phone }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <span class="show-field">{{ trans('salary.Address') }}:</span>                                
                                    </div>
                                    <div class="col-md-8">
                                        <span style="font-size:14px" class="show-result">
                                            {{ duePayments.supplier.address }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-9">
                <div class="panel panel-bordered">
                    <div class="panel-title">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="col-md-12">
                                    <button class="btn btn-primary" @click="changeValue" style="float: left">Add Total</button>     
                                </div>
                                <form @submit.prevent="validateBeforSubmit" action="">
                                    <div :class="{'form-group col-md-12': true, 'has-error': errors.has('value') }">
                                        <input required :placeholder="trans('salary.Type your value')" v-validate="'required|numeric|max_value:' + +payableValue" type="number" v-if="editValue == true"  name="value" v-model="model.value" style="margin-top: 3px;" class="form-control"> 
                                        <span v-show="errors.has('value')" class="help-block" style="color:#f96868">{{ errors.first('value') }}</span>
                                    </div>
                                    <div :class="{'form-group col-md-12': true, 'has-error': errors.has('comment') }">
                                            <textarea  :placeholder="trans('salary.Comment')" v-if="editValue == true" v-model="model.comment" v-validate="'min:5|max:500'" name="comment" cols="30" rows="5" class="form-control"></textarea> 
                                            <span v-show="errors.has('comment')" class="help-block" style="color:#f96868">{{ errors.first('comment') }}</span>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <transition name="list">
                                            <button type="submit" class="btn btn-success btn-block" v-if="editValue == true">Save</button>
                                        </transition>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3 pull-right">
                                <span style="font-size:14px" class="show-result">
                                    <h4>{{trans('salary.Payable')}}: {{payableValue = duePayments.payable - duePayments.sum_value}}</h4>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th>{{ trans('salary.Value') }}</th>
                                        <th>{{ trans('salary.Comment') }}</th>
                                        <th class="actions text-right">{{ trans('table.Actions') }}</th>
                                    </tr>
                                </thead>
                                <transition-group tag="tbody" name="list" mode="in-out">
                                    <tr v-for="(item, index) in duePayments.storages" :key="index">
                                        <td><b>{{ item.value }}</b></td>
                                        <td><b>{{ item.comment }}</b></td>
                                        <td class="actions">
                                            <a href.prevent="" @click="openModal(item)" class="btn btn-sm btn-danger pull-right" style="display:inline; margin-right:10px;">
                                                <i class="voyager-trash"></i> {{ trans('table.Delete') }}
                                            </a>
                                        </td>
                                    </tr>
                                </transition-group>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <modal-system :selectRow="selectRow" @confirm="removeOption" v-if="showModal" @close="showModal = false"></modal-system>
        </div>
    </div>
</template>

<script>
import Modal from '../modal/Modal'
import ModalSystem from '../modal/ModalSystem'

    export default {
        components: {
            Modal,
            ModalSystem,
        },
        props: {
            link: '',
            id: '',
        },
        
        data() {
            return {
                editValue: false,
                showModalPayment: false,
                showModal: false,
                get: {
                    apiURL: 'supplier-pay/show',
                },
                post: {
                    apiURL: 'supplier-pay/show',
                },
                delete: {
                    apiURL: 'supplier-pay-show',
                },
                duePayments: {
                    supplier: {}
                },
                sumPayable: '',
                model: {
                    value: '',
                    comment: '',
                }
            }
        },
        computed: {},
        mounted() {
            this.fetch()
        },
        methods: {
            openModal(value) {
                this.showModal = true
                this.selectRow = value
            },
            
            validateBeforSubmit() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.submit()
                    }
                })
            },
            fetch() {
                this.$store.dispatch('retriveAttendtion', {
                        get: this.get,
                        id: this.$route.params.id,
                    })
                    .then(response => {
                        this.duePayments = response.data.duePayments
                    })
            },
            submit() {
                this.$store.dispatch('submitForm', {
                        due_payment_id: this.$route.params.id,
                        post: this.post,
                        model: this.model,
                    })
                    .then(response => {
                        this.$toast.success({
                            title: response.data
                        })
                        this.fetch()
                        this.model.value = ''
                        this.model.comment = ''
                    })
            },
            changeValue() {
                if (this.editValue == false ) {
                    this.editValue = true
                } else {
                    this.editValue = false
                }
                
            },
            removeOption() {
                this.showModal = false
                let index = this.duePayments.storages.indexOf(this.selectRow);
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

    .fade-enter-active,
    .fade-leave-active {
        transition: opacity .5s
    }

    /* Enter and leave animations can use different */
    /* durations and timing functions.              */
    .slide-fade-enter-active {
        transition: all .5s ease;
    }
    .slide-fade-leave-active {
        transition: all .5s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active below version 2.1.8 */ {
        transform: translateX(10px);
        opacity: 0;
    }

    .fade-enter,
    .fade-leave-to

    /* .fade-leave-active in <2.1.8 */
        {
        opacity: 0
    }

    .list-item {
        display: inline-block;
        margin-right: 3px;
    }

    .list-enter-active,
    .list-leave-active {
        transition: all 0.5s;
    }

    .list-enter,
    .list-leave-to

    /* .list-leave-active below version 2.1.8 */
        {
        opacity: 0;
        transform: translateY(30px);
    }

    .show-field {
        font-weight: 400;
    }

    .show-result {
        font-weight: 600;

    }

    .lecture-select-box {
        /* width: 300px; */
        margin-bottom: 5px;
        float: right;
    }

    .row>[class*=col-] {
        margin-bottom: 0px;
    }


</style>
