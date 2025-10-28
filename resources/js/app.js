import './bootstrap'
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import router from './router'
import App from './App.vue'
import { useAuthStore } from './stores/auth'

// Import CSS
import '../css/app.css'
import 'aos/dist/aos.css'

// Import AOS
import AOS from 'aos'

// Create Pinia store
const pinia = createPinia()

// Create Vue app
const app = createApp(App)

// Use plugins
app.use(pinia)
app.use(router)

// Initialize AOS
AOS.init({
  duration: 800,
  easing: 'ease-in-out',
  once: true,
  offset: 100,
})

// Initialize auth store
const authStore = useAuthStore()
authStore.initAuth()

// Mount app
app.mount('#app')
