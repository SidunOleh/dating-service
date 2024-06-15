import can from '../helpers/can'

const adsApi = {
    async fetch(page = 1, perpage = 15) {
        if (!can('ads.view')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.get(`/api/ads?page=${page}&per_page=${perpage}`)

        return res.data
    },
    async delete(id) {
        if (!can('ads.delete')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.delete(`/api/ads/${id}`)

        return res.data
    },
    async create(data) {
        if (!can('ads.create')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.post('/api/ads', data)

        return res.data
    },
    async edit(id, data) {
        if (!can('ads.edit')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.put(`/api/ads/${id}`, data)

        return res.data
    },
    async editStatus(id, status) {
        if (!can('ads.edit')) {
            throw new Error('Forbidden.')
        }

        let data = { status }
        data._method = 'PATCH'

        const res = await axios.post(`/api/ads/${id}/status`, data)

        return res.data
    },
    async fetchOptions() {
        if (!can('ads.view')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.get('/api/ads/options')

        return res.data
    },
    async editOptions(data) {
        if (!can('ads.edit')) {
            throw new Error('Forbidden.')
        }

        data._method = 'PUT'

        const res = await axios.post('/api/ads/options', data)

        return res.data
    },
}

export default adsApi