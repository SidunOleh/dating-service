import authApi from '../../api/auth'

const auth = {
    state() {
        return {
            user: JSON.parse(
                localStorage.getItem('user')
            ),
        }
    },
    getters: {
        user(state) {
            return state.user
        },
        logged(state) {
            return Boolean(state.user)
        },
    },
    mutations: {
        setUser(state, user) {
            state.user = user
            localStorage.setItem('user', JSON.stringify(user))
        },
    },
    actions: {
        async loginUser({ commit }, credentials) {
            const data = await authApi.login(credentials)

            commit('setUser', data.user)
        },
        async logoutUser({ commit }) {
            await authApi.logout()

            commit('setUser', null)
        },
    },
}

export default auth