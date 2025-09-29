import { InitApp } from '@/helpers/main'

import ServiceFormOffcanvas from './components/ServiceFormOffcanvas.vue'
import ServicePackageFormOffcanvas from './components/ServicePackageFormOffcanvas.vue'
import GalleryFormOffcanvas from './components/GalleryFormOffcanvas.vue'
import ServiceDurationOffcanvas from './components/ServiceDurationOffcanvas.vue' 
import ServiceFacilityForm from './components/ServiceFacilityForm.vue'
import ServiceTrainingOffcanvas from './components/ServiceTrainingOffcanvas.vue' 
import SystemServiceFormOffcanvas from './components/SystemServiceFormOffcanvas.vue'


const app = InitApp()

app.component('service-form-offcanvas', ServiceFormOffcanvas)
app.component('system-service-form-offcanvas', SystemServiceFormOffcanvas)
app.component('service-facility-offcanvas', ServiceFacilityForm)
app.component('service-package-form-offcanvas',ServicePackageFormOffcanvas)



// Gallery Offcanvas
app.component('gallery-form-offcanvas', GalleryFormOffcanvas)
app.component('service-duration-offcanvas',ServiceDurationOffcanvas)
app.component('service-training-offcanvas',ServiceTrainingOffcanvas)



app.mount('[data-render="app"]');
