import axios from 'axios'
import store from '../store/store'

const authApi = {
    async login(credentials) {
        await axios.get('/sanctum/csrf-cookie')

        const res = await axios.post('/cLAhDKeUKrDErLAyUS21/login', credentials)

        return res.data
    },
    async logout() {
        if (!store.getters.logged) {
            throw new Error('Forbidden.')
        }

        const res = await axios.post('/cLAhDKeUKrDErLAyUS21/logout')

        return res.data
    },
    async sendResetLink(email) {
        const res = await axios.post('/api/cLAhDKeUKrDErLAyUS21/send-reset-link', { email })

        return res.data
    },
    async resetPassword(credentials) {
        const res = await axios.post('/api/cLAhDKeUKrDErLAyUS21/reset-password', credentials)

        return res.data
    },
}

export default authApi