import * as types from "../../mutation-types"

export default {
    deleteOneRole ({ commit }, id) {
        return window.axios.delete("/api/roles/" + id)
            .then(response => {
                const r = response.data.data
                commit(types.ROLES_DELETE_ONE, r)
                return r
            })
            .catch(error => {
                var message = error.data.message||error.message
                commit(types.ROLES_ERROR, message)
                return error
            })
    },

    fetchAllRoles ({ commit }, params) {
        commit(types.ROLES_FETCH_ALL_PENDING, true)

        return window.axios.get("/api/roles", { params: params })
            .then(response => {
                const all = response.data.data
                commit(types.ROLES_FETCH_ALL, all)
                commit(types.ROLES_FETCH_ALL_PENDING, false)
                return all
            })
            .catch(error => {
                var message = error.data.message||error.message
                commit(types.ROLES_ERROR, message)
                commit(types.ROLES_FETCH_ALL_PENDING, false)
                return error
            })
    },

    fetchOneRole ({ commit }, id) {
        commit(types.ROLES_FETCH_ONE_PENDING, true)

        return window.axios.get("/api/roles/" + id)
            .then(response => {
                const one = response.data
                commit(types.ROLES_FETCH_ONE, one)
                commit(types.ROLES_FETCH_ONE_PENDING, false)
                return one
            })
            .catch(error => {
                var message = error.data.message||error.message
                commit(types.ROLES_ERROR, message)
                commit(types.ROLES_FETCH_ONE_PENDING, false)
                return error
            })
    },

    reset ({ commit }) {
        commit(types.ROLES_RESET)
        return null
    }
}
