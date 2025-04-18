import can from '../helpers/can'

const postsApi = {
    async fetch(
        page = 1,
        perpage = 15,
        orderby = 'created_at',
        order = 'DESC',
        filters = {},
    ) {
        if (!can('posts.view')) {
            throw new Error('Forbidden.')
        }

        const query = new URLSearchParams({
            page,
            per_page: perpage,
            orderby,
            order,
        })

        for (const field in filters) {
            filters[field]?.forEach(val => query.append(`${field}[]`, val))
        }

        const res = await axios.get(`/api/u0puffeto4nh7SlHzFn8/posts?${query}`)

        return res.data
    },
    async show(id) {
        if (!can('posts.show')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.get(`/api/u0puffeto4nh7SlHzFn8/posts/${id}`)

        return res.data
    },
    async approve(id) {
        if (!can('posts.approve')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.post(`/api/u0puffeto4nh7SlHzFn8/posts/${id}/approve`)

        return res.data
    },
    async reject(id, data) {
        if (!can('posts.reject')) {
            throw new Error('Forbidden.')
        }

        const res = await axios.post(`/api/u0puffeto4nh7SlHzFn8/posts/${id}/reject`, data)

        return res.data
    },
}

export default postsApi