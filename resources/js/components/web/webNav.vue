<template>
    <nav class="w-full">
        <div class="w-full max-w-screen-2xl  bg-transparent mx-auto p-3">
            <div class='w-full flex  -mb-80 justify-between'>
                <div class="w-full flex justify-between">
                   <div class="py-6 -pl-3 relative">
                     <button @click="isDrawerOpen = true" type="button" class="inline-flex absolute items-center w-10 h-10 justify-center text-sm text-white rounded-lg focus:outline-none z-[200]">
                        <span class="sr-only">Open main menu</span>
                        <svg width="32px" height="32px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H14M4 18H9" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                   </div>
                </div>
                <div class=" w-44 md:w-80 z-50 rounded-es-3xl aspect-square">
                    <a href="/">
                        <img src="../assets/img/logo.webp" class="inline-block max-w-full transition-all duration-200 ease-soft-in-out w-full h-full  dark:hidden" alt="main_logo" />
                    </a>
                </div>
            </div>
        </div>  
    </nav>

  <div v-if="isDrawerOpen" 
    @click="isDrawerOpen = false"
    class="fixed inset-0 bg-transparent z-[1001]"
  ></div>

  <div id="drawer-navigation"
    class="fixed top-0 left-0 z-[1001] h-screen p-4 overflow-y-auto transition-transform transform bg-white bg-opacity-30 backdrop-blur-xl shadow-lg w-64 dark:bg-gray-800"
    :class="isDrawerOpen ? 'translate-x-0' : '-translate-x-full'"
    tabindex="-1"
    aria-labelledby="drawer-navigation-label"
  >



    <h5 id="drawer-navigation-label" class="text-base font-semibold text-black uppercase dark:text-gray-400">ALF - 2025</h5>

    <button
      type="button"
      @click="isDrawerOpen = false"
      class="text-gray-400 bg-transparent  hover:text-gray-900 rounded-lg  bg-opacity-30 text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white"
    >

      <svg class=" rotate-180" width="32px" height="32px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M4 6H20M4 12H14M4 18H9" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      <span class="sr-only">Close menu</span>
    </button>

    <div class="py-4 overflow-y-auto">
      <ul class="space-y-2 font-medium">
        <li>
          <a href="/" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg fill="#000000" viewBox="-4.5 0 32 32" class="w-6 h-6" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>home</title> <path d="M19.469 12.594l3.625 3.313c0.438 0.406 0.313 0.719-0.281 0.719h-2.719v8.656c0 0.594-0.5 1.125-1.094 1.125h-4.719v-6.063c0-0.594-0.531-1.125-1.125-1.125h-2.969c-0.594 0-1.125 0.531-1.125 1.125v6.063h-4.719c-0.594 0-1.125-0.531-1.125-1.125v-8.656h-2.688c-0.594 0-0.719-0.313-0.281-0.719l10.594-9.625c0.438-0.406 1.188-0.406 1.656 0l2.406 2.156v-1.719c0-0.594 0.531-1.125 1.125-1.125h2.344c0.594 0 1.094 0.531 1.094 1.125v5.875z"></path> </g></svg>
            <span class="ms-3 font-semibold">Home</span>
          </a>

          <a href="/about-us" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
           <svg class="w-6 h-6" viewBox="0 0 512 512" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>about</title> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="about-white" fill="#000000" transform="translate(42.666667, 42.666667)"> <path d="M213.333333,3.55271368e-14 C95.51296,3.55271368e-14 3.55271368e-14,95.51168 3.55271368e-14,213.333333 C3.55271368e-14,331.153707 95.51296,426.666667 213.333333,426.666667 C331.154987,426.666667 426.666667,331.153707 426.666667,213.333333 C426.666667,95.51168 331.154987,3.55271368e-14 213.333333,3.55271368e-14 Z M213.333333,384 C119.227947,384 42.6666667,307.43872 42.6666667,213.333333 C42.6666667,119.227947 119.227947,42.6666667 213.333333,42.6666667 C307.44,42.6666667 384,119.227947 384,213.333333 C384,307.43872 307.44,384 213.333333,384 Z M240.04672,128 C240.04672,143.46752 228.785067,154.666667 213.55008,154.666667 C197.698773,154.666667 186.713387,143.46752 186.713387,127.704107 C186.713387,112.5536 197.99616,101.333333 213.55008,101.333333 C228.785067,101.333333 240.04672,112.5536 240.04672,128 Z M192.04672,192 L234.713387,192 L234.713387,320 L192.04672,320 L192.04672,192 Z" id="Shape"> </path> </g> </g> </g></svg>
            <span class="ms-3 font-semibold">About</span>
          </a>

          <a href="/speakers-list" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg class="w-6 h-6" fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 92.365 92.365" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M66.761,42.935v12.532h-0.086l-0.809,0.408c-0.406,0.206-6.99,3.444-18.352,3.444c-3.002,0-6.348-0.231-9.992-0.802 l-3.311-0.604c-2.453-0.5-5.018-1.14-7.711-1.981l-0.865-0.271l-0.031-0.192V42.935c0-7.158,4.9-13.18,11.52-14.929 c2.377,2.219,5.557,3.588,9.059,3.588s6.68-1.37,9.06-3.588c5.146,1.36,9.241,5.307,10.813,10.36l0.643,3.207 C66.739,42.022,66.761,42.476,66.761,42.935z M46.184,28.007c7.733,0,14.004-6.27,14.004-14.003C60.188,6.27,53.917,0,46.184,0 C38.449,0,32.18,6.27,32.18,14.004C32.18,21.737,38.448,28.007,46.184,28.007z M63.518,58.225 c-0.358,0.181-6.188,3.049-16.246,3.049c-2.658,0-5.619-0.205-8.848-0.709l-2.932-0.536c-2.172-0.443-4.441-1.009-6.826-1.753 l-0.637-0.2c-0.076,0.254-0.129,0.519-0.129,0.795l5.85,30.71c0,1.539,1.246,2.785,2.785,2.785h7.301V75.723 c0-0.949,0.77-1.717,1.719-1.717c0.949,0,1.717,0.77,1.717,1.717v16.643h7.623c1.537,0,2.785-1.246,2.785-2.785l6.631-30.71 c0-0.337-0.07-0.657-0.181-0.956L63.518,58.225z"></path> </g> </g></svg>
            <span class="ms-3 font-semibold">Speakers</span>
          </a>

          <a href="/the-writing-lab" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <i class="fa-solid fa-feather-alt text-xl"></i>
         
            <span class="ms-3 font-semibold">The Writing Lab</span>
          </a>

          <a href="/the-kipenzi" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <img :src="kipenziIcon" class="w-6 h-6" alt="The Kipenzi">
             <!-- <i class="fa-solid fa-paw text-xl"></i> -->

            <span class="ms-3 font-semibold">Kipenzi ALF Kids</span>
          </a>



          <a href="/events-schedule" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg class="w-6 h-6" viewBox="0 0 32 32" fill="#000000" xmlns="http://www.w3.org/2000/svg">
              <path d="M24,8V4h-4v4h-8V4H8v4H4v20h24V8H24z M20,24h-4v-8h-4v-4h8V24z" />
            </svg>
            
            <span class="ms-3 font-semibold">Events Schedule</span>
          </a>

          <a href="/volunteer-with-us" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <i class="fa-solid fa-hand-holding-heart text-xl"></i>
            <span class="ms-3 font-semibold">Volunteer With Us</span>
          </a>
          
          <a href="/contact-us" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M17.5228 19.8973C9.8475 18.898 4.50854 13.4553 4.03412 6.22965C3.99904 5.6953 4.42174 5.25081 4.9566 5.22451L8.80416 5.03536C9.23381 5.01424 9.62882 5.27025 9.78501 5.67106L10.4779 7.44896C10.6586 7.91277 10.4707 8.43891 10.037 8.68327L7.81212 9.93691C7.2394 10.2596 7.12852 11.0377 7.58829 11.5075L12.3511 16.3747C12.8071 16.8408 13.58 16.7527 13.9195 16.1961L15.3087 13.9185C15.5601 13.5064 16.0699 13.3327 16.5206 13.5056L18.2955 14.1864C18.7124 14.3464 18.9728 14.7635 18.9334 15.2084L18.5961 19.0137C18.5477 19.56 18.0667 19.9681 17.5228 19.8973Z" fill="#000000" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
            <span class="ms-3 font-semibold">Contact Us</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import kipenziIcon from '/public/assets/img/kipenzi-icon.webp';

const isDrawerOpen = ref(false);
</script>

<script setup>

</script>