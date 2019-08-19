<template>
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-3">
                <form @submit.prevent="validateBeforeSubmit" action="">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <h4 v-if="$auth.gender == 1"><img :src="link + '/storage/' + (user.mask == 1 ? 'users/default.png' : user.avatar)" class="img-avatar"> {{ user.name }} {{ user.last_name }}</h4>
                            <h4 v-else><img :src="link + '/storage/' + user.avatar" class="img-avatar"> {{ user.name }} {{ user.last_name }}</h4>
                            <hr>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="show-field">{{ trans('expenses.Basic Expenses') }}:</span>
                                    </div>
                                    <div class="col-md-4">
                                        <span style="font-size:14px" class="show-result label label-primary">
                                            {{ user.class_edu.expenses_cost ? user.class_edu.expenses_cost : '' }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="show-field">{{ trans('expenses.Total Cost') }}:</span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="show-result">
                                            {{ user.costSum ? user.costSum : 0 }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <!-- <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="show-field">{{ trans('expenses.Total Bus Expenses') }}:</span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="show-result">
                                            {{ user.busExpensesSum ? user.busExpensesSum : 0 }}
                                        </span>
                                    </div>
                                </div>
                            </div> -->
                            <!-- panel-body -->

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="show-field">{{ trans('expenses.Total Indebtedness') }}:</span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="show-result">
                                            {{ user.indebtednessSum ? user.indebtednessSum : 0 }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="show-field">{{ trans('expenses.Total Pay') }}:</span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="show-result">
                                            {{ user.paySum ? user.paySum : 0 }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="show-field">{{ trans('expenses.Total Discount') }}:</span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="show-result">
                                            {{ user.discountSum ? user.discountSum : 0 }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="show-field">{{ trans('expenses.Remaining') }}:</span>
                                    </div>
                                    <div class="col-md-4">
                                        <span style="font-size:14px" class="show-result label label-success">
                                            {{ (parseInt(user.class_edu.expenses_cost) +  parseInt(user.costSum) + parseInt(user.indebtednessSum)) - (parseInt(user.paySum) + parseInt(user.discountSum)) ? (parseInt(user.class_edu.expenses_cost) +  parseInt(user.costSum) + parseInt(user.indebtednessSum)) - (parseInt(user.paySum) + parseInt(user.discountSum)) : user.class_edu.expenses_cost }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-9">
                <div>
                    <a class="btn btn-sm btn-primary" @click="paymentClickModal" :title="trans('expenses.Make Payment')"><i class="voyager-credit-card"></i> {{ trans('expenses.Make Payment') }}</a>
                </div>
                <div class="panel panel-bordered" v-if="user.expenses != ''">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover table-bordered text-center dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th>{{ trans('expenses.Created At') }}</th>
                                        <th>{{ trans('expenses.Serial Number') }}</th>
                                        <th>{{ trans('expenses.Pay date') }}</th>
                                        <th>{{ trans('expenses.Pay') }}</th>
                                        <th>{{ trans('expenses.Cost') }}</th>
                                        <th>{{ trans('expenses.Discount') }}</th>
                                        <!-- <th>{{ trans('expenses.Bus Expenses') }}</th> -->
                                        <th>{{ trans('expenses.Indebtedness') }}</th>
                                        <th class="actions text-right">{{ trans('table.Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in user.expenses" :key="index">
                                        <td>
                                            {{ item.created_at }}
                                        </td>
                                        <td><b style="font-weight: 600">{{ item.serial_number }}</b></td>
                                        <td><b>{{ item.pay_date }}</b></td>
                                        <td><b style="font-weight: 600">{{ item.pay }}</b></td>
                                        <td><b>{{ item.cost }}</b></td>
                                        <td><b>{{ item.discount }}</b></td>
                                        <!-- <td><b>{{ item.bus_expenses }}</b></td> -->
                                        <td><b>{{ item.indebtedness }}</b></td>
                                        <td class="actions">
                                            <a href.prevent="" @click="openModal(item)" class="btn btn-sm btn-danger pull-right" style="display:inline; margin-right:10px;">
                                                <i class="voyager-trash"></i> {{ trans('table.Delete') }}
                                            </a>
                                            <a href.prevent="" @click="editAdd(item)" class="btn btn-sm btn-primary pull-right" style="display:inline; margin-right:10px;">
                                                <i class="voyager-edit"></i> {{ trans('table.Edit') }}
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <make-payment :list="list" v-if="paymentModal" @close="paymentModal = false">
            <h3 slot="header"><i class="voyager-tree"></i> <span style="margin-left: 10px;vertical-align: text-bottom;">{{ trans('expenses.Make Payment') }}. </span></h3>
            <div slot="body">
                <div :class="{'form-group col-md-12': true, 'has-error': errors.has('serial_number') }">
                    <label for="serial_number">{{ trans('expenses.Serial Number') }}</label>
                    <input required v-model="model.serial_number" type="text" :placeholder="trans('expenses.Serial Number')" v-validate="'required'" class="form-control" name="serial_number">
                    <span v-show="errors.has('serial_number')" class="help-block" style="color:#f96868">{{ errors.first('serial_number') }}</span>
                </div>
                <div :class="{'form-group col-md-6': true, 'has-error': errors.has('pay_date') }">
                    <label for="pay_date">{{ trans('expenses.Pay date') }}</label>
                    <input required v-model="model.pay_date" type="date" v-validate="'required'" class="form-control" name="pay_date">
                    <span v-show="errors.has('pay_date')" class="help-block" style="color:#f96868">{{ errors.first('pay_date') }}</span>
                </div>
                <div :class="{'form-group col-md-6': true, 'has-error': errors.has('pay') }">
                    <label for="pay">{{ trans('expenses.Payment Amount') }}</label>
                    <input v-model="model.paymentAmount" type="number" v-validate="'numeric|required'" class="form-control" name="pay">
                    <span v-show="errors.has('pay')" class="help-block" style="color:#f96868">{{ errors.first('pay') }}</span>
                </div>
                <!-- <div :class="{'form-group col-md-6': true, 'has-error': errors.has('bus_expenses') }">
                    <label for="bus_expenses">{{ trans('expenses.Bus Expenses') }}</label>
                    <input v-model="model.bus_expenses" type="number" v-validate="'numeric|required'" class="form-control" name="bus_expenses">
                    <span v-show="errors.has('bus_expenses')" class="help-block" style="color:#f96868">{{ errors.first('bus_expenses') }}</span>
                </div> -->
                <div :class="{'form-group col-md-6': true, 'has-error': errors.has('indebtedness') }">
                    <label for="indebtedness">{{ trans('expenses.Indebtedness') }}</label>
                    <input v-model="model.indebtedness" type="number" v-validate="'numeric|required'" class="form-control" name="indebtedness">
                    <span v-show="errors.has('indebtedness')" class="help-block" style="color:#f96868">{{ errors.first('indebtedness') }}</span>
                </div>
                <div :class="{'form-group col-md-6': true, 'has-error': errors.has('cost') }">
                    <label for="cost">{{ trans('expenses.Cost') }}</label>
                    <input v-model="model.cost" type="number" v-validate="'numeric|required'" class="form-control" name="cost">
                    <span v-show="errors.has('cost')" class="help-block" style="color:#f96868">{{ errors.first('cost') }}</span>
                </div>
                <div :class="{'form-group col-md-6': true, 'has-error': errors.has('discount') }">
                    <label for="discount">{{ trans('expenses.Discount') }}</label>
                    <input v-model="model.discount" type="number" v-validate="'numeric|required'" class="form-control" name="discount">
                    <span v-show="errors.has('discount')" class="help-block" style="color:#f96868">{{ errors.first('discount') }}</span>
                </div>
                <div :class="{'form-group col-md-6': true, 'has-error': errors.has('comment') }">
                    <label for="comment">{{ trans('expenses.Comment') }}</label>
                    <textarea v-model="model.comment" v-validate="''" class="form-control" name="comment"></textarea>
                    <span v-show="errors.has('comment')" class="help-block" style="color:#f96868">{{ errors.first('comment') }}</span>
                </div>
            </div>
            <button slot="button" class="btn btn-success" @click="parsist">{{ trans('table.Yes, Save it!') }}</button>
        </make-payment>
        <expenses @getUser="fetch" :list="list" v-if="showModal" @close="showModal = false">
            <h3 slot="header"><i class="voyager-tree"></i> <span style="margin-left: 10px;vertical-align: text-bottom;">{{ trans('expenses.Make Payment') }}. </span></h3>
        </expenses>
        <modal-system :selectRow="selectRow" @confirm="removeOption" v-if="showModalDelete" @close="showModalDelete = false"></modal-system>
    </div>
</template>

<script>
    import Expenses from '../modal/Expenses'
    import ModalSystem from '../modal/ModalSystem'
    import MakePayment from '../modal/MakePayment'
    import Modal from '../modal/Modal'
    export default {
        created() {
            let recaptchaScript = document.createElement('script')
            recaptchaScript.setAttribute('src', 'https://kamel-ouda.com/js/lang.js')
            document.head.appendChild(recaptchaScript)
        },
        components: {
            Expenses,
            ModalSystem,
            MakePayment,
            Modal,
        },
        props: {
            link: '',
            id: '',
        },
        data() {
            return {
                showModalDelete: false,
                paymentModal: false,
                showModal: false,
                get: {
                    apiURL: 'management-exp',
                },
                post: {
                    apiURL: 'expeneses',
                },
                delete: {
                    apiURL: 'expeneses',
                },
                showModalPayment: false,
                user: {
                    avatar: '',
                    class_edu: {
                        expenses_cost: ''
                    }
                },
                attendance: [],
                attendCount: '',
                lateCount: '',
                absentCount: '',
                holidayCount: '',
                addSalary: {
                    cost: '',
                    absent_day: '',
                },
                dateNow: '',
                month: 0,
                list: {},
                allowances: '',
                deductions: '',
                model: {
                    paymentAmount: 0,
                    cost: 0,
                    discount: 0,
                    serial_number: '',
                    pay_date: new Date().toISOString().slice(0,10),
                    bus_expenses: 0,
                    indebtedness: 0,
                    comment: '',
                },
                makePayments: [],
            }
        },
        computed: {
        },
        mounted() {
            this.fetch()
        },
        methods: {
            openModal(value) {
                this.showModalDelete = true
                this.selectRow = value
            },
            paymentClickModal() {
                this.paymentModal = true
            },
            fetch() {
                this.$store.dispatch('retriveAttendtion', {
                        get: this.get,
                        id: this.$route.params.id,
                    })
                    .then(response => {
                        this.user = response.data.user
                    })
            },
            validateBeforeSubmit() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.parsist()
                    }
                })
            },
            parsist() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.paymentModal = false
                        this.$store.dispatch('submitForm', {
                                user_id: this.$route.params.id,
                                post: this.post,
                                model: this.model,
                            })
                            .then(response => {
                                this.$toast.success({
                                    title: response.data
                                })
                                this.fetch()
                                this.model.paymentAmount = ''
                                this.model.cost = ''
                                this.model.discount = ''
                                this.model.serial_number = ''
                                this.model.pay_date = ''
                                this.model.bus_expenses = ''
                                this.model.indebtedness = ''
                                this.model.comment = ''
                            })
                    }
                })
            },
            removeOption() {
                this.showModalDelete = false
                let index = this.user.expenses.indexOf(this.selectRow);
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
            next() {
                this.month++
                this.fetch()
            },
            prev() {
                this.month--
                this.fetch()
            },
            editAdd(list) {
                this.list = list
                this.showModal = true
            },
            deletePayment(id, key) {
                this.showModalPayment = false
                this.user.expenses.splice(key, 1);
                this.$store.dispatch('delete', {
                    delete: this.delete,
                    id: id
                })
                .then(response => {
                    this.$toast.success({
                        title: response.data
                    })
                    this.fetch()
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
    /* .panel-body {
        border-bottom:1px solid #eee;
    } */
</style>
