import axios from "axios"

function initialState() {
    return {
        item: {
            fathnam3: '',
            fathnam2: '',
            fathnam1: '',
            fathnam4: '',
            fathoccup: '',
            mothnam3: '',
            mothnam2: '',
            mothnam1: '',
            mothoccup: '',
            guardian: '',
            guardian_country: '',
            guardian_barangay: '',
            guardian_city: '',
            guardian_province: '',
            guardian_street: '',
            guardian_house: '',
            relationship: '',
            phone2: '',
            annualfamincome: '',
            parentstatus: '',
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
            axios.post(route('api.student.family-information.store'), params)
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
    setFatherName1({commit}, value)
    {
        commit('setFatherName1', value)
    },
    setFatherName2({commit}, value)
    {
        commit('setFatherName2', value)
    },
    setFatherName3({commit}, value)
    {
        commit('setFatherName3', value)
    },
    setFatherName4({commit}, value)
    {
        commit('setFatherName4', value)
    },
    setFatherOccupation({commit}, value)
    {
        commit('setFatherOccupation', value)
    },
    setMotherName1({commit}, value)
    {
        commit('setMotherName1', value)
    },
    setMotherName2({commit}, value)
    {
        commit('setMotherName2', value)
    },
    setMotherName3({commit}, value)
    {
        commit('setMotherName3', value)
    },
    setMotherOccupation({commit}, value)
    {
        commit('setMotherOccupation', value)
    },
    setGuardian({commit}, value)
    {
        commit('setGuardian', value)
    },
    setRelationship({commit}, value)
    {
        commit('setRelationship', value)
    },
    setGuardianPhone({commit}, value)
    {
        commit('setGuardianPhone', value)
    },
    setGuardianBarangay({commit}, value)
    {
        commit('setGuardianBarangay', value)
    },
    setGuardianCountry({commit}, value)
    {
        commit('setGuardianCountry', value)
    },
    setGuardianCity({commit}, value)
    {
        commit('setGuardianCity', value)
    },
    setGuardianProvince({commit}, value)
    {
        commit('setGuardianProvince', value)
    },
    setGuardianStreet({commit}, value)
    {
        commit('setGuardianStreet', value)
    },
    setGuardianHouse({commit}, value)
    {
        commit('setGuardianHouse', value)
    },
    setAnnualIncome({commit}, value)
    {
        commit('setAnnualIncome', value)
    },
    setParentStatus({commit}, value)
    {
        commit('setParentStatus', value)
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
    setFatherName1(state, value){
        state.item.fathnam1 = value
    },
    setFatherName2(state, value){
        state.item.fathnam2 = value
    },
    setFatherName3(state, value){
        state.item.fathnam3 = value
    },
    setFatherName4(state, value){
        state.item.fathnam4 = value
    },
    setFatherOccupation(state, value){
        state.item.fathoccup = value
    },
    setMotherName1(state, value){
        state.item.mothnam1 = value
    },
    setMotherName2(state, value){
        state.item.mothnam2 = value
    },
    setMotherName3(state, value){
        state.item.mothnam3 = value
    },
    setMotherOccupation(state, value){
        state.item.mothoccup = value
    },
    setGuardian(state, value){
        state.item.guardian = value
    },
    setGuardianBarangay(state, value){
        state.item.guardian_barangay = value
    },
    setGuardianCountry(state, value){
        state.item.guardian_country = value
    },
    setGuardianCity(state, value){
        state.item.guardian_city = value
    },
    setGuardianProvince(state, value){
        state.item.guardian_province = value
    },
    setGuardianStreet(state, value){
        state.item.guardian_street = value
    },
    setGuardianHouse(state, value){
        state.item.guardian_house = value
    },
    setRelationship(state, value){
        state.item.relationship = value
    },
    setAnnualIncome(state, value){
        state.item.annualfamincome = value
    },
    setParentStatus(state, value){
        state.item.parentstatus = value
    },
    setGuardianPhone(state, value){
        state.item.phone2 = value
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
