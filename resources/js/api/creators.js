import can from '../helpers/can'

const creatorsApi = {
    async fetch(
        page = 1,
        perpage = 15,
        orderby = 'created_at',
        order = 'DESC',
        q = '',
    ) {
        if (!can('creators.view')) {
            throw new Error('Forbidden.')
        }

        const query = new URLSearchParams({
            page,
            per_page: perpage,
            orderby,
            order,
            q,
        })

        const res = await axios.get(`/api/u0puffeto4nh7SlHzFn8/creators?${query}`)

        return res.data
    },
    async show(id) {
        if (!can('creators.show')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.get(`/api/u0puffeto4nh7SlHzFn8/creators/${id}`)

        return res.data
    },
    async delete(id) {
        if (!can('creators.delete')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.delete(`/api/u0puffeto4nh7SlHzFn8/creators/${id}`)

        return res.data
    },
    async create(data) {
        if (!can('creators.create')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.post('/api/u0puffeto4nh7SlHzFn8/creators', data)

        return res.data
    },
    async edit(id, data) {
        if (!can('creators.edit')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.put(`/api/u0puffeto4nh7SlHzFn8/creators/${id}`, data)

        return res.data
    },
    async updateBalance(id, balance) {
        if (!can('creators.edit-balance')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.post(`/api/u0puffeto4nh7SlHzFn8/creators/${id}/balance`, { balance })

        return res.data
    },
}

export default creatorsApi