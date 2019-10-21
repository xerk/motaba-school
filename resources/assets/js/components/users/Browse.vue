<template>
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <input type="text" v-model.lazy="query" v-debounce="500" @keyup="fetch" placeholder='Search the docs (Press "/" to focus)' class="users-button-search">
                    <div class="users-icon-search">
                        <svg class="" width="20px" height="20px">
                            <path class="search-color"
                                d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="col-md-6">
                    <select @change="jobChange" v-model="job" class="users-select-box">
                        <option value="">نوع الوظيفة</option>
                        <option value="1">طالب</option>
                        <option value="0">موظف</option>
                    </select>
                    <select @change="fetch" v-model="gender" class="users-select-box">
                        <option value="">النوع</option>
                        <option value="1">ذكر</option>
                        <option value="0">إنثى</option>
                    </select>
                    <select @change="fetch" v-model="specialty" v-if="job == 0 && job != ''" class="users-select-box">
                        <option value="">التخصص</option>
                        <option v-for="(item, index) in specialties" :key="index" :value="item.id">{{item.name}}
                        </option>
                    </select>
                    <select @change="fetch" v-model="status" v-if="job == 1" class="users-select-box">
                        <option value="">الحالة</option>
                        <option v-for="(item, index) in statusStudents" :key="index" :value="item.id">{{item.name}}
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Username</th>
                                        <th>Phone</th>
                                        <th>Gender</th>
                                        <th v-if="job == 0 && job != ''">specialty</th>
                                        <th v-else>Status</th>
                                        <th v-if="job == 0 && job != ''">qualification</th>
                                        <th v-else>Stage & Class</th>
                                        <th class="actions text-right">Action</th>
                                    </tr>
                                </thead>
                                <transition-group tag="tbody" name="list" mode="in-out" v-if="!isLoading">
                                    <tr class="users-table-row" v-for="(item, index) in users.data" :key="index">
                                        <td class="users-table-data"><img :src="link + '/storage/' + item.avatar"
                                                class="img-avatar" alt="Admin avatar" width="32px"> {{item.full_name}}
                                        </td>
                                        <td class="users-table-data">{{ item.username }}</td>
                                        <td class="users-table-data">{{ item.mobile }}</td>
                                        <td class="users-table-data">{{ item.gender == 1 ? 'ذكر' : 'إنثى'}}</td>
                                        <td class="users-table-data" v-if="job == 0 && job != ''">
                                            {{ item.specialy ? item.specialy.name : 'لا يوجد' }}</td>
                                        <td class="users-table-data" v-else>
                                            {{ item.status_students ? item.status_students.name : 'لا يوجد' }}</td>
                                        <td v-if="job == 0 && job != ''" class="users-table-data">{{ item.qualification }}</td>
                                        <td v-else class="users-table-data">{{ item.full_stage ? item.full_stage : 'لا يوجد'}}</td>
                                        <td>
                                            <a :href="link + '/admin/users/' + item.id + '/edit'" class="btn btn-primary">Edit</a>
                                            <a href.prevent="" @click="openModal(item)" class="btn btn-sm btn-danger">
                                                <i class="voyager-trash"></i> {{ trans('table.Delete') }}
                                            </a>
                                        </td>
                                    </tr>
                                </transition-group>
                                <tbody v-else>
                                    <tr>
                                        <loading :active.sync="isLoading" v-if="isLoading" :height="64" :width="64" loader="dots"
                                            :is-full-page="false">
                                        </loading>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="pull-left" v-if="!isLoading">
                            <div role="status" class="show-res" aria-live="polite">عرض {{users.from}} إلى {{users.to}} من {{users.total}} عنصر</div>
                        </div>
                        <div class="pull-right" v-if="!isLoading">
                            <pagination :data="users" :limit="3" @pagination-change-page="fetch"></pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal-system :selectRow="selectRow" @confirm="removeOption" v-if="showModal" @close="showModal = false"></modal-system>
    </div>
</template>

<script>
    // Import component
    import ModalSystem from '../modal/ModalSystem'
    import Loading from 'vue-loading-overlay';
    import pagination from 'laravel-vue-pagination';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';
    import debounce from '../../index'
    export default {
        props: ['link'],
        components: {
            Loading,
            pagination,
            ModalSystem,
        },
        directives: {debounce},
        data() {
            return {
                get: {
                    apiURL: 'users',
                },
                delete: {
                    apiURL: 'users',
                },
                showModal: false,
                selectRow: null,
                specialties: null,
                statusStudents: null,
                users: null,
                job: '',
                gender: '',
                specialty: '',
                status: '',
                isLoading: true,
                suggestionAttribute: 'original_title',
                query: '',
            }
        },
        mounted() {
            this.fetch()
        },
        methods: {
            openModal(value) {
                this.showModal = true
                this.selectRow = value
            },
            fetch(page) {
                this.isLoading = true
                setTimeout(() => {
                        axios.get(`users?page=${page}&job=${this.job}&gender=${this.gender}&specialty=${this.specialty}&status_id=${this.status}&value=${this.query}`)
                        .then(response => {
                            this.users = response.data.users
                            this.statusStudents = response.data.statusStudents
                            this.specialties = response.data.specialties
                            this.isLoading = false
                        });
                }, 1000);
            },
            jobChange() {
                this.specialty = ''
                this.status = ''
                this.fetch()
            },
            removeOption() {
                this.showModal = false
                let index = this.users.data.indexOf(this.selectRow);
                this.$store.dispatch('delete', {
                    delete: this.delete,
                    id: this.selectRow.id
                })
                .then(response => {
                    this.$toast.success({
                            title: response.data,
                        })
                        this.fetch()
                })
                this.selectRow = null;
            }
        },
        computed: {

        }
    }

</script>

<style>
    .users-button-search {
        width: 350px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, .1), 0 2px 4px -1px rgba(0, 0, 0, .06) !important;
        padding-left: 3rem !important;
        padding-right: 1rem !important;
        padding-top: 14px;
        padding-bottom: 14px;
        line-height: 1.5 !important;
        display: block !important;
        border-width: 1px !important;
        border-radius: .5rem !important;
        border-color: transparent !important;
        background-color: #fff !important;
        border: 0 solid #e2e8f0;
        box-sizing: inherit;
        color: #718096;
        font-size: 16px;
        height: 50px;
    }

    .users-select-box {
        width: 200px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, .1), 0 2px 4px -1px rgba(0, 0, 0, .06) !important;
        padding-left: 1.5rem !important;
        padding-right: 1rem !important;
        line-height: 1.5 !important;
        border-width: 1px !important;
        border-radius: .5rem !important;
        border-color: transparent !important;
        background-color: #fff !important;
        border: 0 solid #e2e8f0;
        box-sizing: inherit;
        color: #718096;
        font-size: 16px;
        height: 50px;
    }

    .users-icon-search {
        position: absolute;
        top: 16px;
        left: 30px;
    }

    .search-color {
        fill: #718096;
    }

    .users-table-row {
        cursor: pointer;
    }

    .users-table-row:hover {
        background-color: #f3f3f3;
    }

    .users-table-data {
        vertical-align: middle !important;
        color: #718096;
    }

</style>
