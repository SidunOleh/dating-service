import can from '../helpers/can'

const adsApi = {
    async fetch(page = 1, perpage = 15, type) {
        if (!can('ads.view')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.get(`/api/u0puffeto4nh7SlHzFn8/ads?page=${page}&per_page=${perpage}&type=${type}`)

        return res.data
    },
    async delete(id) {
        if (!can('ads.delete')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.delete(`/api/u0puffeto4nh7SlHzFn8/ads/${id}`)

        return res.data
    },
    async create(data) {
        if (!can('ads.create')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.post('/api/u0puffeto4nh7SlHzFn8/ads', data)

        return res.data
    },
    async edit(id, data) {
        if (!can('ads.edit')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.put(`/api/u0puffeto4nh7SlHzFn8/ads/${id}`, data)

        return res.data
    },
}

export default adsApi