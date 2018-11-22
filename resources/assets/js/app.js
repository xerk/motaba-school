require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
import routes from './router'
import SchoolConfigs from './components/SchoolConfigs'
import YearConfigs from './components/YearConfigs'
import SystemConfigs from './components/SystemConfigs'
import Attendance from './components/Attendance'
import EAttendance from './components/EAttendance'
import Attention from './components/Attention'
import EmployeeSalary from './components/EmployeeSalary'
import AddSalary from './components/AddSalary'
import SettingNumber from './components/SettingNumber'
import StudentRepo from './components/reports/Students'
import ParentRepo from './components/reports/Parents'
import AbsentStudentRepo from './components/reports/AbsentStudent'
import AbsentEmpRepo from './components/reports/AbsentEmp'
import GenderRepo from './components/reports/Gender'
import SecretNumber from './components/SecretNumber'
import AddExpense from './components/AddExpense'
import Committee from './components/Committee'
import Results from './components/Results'
import Fab from './components/fab/Fab'
import Croppa from 'vue-croppa'
import {store} from './store/store'
import VeeValidate from 'vee-validate'
import CxltToastr from 'cxlt-vue2-toastr'
import 'cxlt-vue2-toastr/dist/css/cxlt-vue2-toastr.css'
import Moment from 'vue-moment'
import Datetime from 'vue-datetime'
// You need a specific loader for CSS files
import 'vue-datetime/dist/vue-datetime.css'
import vSelect from 'vue-select'

window.Vue = require('vue');
window.EventBus = new Vue()

var toastrConfigs = {
    position: 'top right',
    showDuration: 300,
    timeOut: 5000,
    successColor: '#2ecc71',
    showMethod: 'slideInDown',
    hideMethod: 'flash',
    closeButton: false,
}

Vue.use(CxltToastr, toastrConfigs)
Vue.use(Moment)
Vue.use(VeeValidate)
Vue.use(VueRouter)
Vue.use(Croppa)  
Vue.use(Datetime)
Vue.use(vSelect)

const router = new VueRouter({
    routes,
    mode: 'history'
})


const app = new Vue({
    el: '#app',
    router: router,
    store: store,
    components: { 
        SchoolConfigs,
        YearConfigs, 
        SystemConfigs, 
        Fab, 
        Attendance,
        EAttendance, 
        Attention, 
        SettingNumber, 
        SecretNumber, 
        Committee,  
        Results,
        EmployeeSalary,
        AddSalary,
        AddExpense,
        StudentRepo,
        ParentRepo,
        AbsentStudentRepo,
        AbsentEmpRepo,
        GenderRepo
    },
});
