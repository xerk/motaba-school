<template>
    <div>
        <div class="page-content read container-fluid" v-if="attention">
            <div class="lecture-select-box">
                <a @click="showModal = true" title="delete attention" class="btn btn-sm btn-danger pull-right delete"
                    data-id="2" id="delete-2">
                        <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm"></span>
                </a>

                <router-link tag="a" :to="{ name: 'gattentionsEdit', params: {edit: attention.id} }" :title="trans('attentions.Edit Attention')" class="btn btn-sm btn-primary pull-right edit"
                    data-id="2" id="edit-2">
                        <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm"></span>
                </router-link>

                <router-link :to="{name: 'gattentionsAdd'}" tage="a" class="btn btn-warning">
                    <span class="glyphicon glyphicon-list"></span>&nbsp;
                    {{ trans('attentions.Return Back') }}
                </router-link>

                <modal v-if="showModal" @close="showModal = false">
                    <h3 slot="header"><i class="voyager-trash"></i> {{ trans('attentions.Are you sure you want to delete this attention?') }}</h3>
                    <button slot="button" @click="removeOption()" class="btn btn-danger delete-confirm">{{ trans('table.Yes, Delete it!') }}</button>
                </modal>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered" style="padding-bottom:5px;">
                        <!-- form start -->
                        <div class="panel-body" v-if="attention.stage_edu">
                            <div class="row">
                                <div class="col-md-3">
                                    <span class="show-field">{{ trans('linkTeacher.Stage') }}:</span>
                                </div>
                                <div class="col-md-9">
                                    <span class="show-result">
                                        {{ attention.stage_edu.name }}
                                    </span>
                                </div>
                            </div>
                        </div><!-- panel-body -->

                        <div class="panel-body" v-if="attention.class_edu">
                            <div class="row">
                                <div class="col-md-3">
                                    <span class="show-field">{{ trans('linkTeacher.Class') }}:</span>
                                </div>
                                <div class="col-md-9">
                                    <span class="show-result">
                                        {{ attention.class_edu.name }}
                                    </span>
                                </div>
                            </div>
                        </div><!-- panel-body -->

                        <div class="panel-body" v-if="attention.class_room">
                            <div class="row">
                                <div class="col-md-3">
                                    <span class="show-field">{{ trans('linkTeacher.ClassRoom') }}:</span>
                                </div>
                                <div class="col-md-9">
                                    <span class="show-result">
                                        {{ attention.class_room.name }}
                                    </span>
                                </div>
                            </div>
                        </div><!-- panel-body -->

                        <div class="panel-body" v-if="attention.author">
                            <div class="row">
                                <div class="col-md-3">
                                    <span class="show-field">{{ trans('attentions.Author') }}:</span>
                                </div>
                                <div class="col-md-9">
                                    <span class="show-result" v-if="$auth.gender == 1">
                                        <img :src="link + '/storage/' + (attention.author.mask == 1 ? 'users/default.png' : attention.author.avatar)" class="img-avatar"> {{ attention.author.name }} {{ attention.author.last_name }}
                                    </span>
                                    <span class="show-result" v-else>
                                        <img :src="link + '/storage/' + attention.author.avatar" class="img-avatar"> {{ attention.author.name }} {{ attention.author.last_name }}
                                    </span>
                                </div>
                            </div>
                        </div><!-- panel-body -->

                        <div class="panel-body" v-if="attention.attention_type">
                            <div class="row">
                                <div class="col-md-3">
                                    <span class="show-field">{{ trans('attentions.Type') }}:</span>
                                </div>
                                <div class="col-md-9">
                                    <span class="show-result label label-info">
                                        {{ attention.attention_type.name }}
                                    </span>
                                </div>
                            </div>
                        </div><!-- panel-body -->

                        <div class="panel-body" v-if="attention.end_date">
                            <div class="row">
                                <div class="col-md-3">
                                    <span class="show-field">{{ trans('attentions.End Date') }}:</span>
                                </div>
                                <div class="col-md-9">
                                    <span class="show-result">
                                        {{ attention.end_date }}
                                    </span>
                                </div>
                            </div>
                        </div><!-- panel-body -->

                        <div class="panel-body" v-if="attention.body">
                            <div class="row">
                                <div class="col-md-3">
                                    <span class="show-field">{{ trans('attentions.Body') }}:</span>
                                </div>
                                <div class="col-md-9">
                                    <span class="show-result" v-if="showContent == true" v-html="attention.body"></span>
                                    <span class="show-result">
                                        <a v-if="showContent == false" @click.prevent="showContent = true" href="">{{ trans('attentions.Show Content') }}</a>
                                        <a  v-if="showContent == true" @click.prevent="showContent = false" href="">{{ trans('attentions.Hiden Content') }}</a>
                                    </span>
                                </div>
                            </div>
                        </div><!-- panel-body -->
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content read container-fluid" v-else>
            <div class="lecture-select-box">
                <router-link :to="{name: 'eattentionsAdd'}" tage="a" class="btn btn-warning">
                    <span class="glyphicon glyphicon-list"></span>&nbsp;
                    {{ trans('attentions.Return Back') }}
                </router-link>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered" style="padding-bottom:5px;">
                        <!-- form start -->
                        <div class="panel-body">
                            <div class="row">
                                <h3>There is not any attentions here go back and try to click in attention row</h3>
                            </div>
                        </div><!-- panel-body -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Modal from '../modal/Modal'
export default {
    props: ['link'],
    components: {Modal},
    data() {
        return {
            showModal: false,
            get: {
                apiURL: 'gattention/show',
            },
            delete: {
                apiURL: 'attention',
            },
            attention: {
                end_date: '',
                author: {
                    name: '',
                    last_name: '',
                    avatar: '',
                },
                attention_group_type: {
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
            this.$store.dispatch('retriveFilterSchoolEdit', {
                    get: this.get,
                    stageEdu: this.stageEdu,
                    classEdu: this.classEdu,
                    classRoom: this.classRoom,
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
                        name: 'eattentionsAdd'
                    })
                })
        }
    }
}
</script>


<style scoped>
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

