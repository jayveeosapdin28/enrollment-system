import { debounce } from 'lodash'
function initialState() {
    return {
        barangayData: [],
        cityData: [],
        provinceData: [],

        birthBrgyData: [],
        birthCityData: [],
        birthProvinceData: [],

        guardianBrgyData: [],
        guardianCityData: [],
        guardianProvinceData: [],

        loading: false,
    }
}

const getters = {
    guardianBrgyData: state => state.guardianBrgyData,
    guardianCityData: state => state.guardianCityData,
    guardianProvinceData: state => state.guardianProvinceData,

    barangayData: state => state.barangayData,
    cityData: state => state.cityData,
    provinceData: state => state.provinceData,

    birthBrgyData: state => state.birthBrgyData,
    birthCityData: state => state.birthCityData,
    birthProvinceData: state => state.birthProvinceData,

}

const actions = {
    //PERMANENT ADDRESS
    fetchBarangayData({ commit, state },code) {
        axios.get(route('api.address.barangays.show',code))
            .then(response => {
                commit('setBarangayData', response.data.data)
            })
            .finally(function () {
                commit('setLoading', false);
            })
    },
    fetchCityData({ commit, state },code) {
        axios.get(route('api.address.cities.show',code))
            .then(response => {
                commit('setCityData', response.data.data)
            })
            .finally(function () {
                commit('setLoading', false);
            })
    },
    fetchProvinceData({ commit, state },id) {
        axios.get(route('api.address.provinces.index'))
            .then(response => {
                commit('setProvinceData', response.data.data)
            })
            .finally(function () {
                commit('setLoading', false);
            })
    },
    //BIRTH ADDRESS
    fetchBirthBrgyData({ commit, state },code) {
        axios.get(route('api.address.barangays.show',code))
            .then(response => {
                commit('setBirthBrgyData', response.data.data)
            })
            .finally(function () {
                commit('setLoading', false);
            })
    },
    fetchBirthCityData({ commit, state },code) {
        axios.get(route('api.address.cities.show',code))
            .then(response => {
                commit('setBirthCityData', response.data.data)
            })
            .finally(function () {
                commit('setLoading', false);
            })
    },
    fetchBirthProvinceData({ commit, state },id) {
        axios.get(route('api.address.provinces.index'))
            .then(response => {
                commit('setBirthProvinceData', response.data.data)
            })
            .finally(function () {
                commit('setLoading', false);
            })
    },
    //GUARDIAN ADDRESS
    fetchGuardianBrgyData({ commit, state },code) {
        axios.get(route('api.address.barangays.show',code))
            .then(response => {
                commit('setGuardianBrgyData', response.data.data)
            })
            .finally(function () {
                commit('setLoading', false);
            })
    },
    fetchGuardianCityData({ commit, state },code) {
        axios.get(route('api.address.cities.show',code))
            .then(response => {
                commit('setGuardianCityData', response.data.data)
            })
            .finally(function () {
                commit('setLoading', false);
            })
    },
    fetchGuardianProvinceData({ commit, state },id) {
        axios.get(route('api.address.provinces.index'))
            .then(response => {
                commit('setGuardianProvinceData', response.data.data)
            })
            .finally(function () {
                commit('setLoading', false);
            })
    },
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setBarangayData(state, data) {
        state.barangayData = data;
    },
    setCityData(state, data) {
        state.cityData = data;
    },
    setProvinceData(state, data) {
        state.provinceData = data;
    },
    setBirthBrgyData(state, data) {
        state.birthBrgyData = data;
    },
    setBirthCityData(state, data) {
        state.birthCityData = data;
    },
    setBirthProvinceData(state, data) {
        state.birthProvinceData = data;
    },

    setGuardianBrgyData(state, data) {
        state.guardianBrgyData = data;
    },
    setGuardianCityData(state, data) {
        state.guardianCityData = data;
    },
    setGuardianProvinceData(state, data) {
        state.guardianProvinceData = data;
    },

    resetState(state) {
        state = Object.assign(state, initialState())
    },
    setLoading(state, status) {
        state.loading = status;
    }
}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}
