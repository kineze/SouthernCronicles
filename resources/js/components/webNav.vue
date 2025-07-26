<template>
    <nav class="w-full">
        <div class="w-full max-w-screen-2xl  bg-transparent mx-auto p-3">
            <div class='w-full flex  -mb-96 justify-between'>
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
                <div class=" w-44 md:w-96 rounded-es-3xl aspect-square">
                    <div>
                        <img src="../../../public/assets/img/logo.webp" class="inline-block max-w-full transition-all duration-200 ease-soft-in-out w-full h-full  dark:hidden" alt="main_logo" />
                    </div>
                </div>
            </div>
        </div>  
    </nav>
  <!-- Drawer -->

  <div 
  v-if="isDrawerOpen" 
  @click="isDrawerOpen = false"
  class="fixed inset-0 bg-black/10 z-[1001]"
></div>

  <div id="drawer-navigation"
    class="fixed top-0 left-0 z-[1001] h-screen p-4 overflow-y-auto transition-transform transform bg-white/30 backdrop-blur-lg shadow-2xl w-64 dark:bg-gray-800"
    :class="isDrawerOpen ? 'translate-x-0' : '-translate-x-full'"
    tabindex="-1"
    aria-labelledby="drawer-navigation-label"
  >



    <h5 id="drawer-navigation-label" class="text-base font-semibold text-black uppercase dark:text-gray-400">ALF - 2025</h5>

    <button
      type="button"
      @click="isDrawerOpen = false"
      class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white"
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

const isDrawerOpen = ref(false);
</script>