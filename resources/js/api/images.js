import store from '../store/store'

const imagesApi = {
    async upload(file, watermark, compress) {
        if (!store.getters.logged) {
            throw new Error('Forbidden.')
        }

        const data = new FormData
        data.append('img', file)
        data.append('watermark', watermark ? 1 : 0)
        data.append('compress', compress ?? '')

        const res = await axios.post('/api/images/upload', data)

        return res.data
    },
    async delete(id) {
        if (!store.getters.logged) {
            throw new Error('Forbidden.')
        }

        const res = await axios.delete(`/api/images/${id}`)

        return res.data
    },
}

export default imagesApi