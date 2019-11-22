import { getSavedState } from "@/utilities/helpers"
import actions from "./actions"
import getters from "./getters"
import mutations from "./mutations"

export function initialState() {
    return {
        authPending: false,
        permissions: getSavedState("auth.permissions"),
        role: getSavedState("auth.role"),
        token: getSavedState("auth.token"),
        user: getSavedState("auth.user")
    }
}

const state = {
    initialState: initialState(),
    ...initialState(),
}

export default {
    actions,
    getters,
    mutations,
    state
}
