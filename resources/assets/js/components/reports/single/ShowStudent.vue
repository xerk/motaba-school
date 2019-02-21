<template>
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <h4 v-if="$auth.gender == 1"><img :src="link + '/storage/' + (user.mask == 1 ? 'users/default.png' : user.avatar)" class="img-avatar"> {{ user.name }} {{ user.last_name }}</h4>
                        <h4 v-else><img :src="link + '/storage/' + user.avatar" class="img-avatar"> {{ user.name }} {{ user.last_name }}</h4>
                        <hr>
                        <div class="panel-body">
                            <button @click="absentReport" class="btn btn-primary btn-block">{{ trans('reports.Absent report') }}</button>
                            <button @click="expenseReport" class="btn btn-primary btn-block">{{ trans('reports.Expense report') }}</button>
                        </div><!-- panel-body -->
                        <!-- <h4 class="text-center"><i class="voyager-check"></i> {{ trans('salary.Attendance') }}</h4> -->
                        <hr>
                    </div>
                </div>
            </div>
            <div style="display: none">
                <div class="row">
                    <div class="col-sm-12">
                        <h2>{{ user.name }} {{ user.last_name }}</h2>
                    </div>
                </div>
            </div>
            <transition name="list" mode="in-out">
            <div class="col-md-9" v-show="absent == true">
                <div>
                    <!-- <a class="btn btn-sm btn-primary" @click="printAbsent" :title="trans('reports.Print')"><i class="voyager-credit-card"></i> {{ trans('reports.Print') }}</a> -->
                    <router-link @click.native="next" class="btn btn-sm  btn-primary pull-right edit" style="padding: 5px 10px;" tag="a" :to="{name: 'singleStudentRepoShow', query: {'month': month+1,}}" :title="trans('table.Next')">
                        <span class="hidden-xs hidden-sm"></span> <i class="voyager-double-right"></i>
                    </router-link>
                    <router-link @click.native="prev" class="btn btn-sm  btn-primary pull-right edit" style="padding: 5px 10px;" :title="trans('table.Prev')" tag="a" :to="{name: 'singleStudentRepoShow', query: {'month': month-1,}}">
                        <span class="hidden-xs hidden-sm"></span> <i class="voyager-double-left"></i>
                    </router-link>
                    <button class="btn btn-sm disabled pull-right" style="padding: 4px 15px;">{{ date | moment("(MM) MMMM - YYYY") }}</button>
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
                            <div class="col-md-2">
                                <span style="font-size:14px" class="show-result label label-success">
                                    {{ user.count_attend }}
                                </span>
                            </div>
                            <div class="col-md-2">
                                <span class="show-field">{{ trans('salary.Total Holiday') }}:</span>
                            </div>
                            <div class="col-md-2">
                                <span style="font-size:14px" class="show-result label label-primary">
                                    {{ user.count_holiday }}
                                </span>
                            </div>
                            <div class="col-md-2">
                                <span class="show-field">{{ trans('salary.Total Absent') }}:</span>
                            </div>
                            <div class="col-md-2">
                                <span style="font-size:14px" class="show-result label label-danger">
                                    {{ user.count_absent }}
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
            <div class="col-md-9" v-show="expense == true">
                <div class="panel panel-bordered">
                    <div class="panel-title">
                        <h3><i class="icon voyager-list"></i> {{ trans('reports.Expense report') }}</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <span class="show-field">{{ trans('expenses.Total Pay') }}:</span>
                            </div>
                            <div class="col-md-2">
                                <span style="font-size:14px" class="show-result">
                                    {{ expenses.paySum ? expenses.paySum : 0 }}
                                </span>
                            </div>
                            <div class="col-md-2">
                                <span class="show-field">{{ trans('expenses.Total Cost') }}:</span>
                            </div>
                            <div class="col-md-2">
                                <span style="font-size:14px" class="show-result">
                                    {{ expenses.costSum ? expenses.costSum : 0 }}
                                </span>
                            </div>
                            <div class="col-md-2">
                                <span class="show-field">{{ trans('expenses.Total Discount') }}:</span>
                            </div>
                            <div class="col-md-2">
                                <span style="font-size:14px" class="show-result">
                                    {{ expenses.discountSum ? expenses.discountSum : 0 }}
                                </span>
                            </div>
                            </div>
                            <hr>
                            <div class="row">
                            <div class="col-md-3">
                                <span class="show-field">{{ trans('expenses.Basic Expenses') }}:</span>
                            </div>
                            <div class="col-md-3">
                                <span style="font-size:14px" class="show-result label label-primary">
                                    {{ expenses.class_edu.expenses_cost ? expenses.class_edu.expenses_cost : 0 }}
                                </span>
                            </div>
                            <div class="col-md-3">
                                <span class="show-field">{{ trans('expenses.Remaining') }}:</span>
                            </div>
                            <div class="col-md-3">
                                <span style="font-size:14px" class="show-result label label-success">
                                    {{ (+expenses.class_edu.expenses_cost  + +expenses.costSum) - (+expenses.paySum + +expenses.discountSum) }}
                                </span>
                            </div>
                            </div>
                            <hr>
                            <div class="container" style="margin-top:20px">
                                <div class="table-responsive" v-if="expenses.expenses">
                                    <table id="dataTable" class="table table-hover dataTable no-footer">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('expenses.Created At') }}</th>
                                                <th>{{ trans('expenses.Pay') }}</th>
                                                <th>{{ trans('expenses.Cost') }}</th>
                                                <th>{{ trans('expenses.Discount') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in expenses.expenses" :key="index">
                                                <td>
                                                    {{ item.created_at }}
                                                </td>
                                                <td><b style="font-weight: 600">${{ item.pay }}</b></td>
                                                <td><b>${{ item.cost }}</b></td>
                                                <td><b>${{ item.discount }}</b></td>
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
                    apiURL: 'single-student-report/show',
                },
                user: {},
                attendance: {},
                expenses: {
                    class_edu: {
                        expenses_cost: ''
                    }
                },
                absent: true,
                expense: false,
                month: 0,
                date: '',
            }
        },
        computed: {
        },
        mounted() {
            this.fetch()
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
                        this.expenses = response.data.expenses
                    })
            },
            printAbsent() {
                window.print();
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
                this.absent = true
                this.expense = false
            },
            expenseReport() {
                this.absent = false
                this.expense = true
            }
        }
    };

</script>
<style lang="postcss">
    @page {
        size: auto A4 landscape;
    }

    @media print {

    }
</style>

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
