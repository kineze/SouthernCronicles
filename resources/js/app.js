import './bootstrap';
import '@fortawesome/fontawesome-free/css/all.min.css';


import { createApp } from 'vue'
import DarkModeToggle from './components/DarkModeToggle.vue';


const app = createApp()

app.component('dark-mode-toggle', DarkModeToggle)


app.mount('#app')