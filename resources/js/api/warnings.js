import can from '../helpers/can'

const warningsApi = {
    async fetch(page = 1, perpage = 15) {
        if (!can('warnings.view')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.get(`/api/cLAhDKeUKrDErLAyUS21/warnings?page=${page}&per_page=${perpage}`)

        return res.data
    },
    async delete(id) {
        if (!can('warnings.delete')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.delete(`/api/cLAhDKeUKrDErLAyUS21/warnings/${id}`)

        return res.data
    },
    async create(data) {
        if (!can('warnings.create')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.post('/api/cLAhDKeUKrDErLAyUS21/warnings', data)

        return res.data
    },
    async edit(id, data) {
        if (!can('warnings.edit')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.put(`/api/cLAhDKeUKrDErLAyUS21/warnings/${id}`, data)

        return res.data
    },
    async showSettings() {
        if (!can('warnings.settings')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.get(`/api/cLAhDKeUKrDErLAyUS21/warnings/settings`)

        return res.data
    },
    async editSettings(settings) {
        if (!can('warnings.settings')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.post(`/api/cLAhDKeUKrDErLAyUS21/warnings/settings`, settings)

        return res.data
    },
}

export default warningsApi