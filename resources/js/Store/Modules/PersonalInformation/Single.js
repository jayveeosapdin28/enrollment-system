import axios from "axios"

function initialState() {
    return {
        item: {
            studnam3: '',
            studnam2: '',
            studnam1: '',
            studnam4: '',
            studbday: '',
            studcivilstat: '',
            nationality: '',
            religion_id: '',
            gender: '',
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
    errorMessage: state => state.errorMessage,
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
            axios.post(route('api.student.student-infos.store'), params)
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
        axios.get(route('api.student.student-infos.show', id))
            .then(response => {
                if(response.data.data){
                    commit('setItem', response.data.data);
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
            axios.post(route('api.student.student-infos.update', state.item.id), params)
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
    setStudNam1({commit}, value)
    {
        commit('setStudNam1', value)
    },
    setStudNam2({commit}, value)
    {
        commit('setStudNam2', value)
    },
    setStudNam3({commit}, value)
    {
        commit('setStudNam3', value)
    },
    setStudNam4({commit}, value)
    {
        commit('setStudNam4', value)
    },
    setStudBDay({commit}, value)
    {
        commit('setStudBDay', value)
    },
    setStudCivilStat({commit}, value)
    {
        commit('setStudCivilStat', value)
    },
    setGender({commit}, value)
    {
        commit('setGender', value)
    },
    setReligion({commit}, value)
    {
        commit('setReligion', value)
    },
    setNationality({commit}, value)
    {
        commit('setNationality', value)
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
    setStudNam1(state, value){
        state.item.studnam1 = value
    },
    setStudNam2(state, value){
        state.item.studnam2 = value
    },
    setStudNam3(state, value){
        state.item.studnam3 = value
    },
    setStudNam4(state, value){
        state.item.studnam4 = value
    },
    setGender(state, value){
        state.item.gender = value
    },
    setReligion(state, value){
        state.item.religion_id = value
    },
    setNationality(state, value){
        state.item.nationality = value
    },
    setStudCivilStat({commit}, value) {
        state.item.studcivilstat = value
    },
    setStudBDay({commit}, value) {
        state.item.studbday = value
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
