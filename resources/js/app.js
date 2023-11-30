import './bootstrap';
import './plugins/axios'
import { createApp } from 'vue'
import Vue3Toastify from 'vue3-toastify';
import 'vue3-toastify/dist/index.css'
import router from './router';
import Home from './pages/Home.vue'

const app = createApp({})
app.component('home-component', Home)
app.use(Vue3Toastify,{ autoClose: 3000})
app.use(router)
app.mount('#app')