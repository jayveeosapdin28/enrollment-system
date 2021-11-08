import { debounce } from 'lodash'
function initialState() {
    return {
        tableData: [],
        allData: [],
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
            {value: "subcode", text: "Code",},
            {value: "subdesc", text: "Description",},
            {value: "subunit", text: "Unit",},
            {value: "actions", text: "Action",},

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
        axios.get(route('api.student.subjects.index', state.serverQuery))
            .then(response => {
                commit('setPagination', response.data)
                commit('setTableData', response.data.data)
            })
            .finally(function () {
                commit('setLoading', false);
            })
    },
    fetchPendingData({ commit, state }) {
        commit('setLoading', true);
        axios.get(route('api.student.subjects.index', state.serverQuery))
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
        axios.get(route('api.student.subjects.index', { ...params, perPage: 5000 }))
            .then(response => {
                commit('setAllData', response.data.data)
            })
            .finally(function () {
                commit('setLoading', false);
            })
    },
    destroyData({ dispatch, commit, state }, id) {
        axios.delete(route('api.student.contacts.destroy', id))
            .then(data => {
                runToast('top-right', 'warning', "Data has been removed.")
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
    },
    resetState({ commit }) {
        commit('resetState')
    }
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
    }
}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}
