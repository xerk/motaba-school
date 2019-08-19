<template>
    <div>
        <form @submit.prevent action="">
            <div class="page-content browse container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
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
                                                        <th>{{ trans('link-teacher.Name')}}</th>
                                                        <th>{{ trans('link-teacher.ClassRooms & Subjects No')}}</th>
                                                        <th class="actions text-right">{{ trans('table.Actions')}}</th>
                                                    </tr>
                                                </thead>
                                                <transition-group tag="tbody" name="list" mode="in-out">
                                                        <tr v-for="(item, index) in retriveSearch" :key="index">
                                                            <td><input type="checkbox"></td>
                                                            <td v-if="$auth.gender == 1"><img :src="link + '/storage/' + (item.mask == 1 ? 'users/default.png' : item.avatar)" class="img-avatar"> {{ item.name }} {{ item.last_name }}</td>
                                                            <td v-else><img :src="link + '/storage/' + item.avatar" class="img-avatar"> {{ item.name }} {{ item.last_name }}</td>
                                                            <!-- <td><span class="label label-info">{{ item.lectures.name }}</span></td> -->
                                                            <td><span class="label label-info">{{ item.link_teachers_count }}</span></td>

                                                            <td class="no-sort no-click" id="bread-actions">

                                                                    <router-link tag="a" :to="{ name: 'linkTeacher', params: {id: item.id} }" title="Link a teacher" class="btn btn-new-relationship pull-right add"
                                                                        data-id="2" id="add-2">
                                                                            <i class="voyager-heart"></i> <span class="hidden-xs hidden-sm">Link a teacher</span>
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
                get: {
                    apiURL: 'link-teachers',
                },
                users: [],
                searchItems: [],
                query: ''
            }
        },
        mounted() {
            this.fetch()
        },
        computed: {
            retriveSearch() {
                if (this.query.length == 0) {
                     return this.users.filter(item => {
                        return item.job == 0
                    })
                } else {
                     return this.searchItems.filter(item => {
                        return item.job == 0
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
                this.$store.dispatch('retriveAttendance', {
                    get: this.get
                })
                .then(response => {
                    this.users = response.data.users
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
