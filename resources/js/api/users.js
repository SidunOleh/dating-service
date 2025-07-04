import can from '../helpers/can'

const userApi = {
    async fetch(page = 1, perpage = 15) {
        if (!can('users.view')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.get(`/api/u0puffeto4nh7SlHzFn8/users?page=${page}&per_page=${perpage}`)

        return res.data
    },
    async delete(id) {
        if (!can('users.delete')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.delete(`/api/u0puffeto4nh7SlHzFn8/users/${id}`)

        return res.data
    },
    async create(data) {
        if (!can('users.create')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.post('/api/u0puffeto4nh7SlHzFn8/users', data)

        return res.data
    },
    async edit(id, data) {
        if (!can('users.edit')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.put(`/api/u0puffeto4nh7SlHzFn8/users/${id}`, data)

        return res.data
    },
}

export default userApi