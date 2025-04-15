import can from '../helpers/can'

const transferRequestsApi = {
    async fetch(
        page = 1, 
        perpage = 15,
        orderby = 'created_at',
        order = 'DESC',
    ) {
        if (!can('transfer-requests.view')) {
            throw new Error('Forbidden.')
        }

        const query = new URLSearchParams({
            page,
            per_page: perpage,
            orderby,
            order,
        })

        const res = await axios.get(`/api/u0puffeto4nh7SlHzFn8/transfer-requests?${query}`)

        return res.data
    },
    async approve(id) {
        if (!can('transfer-requests.create')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.post(`/api/u0puffeto4nh7SlHzFn8/transfer-requests/${id}/approve`)

        return res.data
    },
    async reject(id) {
        if (!can('transfer-requests.create')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.post(`/api/u0puffeto4nh7SlHzFn8/transfer-requests/${id}/reject`)

        return res.data
    },
}

export default transferRequestsApi