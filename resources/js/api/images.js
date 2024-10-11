import store from '../store/store'

const imagesApi = {
    async upload(file, process, watermark, quality) {
        if (!store.getters.logged) {
            throw new Error('Forbidden.')
        }

        const data = new FormData
        data.append('img', file)
        data.append('process', process ? 1 : 0)
        data.append('watermark', watermark ? 1 : 0)
        data.append('quality', quality ?? 0)

        const res = await axios.post('/api/u0puffeto4nh7SlHzFn8/images/upload', data)

        return res.data
    },
}

export default imagesApi