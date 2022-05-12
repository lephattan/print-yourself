import {createApp} from 'vue'
import {createPinia} from 'pinia'
import FormEditor from '@/admin/FormEditor.vue'
import '@/preflight.css'
import '@/admin/editor.css'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

const app = createApp(FormEditor)
const pinia = createPinia()
app.use(pinia)
app.component('font-awesome-icon', FontAwesomeIcon)
app.mount('#pry-editor')
