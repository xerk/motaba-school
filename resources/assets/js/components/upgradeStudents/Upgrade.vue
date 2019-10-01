<template>
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <section>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" @click="emptyAll" class="pull-right btn btn-danger"><i class="voyager-trash"></i> تفريغ الجميع </button>
                                </div>
                                <div class="left-area col-md-6">
                                    <div style="padding-bottom: 12px">
                                        <span class="h4" style="font-wghit:bold">
                                            {{classEdus.name}}
                                        </span>
                                        <span class="text-right pull-right">
                                            <label class="label label-primary"
                                                v-if="classEdus.users">{{classEdus.users.length}}</label>
                                        </span>
                                    </div>
                                    <div class="listbox">
                                        <input type="text" class="form-control search-input" placeholder="Search">
                                        <draggable group="people" tag="ul" id="ss_elem_list"
                                            @change="updateOriginal(classEdus)" class="list-group dragArea"
                                            style="height: 650px;" v-model="classEdus.users">
                                            <transition-group type="transition" tag="div" class="dragArea"
                                                :name="'flip-list'">
                                                <li v-for="element in classEdus.users" :key="element.id">
                                                    <a class="list-group-item list-group-item-action"><span>{{ element.name }}
                                                            {{ element.last_name }}</span></a>
                                                </li>
                                            </transition-group>
                                        </draggable>
                                    </div>
                                </div>
                                <div class="left-area col-md-6" v-for="(room,key) in classEdus.class_room" :key="key">
                                    <div style="padding-bottom: 12px">
                                        <span class="h5">
                                            {{room.name}}
                                        </span>
                                        <span class="text-right pull-right">
                                            <label class="label label-primary">{{room.users.length}} / {{room.maximum}}</label>
                                        </span>
                                    </div>
                                    <div class="listbox">
                                        <draggable tag="ul" :group="{ name: 'people', put: putFunction(room) }" class="dragArea list-group"
                                            v-model="room.users" @change="update(room)">
                                            <transition-group tag="div" id="ss_elem_list" type="transition"
                                                style="height: 200px;" class="dragArea" :name="'flip-list'">
                                                <li v-for="element in room.users" :key="element.id">
                                                    <a class="list-group-item list-group-item-action"><span>{{ element.name }}
                                                            {{ element.last_name }}</span></a>
                                                </li>
                                            </transition-group>
                                        </draggable>
                                    </div>
                                    <button @click="empty(room)" type="submit"
                                        class="btn btn-danger pull-right btn-small"><i class="voyager-trash"></i></button>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <div>
            </div>
        </div>
        <fab @parsist="parsist"></fab>
    </div>
</template>

<script>
    import Fab from '../fab/FabUpgrade'
    import draggable from "vuedraggable";
    let idGlobal = 8;
    export default {
        name: "clone-on-control",
        display: "Clone on Control",
        instruction: "Press Ctrl to clone element from list 1",
        order: 4,
        components: {
            draggable,
            Fab
        },
        data() {
            return {
                get: {
                    apiURL: 'upgradeData',
                },
                classEdus: [],
                list2: [],
                controlOnStart: true,
                stageEdu: localStorage.stageEdu,
                classEdu: localStorage.classEdu,
            };
        },
        mounted() {
            this.fetch()
        },
        methods: {
            orderList() {
                this.list1 = this.list1.sort((one, two) => {
                    return one.name - two.name;
                });
            },
            fetch() {
                this.$store.dispatch('retriveAttendtion', {
                        get: this.get,
                        id: this.classEdu
                    })
                    .then(response => {
                        this.classEdus = response.data.classEdus
                    })
            },
            parsist(stageEdu, classEdu) {
                this.stageEdu = stageEdu
                this.classEdu = classEdu
                this.fetch()
            },
            updateOriginal(classUpdate) {
                classUpdate.users.map((user, index) => {
                    user.classroom_id = null
                })

                axios.put('/updateEmptyClass', {
                    users: this.classEdus.users
                }).then((response) => {
                    this.$toast.success({
                        title: response.data,
                    })
                })
            },
            update(room) {
                room.users.map((user, index) => {
                    user.classroom_id = room.id
                })

                axios.put('/updateAddToRoom', {
                    users: room.users,
                    id: room.id
                }).then((response) => {
                    this.$toast.success({
                        title: response.data,
                    })
                })
            },
            empty(room) {
                room.users.map((user, index) => {
                    this.classEdus.users.push(user)
                })
                room.users = []

                // // room.users.each((user, index) => {
                // //     user.classroom_id = null
                // // })
                axios.put('/updateEmptyClass', {
                    users: this.classEdus.users
                }).then((response) => {
                    this.$toast.success({
                        title: response.data,
                    })
                })
            },
            emptyAll() {
                this.classEdus.class_room.forEach((room) => {
                    room.users.map((user, index) => {
                        this.classEdus.users.push(user)
                    })
                    room.users = []
                })

                axios.put('/updateEmptyClass', {
                    users: this.classEdus.users
                }).then((response) => {
                    this.$toast.success({
                        title: response.data,
                    })
                })
            },
            putFunction(room) {
                if (room.users.length >= room.maximum) return false
            },
        }
    };

</script>
<style scoped>
    .flip-list-move {
        transition: transform 0.5s;
    }

    .search-input {
        border: none;
        border-bottom: 1px solid #cecaca;
        border-radius: 0;
    }

    .dragArea {
        min-height: 100%;
    }

</style>
