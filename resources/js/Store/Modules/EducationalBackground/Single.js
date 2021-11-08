import axios from "axios"

function initialState() {
    return {
        item: {
            elemschool: '',
            elemsy: '',
            hsschool: '',
            hssy: '',
            college: '',
            collegesy: '',
        },
        formErrors: {},
        errorMessage: null,
        loading: false,
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
            axios.post(route('api.student.educational-backgrounds.store'), params)
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
        axios.get(route('api.student.educational-backgrounds.show', id))
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
            axios.post(route('api.student.educational-backgrounds.update', state.item.id), params)
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
    setItem({commit}, value)
    {
        commit('setItem', value)
    },
    setElementaryName({commit}, value)
    {
        commit('setElementaryName', value)
    },
    setElementaryGraduate({commit}, value)
    {
        commit('setElementaryGraduate', value)
    },
    setHighSchoolName({commit}, value)
    {
        commit('setHighSchoolName', value)
    },
    setHighSchoolGraduate({commit}, value)
    {
        commit('setHighSchoolGraduate', value)
    },
    setCollegeName({commit}, value)
    {
        commit('setCollegeName', value)
    },
    setCollegeGraduate({commit}, value)
    {
        commit('setCollegeGraduate', value)
    },

    setErrorMessage({commit}, value)
    {
        commit('setErrorMessage', value)
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
    setElementaryName(state, value){
        state.item.elemschool = value
    },
    setElementaryGraduate(state, value){
        state.item.elemsy = value
    },
    setHighSchoolName(state, value){
        state.item.hsschool = value
    },
    setHighSchoolGraduate(state, value){
        state.item.hssy = value
    },
    setCollegeName(state, value){
        state.item.college = value
    },
    setCollegeGraduate(state, value){
        state.item.collegesy = value
    },
    setErrorMessage(state, value){
        state.errorMessage = value
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
