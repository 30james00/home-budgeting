import {InjectionKey} from 'vue'
import {createStore, useStore as baseUseStore, Store} from 'vuex'
import {IUser} from "./interfaces/IUser";
import {getUser} from "./services/UserService";

export interface State {
    user: IUser | null,
}

export const key: InjectionKey<Store<State>> = Symbol()

export const store = createStore<State>({
    state: {
        user: null
    },
    mutations: {
        setUser(state, {user}) {
            state.user = user
        },
        deleteUser(state) {
            state.user = null
        },
    },
    actions: {
        async getCurrentUser({commit}, {iri}) {
            const user = await getUser(iri)
            commit('setUser', {user})
        }
    },
})

// define your own `useStore` composition function
export function useStore(): Store<State> {
    return baseUseStore(key)
}