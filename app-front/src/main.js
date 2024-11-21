import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from './router'
import vuex from './vuex'
import './axios'

createApp(App)
.use(router)
.use(vuex)
.mount('#app')
