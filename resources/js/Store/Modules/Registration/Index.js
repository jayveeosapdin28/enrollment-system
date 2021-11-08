import { debounce } from 'lodash'
function initialState() {
    return {
        tableData: [],
        allData: [],
        serverQuery: {
            query: '',
            perPage: 10,
            page: 1,
            step_from: '',
            step_to: ''
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
            {value: "idnumber", text: "ID Number",},
            {value: "user.name", text: "Full Name",},
            {value: "program.corcode", text: "Program",},
            {value: "program.cormajor", text: "Major",},
            {value: "yearlevel", text: "Year Level",},
            {value: "studsem", text: "Semester",},
            {value: "cureffec", text: "Academic Year",},
            {value: "status", text: "Status",},
            { text: 'Action', value: 'actions' },

        ],
        loading: false,
    }
}

const getters = {
    tableData: state => state.tableData,
    allData: state => state.allData,
    pagination: state => state.pagination,
    tableColumns: state => state.tableColumns,
    serverQuery: state => state.serverQuery,
    loading: state => state.loading
}

const actions = {
    fetchData({ commit, state }) {
        commit('setLoading', true);
        axios.get(route('api.admin.enrollment-application.registration', state.serverQuery))
            .then(response => {
                commit('setPagination', response.data)
                commit('setTableData', response.data.data)
            })
            .finally(function () {
                commit('setLoading', false);
            })
    },
    fetchAllData({ commit, state }, params = {}) {
        commit('setLoading', true);
        axios.get(route('api.admin.enrollment-application.registration', { ...params, perPage: 5000 }))
            .then(response => {
                commit('setAllData', response.data.data)
            })
            .finally(function () {
                commit('setLoading', false);
            })
    },
    fetchOnProcess({ commit, state }, params = {}) {
        commit('setLoading', true);
        axios.get(route('api.admin.enrollment-application.registration.on-process', state.serverQuery))
            .then(response => {
                commit('setTableData', response.data.data)
            })
            .finally(function () {
                commit('setLoading', false);
            })
    },
    fetchComplete({ commit, state }, params = {}) {
        commit('setLoading', true);
        axios.get(route('api.admin.enrollment-application.registration.complete', state.serverQuery))
            .then(response => {
                commit('setTableData', response.data.data)
            })
            .finally(function () {
                commit('setLoading', false);
            })
    },
    destroyData({ dispatch, commit, state }, id) {
        axios.delete(route('api.student.contacts.destroy', id))
            .then(data => {
                dispatch('delayServerQuery');
            })
    },
    setServerQuery({ commit, dispatch }, payload) {
        commit('setServerQuery', payload)
        dispatch('delayServerQuery');
    },
    delayServerQuery: debounce(({ dispatch }, text) => {
        dispatch("dispatchQueryString");
    }, 500),

    dispatchQueryString({ dispatch }) {
        dispatch('fetchData');
        //dispatch('fetchOnProcess');
    },
    resetState({ commit }) {
        commit('resetState')
    },
    setStepFrom({commit}, value) {
        commit('setStepFrom', value)
    },
    setStepTo({commit}, value) {
        commit('setStepTo', value)
    },
}

const mutations = {
    setPagination(state, { current_page, from, per_page, total, to,last_page }) {
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
    setAllData(state, data) {
        state.allData = data;
    },
    setQuery(state, query) {
        state.query = query
    },
    resetState(state) {
        state = Object.assign(state, initialState())
    },
    setServerQuery(state, { name, value }) {
        state.serverQuery[name] = value
    },
    setLoading(state, status) {
        state.loading = status;
    },
    setStepFrom(state, status) {
        state.serverQuery.step_from = status;
    },
    setStepTo(state, status) {
        state.serverQuery.step_to = status;
    },
}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}
