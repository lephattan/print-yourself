import {createApp} from 'vue'
import FormEditor from '@/admin/FormEditor.vue'
import '@/admin/editor.css'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

const app = createApp(FormEditor)
app.component('font-awesome-icon', FontAwesomeIcon)
app.mount('#pry-editor')
