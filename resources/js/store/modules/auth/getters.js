import { strLimit } from "@/utilities/helpers"

export default {
    authPending (state) {
        return state.authPending
    },

    isAdmin (state) {
        var user = state.user
        if (user) {
            var roles = user.roles
            if (roles) {
                return roles.map(item => item["slug"]).includes("admin")
            }
        }

        return false
    },

    isAuthenticated (state) {
        return !!state.token
    },

    permissions (state) {
        return state.permissions
    },

    role (state) {
        return state.role
    },

    username (state) {
        return state.user && undefined !== state.user.email ? strLimit(state.user.email) : "..."
    }
}
