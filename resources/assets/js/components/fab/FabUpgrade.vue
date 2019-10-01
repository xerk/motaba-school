<template>
    <div>
        <modal v-if="showModal" @close="showModal = false">
            <div slot="body">
            <label for="stage">{{ trans('fab.Stage Education')}}</label>
            <select id="m_stage" class="form-control" v-model="stageSelect" @change="changeStage" name="stage">
                <option value="" selected="selected">{{ trans('fab.Choose Stage')}}</option>
                <option v-for="(stage, key) in model.stageEdu" :key="key" :value="stage.id">{{ stage.name }}</option>
            </select>
            <br>
            <label for="class">{{ trans('fab.Class Education')}}</label>
            <select id="m_class" class="form-control" v-model="classSelect" name="class">
                <option value="" selected="selected">{{ trans('fab.Choose Class')}}</option>
                <option v-for="(classItem, key) in classEduFilter" :key="key" :value="classItem.id">{{ classItem.name }}</option>
            </select>
            <br>
            </div>
            <h3 slot="header"><i class="voyager-tree"></i> <span style="margin-left: 10px;vertical-align: text-bottom;">{{ trans('fab.Select student filter')}}.</span></h3>
            <button slot="button" @click="parsist" class="btn btn-success">{{ trans('table.Yes, Save it!')}}</button>
        </modal>
    <fab :actions="fabActions" :bg-color="bgColor" :main-tooltip="mainTooltip" :icon-size="iconSize" @system="showModal = true"></fab>
    </div>
</template>

<script>
    import fab from 'vue-fab'
    import Modal from '../modal/SelectSystem'
    export default {
        components: {
            fab,
            Modal
        },
        data() {
            return {
                stageSelect: '',
                classSelect: '',
                showModal: false,
                bgColor: '#22A7F0',
                position: 'top-right',
                iconSize: 'small',
                mainTooltip: this.trans('results.Display Student'),
                fabActions: [
                    {
                        name: 'system',
                        icon: 'create_new_folder',
                        tooltip: this.trans('results.Filter Student'),
                        color: '#000000',
                    },
                    {
                        name: 'system',
                        icon: 'book',
                        tooltip: this.trans('results.Filter Student'),
                        color: '#000000',
                    },
                    {
                        name: 'system',
                        icon: 'school',
                        tooltip: this.trans('results.Filter Student'),
                        color: '#000000',
                    },
                ],
                get: {
                    apiURL: 'system-configs',
                },
                model: {
                    stageEdu: [],
                    classEdu: [],
                    classRoom: [],
                    classEduEmpty: [],
                },
                stagelog: [],
            }
        },
        mounted() {
            this.$store.dispatch('retriveOptions', this.get)
                .then(response => {
                    this.model.stageEdu = response.data.stageEduPerm
                    this.model.classEdu = response.data.classEduPerm
                    this.model.classEduEmpty = response.data.classEdu
                })
            if (localStorage.stageEdu) {
                this.stageSelect = localStorage.stageEdu;
            }
            if (localStorage.classEdu) {
                this.classSelect = localStorage.classEdu;
            }
        },
        computed: {
            classEduFilter() {
                if (this.stageSelect == '') {
                    this.classSelect = ''
                } else {
                    var ClassIsEmpty = this.model.classEdu.filter(item => {
                        return item.stage_edu_id == this.stageSelect
                    })
                    if (ClassIsEmpty == '') {
                        return this.model.classEduEmpty.filter(item => {
                            return item.stage_edu_id == this.stageSelect
                        })
                    } else {
                        return ClassIsEmpty
                    }
                }
            },
        },
        methods: {
            parsist() {
                this.$emit('parsist', this.stageSelect, this.classSelect)
                localStorage.stageEdu = this.stageSelect;
                localStorage.classEdu = this.classSelect;
                this.showModal = false
            },
            changeStage() {
                this.$emit('changeS')
                this.classSelect = ''
            }
        }
    }

</script>
