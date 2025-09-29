import { InitApp } from '../helpers/main'

import UserFormOffcanvas from './components/user/Offcanvas/UserFormOffcanvas.vue'
import ModuleOffcanvas from './components/module/ModuleOffcanvas.vue'
import VueTelInput from 'vue3-tel-input'
import 'vue3-tel-input/dist/vue3-tel-input.css'

const app = InitApp()

app.use(VueTelInput)
app.component('customer-form-offcanvas',UserFormOffcanvas)
app.component('module-form-offcanvas', ModuleOffcanvas)


app.mount('[data-render="app"]');
