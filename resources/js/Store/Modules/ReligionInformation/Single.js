import axios from "axios"

function initialState() {
    return {
        item: {
            EMAIL1: '',
            PHONE1: '',
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
                    runToast('top-right', 'success', "Data has been saved.")
                    resolve(response)
                }).catch(error => {
                if(typeof error.response.data.errors != 'undefined')
                {
                    commit('setFormErrors', error.response.data.errors)
                    runToast('top-right', 'warning', error.response.data.message)
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
    setEmail({commit}, value)
    {
        commit('setEmail', value)
    },
    setPhone({commit}, value)
    {
        commit('setPhone', value)
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
    setEmail(state, value){
        state.item.EMAIL1 = value
    },
    setPhone(state, value){
        state.item.PHONE1 = value
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
