import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import {SchoolConfigs} from './configs/schoolConfigs'

Vue.use(Vuex)
axios.defaults.baseURL = 'https://old.schoolver.com/api/'



export const store = new Vuex.Store({
    modules: {
        SchoolConfigs: SchoolConfigs
    },
    state: {
        $auth: {}
    },
    getters: {
    },
    mutations: {
        getAuth(state, auth) {
            state.$auth = auth
        },
    },
    actions: {
        retrieveAuth(context) {
            return new Promise((resolve, reject) => {
                axios.get(`get-auth`)
                    .then(response => {
                        context.commit('getAuth', response.data)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        retriveOptions(context, data) {
            return new Promise((resolve, reject) => {
                axios.get(`${data.apiURL}`)
                    .then(response => {
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        retriveTimetables(context, data) {
            return new Promise((resolve, reject) => {
                axios.get(`${data.get.apiURL}?classroom=${data.classRoom}`)
                    .then(response => {
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        retriveFilterSchool(context, data) {
            return new Promise((resolve, reject) => {
                axios.get(`${data.get.apiURL}?stageEdu=${data.stageEdu}&classEdu=${data.classEdu}&classRoom=${data.classRoom}`)
                    .then(response => {
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        exportResult(context, data) {
            return new Promise((resolve, reject) => {
                axios({
                        url: `${data.get.apiURL}?class_id=${data.class_id}&subject_id=${data.subject_id}&exam_id=${data.exam_id}`,
                        method: 'GET',
                        responseType: 'blob', // important
                    })
                    .then(response => {
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        retriveFilterSchoolEdit(context, data) {
            return new Promise((resolve, reject) => {
                axios.get(`${data.get.apiURL}?stageEdu=${data.stageEdu}&classEdu=${data.classEdu}&classRoom=${data.classRoom}&edit=${data.edit}`)
                    .then(response => {
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        retriveResults(context, data) {
            return new Promise((resolve, reject) => {
                axios.get(`${data.apiURL}?type=${data.params.typeExamId}&subject=${data.params.supSubjectId}`)
                    .then(response => {
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        retriveAttendance(context, data) {
            const params = {
                ...data
            }
            return new Promise((resolve, reject) => {
                axios.get(`${data.get.apiURL}?day=${data.day}`)
                    .then(response => {
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        retriveAttendanceTwo(context, data) {
            const params = {
                ...data
            }
            return new Promise((resolve, reject) => {
                axios.get(`${data.get.apiURL}?stageEdu=${data.stageEdu}&classEdu=${data.classEdu}&classRoom=${data.classRoom}&day=${data.day}`)
                    .then(response => {
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        retriveAttendtion(context, data) {
            const params = {
                ...data
            }
            return new Promise((resolve, reject) => {
                axios.get(`${data.get.apiURL}?id=${data.id}`)
                    .then(response => {
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        retriveAttendtionEdit(context, data) {
            const params = {
                ...data
            }
            return new Promise((resolve, reject) => {
                axios.get(`${data.get.apiURL}?id=${data.id}&attentionGet=${data.edit}`)
                    .then(response => {
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        retriveAttendtionShow(context, data) {
            const params = {
                ...data
            }
            return new Promise((resolve, reject) => {
                axios.get(`${data.get.apiURL}?attentionGet=${data.edit}`)
                    .then(response => {
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        retriveUser(context, data) {
            const params = {
                ...data
            }
            return new Promise((resolve, reject) => {
                axios.get(`${data.get.apiURL}?classEdu=${data.classEdu}&classroom=${data.classRoom}`)
                    .then(response => {
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        retrivePayemtnDetails(context, data) {
            const params = {
                ...data
            }
            return new Promise((resolve, reject) => {
                axios.get(`${data.get.apiURL}?id=${data.id}&month=${data.month}`)
                    .then(response => {
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        submitForm(context, data) {
            const params = {
                ...data
            }
            return new Promise((resolve, reject) => {
                axios.post(`${data.post.apiURL}`, params)
                    .then(response => {
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        delete(context, data) {
            return new Promise((resolve, reject) => {
                axios.delete(`${data.delete.apiURL}/${data.id}`)
                    .then(response => {
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        }
    }
})
