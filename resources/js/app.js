import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import { createPinia } from 'pinia'
import loader from './plugins/loader'
import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'



// =====================
// jQuery (REQUERIDO por Bootstrap 4)
// =====================
import $ from 'jquery'
window.$ = window.jQuery = $

// =====================
// Popper
// =====================
import { createPopper } from '@popperjs/core'
window.Popper = { createPopper }

// =====================
// Bootstrap (CSS PRIMERO)
// =====================
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap'

// =====================
// Toastr (DESPUÉS de Bootstrap)
// =====================
import 'toastr/build/toastr.min.css'
import toastr from 'toastr'

// =====================
// Axios (Laravel)
// =====================
import './bootstrap'

// =====================
// Crear app
// =====================
const app = createApp(App)

// =====================
// Configuración global Toastr
// =====================
toastr.options = {
  closeButton: true,
  progressBar: true,
  positionClass: 'toast-top-right',
  timeOut: 3000,
  extendedTimeOut: 1000,
  preventDuplicates: true,
  newestOnTop: true
}

app.config.globalProperties.$toastr = toastr

// =====================
// Plugins
// =====================
app.use(router)
app.use(createPinia())
app.use(loader)

// =====================
// Mount
// =====================
app.mount('#app')
