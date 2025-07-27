import './bootstrap';
import '@fortawesome/fontawesome-free/css/all.min.css';
import 'vue-toastification/dist/index.css';
import 'tom-select/dist/css/tom-select.css';


import Toast from 'vue-toastification';
import { POSITION } from 'vue-toastification';



import { createApp } from 'vue'
// for admin view 

import DarkModeToggle from './components/DarkModeToggle.vue';
import Festivals from './components/Festivals.vue';
import SpeakerTypes from './components/SpeakerTypes.vue';
import Speakers from './components/Speakers.vue';
import Partners from './components/Partners.vue';
import RegisteredList from './components/RegisteredList.vue';
import ManageEvents from './components/ManageEvents.vue';
import ManageTeams from './components/ManageTeams.vue';

// for web view 
import WebNav from './components/webNav.vue';
import SpeakersCarousel from './components/SpeakersCarousel.vue';
import SpeakersList from './components/Speakers List.vue';
import OurPartners from './components/OurPartners.vue';
import UsefullLinks from './components/UsefullLinks.vue';
import ContactUs from './components/ContactUs.vue';
import RegisterNowModal from './components/RegisterNowModal.vue';
import OurEcosystem from './components/OurEcosystem.vue';
import EventSchedule from './components/EventSchedule.vue';
import NextCountDown from './components/NextCountDown.vue';
import TeamsCarousel from './components/TeamsCarousel.vue';
import ReadMoreText from './components/ReadMoreText.vue';


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

    //for admin view
    .component('dark-mode-toggle', DarkModeToggle)
    .component('festivals', Festivals)
    .component('speaker-types',SpeakerTypes)
    .component('speakers',Speakers)
    .component('partners',Partners)
    .component('registered-list',RegisteredList)
    .component('manage-events', ManageEvents)
    .component('manage-teams', ManageTeams)

    // for web view
    .component('web-nav',WebNav)
    .component('speakers-carousel',SpeakersCarousel)
    .component('speakers-list', SpeakersList)
    .component('our-partners',OurPartners)
    .component('usefull-links', UsefullLinks)
    .component('contact-us',ContactUs)
    .component('register-now-modal', RegisterNowModal)
    .component('our-ecosystem', OurEcosystem)
    .component('event-schedule',EventSchedule)
    .component('next-count-down',NextCountDown)
    .component('teams-carousel',TeamsCarousel)
    .component('read-more-text',ReadMoreText)


    .mount('#app')