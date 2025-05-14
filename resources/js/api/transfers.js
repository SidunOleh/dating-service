import can from '../helpers/can'

const transfersApi = {
    async fetch(
        page = 1,
        perpage = 15,
        orderby = 'created_at',
        order = 'DESC',
    ) {
        if (!can('transfes.view')) {
            throw new Error('Forbidden.')
        }

        const query = new URLSearchParams({
            page,
            per_page: perpage,
            orderby,
            order,
        })

        const res = await axios.get(`/api/u0puffeto4nh7SlHzFn8/transfers?${query}`)

        return res.data
    },
    async transfer(creatorId) {
        if (!can('transfers.transfer')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.post(`/api/u0puffeto4nh7SlHzFn8/transfers/${creatorId}/transfer`)

        return res.data
    },
    async reset(creatorId) {
        if (!can('transfers.reset')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.post(`/api/u0puffeto4nh7SlHzFn8/transfers/${creatorId}/reset`)

        return res.data
    },
}

export default transfersApi