import './bootstrap';
import '@fortawesome/fontawesome-free/css/all.min.css';
import 'vue-toastification/dist/index.css';
import 'tom-select/dist/css/tom-select.css';



import Toast from 'vue-toastification';
import { POSITION } from 'vue-toastification';



import { createApp } from 'vue'
// for admin view 

import DarkModeToggle from './components/admin/DarkModeToggle.vue';
import Festivals from './components/admin/Festivals.vue';
import SpeakerTypes from './components/admin/SpeakerTypes.vue';
import Speakers from './components/admin/Speakers.vue';
import Partners from './components/admin/Partners.vue';
import RegisteredList from './components/admin/RegisteredList.vue';
import ManageEvents from './components/admin/ManageEvents.vue';
import ManageTeams from './components/admin/ManageTeams.vue';
import ManageTimeSlots from './components/admin/ManageTimeSlots.vue';
import ManageBookings from './components/admin/ManageBookings.vue';
import MemorySubmission from './components/admin/MemorySubmission.vue';
import ManageUsefullLinks from './components/admin/ManageUsefullLinks.vue';
import VolunteersList from './components/admin/VolunteersList.vue';
import ManageNews from './components/admin/ManageNews.vue';
import PartnerTypes from './components/admin/PartnerTypes.vue';
import TeamTypes from './components/admin/TeamTypes.vue';

// for web view 
import WebNav from './components/web/webNav.vue';
import SpeakersCarousel from './components/web/SpeakersCarousel.vue';
import SpeakersList from './components/web/Speakers List.vue';
import OurPartners from './components/web/OurPartners.vue';
import UsefullLinks from './components/web/UsefullLinks.vue';
import ContactUs from './components/web/ContactUs.vue';
import RegisterNowModal from './components/web/RegisterNowModal.vue';
import OurEcosystem from './components/web/OurEcosystem.vue';
import EventSchedule from './components/web/EventSchedule.vue';
import NextCountDown from './components/web/NextCountDown.vue';
import TeamsCarousel from './components/web/TeamsCarousel.vue';
import PrivacyPolicy from './components/web/PrivacyPolicy.vue';
import ReadMoreText from './components/web/ReadMoreText.vue';
import TermsConditions from './components/web/TermsConditions.vue';
import BookingNow from './components/web/BookingNow.vue';
import LivingMemoryVault from './components/web/LivingMemoryVault.vue';
import TheKipenzi from './components/web/TheKipenzi.vue';
import Volunteers from './components/web/Volunteers.vue';
import VolunteerWithUs from './components/web/VolunteerWithUs.vue';
import UpComingFestivals from './components/web/UpComingFestivals.vue';
import FestivalLocations from './components/web/FestivalLocations.vue';
import TeamList from './components/web/TeamList.vue';
import LatestNews from './components/web/LatestNews.vue';

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
    .component('manage-time-slots', ManageTimeSlots)
    .component('manage-bookings', ManageBookings)
    .component('memory-submission', MemorySubmission)
    .component('manage-usefull-links', ManageUsefullLinks)
    .component('volunteers-list', VolunteersList)
    .component('volunteers', Volunteers)
    .component('manage-news', ManageNews)
    .component('partner-types', PartnerTypes)
    .component('team-types', TeamTypes)


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
    .component('privacy-policy',PrivacyPolicy)
    .component('read-more-text',ReadMoreText)
    .component('terms-conditions',TermsConditions)
    .component('booking-now',BookingNow)
    .component('living-memory-vault', LivingMemoryVault)
    .component('the-kipenzi', TheKipenzi)
    .component('volunteer-with-us', VolunteerWithUs)
    .component('up-coming-festivals', UpComingFestivals)
    .component('festival-locations', FestivalLocations)
    .component('team-list', TeamList)
    .component('latest-news', LatestNews)



    .mount('#app')