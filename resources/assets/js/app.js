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
import Timetables from './components/Timetables'
import EmployeeSalary from './components/EmployeeSalary'
import AddSalary from './components/AddSalary'
import SettingNumber from './components/SettingNumber'
import StudentRepo from './components/reports/Students'
import ParentRepo from './components/reports/Parents'
import NewStatusRepo from './components/reports/NewStatusRepo'
import NewcomerRepo from './components/reports/NewcomerRepo'
import TransportedRepo from './components/reports/TransportedRepo'
import TransferRepo from './components/reports/TransferRepo'
import FailureRepo from './components/reports/FailureRepo'
import BlindRepo from './components/reports/BlindRepo'
import DoctrineRepo from './components/reports/DoctrineRepo'
import ClassListRepo from './components/reports/ClassListRepo'
import SingleEmpRepo from './components/reports/SingleEmpRepo'
import SingleStudentRepo from './components/reports/SingleStudentRepo'
import SalaryMonthelyRepo from './components/reports/SalaryMonthely'
import AbsentStudentRepo from './components/reports/AbsentStudent'
import AbsentEmpRepo from './components/reports/AbsentEmp'
import AbsentEmpMonthRepo from './components/reports/AbsentEmpMonth'
import EmployeeRepo from './components/reports/Employee'
import GenderRepo from './components/reports/Gender'
import RepoDesigner from './components/reports/ReportDesigner'
import UpgradeStudents from './components/upgradeStudents/Upgrade'
import StatusStudents from './components/statusStudents/Status'
const _ = require('lodash')
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
import VueFuse from 'vue-fuse'
import Vddl from 'vddl';
import 'vue-instant/dist/vue-instant.css'
import VueInstant from 'vue-instant'
Vue.use(VueInstant)

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

Vue.use(VueFuse)
Vue.use(CxltToastr, toastrConfigs)
Vue.use(Moment)
Vue.use(VueRouter)
Vue.use(Croppa)
Vue.use(Datetime)
Vue.use(vSelect)
Vue.use(VeeValidate, {fieldsBagName: 'formFields'})
Vue.use(Vddl);

const router = new VueRouter({
    routes,
    mode: 'history'
})

Vue.mixin({
    computed: {
        $auth: {
            get() {return store.state.$auth}
        }
    }
})

Vue.prototype.envURL = process.env.MIX_APP_URL;
Vue.prototype.moment = Moment;
Vue.prototype.trans = local => _.get(window.i18n, local)
const app = new Vue({
    created() {
        let recaptchaScript = document.createElement('script')
        recaptchaScript.setAttribute('src', 'https://kamel-ouda.com/js/lang.js')
        document.head.appendChild(recaptchaScript)
        this.$store.dispatch('retrieveAuth')
    },
    el: '#app',
    router: router,
    store: store,
    newsss: 'hi',
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
        GenderRepo,
        NewStatusRepo,
        NewcomerRepo,
        TransportedRepo,
        TransferRepo,
        FailureRepo,
        BlindRepo,
        BlindRepo,
        DoctrineRepo,
        ClassListRepo,
        SalaryMonthelyRepo,
        SingleEmpRepo,
        SingleStudentRepo,
        EmployeeRepo,
        Timetables,
        AbsentEmpMonthRepo,
        UpgradeStudents,
        StatusStudents,
        RepoDesigner,
    },

});
