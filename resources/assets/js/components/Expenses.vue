<template>
    <div>
        <form @submit.prevent action="">

            <div class="page-content browse container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <h3 class="text-center"><span v-if="user.user.classEdu != ''">{{user.user.class_edu.name}}</span> - <span v-if="user.user.classRoom != ''">{{user.user.class_room.name}}</span></h3>
                                <div class="row">
                                    <div class="col-md-6 pull-right">
                                        <Search @performSearch="searchResults" :items="users" ></Search>
                                    </div>
                                    <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover dataTable no-footer">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox"></th>
                                                <th>{{ trans('expenses.Students')}}</th>
                                                <th>{{ trans('expenses.Total Pay')}}</th>
                                                <th>{{ trans('expenses.Total Cost') }}</th>
                                                <th class="actions text-right">{{ trans('table.Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <transition-group tag="tbody" name="list" mode="in-out">
                                                <tr v-for="(item, index) in retriveSearch" :key="index">
                                                    <td><input type="checkbox"></td>
                                                    <td v-if="$auth.gender == 1"><img :src="link + '/storage/' + (item.mask == 1 ? 'users/default.png' : item.avatar)" class="img-avatar"> {{ item.name }} {{ item.last_name }}</td>
                                                    <td v-else><img :src="link + '/storage/' + item.avatar" class="img-avatar"> {{ item.name }} {{ item.last_name }}</td>
                                                    <!-- <td><span class="label label-info">{{ item.lectures.name }}</span></td> -->
                                                    <td><span class="label label-success">{{ item.paySum ? item.paySum : 0 }}</span></td>
                                                    <td><span class="label label-info">{{ (parseInt(item.class_edu) + parseInt(item.costSum)) ? parseInt(item.class_edu.expenses_cost) + parseInt(item.costSum) : 0}}</span></td>

                                                    <td class="no-sort no-click" id="bread-actions">

                                                            <router-link tag="a" :to="{ name: 'studentExpenses', params: {id: item.id} }" :title="trans('expenses.Make payment')" class="btn btn-sm btn-info pull-right add"
                                                                data-id="2" id="add-2">
                                                                    <i class="voyager-credit-card"></i> <span class="hidden-xs hidden-sm">{{ trans('expenses.Make Payment') }}</span>
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
                </div>
            </div>
        </form>
        <fab @parsist="parsist"></fab>
    </div>
</template>
<script>
    import Search from './table/Search'
    import Fab from './fab/Fab'
    export default {
        components: {
            Fab,
            Search,
        },
        props: ['link'],
        data() {
            return {
                get: {
                    apiURL: 'expeneses',
                },
                post: {
                    apiURL: 'expeneses',
                },
                postTwo: {
                    apiURL: 'expeneses-update',
                },
                users: [],
                stageEdu: localStorage.stageEdu,
                classEdu: localStorage.classEdu,
                classRoom: localStorage.classRoom,
                user: {
                    user: {
                            class_room: {
                            name: ''
                        },
                            class_edu: {
                            name: ''
                        }
                    }
                },
                getUser: {
                    apiURL: 'report-users',
                },
                searchItems: [],
                query: ''
            }
        },
        mounted() {
            this.fetch()
            this.getUsers()
        },
        computed: {
            usersFilter() {
                return this.users.filter(item => {
                    return item.stage_id == this.stageEdu && item.class_id == this.classEdu &&
                        item.classroom_id == this.classRoom && item.job == 1
                })
            },
            retriveSearch() {
                if (this.query.length == 0) {
                     return this.users.filter(item => {
                        return item.stage_id == this.stageEdu && item.class_id == this.classEdu &&
                            item.classroom_id == this.classRoom && item.job == 1
                    })
                } else {
                     return this.searchItems.filter(item => {
                        return item.stage_id == this.stageEdu && item.class_id == this.classEdu &&
                            item.classroom_id == this.classRoom && item.job == 1
                    })
                }
            }
        },
        methods: {
            searchResults(result, query) {
                this.searchItems = result
                this.query = query
            },
            fetch() {
                this.$store.dispatch('retriveOptions', this.get)
                .then(response => {
                    this.users = response.data.users
                })
            },
            parsist(stageEdu, classEdu, classRoom) {
                this.stageEdu = stageEdu
                this.classEdu = classEdu
                this.classRoom = classRoom
                this.getUsers()
            },
            getUsers() {
                this.$store.dispatch('retriveUser', {
                    get: this.getUser,
                    classRoom: this.classRoom,
                    classEdu: this.classEdu
                })
                .then(response => {
                    this.user = response.data
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
