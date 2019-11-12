<template>
    <div>
        <form @submit.prevent action="">
            <div class="page-content browse container-fluid">
                <div class="attend-button">
                    <!-- <button @click="sendSMS" type="submit" :title="trans('attendance.Send SMS')" class="btn btn-sm btn-warning pull-right delete"
                         id="sms-2">
                        <i class="voyager-paper-plane"></i> <span class="hidden-xs hidden-sm">{{ trans('attendance.Send SMS') }}</span>
                    </button> -->
                    <button @click="submit(3)" type="submit" :title="trans('attendance.Absent')"
                        class="btn btn-sm btn-danger pull-right delete" data-id="2" id="delete-2">
                        <i class="voyager-skull"></i> <span
                            class="hidden-xs hidden-sm">{{ trans('attendance.Absent') }}</span>
                    </button>
                    <button @click="submit(2)" type="submit" :title="trans('attendance.Holiday')"
                        class="btn btn-sm  btn-primary pull-right edit">
                        <i class="voyager-exclamation"></i> <span
                            class="hidden-xs hidden-sm">{{ trans('attendance.Holiday') }}</span>
                    </button>
                    <button @click="submit(1)" type="submit" :title="trans('attendance.Attendants')"
                        class="btn btn-sm btn-success pull-right view">
                        <i class="voyager-check"></i> <span
                            class="hidden-xs hidden-sm">{{ trans('attendance.Attendants') }}</span>
                    </button>
                </div>
                <div class="lecture-select-box">
                    <!-- <select name="lecture" id="lecture" v-validate="'required'" :class="{'form-control lecture-select-box': true, 'has-error': errors.has('lecture') }" v-model="lecture">
                        <option value="">Choose Lecture...</option>
                        <option v-for="(item, index) in lectures" :key="index" :value="item.id">Lecture: {{ item.name }} -
                            {{ item.start_in }} - {{ item.end_in }}</option>
                    </select>
                    <span v-show="errors.has('lecture')" class="help-block" style="color:#f96868">{{ errors.first('lecture') }}</span> -->
                    <!-- <span>{{ moment("1995-12-25") }}</span> -->
                    <router-link @click.native="next" style="padding: 5px 10px;" :title="trans('table.Next')"
                        class="btn btn-sm  btn-primary pull-right edit" tag="a"
                        :to="{path: '/admin/eattendances', query: {'day': day+1,}}">
                        <span class="hidden-xs hidden-sm"></span> <i class="voyager-double-right"></i>
                    </router-link>
                    <router-link @click.native="prev" style="padding: 5px 10px;" :title="trans('table.Prev')"
                        class="btn btn-sm  btn-primary pull-right edit" tag="a"
                        :to="{path: '/admin/eattendances', query: {'day': day-1,}}">
                        <i class="voyager-double-left"></i> <span class="hidden-xs hidden-sm"></span>
                    </router-link>
                    <button class="btn btn-sm disabled"
                        style="padding: 4px 15px;">{{ dateNow | moment("dddd, Do MM YY") }}</button>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6 pull-right">
                                        <Search @performSearch="searchResults" :items="attendances"></Search>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="dataTable" class="table table-hover dataTable no-footer">
                                                <thead>
                                                    <tr>
                                                        <th>{{ trans('attendance.Employees') }}</th>
                                                        <!-- <th>Lecture</th> -->
                                                        <th>{{ trans('attendance.Date') }}</th>
                                                        <!-- <th>{{ trans('attendance.Created At') }}</th> -->
                                                        <th>{{ trans('attendance.Status') }}</th>
                                                        <th class="actions text-right">{{ trans('attendance.Status') }}</th>
                                                        <th class="actions text-right">{{ trans('table.Actions') }}</th>
                                                    </tr>
                                                </thead>
                                                <transition-group tag="tbody" name="list" mode="in-out">
                                                    <tr v-for="(item, index) in retriveSearch" :key="index">

                                                        <td v-if="$auth.gender == 1 && item.users"><img
                                                                :src="link + '/storage/' + (item.users.mask == 1 ? 'users/default.png' : item.users.avatar)"
                                                                class="img-avatar"> {{ item.users.name }}
                                                            {{ item.users.last_name }}</td>
                                                        <td v-else-if="item.users"><img
                                                                :src="link + '/storage/' + item.users.avatar"
                                                                class="img-avatar"> {{ item.users.name }}
                                                            {{ item.users.last_name }}</td>

                                                        <!-- <td><span class="label label-info">{{ item.lectures.name }}</span></td> -->
                                                        <td>{{ item.attend_date }}</td>
                                                        <!-- <td>{{ item.created_at }}</td> -->
                                                        <td>
                                                            <transition name="fade" mode="in-out">
                                                                <span v-if="item.status == 7"
                                                                    class="label label-warning">{{ trans('attendance.Delay permissions') }}</span>
                                                            </transition>
                                                            <transition name="fade" mode="in-out">
                                                                <span v-if="item.status == 6"
                                                                    class="label label-warning">{{ trans('attendance.Delayed supervision') }}</span>
                                                            </transition>
                                                            <transition name="fade" mode="in-out">
                                                                <span v-if="item.status == 5"
                                                                    class="label label-warning">{{ trans('attendance.Absence of patients') }}</span>
                                                            </transition>
                                                            <transition name="fade" mode="in-out">
                                                                <span v-if="item.status == 4"
                                                                    class="label label-warning">{{ trans('attendance.Late') }}</span>
                                                            </transition>
                                                            <transition name="fade" mode="in-out">
                                                                <span v-if="item.status == 3"
                                                                    class="label label-danger">{{ trans('attendance.Absent') }}</span>
                                                            </transition>
                                                            <transition name="fade" mode="in-out">
                                                                <span v-if="item.status == 2"
                                                                    class="label label-primary">{{ trans('attendance.Holiday') }}</span>
                                                            </transition>
                                                            <transition name="fade" mode="in-out">
                                                                <span v-if="item.status == 1"
                                                                    class="label label-success">{{ trans('attendance.Existing') }}</span>
                                                            </transition>
                                                        </td>
                                                        <td>
                                                            <transition name="slide" >
                                                                <div v-if="item.status == 4 && item.late_min == null" :class="{'has-error': errors.has('late_min') }">
                                                                    <button type="submit" @click="lateTime(item.id)" class="btn-attend btn btn-sm btn-primary"><i class="voyager-check"></i></button>
                                                                    <input placeholder="وقت" v-model="lateMin" v-validate="'required'" name="late_min"  type="number" class="attend_input">
                                                                    <span v-show="errors.has('late_min')" class="help-block" style="color:#f96868">{{ errors.first('late_min') }}</span>
                                                                </div>
                                                                <span v-else-if="item.late_min > 0 && item.status == 4">{{item.late_min}} دقيقة</span>

                                                            </transition>
                                                        </td>
                                                        <td class="no-sort no-click" id="bread-actions">
                                                            <a v-show="item.status != 7"
                                                                :title="trans('attendance.Delay permissions')"
                                                                @click="action(item, 7)"
                                                                class="btn btn-sm btn-warning pull-right delete"
                                                                data-id="2" id="absent-2">
                                                                <i class="voyager-skull"></i> <span
                                                                    class="hidden-xs hidden-sm">{{ trans('attendance.Delay permissions') }}</span>
                                                            </a>
                                                            <a v-show="item.status != 6"
                                                                :title="trans('attendance.Delayed supervision')"
                                                                @click="action(item, 6)"
                                                                class="btn btn-sm btn-warning pull-right delete"
                                                                data-id="2" id="absent-2">
                                                                <i class="voyager-skull"></i> <span
                                                                    class="hidden-xs hidden-sm">{{ trans('attendance.Delayed supervision') }}</span>
                                                            </a>
                                                            <a v-show="item.status != 5"
                                                                :title="trans('attendance.Absence of patients')"
                                                                @click="action(item, 5)"
                                                                class="btn btn-sm btn-danger pull-right delete"
                                                                data-id="2" id="absent-2">
                                                                <i class="voyager-skull"></i> <span
                                                                    class="hidden-xs hidden-sm">{{ trans('attendance.Absence of patients') }}</span>
                                                            </a>
                                                            <a v-show="item.status != 3"
                                                                :title="trans('attendance.Absent')"
                                                                @click="action(item, 3)"
                                                                class="btn btn-sm btn-danger pull-right delete"
                                                                data-id="2" id="absent-2">
                                                                <i class="voyager-skull"></i> <span
                                                                    class="hidden-xs hidden-sm">{{ trans('attendance.Absent') }}</span>
                                                            </a>
                                                            <a v-show="item.status != 4"
                                                                :title="trans('attendance.Late')"
                                                                @click="action(item, 4)"
                                                                class="btn btn-sm btn-warning pull-right delete"
                                                                data-id="2" id="late-2">
                                                                <i class="voyager-skull"></i> <span
                                                                    class="hidden-xs hidden-sm">{{ trans('attendance.Late') }}</span>
                                                            </a>
                                                            <a v-show="item.status != 2"
                                                                :title="trans('attendance.Holiday')"
                                                                class="btn btn-sm  btn-primary pull-right edit"
                                                                @click="action(item, 2)">
                                                                <i class="voyager-exclamation"></i> <span
                                                                    class="hidden-xs hidden-sm">{{ trans('attendance.Holiday') }}</span>
                                                            </a>
                                                            <a v-show="item.status != 1"
                                                                :title="trans('attendance.Existing')"
                                                                class="btn btn-sm btn-success pull-right view"
                                                                @click="action(item, 1)">
                                                                <i class="voyager-check"></i> <span
                                                                    class="hidden-xs hidden-sm">{{ trans('attendance.Existing') }}</span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </transition-group>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
import Search from './table/Search'
    export default {
        components: {
            Search,
        },
        props: ['link'],
        data() {
            return {
                input_show: false,
                get: {
                    apiURL: 'eattendance',
                },
                post: {
                    apiURL: 'eattendance',
                },
                postTwo: {
                    apiURL: 'eattendance-post',
                },
                postThree: {
                    apiURL: 'eattendance-post-3',
                },
                attendances: [],
                // lectures: [],
                // lecture: '',
                day: 0,
                dateNow: '',
                searchItems: [],
                query: '',
                lateMin: null,
            }
        },
        computed: {
            retriveSearch() {
                if (this.query.length == 0) {
                    return this.attendances
                } else {
                    return this.searchItems
                }
            }
        },
        mounted() {
            this.fetch()
        },
        methods: {
            searchResults(result, query) {
                this.searchItems = result
                this.query = query
            },
            fetch() {
                this.$store.dispatch('retriveAttendance', {
                        get: this.get,
                        day: this.day
                    })
                    .then(response => {
                        this.attendances = response.data.attendances
                        this.dateNow = response.data.date
                    })
            },
            submit(value) {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.$store.dispatch('submitForm', {
                                post: this.postTwo,
                                status: value,
                                day: this.day
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
            lateTime(value) {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        console.log(value)
                        this.$store.dispatch('submitForm', {
                                post: this.postThree,
                                late: this.lateMin,
                                id: value,
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
            sendSMS() {
                this.$store.dispatch('submitForm', {
                        post: this.sms,
                        classRoom: this.classRoom,
                        day: this.day
                    })
                    .then(response => {
                        this.$toast.success({
                            title: response.data
                        })
                        this.fetch()
                    })
            },
            action(item, value) {
                this.$store.dispatch('submitForm', {
                        post: this.post,
                        status: value,
                        id: item.id,
                    })
                    .then(response => {
                        this.$toast.success({
                            title: response.data
                        })
                        // this.fetch()
                        const index = this.attendances.findIndex(option => option.id == item.id);
                        this.attendances.splice(index, 1, {
                            'attend_date': item.attend_date,
                            'created_at': item.created_at,
                            'id': item.id,
                            'updated_at': item.updated_at,
                            'user_id': item.user_id,
                            'users': item.users,
                            'status': value,
                        })
                    })
            },
            next() {
                this.day++
                this.fetch()
            },
            prev() {
                this.day--
                this.fetch()
            }
        }
    }

</script>

<style>
    .lecture-select-box {
        /* width: 300px; */
        margin-bottom: 5px;
        float: right;
    }

    .attend-button {
        margin-bottom: 5px;
        float: left;
    }
    .slide-leave-active,
.slide-enter-active {
  transition: 1s;
}
.slide-enter {
  transform: translate(100%, 0);
}
.slide-leave-to {
  transform: translate(-100%, 0);
}

    .fade-enter-active,
    .fade-leave-active {
        transition: opacity .5s
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

    .img-avatar {
        width: 35px;
        margin-right: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.16);
        border-radius: 100%;
    }
    .attend_input {
        width: 100px;
        height: 30px;   
        border: 1px solid #fff;
        border-radius: 25px;
        padding: 0 40px 0 14px;
        text-align: center;
        float: right;
        box-shadow: 2px 4px 6px -1px rgba(0, 0, 0, 0.25), 2px 2px 4px -1px rgba(0, 0, 0, 0.09);
    }
    .btn-attend {
        height: 28px;
        margin-right: 0px;
        border-radius: 25px !important;
        width: 28px;
        padding: 0;
        margin: 0;
        float: right;
        position: relative;
        top: 1px;
        right: 29px;
    }

    input[type=number]::-webkit-inner-spin-button {
  -webkit-appearance: none;
}

</style>
