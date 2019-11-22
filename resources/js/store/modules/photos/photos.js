import actions from "./actions"
import getters from "./getters"
import mutations from "./mutations"

export function initialState()
{
    return {
        all: [],
        allPending: false,
        featured: [],
        nonFeatured: [],
        one: {
            description: "",
            featured: 0,
            landscape: 0,
            location: "",
            name: "",
            photoable_id: "",
            photoable_type: "",
            portrait: 0,
            slug: "",
            user_id: "",
        },
        onePending: false,
    }
}

const state = {
    initialState: initialState(),
    ...initialState()
}

export default {
    actions,
    getters,
    mutations,
    state
}
