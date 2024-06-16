import can from '../helpers/can'

const settingsApi = {
    async fetch() {
        if (!can('settings.view')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.get('/api/settings')

        return res.data
    },
    async edit(data) {
        if (!can('settings.edit')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.post('/api/settings', data)

        return res.data
    },
}

export default settingsApi