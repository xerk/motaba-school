<template>
    <div>
        <form @submit.prevent action="">

            <div class="page-content browse container-fluid">
                <!-- <div class="attend-button">
                    <button type="submit" title="Bulk add attention" class="btn btn-sm btn-success" id="bulk-add">
                        <i class="voyager-bell"></i> <span class="hidden-xs hidden-sm">Bulk Add</span>
                    </button>
                </div> -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover dataTable no-footer">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox"></th>
                                                <th>{{ trans('attentions.Students') }}</th>
                                                <th>{{ trans('attentions.Attentions No') }}</th>
                                                <th class="actions text-right">{{ trans('table.Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <transition-group tag="tbody" name="list" mode="in-out">
                                                <tr v-for="(item, index) in usersFilter" :key="index">
                                                    <td><input type="checkbox"></td>
                                                    <td v-if="$auth.gender == 1"><img :src="link + '/storage/' + (item.mask == 1 ? 'users/default.png' : item.avatar)" class="img-avatar"> {{ item.name }} {{ item.last_name }}</td>
                                                    <td v-else><img :src="link + '/storage/' + item.avatar" class="img-avatar"> {{ item.name }} {{ item.last_name }}</td>

                                                    <td><span class="label label-info">{{ item.attentions_count }}</span></td>

                                                    <td class="no-sort no-click" id="bread-actions">

                                                            <router-link tag="a" :to="{ name: 'attentionsAdd', params: {id: item.id} }" :title="trans('attentions.New Attentions')" class="btn btn-sm btn-info pull-right add"
                                                                data-id="2" id="add-2">
                                                                    <i class="voyager-bell"></i> <span class="hidden-xs hidden-sm">{{ trans('attentions.New Attentions') }}</span>
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

        <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-trash"></i> {{trans('table.delete qutions?')}}</h4>
                    </div>
                    <div class="modal-footer">
                        <form action="#" id="delete_form" method="POST">

                            <input type="submit" class="btn btn-danger pull-right delete-confirm" value="confirm">
                        </form>
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{trans('table.Cancel')}}</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <fab @parsist="parsist"></fab>
    </div>
</template>
<script>
    import Fab from './fab/Fab'
    export default {
        components: {
            Fab,
        },
        props: ['link'],
        data() {
            return {
                get: {
                    apiURL: 'attention',
                },
                post: {
                    apiURL: 'attendance',
                },
                postTwo: {
                    apiURL: 'attendance-post',
                },
                users: [],
                stageEdu: localStorage.stageEdu,
                classEdu: localStorage.classEdu,
                classRoom: localStorage.classRoom,
                day: 0,
                dateNow: '',
            }
        },
        mounted() {
            this.fetch()
        },
        computed: {
            usersFilter() {
                return this.users.filter(item => {
                    if (this.classRoom != "") {
                        return item.stage_id == this.stageEdu && item.class_id == this.classEdu &&
                        item.classroom_id == this.classRoom && item.job == 1
                    } else {
                        return item.job == 0
                    }
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
                        status: value,
                        stageEdu: this.stageEdu,
                        classEdu: this.classEdu,
                        classRoom: this.classRoom,
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
            parsist(stageEdu, classEdu, classRoom) {
                this.stageEdu = stageEdu
                this.classEdu = classEdu
                this.classRoom = classRoom
                if (this.classRoom == '' || this.classEdu == '' || this.stageEdu == '') {
                    this.$toast.success({
                        title: 'Employees is Displaying'
                    })
                } else {
                    this.$toast.success({
                        title: 'Students is Displaying'
                    })
                }
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
                        const index = this.attendances.findIndex(item => item.id == item.id);
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
