import can from '../helpers/can'

const profilRequestsApi = {
    async fetch(
        approved,
        page = 1,
        perpage = 15,
        orderby = 'created_at',
        order = 'DESC',
    ) {
        if (!can(['approved-creators.profile-requests.view', 'not-approved-creators.profile-requests.view', ])) {
            throw new Error('Forbidden.')
        }

        const query = new URLSearchParams({
            approved: approved ? 1 : 0,
            page,
            per_page: perpage,
            orderby,
            order,
        })

        const res = await axios.get(`/cLAhDKeUKrDErLAyUS21/profile-requests?${query}`)

        return res.data
    },
    async show(id) {
        if (!can(['approved-creators.profile-requests.show', 'not-approved-creators.profile-requests.show', ])) {
            throw new Error('Forbidden.')
        }

        const res = await axios.get(`/cLAhDKeUKrDErLAyUS21/profile-requests/${id}`)

        return res.data
    },
    async done(id, data) {
        if (!can(['approved-creators.profile-requests.done', 'not-approved-creators.profile-requests.done', ])) {
            throw new Error('Forbidden.')
        }

        const res = await axios.put(`/cLAhDKeUKrDErLAyUS21/profile-requests/${id}`, data)

        return res.data
    },
}

export default profilRequestsApi