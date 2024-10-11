import can from '../helpers/can'

const listTemplatesApi = {
    async fetch(page = 1, perpage = 15) {
        if (!can('templates.view')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.get(`/api/u0puffeto4nh7SlHzFn8/templates?page=${page}&per_page=${perpage}`)

        return res.data
    },
    async show(id) {
        if (!can('templates.show')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.get(`/api/u0puffeto4nh7SlHzFn8/templates/${id}`)

        return res.data
    },
    async delete(id) {
        if (!can('templates.delete')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.delete(`/api/u0puffeto4nh7SlHzFn8/templates/${id}`)

        return res.data
    },
    async create(data) {
        if (!can('templates.create')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.post('/api/u0puffeto4nh7SlHzFn8/templates', data)

        return res.data
    },
    async edit(id, data) {
        if (!can('templates.edit')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.put(`/api/u0puffeto4nh7SlHzFn8/templates/${id}`, data)

        return res.data
    },
}

export default listTemplatesApi