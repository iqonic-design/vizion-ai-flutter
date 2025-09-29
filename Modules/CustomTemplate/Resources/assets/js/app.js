import { InitApp } from '@/helpers/main'
import CustomTemplateOffcanvas from './components/CustomTemplateOffcanvas.vue'


const app = InitApp()

app.component('customtemplate-offcanvas', CustomTemplateOffcanvas)

app.mount('[data-render="app"]');
