<template>
    <nav class="w-full">
        <div class="w-full max-w-screen-2xl  bg-transparent mx-auto p-3">
            <div class='w-full flex  -mb-96 justify-between'>
                <div class="w-full flex justify-between">
                   <div class="p-6 relative">
                     <button @click="isDrawerOpen = true" type="button" class="inline-flex absolute items-center w-10 h-10 justify-center text-sm text-white rounded-lg focus:outline-none z-[200]">
                        <span class="sr-only">Open main menu</span>
                        <svg width="32px" height="32px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H14M4 18H9" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                   </div> 
                </div>
                <div class="w-96 rounded-es-3xl aspect-square">
                    <div>
                        <img src="../../../public/assets/img/logo.webp" class="inline-block max-w-full transition-all duration-200 ease-soft-in-out w-full h-full  dark:hidden" alt="main_logo" />
                    </div>
                </div>
            </div>
        </div>  
    </nav>
  <!-- Drawer -->
  <div
    id="drawer-navigation"
    class="fixed top-0 left-0 z-[1001] h-screen p-4 overflow-y-auto transition-transform transform bg-white/30 backdrop-blur-xl shadow-2xl w-64 dark:bg-gray-800"
    :class="isDrawerOpen ? 'translate-x-0' : '-translate-x-full'"
    tabindex="-1"
    aria-labelledby="drawer-navigation-label"
  >
    <h5 id="drawer-navigation-label" class="text-base font-semibold text-gray-500 uppercase dark:text-gray-400">Menu</h5>

    <button
      type="button"
      @click="isDrawerOpen = false"
      class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white"
    >
      <!-- <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
      </svg> -->
      <svg class="w-6 h-6" fill="#000000" width="32px" height="32px" viewBox="-5.5 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>alignright</title> <path d="M19.938 9.75h-10.406c-0.469 0-0.844-0.438-0.844-0.875v-1.313c0-0.438 0.375-0.844 0.844-0.844h10.406c0.469 0 0.875 0.406 0.875 0.844v1.313c0 0.469-0.406 0.875-0.875 0.875zM19.938 14.813h-17.344c-0.469 0-0.875-0.375-0.875-0.875v-1.281c0-0.5 0.406-0.844 0.875-0.844h17.344c0.469 0 0.875 0.344 0.875 0.844v1.281c0 0.5-0.406 0.875-0.875 0.875zM19.938 19.906h-12.125c-0.469 0-0.875-0.406-0.875-0.875v-1.313c0-0.469 0.406-0.875 0.875-0.875h12.125c0.469 0 0.875 0.406 0.875 0.875v1.313c0 0.469-0.406 0.875-0.875 0.875zM0.906 22.219h19.031c0.469 0 0.875 0.438 0.875 0.875v1.281c0 0.5-0.406 0.906-0.875 0.906h-19.031c-0.5 0-0.906-0.406-0.906-0.906v-1.281c0-0.469 0.406-0.875 0.906-0.875z"></path> </g></svg>
      <span class="sr-only">Close menu</span>
    </button>

    <div class="py-4 overflow-y-auto">
      <ul class="space-y-2 font-medium">
        <li>
          <a href="/" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg fill="#000000" viewBox="-4.5 0 32 32" class="w-6 h-6" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>home</title> <path d="M19.469 12.594l3.625 3.313c0.438 0.406 0.313 0.719-0.281 0.719h-2.719v8.656c0 0.594-0.5 1.125-1.094 1.125h-4.719v-6.063c0-0.594-0.531-1.125-1.125-1.125h-2.969c-0.594 0-1.125 0.531-1.125 1.125v6.063h-4.719c-0.594 0-1.125-0.531-1.125-1.125v-8.656h-2.688c-0.594 0-0.719-0.313-0.281-0.719l10.594-9.625c0.438-0.406 1.188-0.406 1.656 0l2.406 2.156v-1.719c0-0.594 0.531-1.125 1.125-1.125h2.344c0.594 0 1.094 0.531 1.094 1.125v5.875z"></path> </g></svg>
            <span class="ms-3 font-semibold">Home</span>
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