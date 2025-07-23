import './bootstrap';
import '@fortawesome/fontawesome-free/css/all.min.css';
import 'vue-toastification/dist/index.css';
import Toast from 'vue-toastification';
import { POSITION } from 'vue-toastification';



import { createApp } from 'vue'
import DarkModeToggle from './components/DarkModeToggle.vue';

import Festivals from './components/Festivals.vue';



const app = createApp({});

app
  .use(Toast, {
    position: POSITION.TOP_RIGHT,
    timeout: 3000,
    closeOnClick: true,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: false,
    hideProgressBar: false,
    closeButton: "button",
    icon: true,
    rtl: false
  })

    .component('dark-mode-toggle', DarkModeToggle)

    .component('festivals', Festivals)



    .mount('#app')