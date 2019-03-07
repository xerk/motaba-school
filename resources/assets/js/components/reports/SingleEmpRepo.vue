<template>
    <div>

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
                                                <th class="actions text-right">{{ trans('table.Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <transition-group tag="tbody" name="list" mode="in-out">
                                                <tr v-for="(item, index) in usersFilter" :key="index">
                                                    <td><input type="checkbox"></td>
                                                    <td v-if="$auth.gender == 1"><img :src="link + '/storage/' + (item.mask == 1 ? 'users/default.png' : item.avatar)" class="img-avatar"> {{ item.name }} {{ item.last_name }}</td>
                                                    <td v-else><img :src="link + '/storage/' + item.avatar" class="img-avatar"> {{ item.name }} {{ item.last_name }}</td>

                                                    <td class="no-sort no-click" id="bread-actions">
                                                        <router-link tag="a" :to="{ name: 'singleEmpRepoShow', params: {id: item.id} }" :title="trans('reports.Show Reports')" class="btn btn-sm btn-info pull-right add"
                                                            data-id="2" id="add-2">
                                                                <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">{{ trans('reports.Show Reports') }}</span>
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
</template>
<script>
    export default {
        props: ['link'],
        data() {
            return {
                get: {
                    apiURL: 'single-emp-report',
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
        },
        methods: {
            fetch() {
                this.$store.dispatch('retriveOptions', this.get)
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
