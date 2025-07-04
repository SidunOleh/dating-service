import can from '../helpers/can'

const contentApi = {
    async fetch() {
        if (!can('content.view')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.get('/api/u0puffeto4nh7SlHzFn8/content')

        return res.data
    },
    async edit(data) {
        if (!can('content.edit')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.post('/api/u0puffeto4nh7SlHzFn8/content', data)

        return res.data
    },
}

export default contentApi