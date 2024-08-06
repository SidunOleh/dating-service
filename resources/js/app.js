import './bootstrap';
import { createApp, } from 'vue'
import App from './views/App.vue'
import store from './store/store'
import router from './routes/routes'
import { QuillEditor, } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'

const globalOptions = {
    theme: 'snow',
}

QuillEditor.props.globalOptions.default = () => globalOptions

const app = createApp(App)

app.use(store)
app.use(router)
app.mount('#app')

app.component('QuillEditor', QuillEditor)