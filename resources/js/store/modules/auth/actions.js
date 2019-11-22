import { deleteSavedState } from "@/utilities/helpers"
import * as types from "../../mutation-types"
import axios from "axios"

export default {
    init({ commit, dispatch, state }) {
        commit(types.AUTH_PENDING, true)
        commit(types.AUTH_TOKEN, state.token)
        return dispatch("validate")
    },

    login ({ commit, dispatch, getters }, response) {
        if (getters.isAuthenticated) return dispatch("validate")

        const token = response.data.token
        commit(types.AUTH_TOKEN, token)

        const user = response.data.user
        commit(types.AUTH_USER, user)

        commit(types.AUTH_PENDING, false)

        return response
    },

    logout ({ commit, dispatch }) {
        var redirect
        axios.post("/logout")
            .then(response => {
                redirect = response.data.redirect || "/"
                return window.location.href = redirect
            })
            .catch(error => {
                var message = error.data.message||error.message
                commit(types.AUTH_ERROR, message)
                return error
            })

        unsetDefaultAuthHeaders()
        deleteSavedState("auth.token")
        deleteSavedState("auth.user")

        commit(types.AUTH_PENDING, false)

        return dispatch("reset")
    },

    reset ({ commit }) {
        commit(types.AUTH_RESET)
        return null
    },

    validate ({ commit, dispatch, state }) {
        if (!state.user) return null

        return axios.get("/api/validate")
            .then(response => {
                const user = response.data.data.user
                commit(types.AUTH_USER, user)
                commit(types.AUTH_PENDING, false)
                return user
            })
            .catch(error => {
                dispatch("logout")

                var message = error.data.message||error.message
                commit(types.AUTH_ERROR, message)
                commit(types.AUTH_PENDING, false)
                return error
            })
    },
}

// Helpers

export function setDefaultAuthHeaders(token) {
    axios.defaults.headers.common["Authorization"] = "Bearer " + token
}

export function unsetDefaultAuthHeaders() {
    delete axios.defaults.headers.common["Authorization"]
}
