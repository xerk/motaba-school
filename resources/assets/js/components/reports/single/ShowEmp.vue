<template>
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <h4 class=""><img :src="link + '/storage/' + user.avatar" class="img-avatar"> {{ user.name }} {{ user.last_name }}</h4>
                        <hr>
                        <div class="panel-body">
                            <button @click="absentReport" class="btn btn-primary btn-block">{{ trans('reports.Absent report') }}</button>
                            <button @click="salaryReport" class="btn btn-primary btn-block">{{ trans('reports.Salary report') }}</button>
                        </div><!-- panel-body -->


                        <!-- <h4 class="text-center"><i class="voyager-check"></i> {{ trans('salary.Attendance') }}</h4> -->
                        <hr>

                    </div>
                </div>
            </div>
            <transition name="list" mode="in-out">
            <div class="col-md-9" v-show="absentShow == true">
                <div>
                    <a class="btn btn-sm btn-primary" :title="trans('reports.Print')"><i class="voyager-credit-card"></i> {{ trans('reports.Print') }}</a>
                    <router-link @click.native="next" class="btn btn-sm  btn-primary pull-right edit" style="padding: 5px 10px;" tag="a" :to="{name: 'singleStudentRepoShow', query: {'month': month+1,}}" :title="trans('table.Next')">
                        <span class="hidden-xs hidden-sm"></span> <i class="voyager-double-right"></i>
                    </router-link>
                    <router-link @click.native="prev" class="btn btn-sm  btn-primary pull-right edit" style="padding: 5px 10px;" :title="trans('table.Prev')" tag="a" :to="{name: 'singleStudentRepoShow', query: {'month': month-1,}}">
                        <span class="hidden-xs hidden-sm"></span> <i class="voyager-double-left"></i>
                    </router-link>
                    <button class="btn btn-sm disabled pull-right" style="padding: 4px 15px;">{{ date | moment("dddd, Do MM YY") }}</button>
                </div>
                <div class="panel panel-bordered">
                    <div class="panel-title">
                        <h3><i class="icon voyager-list"></i> {{ trans('reports.Absent report') }}</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <span class="show-field">{{ trans('salary.Total Attend') }}:</span>
                            </div>
                            <div class="col-md-1">
                                <span style="font-size:14px" class="show-result label label-success">
                                    {{ user.count_attend }}
                                </span>
                            </div>
                            <div class="col-md-2">
                                <span class="show-field">{{ trans('salary.Total Holiday') }}:</span>
                            </div>
                            <div class="col-md-1">
                                <span style="font-size:14px" class="show-result label label-primary">
                                    {{ user.count_holiday }}
                                </span>
                            </div>
                            <div class="col-md-2">
                                <span class="show-field">{{ trans('salary.Total Absent') }}:</span>
                            </div>
                            <div class="col-md-1">
                                <span style="font-size:14px" class="show-result label label-danger">
                                    {{ user.count_absent }}
                                </span>
                            </div>
                            <div class="col-md-2">
                                <span class="show-field">{{ trans('salary.Total Absent') }}:</span>
                            </div>
                            <div class="col-md-1">
                                <span style="font-size:14px" class="show-result label label-warning">
                                    {{ user.count_late }}
                                </span>
                            </div>
                            <hr>
                            <div class="container" style="margin-top:20px">
                                <hr>
                                <div class="table-responsive" v-if="attendance">
                                    <table id="dataTable" class="table table-hover dataTable no-footer">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('reports.Status') }}</th>
                                                <th>{{ trans('attendance.Date') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in attendance.attendance" :key="index">
                                                <td>
                                                    <span v-if="item.status == 3" class="label label-danger">{{ trans('salary.Absent') }}</span>
                                                    <span v-if="item.status == 4" class="label label-warning">{{ trans('salary.Late') }}</span>
                                                </td>
                                                <td>{{ item.attend_date }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center" v-else>
                                    <h3 >{{ trans('reports.This student has not been absent all month!')}}.</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </transition>
            <transition name="list" mode="in-out">
                <div class="col-md-9" v-show="salary == true">
                    <div class="panel panel-bordered">
                        <div class="panel-title">
                            <h3><i class="icon voyager-list"></i> {{ trans('reports.Salary report') }}</h3>
                        </div>
                        <div class="panel-body">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="show-field">{{ trans('salary.Basic Salary') }}:</span>
                                    </div>
                                    <div class="col-md-4">
                                        <span style="font-size:14px" class="show-result label label-primary">
                                            {{ cost =  addSalary.cost + addSalary.bonus + addSalary.may_grant + addSalary.prev_year_bonus + addSalary.share_employer + addSalary.variable_wages }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- panel-body -->

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="show-field">{{ trans('salary.Absent') }} (${{ addSalary.absent_day }}):</span>
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
                                        <span class="show-field">{{ trans('salary.Late') }} (${{ addSalary.late_day }}):</span>
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
                                            {{ (parseInt(cost) +  parseInt(allowances)) - (parseInt(deductions) + parseInt(absent) + parseInt(late)) }}
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
                                <hr>
                                <div class="container" style="margin-top:20px">
                                    <div class="table-responsive" v-if="userTwo.attendance">
                                        <table id="dataTable" class="table table-hover dataTable no-footer">
                                            <thead>
                                                <tr>
                                                    <th>{{ trans('salary.Attendance') }}</th>
                                                    <th>{{ trans('salary.Date') }}</th>
                                                    <th>{{ trans('salary.Total Allowances') }}</th>
                                                    <th>{{ trans('salary.Total Deductions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item, index) in userTwo.attendance" :key="index">
                                                    <td>
                                                        <span v-if="item.status == 1" class="label label-success">{{ trans('salary.Attend') }}</span>
                                                        <span v-if="item.status == 2" class="label label-primary">{{ trans('salary.Holiday') }}</span>
                                                        <span v-if="item.status == 3" class="label label-danger">{{ trans('salary.Absent') }}</span>
                                                        <span v-if="item.status == 4" class="label label-warning">{{ trans('salary.Late') }}</span>
                                                    </td>
                                                    <td>{{ item.attend_date }}</td>
                                                    <td><b>{{ item.additional + item.bonus + item.incentive + item.reward + item.allowance }}</b></td>
                                                    <td><b>{{ item.loan + item.penalty + item.discount }}</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-center" v-else>
                                        <h3 >{{ trans('reports.This student has not been absent all month!')}}.</h3>
                                    </div>
                                    <hr>
                                    <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover dataTable no-footer">
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
                                                    <a href.prevent="" @click="showModalPayment = true" class="btn btn-sm btn-danger pull-right" style="display:inline; margin-right:10px;">
                                                        <i class="voyager-edit"></i> Delete
                                                    </a>
                                                </td>
                                                <modal v-if="showModalPayment" @close="showModalPayment = false">
                                                    <!--
                                                    you can use custom content here to overwrite
                                                    default content
                                                    -->
                                                    <h3 slot="header"><i class="voyager-trash"></i> {{ trans('salary.Are you sure you want to delete this Make Payment?') }}</h3>
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
            </transition>
        </div>
    </div>
</template>

<script>

    export default {
        props: {
            link: '',
            id: '',
        },
        data() {
            return {
                get: {
                    apiURL: 'single-emp-report/show',
                },
                getTwo: {
                    apiURL: 'single-emp-report/salaryshow',
                },
                user: {},
                attendance: {},
                expenses: {},
                absentShow: true,
                salary: false,
                month: 0,
                date: '',
                attendCount: '',
                lateCount: '',
                absentCount: '',
                holidayCount: '',
                addSalary: {},
                allowances: '',
                deductions: '',
                makePayments: [],
                userTwo: {},
            }
        },
        computed: {
        },
        mounted() {
            this.fetch()
            this.fetchTwo()
        },
        methods: {
            fetch() {
                this.$store.dispatch('retrivePayemtnDetails', {
                        get: this.get,
                        id: this.$route.params.id,
                        month: this.month
                    })
                    .then(response => {
                        this.user = response.data.user
                        this.date = response.data.date
                        this.attendance = response.data.attendance
                    })
            },
            fetchTwo() {
                this.$store.dispatch('retrivePayemtnDetails', {
                        get: this.getTwo,
                        id: this.$route.params.id,
                        month: this.month
                    })
                    .then(response => {
                        this.userTwo = response.data.userTwo
                        this.attendCount = response.data.attendCount
                        this.holidayCount = response.data.holidayCount
                        this.lateCount = response.data.lateCount
                        this.absentCount = response.data.absentCount
                        this.addSalary = response.data.addSalary
                        this.allowances = response.data.allowances
                        this.deductions = response.data.deductions
                        this.makePayments = response.data.makePayments
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
            absentReport() {
                this.absentShow = true
                this.salary = false
            },
            salaryReport() {
                this.absentShow = false
                this.salary = true
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
