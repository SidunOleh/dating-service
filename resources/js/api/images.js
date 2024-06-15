import store from '../store/store'

const imagesApi = {
    async upload(file, thumb, watermark) {
        if (!store.getters.logged) {
            throw new Error('Forbidden.')
        }

        const data = new FormData
        data.append('img', file)
        data.append('thumb', thumb ? 1 : 0)
        data.append('watermark', watermark ? 1 : 0)

        const res = await axios.post('/api/images/upload', data)

        return res.data
    },
}

export default imagesApi