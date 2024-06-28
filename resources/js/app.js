import './bootstrap';
import { createApp, } from 'vue'
import App from './views/App.vue'
import store from './store/store'
import router from './routes/routes'

const app = createApp(App)
app.use(store)
app.use(router)
app.mount('#app')