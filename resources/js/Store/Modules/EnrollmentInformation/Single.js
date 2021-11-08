import axios from "axios"

function initialState() {
    return {
        item: {
            status: null,
            corid: null,
            yearlevel: null,
            campcode: null,
            cureffec: null,
            studsem: null,
            enrollment_status: null,
            studsection: null,
        },
        formErrors: {},
        loading: false,
        errorMessage: null,

    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    formErrors: state => state.formErrors,
    errorMessage: state => state.errorMessage
}

const actions = {
    storeData({ commit, state, dispatch }) {
        commit('setLoading', true);
        let params = new FormData();
        params.set('_method', 'POST')
        for (let fieldName in state.item) {
            let fieldValue = state.item[fieldName];
            if (typeof fieldValue !== 'object') {
                params.set(fieldName, fieldValue);
            } else {
                if (fieldValue && typeof fieldValue[0] !== 'object') {
                    params.set(fieldName, fieldValue);
                } else {
                    for (let index in fieldValue) {
                        params.set(fieldName + '[' + index + ']', fieldValue[index]);
                    }
                }
            }
        }

        return new Promise((resolve, reject) => {
            axios.post(route('api.student.enrollment-applications.store'), params)
                .then(response => {
                    resolve(response)
                    commit('setLoading', false);
                }).catch(error => {
                commit('setErrorMessage', error.response.data.message)
                if(typeof error.response.data.errors != 'undefined')
                {
                    commit('setFormErrors', error.response.data.errors)
                }
                commit('setLoading', false);
                reject(error)
            });
        })
    },
    findData({ commit, state }, id) {
        commit('setLoading', true);
        commit('resetState')
        axios.get(route('api.student.enrollment-applications.show', id))
            .then(response => {
                if( response.data.data){
                    commit('setItem', response.data.data)
                }
                commit('setLoading', false);
            })
            .finally(function () {
                commit('setLoading', false);
            })
    },
    updateData({ commit, state, dispatch }) {
        commit('setLoading', true)
        let params = new FormData();
        params.set('_method', 'PATCH')

        for (let fieldName in state.item) {
            let fieldValue = state.item[fieldName];
            if (typeof fieldValue !== 'object') {
                params.set(fieldName, fieldValue);
            } else {
                if (fieldValue && typeof fieldValue[0] !== 'object') {
                    params.set(fieldName, fieldValue);
                } else {
                    for (let index in fieldValue) {
                        params.set(fieldName + '[' + index + ']', fieldValue[index]);
                    }
                }
            }
        }


        return new Promise((resolve, reject) => {
            axios.post(route('api.student.enrollment-applications.update', state.item.id), params)
                .then(response => {
                    commit('setLoading', false);
                    resolve(response)
                }).catch(error => {
                commit('setErrorMessage', error.response.data.message)
                if(typeof error.response.data.errors != 'undefined')
                {
                    commit('setFormErrors', error.response.data.errors)
                }
                commit('setLoading', false);
                reject(error)
            });
        })
    },
    setItem({commit}, value)
    {
        commit('setItem', value)
    },
    setEnrollmentStatus({commit}, value)
    {
        commit('setEnrollmentStatus', value)
    },
    setIDNumber({commit}, value)
    {
        commit('setIDNumber', value)
    },
    setAcademicYear({commit}, value)
    {
        commit('setAcademicYear', value)
    },
    setCourse({commit}, value)
    {
        commit('setCourse', value)
    },
    setSemester({commit}, value)
    {
        commit('setSemester', value)
    },
    setYearLevel({commit}, value)
    {
        commit('setYearLevel', value)
    },
    setSection({commit}, value)
    {
        commit('setSection', value)
    },
    setCampus({commit}, value)
    {
        commit('setCampus', value)
    },
    setFormErrors({commit}, value)
    {
        commit('setFormErrors', value)
    },
    setErrorMessage({commit}, value)
    {
        commit('setErrorMessage', value)
    },
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setItem(state, value){
        state.item = value
    },
    setEnrollmentStatus(state, value){
        state.item.enrollment_status = value
    },
    setIDNumber(state, value){
        state.item.idnumber = value
    },
    setCourse(state, value){
        state.item.corid = value
    },
    setAcademicYear(state, value){
        state.item.cureffec = value
    },
    setSemester(state, value){
        state.item.studsem = value
    },
    setSection(state, value){
        state.item.studsection = value
    },
    setYearLevel(state, value){
        state.item.yearlevel = value
    },
    setCampus(state, value){
        state.item.campcode = value
    },
    setFormErrors(state, errors)
    {
        state.formErrors = errors;
    },
    setErrorMessage(state, errors)
    {
        state.errorMessage = errors;
    },
    setLoading(state, loading) {
        state.loading = loading
    },
    resetState(state) {
        state = Object.assign(state, initialState())
    }
}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}
