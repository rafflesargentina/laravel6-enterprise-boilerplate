import * as types from "../../mutation-types"
import { initialState } from "./roles"

export default {
    [types.ROLES_DELETE_ONE] () {},

    [types.ROLES_ERROR] (state, payload) {
        state.error = JSON.stringify(payload)
    },

    [types.ROLES_FETCH_ALL] (state, payload) {
        state.all = payload
    },

    [types.ROLES_FETCH_ALL_PENDING] (state, payload) {
        state.allPending = payload
    },

    [types.ROLES_FETCH_ONE] (state, payload) {
        state.one = payload
    },

    [types.ROLES_FETCH_ONE_PENDING] (state, payload) {
        state.onePending = payload
    },

    [types.ROLES_RESET] (state) {
        Object.assign(state, { initialState: initialState(), ...initialState() })
    },
}
