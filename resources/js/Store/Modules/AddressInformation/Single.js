import axios from "axios"

function initialState() {
    return {
        item: {
            brthhouseno: '',
            brthstreet: '',
            brthbrgy: '',
            brthtown: '',
            brthzipcode: '',
            brthprovince: '',
            brthcountry: '',
            addhouseno: '',
            addstreet: '',
            addbrgy: '',
            addtown: '',
            addzipcode: '',
            addprovince: '',
            addcountry: '',
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
            axios.post(route('api.student.addresses.store'), params)
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
        axios.get(route('api.student.addresses.show', id))
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
            axios.post(route('api.student.addresses.update', state.item.id), params)
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
    setBirthHouseNo({commit}, value)
    {
        commit('setBirthHouseNo', value)
    },
    setBirthStreet({commit}, value)
    {
        commit('setBirthStreet', value)
    },
    setBirthBarangay({commit}, value)
    {
        commit('setBirthBarangay', value)
    },
    setBirthTown({commit}, value)
    {
        commit('setBirthTown', value)
    },
    setBirthZipcode({commit}, value)
    {
        commit('setBirthZipcode', value)
    },
    setBirthProvince({commit}, value)
    {
        commit('setBirthProvince', value)
    },
    setBirthCountry({commit}, value)
    {
        commit('setBirthCountry', value)
    },
    setPermanentHouseNo({commit}, value)
    {
        commit('setPermanentHouseNo', value)
    },
    setPermanentStreet({commit}, value)
    {
        commit('setPermanentStreet', value)
    },
    setPermanentBarangay({commit}, value)
    {
        commit('setPermanentBarangay', value)
    },
    setPermanentTown({commit}, value)
    {
        commit('setPermanentTown', value)
    },
    setPermanentZipcode({commit}, value)
    {
        commit('setPermanentZipcode', value)
    },
    setPermanentProvince({commit}, value)
    {
        commit('setPermanentProvince', value)
    },
    setPermanentCountry({commit}, value)
    {
        commit('setPermanentCountry', value)
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
    setBirthHouseNo(state, value){
        state.item.brthhouseno = value
    },
    setBirthStreet(state, value){
        state.item.brthstreet = value
    },
    setBirthBarangay(state, value){
        state.item.brthbrgy = value
    },
    setBirthTown(state, value){
        state.item.brthtown = value
    },
    setBirthZipcode(state, value){
        state.item.brthzipcode = value
    },
    setBirthProvince(state, value){
        state.item.brthprovince = value
    },
    setBirthCountry(state, value){
        state.item.brthcountry = value
    },
    setPermanentHouseNo(state, value){
        state.item.addhouseno = value
    },
    setPermanentStreet(state, value){
        state.item.addstreet = value
    },
    setPermanentBarangay(state, value){
        state.item.addbrgy = value
    },
    setPermanentTown(state, value){
        state.item.addtown = value
    },
    setPermanentZipcode(state, value){
        state.item.addzipcode = value
    },
    setPermanentProvince(state, value){
        state.item.addprovince = value
    },
    setPermanentCountry(state, value){
        state.item.addcountry = value
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
