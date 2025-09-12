import './bootstrap';
import '@fortawesome/fontawesome-free/css/all.min.css';
import 'vue-toastification/dist/index.css';
import 'tom-select/dist/css/tom-select.css';

import VueTelInput from 'vue3-tel-input';
import 'vue3-tel-input/dist/vue3-tel-input.css';

import Toast from 'vue-toastification';
import { POSITION } from 'vue-toastification';

import { createApp } from 'vue'

// admin components
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
import ManageCareers from './components/admin/ManageCareers.vue';
import CareerApplications from './components/admin/CareerApplications.vue';
import InternshipApplications from './components/admin/InternshipApplications.vue';
import VolunteerApplications from './components/admin/VolunteerApplications.vue';
import ManagePartnerInquiries from './components/admin/ManagePartnerInquiries.vue';
import AdvisorTypes from './components/admin/AdvisorTypes.vue';
import ManageAdvisors from './components/admin/ManageAdvisors.vue';
import GalaxyApplications from './components/admin/GalaxyApplications.vue';
// web components
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
import NewsList from './components/web/NewsList.vue';
import ViewNews from './components/web/ViewNews.vue';
import HexHoney from './components/web/HexHoney.vue';
import VisionMission from './components/web/VisionMission.vue';
import Careers from './components/web/Careers.vue';
import CareerView from './components/web/CareerView.vue';
import PartnerWithUs from './components/web/PartnerWithUs.vue';
import AdvisorCarousel from './components/web/AdvisorCarousel.vue';
import AdvisorsList from './components/web/AdvisorsList.vue';
import SpeakerListHex from './components/web/SpeakerListHex.vue';
import AsianGroupOfLiterature from './components/web/AsianGroupOfLiterature.vue';
import ThePurpleUmbrella from './components/web/ThePurpleUmbrella.vue';
import GalaxyApply from './components/web/GalaxyApply.vue';
import NextCountdownDesktop from './components/web/NextCountdownDesktop.vue';

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

  
  .use(VueTelInput, {
    mode: 'international',
    inputOptions: { showDialCode: true, placeholder: 'Your phone number' },
    dropdownOptions: {
      showFlags: true,
      showDialCodeInList: true,
      showSearchBox: true,
    },
  })
  // admin
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
  .component('manage-careers', ManageCareers)
  .component('career-applications', CareerApplications)
  .component('internship-applications', InternshipApplications)
  .component('volunteer-applications',VolunteerApplications)
  .component('manage-partner-inquiries', ManagePartnerInquiries)
  .component('advisor-types', AdvisorTypes)
  .component('manage-advisors', ManageAdvisors)
  .component('galaxy-applications', GalaxyApplications)
  // web
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
  .component('news-list', NewsList)
  .component('view-news', ViewNews)
  .component('hex-honey', HexHoney)
  .component('vision-mission', VisionMission)
  .component('careers', Careers)
  .component('career-view', CareerView)
  .component('partner-with-us',PartnerWithUs)
  .component('advisor-carousel', AdvisorCarousel)
  .component('advisors-list', AdvisorsList)

  .component('speaker-list-hex', SpeakerListHex)
  .component('asian-group-of-literature', AsianGroupOfLiterature)
  .component('the-purple-umbrella', ThePurpleUmbrella)
  .component('galaxy-apply', GalaxyApply)
  .component('next-countdown-desktop', NextCountdownDesktop)
.mount('#app')
