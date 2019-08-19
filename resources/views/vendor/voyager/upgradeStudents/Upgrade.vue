<template>
    <div>
        <div class="page-content browse container-fluid">
            <div class="attend-button">
                <button @click="submit(3)" type="submit" :title="trans('attendance.Absent')"
                    class="btn btn-sm btn-danger pull-right delete" id="absent-2">
                    <i class="voyager-skull"></i> <span
                        class="hidden-xs hidden-sm">{{ trans('attendance.Absent') }}</span>
                </button>
                <button @click="submit(2)" type="submit" :title="trans('attendance.Holiday')"
                    class="btn btn-sm  btn-primary pull-right edit">
                    <i class="voyager-exclamation"></i> <span
                        class="hidden-xs hidden-sm">{{ trans('attendance.Holiday') }}</span>
                </button>
                <button @click="submit(1)" type="submit" :title="trans('attendance.Attendants')"
                    class="btn btn-sm btn-success pull-right view">
                    <i class="voyager-check"></i> <span
                        class="hidden-xs hidden-sm">{{ trans('attendance.Attendants') }}</span>
                </button>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <vuetable ref="vuetable" :show-sort-icons="true" :sortableIcon="'voyager-angle-down'" :ascendingClass="'voyager-angle-down'" :descendingClass="'voyager-angle-down'" api-url="https://vuetable.ratiw.net/api/users" :fields="fields">
                            </vuetable>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <fab @parsist="parsist"></fab>
    </div>
</template>

<script>
    import Vuetable from 'vuetable-2'
    import Fab from '../fab/Fab'
    import moment from "moment"
    import accounting from "accounting"
    
    export default {
        components: {
            Vuetable,
            Fab,
        },
        data() {
            return {
                fields: [
        {
          name: "name",
          title: '<i class="grey user outline icon"></i>Name',
          sortField: "name",
          width: "20%"
        },
        {
          name: "email",
          title: '<i class="grey mail outline icon"></i>Email',
          sortField: "email",
          width: "20%"
        },
        {
          name: "group.description",
          title: '<i class="grey sitemap icon"></i>Group',
          sortField: "description",
          width: "15%"
        },
        {
          name: "birthdate",
          title: '<i class="grey birthday icon"></i>Birthdate',
          sortField: "birthdate",
          width: "15%",
          formatter: (value) => { 
            return (value === null)
              ? ''
              : moment(value, 'YYYY-MM-DD').format('MMM Do, YYYY')
          }
        },
        {
          name: "gender",
          title: '<i class="grey heterosexual icon"></i>Gender',
          titleClass: "center aligned",
          dataClass: "center aligned",
          sortField: "gender",
          width: "20%",
          formatter: (value) => {
            return value.toUpperCase() === 'M' 
              ? '<span class="label label-primary"><i class="large man icon"></i>Male</span>' 
              : '<span class="label label-danger"><i class="large woman icon"></i>Female</span>'
          }
        },
        {
          name: "salary",
          title: '<i class="grey money icon"></i>Salary',
          titleClass: "center aligned",
          dataClass: "right aligned",
          width: "15%",
          formatter: (value) => accounting.formatNumber(value, 2)
        }
      ],    
                stageEdu: localStorage.stageEdu,
                classEdu: localStorage.classEdu,
                classRoom: localStorage.classRoom,
            }
        },
        mounted() {
            this.fetch()
        },
        methods: {
            parsist(stageEdu, classEdu, classRoom) {
                this.stageEdu = stageEdu
                this.classEdu = classEdu
                this.classRoom = classRoom
                this.fetch()
                this.getUsers()
            },
            fetch() {

            }
        }
    }

</script>

<style>

</style>
