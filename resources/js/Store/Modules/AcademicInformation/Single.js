import axios from "axios"

function initialState() {
    return {
        item: {
            CORID: null,
            YEARLEVEL: null,
            CAMPCODE: null,
            CUREFFEC: null,
            STUDSEM: null,
            STUDSECTION: null,
        },
        formErrors: {},
        loading: false,
    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    formErrors: state => state.formErrors
}

const actions = {
    storeData({ commit, state, dispatch }) {

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
            axios.post(route('api.clients.store'), params)
                .then(response => {
                    resolve(response)
                }).catch(error => {
                if(typeof error.response.data.errors != 'undefined')
                {
                    commit('setFormErrors', error.response.data.errors)
                }
                reject(error)
            });
        })
    },
    findData({ commit, state }, id) {
        commit('setLoading', true);
        commit('resetState')
        axios.get(route('api.clients.show', id))
            .then(response => {
                commit('setItem', response.data.data)
            })
            .finally(function () {
                commit('setLoading', false);
            })
    },
    updateData({ commit, state, dispatch }) {
        // commit('setLoading', true)
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
            axios.post(route('api.clients.update', state.item.id), params)
                .then(response => {
                    runToast('top-right', 'success', "Data has been saved.")
                    resolve(response)
                }).catch(error => {
                console.log(error.response.data)
                if(typeof error.response.data.errors != 'undefined')
                {
                    commit('setFormErrors', error.response.data.errors)
                    runToast('top-right', 'warning', error.response.data.message)
                }
                reject(error)
            });
        })
    },
    setItem({commit}, value)
    {
        commit('setItem', value)
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
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setItem(state, value){
        state.item = value
    },
    setCourse(state, value){
        state.item.CORID = value
    },
    setAcademicYear(state, value){
        state.item.CUREFFEC = value
    },
    setSemester(state, value){
        state.item.STUDSEM = value
    },
    setSection(state, value){
        state.item.STUDSECTION = value
    },
    setYearLevel(state, value){
        state.item.YEARLEVEL = value
    },
    setCampus(state, value){
        state.item.CAMPCODE = value
    },
    setFormErrors(state, errors)
    {
        state.formErrors = errors;
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
