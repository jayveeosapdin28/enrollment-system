import {debounce} from 'lodash'

function initialState() {
    return {
        tableData: [],
        allData: [],
        assessmentData: [],
        newFeeData: null,
        serverQuery: {
            query: '',
            perPage: 10,
            page: 1
        },
        pagination: {
            currentPage: 0,
            total: 0,
            perPage: 0,
            from: 0,
            to: 0,
            lastPage: 0,
            perPageOptions: [5, 10, 25, 50],
        },
        tableColumns: [
            {value: "feename", text: "Fee",},
            {value: "feeamount1", text: "Amount"},
        ],
        loading: false,
    }
}

const getters = {
    tableData: state => state.tableData,
    assessmentData: state => state.assessmentData,
    allData: state => state.allData,
    pagination: state => state.pagination,
    tableColumns: state => state.tableColumns,
    serverQuery: state => state.serverQuery,
    loading: state => state.loading,
    newFeeData: state => state.newFeeData
}

const actions = {
    fetchData({commit, state}) {
        commit('setLoading', true);
        axios.get(route('api.admin.enrollment-application.fees.index', state.serverQuery))
            .then(response => {
                commit('setPagination', response.data)
                commit('setTableData', response.data.data)
            })
            .finally(function () {
                commit('setLoading', false);
            })
    },
    fetchAssessmentData({commit, state},id) {
        commit('setLoading', true);
        axios.get(route('api.admin.enrollment-application.registration.assessments.get-assessment',id))
            .then(response => {
                commit('setAssessmentData', response.data.data)
            })
            .finally(function () {
                commit('setLoading', false);
            })
    },
    fetchAllData({commit, state}, params = {}) {
        commit('setLoading', true);
        return new Promise((resolve, reject) => {
            axios.get(route('api.admin.enrollment-application.fees.index', {...params, perPage: 5000}))
                .then(response => {
                    resolve(response)
                    commit('setAllData', response.data.data)
                })
                .catch(error => {
                    reject(error)
                })
                .finally(function () {
                    commit('setLoading', false);
                })
        })
    },
    destroyData({dispatch, commit, state}, id) {
        axios.delete(route('api.student.contacts.destroy', id))
            .then(data => {
                dispatch('delayServerQuery');
            })
    },
    setServerQuery({commit, dispatch}, payload) {
        commit('setServerQuery', payload)
        dispatch('delayServerQuery');
    },
    delayServerQuery: debounce(({dispatch}, text) => {
        dispatch("dispatchQueryString");
    }, 500),
    setTableData({commit}, value) {
        commit('setTableData', value)
    },
    setAssessmentData({commit}, value) {
        commit('setAssessmentData', value)
    },
    setNewFeeData({commit}, value) {
        commit('setNewFeeData', value)
    },
    dispatchQueryString({dispatch}) {
        dispatch('fetchData');
    },
    resetState({commit}) {
        commit('resetState')
    }
}

const mutations = {
    setPagination(state, {current_page, from, per_page, total, to, last_page}) {
        state.pagination.currentPage = current_page;
        state.pagination.total = total;
        state.pagination.perPage = parseInt(per_page);
        state.pagination.from = from;
        state.pagination.to = to;
        state.pagination.lastPage = last_page;
    },
    setTableData(state, data) {
        state.tableData = data;
    },
    setAssessmentData(state, data) {
        state.assessmentData = data;
    },
    setNewFeeData(state, data) {
        state.newFeeData = data;
    },
    setAllData(state, data) {
        state.allData = data;
    },
    setQuery(state, query) {
        state.query = query
    },
    resetState(state) {
        state = Object.assign(state, initialState())
    },
    setServerQuery(state, {name, value}) {
        state.serverQuery[name] = value
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
