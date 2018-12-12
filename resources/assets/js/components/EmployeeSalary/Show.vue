<template>
    <div class="page-content read container-fluid">
        <div class="lecture-select-box">
            <a @click="showModal = true" title="delete attention" class="btn btn-sm btn-danger pull-right delete"
                data-id="2" id="delete-2">
                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm"></span>
            </a>

            <router-link tag="a" :to="{ name: 'attentionsEdit', params: {id: attention.users.id, edit: attention.id} }" title="edit attention" class="btn btn-sm btn-primary pull-right edit"
                data-id="2" id="edit-2">
                    <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm"></span>
            </router-link>

            <router-link :to="{name: 'attentionsAdd', params: {id: attention.users.id}}" tage="a" class="btn btn-warning">
                <span class="glyphicon glyphicon-list"></span>&nbsp;
                {{ trans('salary.Return Back')}}
            </router-link>

            <modal v-if="showModal" @close="showModal = false">
                <h3 slot="header"><i class="voyager-trash"></i> {{ trans('salary.Are you sure you want to delete this EmpyloeeSalary?')}}</h3>                        
                <button slot="button" @click="removeOption()" class="btn btn-danger delete-confirm">{{ trans('table.Yes, Delete it!')}}</button>
            </modal>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <!-- form start -->
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <span class="show-field">{{ trans('salary.Student')}}:</span>
                            </div>
                            <div class="col-md-9">
                                <span class="show-result">
                                    <img :src="link + '/storage/' + attention.users.avatar" class="img-avatar"> {{ attention.users.name }} {{ attention.users.last_name }}
                                </span>
                            </div>
                        </div>
                    </div><!-- panel-body -->

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <span class="show-field">{{ trans('salary.Author')}}:</span>
                            </div>
                            <div class="col-md-9">
                                <span class="show-result">
                                    <img :src="link + '/storage/' + attention.users.avatar" class="img-avatar"> {{ attention.authors.name }} {{ attention.authors.last_name }}
                                </span>
                            </div>
                        </div>
                    </div><!-- panel-body -->

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <span class="show-field">{{ trans('salary.Type')}}:</span>                                
                            </div>
                            <div class="col-md-9">
                                <span class="show-result label label-info">
                                    {{ attention.attention_types.name }}
                                </span>
                            </div>
                        </div>
                    </div><!-- panel-body -->

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <span class="show-field">{{ trans('salary.End Date')}}:</span>                                                      
                            </div>
                            <div class="col-md-9">
                                <span class="show-result">
                                    {{ attention.end_date }}
                                </span>
                            </div>
                        </div>
                    </div><!-- panel-body -->

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <span class="show-field">{{ trans('salary.Body')}}:</span>                                                      
                            </div>
                            <div class="col-md-9">
                                <span class="show-result" v-if="showContent == true" v-html="attention.body"></span>
                                <span class="show-result">
                                    <a v-if="showContent == false" @click.prevent="showContent = true" href="">{{ trans('salary.Show Content')}}</a>
                                    <a  v-if="showContent == true" @click.prevent="showContent = false" href="">{{ trans('salary.Hiden Content')}}</a>
                                </span>
                            </div>
                        </div>
                    </div><!-- panel-body -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Modal from '../modal/Modal'
export default {
    props: ['id', 'link'],
    components: {Modal},
    data() {
        return {
            showModal: false,
            get: {
                apiURL: 'attention',
            },
            delete: {
                apiURL: 'attention',
            },
            attention: {
                end_date: '',
                authors: {
                    name: '',
                    last_name: '',
                },
                users: {
                    id: '',
                    avatar: '',
                    name: '',
                    last_name: '',
                },
                attention_types: {
                    name: ''
                },
            },
            showContent: false,
        }
    },
    mounted() {
        this.fetch()
    },
    methods: {
        fetch() {
            this.$store.dispatch('retriveAttendtionShow', {
                    get: this.get,
                    edit: this.$route.params.id
                })
                .then(response => {
                    this.attention = response.data.attention
                })
        },
        removeOption() {
            this.$store.dispatch('delete', {
                    delete: this.delete,
                    id: this.$route.params.id
                })
                .then(response => {
                    this.$toast.success({
                        title: response.data
                    })
                    this.showModal = false
                    this.$router.push({
                        name: 'attentionsAdd',
                        params: {id: this.attention.users.id}
                    }) 
                })
        }
    }
}
</script>


<style>
    .show-field {
        font-weight: 400;
    }
    .show-result {
        font-weight: 600;

    }
    .img-avatar {
        width: 35px;
        margin-right: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.16);
        border-radius: 100%;
    }
    .lecture-select-box {
        /* width: 300px; */
        margin-bottom: 5px;
        float: right;
    }
    .row>[class*=col-] {
        margin-bottom: 0px;
    }
</style>

