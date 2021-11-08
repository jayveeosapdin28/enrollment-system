import axios from "axios"

function initialState() {
    return {
        item: {
            email1: '',
            phone1: '',
        },
        selected_subjects: [],
        formErrors: {},
        errorMessage: null,
        loading: false,
    }
}

const getters = {
    item: state => state.item,
    selected_subjects: state => state.selected_subjects,
    loading: state => state.loading,
    formErrors: state => state.formErrors,
    errorMessage: state => state.errorMessage
}

const actions = {
    storeData({commit, state},id) {
        commit('setLoading', true);
        let params = new FormData();
        params.set('id',id)
        for (let index in state.selected_subjects) {
            params.set('subjects['+index+']', state.selected_subjects[index]);
        }
        return new Promise((resolve, reject) => {
            axios.post(route('api.admin.enroll-subjects.store'), params)
                .then(response => {
                    resolve(response)
                    commit('setLoading', false);
                }).catch(error => {
                commit('setErrorMessage', error.response.data.message)
                if (typeof error.response.data.errors != 'undefined') {
                    commit('setFormErrors', error.response.data.errors)

                }
                commit('setLoading', false);
                reject(error)
            });
        })
    },
    findData({commit, state}, id) {
        commit('setLoading', true);
        commit('resetState')
        axios.get(route('api.admin.enroll-subjects.show', id))
            .then(response => {
                if (response.data.data) {
                    commit('setItem', response.data.data)
                }
                commit('setLoading', false);
            })
            .finally(function () {
                commit('setLoading', false);
            })
    },
    updateData({commit, state, dispatch}) {
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
            axios.post(route('api.admin.enroll-subjects.update', state.item.id), params)
                .then(response => {
                    resolve(response)
                    commit('setLoading', false);
                }).catch(error => {
                commit('setErrorMessage', error.response.data.message)
                if (typeof error.response.data.errors != 'undefined') {
                    commit('setFormErrors', error.response.data.errors)

                }
                commit('setLoading', false);
                reject(error)
            });
        })
    },
    setItem({commit}, value) {
        commit('setItem', value)
    },
    setSelectedSubject({commit}, value) {
        commit('setSelectedSubject', value)
    },
    setFormErrors({commit}, value) {
        commit('setFormErrors', value)
    },
    setErrorMessage({commit}, value) {
        commit('setErrorMessage', value)
    },
    resetState({commit}) {
        commit('resetState')
    }
}

const mutations = {
    setItem(state, value) {
        state.item = value
    },
    setSelectedSubject(state, value) {
        state.selected_subjects = value;
    },
    setFormErrors(state, errors) {
        state.formErrors = errors;
    },
    setErrorMessage(state, errors) {
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
