import can from '../helpers/can'

const listTemplatesApi = {
    async fetch(page = 1, perpage = 15) {
        if (!can('templates.view')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.get(`/api/cLAhDKeUKrDErLAyUS21/templates?page=${page}&per_page=${perpage}`)

        return res.data
    },
    async show(id) {
        if (!can('templates.show')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.get(`/api/cLAhDKeUKrDErLAyUS21/templates/${id}`)

        return res.data
    },
    async delete(id) {
        if (!can('templates.delete')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.delete(`/api/cLAhDKeUKrDErLAyUS21/templates/${id}`)

        return res.data
    },
    async create(data) {
        if (!can('templates.create')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.post('/api/cLAhDKeUKrDErLAyUS21/templates', data)

        return res.data
    },
    async edit(id, data) {
        if (!can('templates.edit')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.put(`/api/cLAhDKeUKrDErLAyUS21/templates/${id}`, data)

        return res.data
    },
}

export default listTemplatesApi