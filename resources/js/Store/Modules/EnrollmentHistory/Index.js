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
            perPageOptions: [5, 10, 25, 50],
        },
        tableColumns: [
            {text: 'Academic Year', value: 'cureffec',},
            { text: 'Program', value: 'program.cordesc' },
            { text: 'Major', value: 'program.cormajor' },
            { text: 'Semester', value: 'studsem' },
            { text: 'Year Level', value: 'yearlevel' },
            { text: 'Status', value: 'status' },
            { text: 'Actions', value: 'actions' },
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
        axios.get(route('api.student.enrollment-history.index', state.serverQuery))
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
        axios.get(route('api.student.enrollment-history.index', { ...params, perPage: 5000 }))
            .then(response => {
                commit('setAllData', response.data.data)
            })
            .finally(function () {
                commit('setLoading', false);
            })
    },
    destroyData({ dispatch, commit, state }, id) {
        return new Promise((resolve, reject) => {
            axios.delete(route('api.student.enrollment-history.destroy', id))
                .then(data => {
                    resolve(data)
                    dispatch('delayServerQuery');
                }).catch(error => {
                reject(error)
            });
        });
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
    setPagination(state, { current_page, from, per_page, total, to }) {
        state.pagination.currentPage = current_page;
        state.pagination.total = total;
        state.pagination.perPage = parseInt(per_page);
        state.pagination.from = from;
        state.pagination.to = to;
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
