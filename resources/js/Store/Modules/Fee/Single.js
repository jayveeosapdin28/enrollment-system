import axios from "axios"

function initialState() {
    return {
        item: {
            enrollment_app_id: null,
            selected_fees: [],
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
        commit('setLoading', true)
        console.log(state.item)
        let params = new FormData();
        params.set('_method', 'POST')
        params.append('enrollment_id',state.item.enrollment_app_id);
        state.item.selected_fees.map((fees,i)=>{
            Object.keys(fees).forEach(function (key) {
                params.append('selected_fees['+i+']['+key+']',fees[key])
            })
        })

        return new Promise((resolve, reject) => {
            axios.post(route('api.admin.enrollment-application.fees.store'), params)
                .then(response => {
                    resolve(response)
                    commit('setLoading', false)
                }).catch(error => {
                commit('setLoading', false)
                commit('setErrorMessage', error.response.data.message)
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
        axios.get(route('api.student.family-information.show', id))
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
            axios.post(route('api.student.family-information.update', state.item.id), params)
                .then(response => {
                    resolve(response);
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
    setSelectedFees({commit}, value)
    {
        commit('setSelectedFees', value)
    },
    setEnrollmentAppId({commit}, value)
    {
        commit('setEnrollmentAppId', value)
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
    setSelectedFees(state, value){
        state.item.selected_fees = value
    },
    setEnrollmentAppId(state, value){
        state.item.enrollment_app_id = value
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
