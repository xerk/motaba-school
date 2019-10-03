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
                                    <button type="submit" :class="gender ? 'btn btn-danger' : 'btn btn-primary'" @click="gender = !gender">{{ gender ? 'انثى' : 'ذكر' }}</button>
                                    <button type="submit" :class="gender == 'all' ? 'btn btn-info' : 'btn btn-muted'" :disabled="gender == 'all'" @click="gender = 'all'">{{ gender == 'all' ? 'الكل' : 'أضغط للكل' }}</button>
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
                                        <input 
                                            type="text"
                                            class="form-control fuse-search"
                                            placeholder="بحث"
                                            ref="search"
                                            v-model="query"
                                            @keyup="performSearch"
                                            @keydown="performSearch">
                                        <i class="voyager-sort" @click="orderList"></i>
                                        <draggable group="people" tag="ul" id="ss_elem_list"
                                            @change="updateOriginal(classEdus)" class="list-group dragArea"
                                            style="height: 650px;" v-model="classEdus.users">
                                            <transition-group type="transition" tag="div" class="dragArea"
                                                :name="'flip-list'">
                                                <li v-for="element in retriveSearch " :key="element.id">
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
    export default {
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
                query: '',
                searchResults: [],
                sorted: false,
                gender: 'all',
                options: {
                    shouldSort: true,
                    threshold: 0.5,
                    location: 0,
                    distance: 500,
                    maxPatternLength: 32,
                    minMatchCharLength: 1,
                    keys: ['users.name', 'users.last_name', 'name', 'last_name'],
                },
            };
        },
        mounted() {
            this.fetch()
        },
        methods: {
            orderList() {

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
            performSearch() {
                this.$search(this.query, this.classEdus.users, this.options)
                    .then(results => {
                        this.searchResults = results
                    })
            }
        },
        computed: {
            retriveSearch() {
                if (this.query.length == 0) {
                    return this.classEdus.users.filter(item => {
                        if (this.gender == 'all') {
                            return true
                        } else if (this.gender) {
                            return item.gender == 1
                        } else {
                            return item.gender == 0
                        }
                    })
                } else {
                    return this.searchResults.filter(item => {
                        if (this.gender == 'all') {
                            return true
                        } else if (this.gender) {
                            return item.gender == 1
                        } else {
                            return item.gender == 0
                        }
                    })
                }
            }
        },
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
