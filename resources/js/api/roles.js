import can from '../helpers/can'

const rolesApi = {
    async fetch(page = 1, perpage = 15) {
        if (!can('users.view')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.get(`/api/cLAhDKeUKrDErLAyUS21/roles?page=${page}&per_page=${perpage}`)

        return res.data
    },
    async delete(id) {
        if (!can('users.delete')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.delete(`/api/cLAhDKeUKrDErLAyUS21/roles/${id}`)

        return res.data
    },
    async create(data) {
        if (!can('users.create')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.post('/api/cLAhDKeUKrDErLAyUS21/roles', data)

        return res.data
    },
    async edit(id, data) {
        if (!can('users.edit')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.put(`/api/cLAhDKeUKrDErLAyUS21/roles/${id}`, data)

        return res.data
    },
}

export default rolesApi