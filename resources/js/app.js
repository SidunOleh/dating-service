import './bootstrap';
import { createApp, } from 'vue'
import App from './views/App.vue'
import store from './store/store'
import router from './routes/routes'
import VueGoogleMaps from '@fawmi/vue-google-maps'

const app = createApp(App)
app.use(store)
app.use(router)
app.use(VueGoogleMaps, { load: { key: google_maps_key, libraries: 'places', }, })
app.mount('#app')