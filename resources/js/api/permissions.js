import can from '../helpers/can'

const permissionsApi = {
    async fetch(page = 1, perpage = 15) {
        if (!can('users.view')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.get(`/api/u0puffeto4nh7SlHzFn8/permissions?page=${page}&per_page=${perpage}`)

        return res.data
    },
    async delete(id) {
        if (!can('users.delete')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.delete(`/api/u0puffeto4nh7SlHzFn8/permissions/${id}`)

        return res.data
    },
    async create(data) {
        if (!can('users.create')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.post('/api/u0puffeto4nh7SlHzFn8/permissions', data)

        return res.data
    },
}

export default permissionsApi