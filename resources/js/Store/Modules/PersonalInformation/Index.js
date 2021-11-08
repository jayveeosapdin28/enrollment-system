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
        id: null,
        pagination: {
            currentPage: 0,
            total: 0,
            perPage: 0,
            from: 0,
            to: 0,
            perPageOptions: [5, 10, 25, 50],
        },
        tableColumns: [
            {
                prop: "first_name",
                label: "First Name",
                minWidth: 250,
            },
            {
                prop: "last_name",
                label: "Last Name",
                minWidth: 250,
            },
            {
                prop: "email",
                label: "Email",
                minWidth: 250,
            },
            {
                prop: "phone",
                label: "Phone",
                minWidth: 250,
            },

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
    loading: state => state.loading,
    id: state => state.id
}

const actions = {
    fetchData({ commit, state }) {
        commit('setLoading', true);
        axios.get(route('api.student.student-infos.show', state.serverQuery))
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
        axios.get(route('api.student.student-infos.index', { ...params, perPage: 5000 }))
            .then(response => {
                commit('setAllData', response.data.data)
            })
            .finally(function () {
                commit('setLoading', false);
            })
    },
    destroyData({ dispatch, commit, state }, id) {
        axios.delete(route('api.student.student-infos.destroy', id))
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
    setID(state, data) {
        state.id = data;
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
