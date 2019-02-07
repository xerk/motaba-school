import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import {SchoolConfigs} from './configs/schoolConfigs'

Vue.use(Vuex)
axios.defaults.baseURL = 'https://kamel-ouda.com/api/'



export const store = new Vuex.Store({
    modules: {
        SchoolConfigs: SchoolConfigs
    },
    actions: {
        sendSMS(context, data) {
            const params = {
                ...data
            }
            return new Promise((resolve, reject) => {
                axios.post(`${data.sms.apiURL}`, params)
                    .then(response => {
                        resolve(response)
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
