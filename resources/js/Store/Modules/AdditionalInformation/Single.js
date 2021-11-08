import axios from "axios"

function initialState() {
    return {
        item: {
            scholarship: null,
            lgbt: null,
            tribe: null,
            learning_module: null,
            internet_connectivity: null,
            student_type: null,
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
            axios.post(route('api.student.additional-informations.store'), params)
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
        axios.get(route('api.student.additional-informations.show', id))
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
            axios.post(route('api.student.additional-informations.update', state.item.id), params)
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
    setLGBT({commit}, value)
    {
        commit('setLGBT', value)
    },
    setTribe({commit}, value)
    {
        commit('setTribe', value)
    },
    setStudentType({commit}, value)
    {
        commit('setStudentType', value)
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
    setLGBT(state, value){
        state.item.lgbt = value
    },
    setTribe(state, value){
        state.item.tribe = value
    },
    setStudentType(state, value){
        state.item.student_type = value
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
