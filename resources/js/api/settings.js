import can from '../helpers/can'

const settingsApi = {
    async fetch() {
        if (!can('settings.view')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.get('/api/u0puffeto4nh7SlHzFn8/settings')

        return res.data
    },
    async edit(data) {
        if (!can('settings.edit')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.post('/api/u0puffeto4nh7SlHzFn8/settings', data)

        return res.data
    },
}

export default settingsApi