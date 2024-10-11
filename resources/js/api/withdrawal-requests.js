import can from '../helpers/can'

const withdrawalRequestsApi = {
    async fetch(
        page = 1,
        perpage = 15,
        orderby = 'created_at',
        order = 'DESC',
    ) {
        if (!can('withdrawal-requests.view')) {
            throw new Error('Forbidden.')
        }

        const query = new URLSearchParams({
            page,
            per_page: perpage,
            orderby,
            order,
        })

        const res = await axios.get(`/api/u0puffeto4nh7SlHzFn8/withdrawal-requests?${query}`)

        return res.data
    },
    async amount(id) {
        if (!can('withdrawal-requests.withdraw')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.get(`/api/u0puffeto4nh7SlHzFn8/withdrawal-requests/${id}/amount`)

        return res.data
    },
    async withdraw(id) {
        if (!can('withdrawal-requests.withdraw')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.post(`/api/u0puffeto4nh7SlHzFn8/withdrawal-requests/${id}/withdraw`)

        return res.data
    },
    async reject(id) {
        if (!can('withdrawal-requests.withdraw')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.post(`/api/u0puffeto4nh7SlHzFn8/withdrawal-requests/${id}/reject`)

        return res.data
    },
    async delete(id) {
        if (!can('withdrawal-requests.delete')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.delete(`/api/u0puffeto4nh7SlHzFn8/withdrawal-requests/${id}`)

        return res.data
    },
}

export default withdrawalRequestsApi