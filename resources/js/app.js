import './bootstrap';
import './plugins/axios'
import { createApp } from 'vue'
import router from './router';
import Home from './pages/Home.vue'

const app = createApp({})
app.component('home-component', Home)
app.use(router)
app.mount('#app')