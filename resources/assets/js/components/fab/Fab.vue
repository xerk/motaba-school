<template>
    <div>
        <modal v-if="showModal" @close="showModal = false">
            <div slot="body">
            <label for="stage">{{ trans('configs.Stage Education')}}</label>
            <select id="m_stage" class="form-control" v-model="stageSelect" @change="changeStage" name="stage">
                <option value="" selected="selected">{{ trans('configs.Choose Stage')}}</option>
                <option v-for="(stage, key) in model.stageEdu" :key="key" :value="stage.id">{{ stage.name }}</option>
            </select>
            <br>
            <label for="class">{{ trans('configs.Class Education')}}</label>
            <select id="m_class" class="form-control" v-model="classSelect" @change="changeClass" name="class">
                <option value="" selected="selected">{{ trans('configs.Choose Class')}}</option>
                <option v-for="(classItem, key) in classEduFilter" :key="key" :value="classItem.id">{{ classItem.name }}</option>
            </select>
            <br>
            <label for="classroom">{{ trans('configs.Class-Room')}}</label>
            <select id="m_classroom" class="form-control" v-model="classRoomSelect" name="classroom">
                <option value="" selected="selected">{{ trans('configs.Choose Class-Room')}}</option>
                <option v-for="(classRoom, key) in classRoomEduFilter" :key="key" :value="classRoom.id">{{ classRoom.name }}</option>
            </select>
            </div>
            <h3 slot="header"><i class="voyager-tree"></i> <span style="margin-left: 10px;vertical-align: text-bottom;">{{ trans('configs.Select student filter')}}.</span></h3>                        
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
                classRoomSelect: '',
                showModal: false,   
                bgColor: '#22A7F0',
                position: 'top-right',
                iconSize: 'small',
                mainTooltip: 'Display Student',
                fabActions: [
                    {
                        name: 'system',
                        icon: 'create_new_folder',
                        tooltip: 'ClassRoom',
                        color: '#000000',
                    },
                    {
                        name: 'system',
                        icon: 'book',
                        tooltip: 'Class',
                        color: '#000000',
                    },
                    {
                        name: 'system',
                        icon: 'school',
                        tooltip: 'Stage',
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
                },
                stagelog: [],
            }
        },
        mounted() {
            this.$store.dispatch('retriveOptions', this.get)
                .then(response => {
                    this.model.stageEdu = response.data.stageEduPerm
                    this.model.classEdu = response.data.classEduPerm
                    this.model.classRoom = response.data.classRoomEduPerm
                })
            if (localStorage.stageEdu) {
                this.stageSelect = localStorage.stageEdu;
            }
            if (localStorage.classEdu) {
                this.classSelect = localStorage.classEdu;
            }
            if (localStorage.classRoom) {
                this.classRoomSelect = localStorage.classRoom;
            }
        },
        computed: {
            classEduFilter() {
                if (this.stageSelect == '') {
                    this.classSelect = ''
                } else {
                    return this.model.classEdu.filter(item => {
                        return item.stage_edu_id == this.stageSelect
                    })
                }
            },
            classRoomEduFilter() {
                if (this.classSelect == '') {
                    this.classRoomSelect = ''
                } else {
                    return this.model.classRoom.filter(item => {
                        return item.class_edu_id == this.classSelect
                    })
                }
            }
        },
        methods: {
            parsist() {
                this.$emit('parsist', this.stageSelect, this.classSelect, this.classRoomSelect)
                localStorage.stageEdu = this.stageSelect;
                localStorage.classEdu = this.classSelect;
                localStorage.classRoom = this.classRoomSelect;
                this.showModal = false
            },
            changeStage() {
                this.$emit('changeS')
                this.classSelect = ''
                this.classRoomSelect = ''
            },
            changeClass() {
                this.classRoomSelect = ''
            }
        }
    }

</script>
