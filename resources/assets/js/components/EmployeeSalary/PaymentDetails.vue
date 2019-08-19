<template>
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="content-header" style="display: none">
                <div class="row">
                    <div class="col-print-4 pull-left" style="padding-left: 10px">
                        <img src="https://kamel-ouda.com/images/logo/PNG-24.png" alt="Logo" style="width:75px" class='img-responsive' />
                    </div>
                    <div class="col-print-4 text-center">
                        <h3 class="text-center" v-if="user"><span>{{ user.name }} {{ user.last_name }} سجل راتب</span></h3>
                    </div>
                    <div class='col-print-4' style="padding-right: 10px">
                        <ul class="list-unstyled timetable-list text-center pull-right">
                            <li>الأزهر الشريف</li>
                            <li>منطقة الجيزه الأزهريه</li>
                            <li>معهد كامل عودة الأزهري الخاص</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="content-footer" style="display:none">
                <div class="row">
                    <div class="col-print-4 text-center" style="padding-left: 10px">
                        <ul class="list-unstyled">
                            <li>عميد المعهد</li>
                            <li>أ/سعيد عيسي</li>
                        </ul>
                    </div>
                    <div class="col-sm-4 col-print-4 text-center">
                        <ul class="list-unstyled">
                            <li>المدير المالي</li>
                            <li>أ/خالد إبراهيم</li>
                        </ul>
                    </div>
                    <div class='col-print-4 text-center' style="padding-right: 10px">
                        <ul class="list-unstyled">
                            <li>شئون العاملين</li>
                            <li>أ/عبير السيد</li>
                        </ul>
                    </div>
                </div>
                <span style="position: fixed;bottom: 0;font-size: 12px;padding: 3px;font-weight: 400;"><img src="https://kamel-ouda.com/images/logo/motawer-black.png" alt="Logo" style="width:32px;display: inline;margin-right: 5px;" class='img-responsive' /> Powered by MOTAWER</span>
            </div>
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
                                        <span class="show-field">{{ trans('salary.Basic Salary') }}:</span>
                                    </div>
                                    <div class="col-md-4">
                                        <span style="font-size:14px" class="show-result label label-primary">
                                            {{ cost =  addSalary.cost + addSalary.bonus + addSalary.may_grant + addSalary.prev_year_bonus + addSalary.share_employer + addSalary.share_employee + addSalary.variable_wages }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="show-field">{{ trans('salary.Absent') }} - {{ addSalary.absent_day }}:</span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="show-result">
                                            {{ absent = addSalary.absent_day * absentCount}}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="show-field">{{ trans('salary.Absence of patients') }} - {{ Math.round(addSalary.absent_day / 4, 2) }}:</span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="show-result">
                                            {{ absentPatient = (addSalary.absent_day * patientCount) / 4}}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="show-field">{{ trans('salary.Late') }} - {{ addSalary.late_day }}:</span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="show-result">
                                            {{ late = addSalary.late_day * lateCount}}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="show-field">{{ trans('salary.Total Allowances') }}:</span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="show-result">
                                            {{ allowances }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="show-field">{{ trans('salary.Total Deductions') }}:</span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="show-result">
                                            {{ deductions }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="show-field">{{ trans('salary.Total Salary') }}:</span>
                                    </div>
                                    <div class="col-md-4">
                                        <span style="font-size:14px" class="show-result label label-success">
                                            {{ (parseInt(cost) +  parseInt(allowances)) - (parseInt(deductions) + parseInt(absent) + parseInt(absentPatient) + parseInt(late)) }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->
                            <h4 class="text-center"><i class="voyager-check"></i> {{ trans('salary.Attendance') }}</h4>
                            <hr>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="show-field">{{ trans('salary.Total Attend') }}:</span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="label label-success">
                                            {{ attendCount }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="show-field">{{ trans('salary.Total Absent') }}:</span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="label label-danger">
                                            {{ absentCount }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="show-field">{{ trans('salary.Total absence of patients') }}:</span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="label label-danger">
                                            {{ patientCount }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="show-field">{{ trans('salary.Total Holiday') }}:</span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="label label-primary">
                                            {{ holidayCount }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="show-field">{{ trans('salary.Total Late') }}:</span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="label label-warning">
                                            {{ lateCount }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="show-field">{{ trans('salary.Total delayed supervision') }}:</span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="label label-warning">
                                            {{ supervisionCount }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="show-field">{{ trans('salary.Total delay permissions') }}:</span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="label label-warning">
                                            {{ permissionsCount }}
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
                    <a class="btn btn-sm btn-primary" @click="paymentClickModal" :title="trans('salary.Pay Salary')"><i class="voyager-credit-card"></i> {{ trans('salary.Pay Salary') }}</a>
                    <router-link @click.native="next" class="btn btn-sm  btn-primary pull-right edit" style="padding: 5px 10px;" tag="a" :to="{name: 'paymentDetails', query: {'month': month+1,}}" :title="trans('table.Next')">
                        <span class="hidden-xs hidden-sm"></span> <i class="voyager-double-right"></i>
                    </router-link>
                    <router-link @click.native="prev" class="btn btn-sm  btn-primary pull-right edit" style="padding: 5px 10px;" :title="trans('table.Prev')" tag="a" :to="{name: 'paymentDetails', query: {'month': month-1,}}">
                        <span class="hidden-xs hidden-sm"></span> <i class="voyager-double-left"></i>
                    </router-link>
                    <button class="btn btn-sm disabled pull-right" style="padding: 4px 15px;">{{ dateNow | moment("(MM) MMMM - YYYY") }}</button>
                </div>
                <div class="panel panel-bordered">
                    <!-- <div class="panel-title">
                        <h3><i class="icon voyager-bell"></i> Attentions</h3>
                    </div> -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th>{{ trans('salary.Attendance') }}</th>
                                        <th>{{ trans('salary.Date') }}</th>
                                        <th>{{ trans('salary.Total Allowances') }}</th>
                                        <th>{{ trans('salary.Total Deductions') }}</th>
                                        <th>{{ trans('salary.Comment') }}</th>
                                        <th class="actions text-right">{{ trans('table.Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in user.attendance" :key="index">
                                        <td>
                                            <span v-if="item.status == 1" class="label label-success">{{ trans('salary.Attend') }}</span>
                                            <span v-if="item.status == 2" class="label label-primary">{{ trans('salary.Holiday') }}</span>
                                            <span v-if="item.status == 3" class="label label-danger">{{ trans('salary.Absent') }}</span>
                                            <span v-if="item.status == 4" class="label label-warning">{{ trans('salary.Late') }}</span>
                                            <span v-if="item.status == 5" class="label label-danger">{{ trans('attendance.Absence of patients') }}</span>
                                            <span v-if="item.status == 6" class="label label-warning">{{ trans('attendance.Delayed supervision') }}</span>
                                            <span v-if="item.status == 7" class="label label-warning">{{ trans('attendance.Delay permissions') }}</span>
                                        </td>
                                        <td>{{ item.attend_date }}</td>
                                        <td><b>{{ item.additional + item.bonus + item.incentive + item.reward + item.allowance }}</b></td>
                                        <td><b>{{ item.loan + item.penalty + item.discount }}</b></td>
                                        <td>{{ item.comment }}</td>
                                        <td class="actions">
                                            <a href.prevent="" @click="editAdd(item)" class="btn btn-sm btn-primary pull-right" style="display:inline; margin-right:10px;">
                                                <i class="voyager-edit"></i> {{ trans('salary.Modify') }}
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-bordered">
                    <!-- <div class="panel-title">
                        <h3><i class="icon voyager-bell"></i> Attentions</h3>
                    </div> -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="users-table" class="table table-hover dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th>{{ trans('salary.Payment Method') }}</th>
                                        <th>{{ trans('salary.Net Salary') }}</th>
                                        <th>{{ trans('salary.Payment Amount') }}</th>
                                        <th>{{ trans('salary.Created At') }}</th>
                                        <th class="actions text-right">{{ trans('table.Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in makePayments" :key="index">
                                        <td>
                                            <span v-if="item.payment_method == 'cash'" class="label label-success">{{ trans('salary.Cash') }}</span>
                                            <span v-if="item.payment_method == 'credit'" class="label label-primary">{{ trans('salary.Credit Card') }}</span>
                                        </td>
                                        <td>{{ item.net_salary }}</td>
                                        <td>{{ item.payment_amount }}</td>
                                        <td>{{ item.created_at }}</td>
                                        <td class="actions">
                                            <a href.prevent="" @click="openModal(item)" class="btn btn-sm btn-danger pull-right" style="display:inline; margin-right:10px;">
                                                <i class="voyager-edit"></i> Delete
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
            <h3 slot="header"><i class="voyager-tree"></i> <span style="margin-left: 10px;vertical-align: text-bottom;">{{ trans('salary.Make Payment') }}</span></h3>
            <div slot="body">
                <div :class="{'form-group col-md-12': true, 'has-error': errors.has('payment-method') }">
                    <label for="payment-method">{{ trans('salary.Payment method') }}</label>
                    <select required="required" id="payment-method" v-validate="'required'" v-model="model.paymentMethod" class="form-control" name="payment-method">
                        <option value="">{{ trans('salary.Choose Payment Method') }}</option>
                        <option value="cash">{{ trans('salary.Cash') }}</option>
                        <option value="credit">{{ trans('salary.Credit Card') }}</option>
                    </select>
                    <span v-show="errors.has('payment-method')" class="help-block" style="color:#f96868">{{ errors.first('payment-method') }}</span>
                </div>
                <div :class="{'form-group col-md-6': true, 'has-error': errors.has('net_salary') }">
                    <label for="net_salary">{{ trans('salary.Net Salary') }}</label>
                    <input required v-model="model.netSalary" type="number" v-validate="'numeric'" class="form-control" name="net_salary">
                    <span v-show="errors.has('net_salary')" class="help-block" style="color:#f96868">{{ errors.first('net_salary') }}</span>
                </div>
                <div :class="{'form-group col-md-6': true, 'has-error': errors.has('payment-amount') }">
                    <label for="payment-amount">{{ trans('salary.Payment Amount') }}</label>
                    <input required v-model="model.paymentAmount"  type="number" v-validate="'numeric'" class="form-control" name="payment-amount">
                    <span v-show="errors.has('payment-amount')" class="help-block" style="color:#f96868">{{ errors.first('payment-amount') }}</span>
                </div>
                <div class="form-group col-md-12">
                    <label for="comment">{{ trans('salary.Comment') }}</label>
                    <textarea v-model="model.comment" class="form-control" name="comment"></textarea>
                </div>
            </div>
            <button slot="button" class="btn btn-success" @click="parsist">{{ trans('table.Yes, Save it!') }}</button>
        </make-payment>
        <salary @getAttend="fetch" :list="list" v-if="showModal" @close="showModal = false">
            <h3 slot="header"><i class="voyager-tree"></i> <span style="margin-left: 10px;vertical-align: text-bottom;">{{ trans('salary.Make Payment') }} ({{ list.attend_date }}). </span></h3>
        </salary>
        <modal-system :selectRow="selectRow" @confirm="removeOption" v-if="showModalDelete" @close="showModalDelete = false"></modal-system>
    </div>
</template>

<script>
    import Salary from '../modal/Salary'
    import ModalSystem from '../modal/ModalSystem'
    import MakePayment from '../modal/MakePayment'
    import Modal from '../modal/Modal'
    export default {
        components: {
            Salary,
            MakePayment,
            Modal,
            ModalSystem,
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
                    apiURL: 'employee-details',
                },
                post: {
                    apiURL: 'make-payment',
                },
                delete: {
                    apiURL: 'make-payment',
                },
                showModalDelete: false,
                selectRow: {},
                user: {},
                attendance: [],
                attendCount: '',
                lateCount: '',
                supervisionCount: '',
                permissionsCount: '',
                absentCount: '',
                patientCount: '',
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
                    paymentMethod: 'cash',
                    netSalary: '',
                    paymentAmount: '',
                    comment: '',
                },
                makePayments: [],
            }
        },
        computed: {
        },
        mounted() {
            this.fetch()
            setTimeout(() => {
                this.dataTables()
            }, 2000);
        },
        methods: {
            openModal(value) {
                this.showModalDelete = true
                this.selectRow = value
            },
            paymentClickModal() {
                var tSalary = (parseInt(this.cost) +  parseInt(this.allowances)) - (parseInt(this.deductions) + parseInt((this.addSalary.absent_day * this.absentCount)) + parseInt(((this.addSalary.absent_day / 4) * this.patientCount)))
                this.model.netSalary = tSalary
                this.model.paymentAmount = tSalary
                this.paymentModal = true
            },
            fetch() {
                this.$store.dispatch('retrivePayemtnDetails', {
                        get: this.get,
                        id: this.$route.params.id,
                        month: this.month
                    })
                    .then(response => {
                        this.user = response.data.user
                        this.attendCount = response.data.attendCount
                        this.holidayCount = response.data.holidayCount
                        this.lateCount = response.data.lateCount
                        this.supervisionCount = response.data.supervisionCount
                        this.permissionsCount = response.data.permissionsCount
                        this.absentCount = response.data.absentCount
                        this.patientCount = response.data.patientCount
                        this.addSalary = response.data.addSalary
                        this.dateNow = response.data.date
                        this.allowances = response.data.allowances
                        this.deductions = response.data.deductions
                        this.makePayments = response.data.makePayments
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
                                $('#users-table').DataTable().destroy();
                                setTimeout(() => {
                                    this.dataTables()
                                }, 2000);
                            })
                    }
                })
            },
            removeOption() {
                this.showModalDelete = false
                let index = this.makePayments.indexOf(this.selectRow);
                this.$store.dispatch('delete', {
                    delete: this.delete,
                    id: this.selectRow.id
                })
                .then(response => {
                    this.$toast.success({
                        title: response.data,
                    })
                    this.fetch()
                    this.makePayments.splice(index, 1)
                    $('#users-table').DataTable().destroy();
                    setTimeout(() => {
                        this.dataTables()
                    }, 2000);
                })
                this.selectRow = null;
            },
            dataTables() {
                $(function() {
                    $('#users-table').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'print',
                                autoPrint: false,
                                text: '<i class="fa fa-print" aria-hidden="true"></i> طباعة',
                                customize: function (win) {
                                    $(win.document.body)
                                    .css('font-size', '11px')
                                    $(win.document.body).find('div').first()
                                        .prepend( $( ".content-header" ).clone().css({
                                                'display': 'block',
                                        }) )

                                    $(win.document.body).find('div').last()
                                        .prepend( $( ".content-footer" ).clone().css({
                                                'display': 'block',
                                                'margin-top': '20px',
                                        }) )

                                    $(win.document.body).find('h1')
                                        .css('display', 'none')
                                    $(win.document.body).find('table')
                                        .addClass('timetable-table')
                                        .css('direction', 'rtl')
                                    $(win.document.body).find('th')
                                        .css({
                                                'text-align': 'center',
                                                'border': '2px solid #000',
                                                'vertical-align': 'middle',
                                                'text-align': 'center',
                                            })
                                    $(win.document.body).find('td')
                                        .css({
                                            'text-align': 'center',
                                            'vertical-align': 'middle',
                                            'border': '1px solid #EAEAEA',
                                        })
                                    $(win.document.body).find('th:last-child, td:last-child')
                                        .css({
                                            'display': 'none',
                                        })

                                }
                            },
                        ],
                        searching: false,
                        paging: false,
                        ordering: false,
                        serverSide: false,
                        select: true

                    });
                });
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
                this.showModalDelete = false
                this.makePayments.splice(key, 1);
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
    @media print {
        .timetable-font-size {
            font-size: 14px
        }
        .col-print-1 {width:8%;  float:left;}
        .col-print-2 {width:16%; float:left;}
        .col-print-3 {width:25%; float:left;}
        .col-print-4 {width:33%; float:left;}
        .col-print-5 {width:42%; float:left;}
        .col-print-6 {width:50%; float:left;}
        .col-print-7 {width:58%; float:left;}
        .col-print-8 {width:66%; float:left;}
        .col-print-9 {width:75%; float:left;}
        .col-print-10{width:83%; float:left;}
        .col-print-11{width:92%; float:left;}
        .col-print-12{width:100%; float:left;}
    }
</style>
