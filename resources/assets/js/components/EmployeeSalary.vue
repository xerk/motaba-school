<template>
    <div>
        <form @submit.prevent action="">
            <div class="page-content browse container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover dataTable no-footer">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox"></th>
                                                <th>{{ trans('salary.Name')}}</th>
                                                <th>{{ trans('salary.Salary')}}</th>
                                                <th class="actions text-right">{{ trans('table.Actions')}}</th>
                                            </tr>
                                        </thead>
                                        <transition-group tag="tbody" name="list" mode="in-out">
                                                <tr v-for="(item, index) in usersFilter" :key="index">
                                                    <td><input type="checkbox"></td>
                                                    <td v-if="$auth.gender == 1"><img :src="link + '/storage/' + (item.mask == 1 ? 'users/default.png' : item.avatar)" class="img-avatar"> {{ item.name }} {{ item.last_name }}</td>
                                                    <td v-else><img :src="link + '/storage/' + item.avatar" class="img-avatar"> {{ item.name }} {{ item.last_name }}</td>
                                                    <!-- <td><span class="label label-info">{{ item.lectures.name }}</span></td> -->
                                                    <td><span class="label label-info"></span></td>

                                                    <td class="no-sort no-click" id="bread-actions">

                                                            <router-link tag="a" :to="{ name: 'paymentDetails', params: {id: item.id} }" :title="trans('salary.Make Payment')" class="btn btn-sm btn-info pull-right add"
                                                                data-id="2" id="add-2">
                                                                    <i class="voyager-credit-card"></i> <span class="hidden-xs hidden-sm">{{ trans('salary.Make Payment')}}</span>
                                                            </router-link>
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
        </form>
    </div>
</template>
<script>
    export default {
        props: ['link'],
        data() {
            return {
                get: {
                    apiURL: 'employee',
                },
                post: {
                    apiURL: 'employee',
                },
                postTwo: {
                    apiURL: 'employee-post',
                },
                users: [],
            }
        },
        mounted() {
            this.fetch()
        },
        computed: {
            usersFilter() {
                return this.users.filter(item => {
                    return item.job == 0
                })
            },
            // lectureFilter() {
            //     return this.lectures.filter(item => {
            //         return item.id == this.lecture
            //     })
            // }
        },
        methods: {
            fetch() {
                this.$store.dispatch('retriveAttendance', {
                    get: this.get
                })
                .then(response => {
                    this.users = response.data.users
                })
            },
            submit(value) {
                this.$validator.validateAll().then((result) => {
                    if(result) {
                        this.$store.dispatch('submitForm', {
                        post: this.postTwo,
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

    .img-avatar {
        width: 35px;
        margin-right: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.16);
        border-radius: 100%;
    }

</style>
