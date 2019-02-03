<template>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <form @submit.prevent="validateBeforeSubmit" action="">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <h4 class=""><img :src="link + '/storage/' + user.avatar" class="img-avatar"> {{ user.name }} {{ user.last_name }}</h4>
                            <hr>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="show-field">{{ trans('expenses.Basic Expenses') }}:</span>                                
                                    </div>
                                    <div class="col-md-4">
                                        <span style="font-size:14px" class="show-result label label-primary">
                                            ${{ user.class_edu.expenses_cost ? user.class_edu.expenses_cost : '' }}
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
                                            ${{ user.costSum ? user.costSum : 0 }}
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
                                            ${{ user.paySum ? user.paySum : 0 }}
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
                                            ${{ user.discountSum ? user.discountSum : 0 }}
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
                                            ${{ (parseInt(user.class_edu.expenses_cost) +  parseInt(user.costSum)) - (parseInt(user.paySum) + parseInt(user.discountSum)) ? (parseInt(user.class_edu.expenses_cost) +  parseInt(user.costSum)) - (parseInt(user.paySum) + parseInt(user.discountSum)) : user.class_edu.expenses_cost }}
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
                            <table id="dataTable" class="table table-hover dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th>{{ trans('expenses.Created At') }}</th>
                                        <th>{{ trans('expenses.Pay') }}</th>
                                        <th>{{ trans('expenses.Cost') }}</th>
                                        <th>{{ trans('expenses.Discount') }}</th>
                                        <th class="actions text-right">{{ trans('table.Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in user.expenses" :key="index">
                                        <td>
                                            {{ item.created_at }}
                                        </td>
                                        <td><b style="font-weight: 600">${{ item.pay }}</b></td>
                                        <td><b>${{ item.cost }}</b></td>
                                        <td><b>${{ item.discount }}</b></td>
                                        <td class="actions">
                                            <a href.prevent="" @click="showModalPayment = true" class="btn btn-sm btn-danger pull-right" style="display:inline; margin-right:10px;">
                                                <i class="voyager-edit"></i> {{ trans('table.Delete') }}
                                            </a>
                                            <a href.prevent="" @click="editAdd(item)" class="btn btn-sm btn-primary pull-right" style="display:inline; margin-right:10px;">
                                                <i class="voyager-edit"></i> {{ trans('table.Edit') }}
                                            </a>
                                        </td>
                                        <modal v-if="showModalPayment" @close="showModalPayment = false">
                                            <!--
                                            you can use custom content here to overwrite
                                            default content
                                            -->
                                            <h3 slot="header"><i class="voyager-trash"></i> {{ trans('expenses.Are you sure you want to delete this expenses?') }}</h3>                        
                                            <button slot="button" @click.once="deletePayment(item.id, index)" class="btn btn-danger delete-confirm">{{ trans('table.Yes, Delete it!') }}</button>
                                        </modal>
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
                <div :class="{'form-group col-md-12': true, 'has-error': errors.has('pay') }">
                    <label for="pay">{{ trans('expenses.Payment Amount') }}</label>
                    <input required v-model="model.paymentAmount" type="number" v-validate="'numeric'" class="form-control" name="pay">
                    <span v-show="errors.has('pay')" class="help-block" style="color:#f96868">{{ errors.first('pay') }}</span>
                </div>
                <div :class="{'form-group col-md-12': true, 'has-error': errors.has('cost') }">
                    <label for="cost">{{ trans('expenses.Cost') }}</label>
                    <input required v-model="model.cost" type="number" v-validate="'numeric'" class="form-control" name="cost">
                    <span v-show="errors.has('cost')" class="help-block" style="color:#f96868">{{ errors.first('cost') }}</span>
                </div>
                <div :class="{'form-group col-md-12': true, 'has-error': errors.has('discount') }">
                    <label for="discount">{{ trans('expenses.Discount') }}</label>
                    <input required v-model="model.discount" type="number" v-validate="'numeric'" class="form-control" name="discount">
                    <span v-show="errors.has('discount')" class="help-block" style="color:#f96868">{{ errors.first('discount') }}</span>
                </div>
            </div>
            <button slot="button" class="btn btn-success" @click.once="parsist">{{ trans('table.Yes, Save it!') }}</button>
        </make-payment>
        <expenses @getUser="fetch" :list="list" v-if="showModal" @close="showModal = false">
            <h3 slot="header"><i class="voyager-tree"></i> <span style="margin-left: 10px;vertical-align: text-bottom;">{{ trans('expenses.Make Payment') }}. </span></h3>                        
        </expenses>
    </div>
</template>

<script>
    import Expenses from '../modal/Expenses'
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
            MakePayment,
            Modal,
        },
        props: {
            link: '',
            id: '',
        },
        data() {
            return {
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
            paymentClickModal() {
                this.model.paymentAmount = 0
                this.model.cost = 0
                this.model.discount = 0
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
                            })
                    }
                })
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
