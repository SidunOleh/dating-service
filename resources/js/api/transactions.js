import can from '../helpers/can'

const transactionsApi = {
    async fetch(
        page = 1,
        perpage = 15,
        orderby = 'created_at',
        order = 'DESC'
    ) {
        if (!can('transactions.view')) {
            throw new Error('Forbidden.')
        }

        const query = new URLSearchParams({
            page,
            per_page: perpage,
            orderby,
            order,
        })

        const res = await axios.get(`/api/u0puffeto4nh7SlHzFn8/transactions?${query}`)

        return res.data
    },
    async delete(id) {
        if (!can('transactions.delete')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.delete(`/api/u0puffeto4nh7SlHzFn8/transactions/${id}`)

        return res.data
    },
}

export default transactionsApi