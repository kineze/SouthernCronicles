<template>
  <nav class="w-full">
    <div class="w-full max-w-screen-2xl bg-transparent mx-auto p-3">
      <div class="w-full flex -mb-80 justify-between">
        <div class="w-full flex justify-between">
          <div class="py-6 -pl-3 relative">
            <button
              @click="isDrawerOpen = true"
              type="button"
              class="inline-flex absolute items-center w-10 h-10 justify-center text-sm text-white rounded-lg focus:outline-none z-[200]"
            >
              <span class="sr-only">Open main menu</span>
              <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                <path d="M4 6H20M4 12H14M4 18H9" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
        </div>

        <div class=" w-4/12 flex  justify-end items-start z-50 rounded-es-3xl aspect-square">
          <div>
          <a href="/">
            <img
              :src="trogonUrl"
              class="inline-block max-w-full transition-all lg:w-36 lg:h-36 h-24 w-24 p-4 duration-200 ease-soft-in-out"
              alt="main_logo"
            />
          </a>
           <a href="/">
            <img
              :src="logoUrl"
              class="inline-block max-w-full transition-all  lg:w-44 lg:h-44 w-24 h-24 aspect-square duration-200 ease-soft-in-out "
              alt="main_logo"
            />  
          </a>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <div
    v-if="isDrawerOpen"
    @click="isDrawerOpen = false"
    class="fixed inset-0 bg-transparent z-[1001]"
  ></div>

  <div
    id="drawer-navigation"
    class="fixed top-0 left-0 z-[1001] h-screen p-4 overflow-y-auto transition-transform transform bg-white bg-opacity-30 backdrop-blur-xl shadow-lg w-64 dark:bg-gray-800"
    :class="isDrawerOpen ? 'translate-x-0' : '-translate-x-full'"
    tabindex="-1"
    aria-labelledby="drawer-navigation-label"
  >
    <h5 id="drawer-navigation-label" class="text-base font-semibold text-black uppercase dark:text-gray-400">ALF - 2025</h5>

    <button
      type="button"
      @click="isDrawerOpen = false"
      class="text-gray-400 bg-transparent hover:text-gray-900 rounded-lg bg-opacity-30 text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white"
    >
      <svg class="rotate-180" width="32" height="32" viewBox="0 0 24 24" fill="none">
        <path d="M4 6H20M4 12H14M4 18H9" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      <span class="sr-only">Close menu</span>
    </button>

    <div class="py-4 overflow-y-auto">
      <ul class="space-y-2 font-medium">
        <li>
          <a href="/" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg fill="#000" viewBox="-4.5 0 32 32" class="w-6 h-6"><path d="M19.469 12.594l3.625 3.313c0.438 0.406 0.313 0.719-0.281 0.719h-2.719v8.656c0 0.594-0.5 1.125-1.094 1.125h-4.719v-6.063c0-0.594-0.531-1.125-1.125-1.125h-2.969c-0.594 0-1.125 0.531-1.125 1.125v6.063h-4.719c-0.594 0-1.125-0.531-1.125-1.125v-8.656h-2.688c-0.594 0-0.719-0.313-0.281-0.719l10.594-9.625c0.438-0.406 1.188-0.406 1.656 0l2.406 2.156v-1.719c0-0.594 0.531-1.125 1.125-1.125h2.344c0.594 0 1.094 0.531 1.094 1.125v5.875z"/></svg>
            <span class="ms-3 font-semibold">Home</span>
          </a>

          <a href="/about-us" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg class="w-6 h-6" viewBox="0 0 512 512" fill="#000"><path d="M256 0C138 0 42.667 95.312 42.667 213.333 42.667 331.154 138 426.667 256 426.667S469.333 331.154 469.333 213.333C469.333 95.312 374 0 256 0zm0 384c-94.105 0-170.667-76.561-170.667-170.667S161.895 42.667 256 42.667 426.667 119.229 426.667 213.333 350.105 384 256 384zm26.713-256c0 15.468-11.262 26.667-26.497 26.667-15.851 0-26.837-11.199-26.837-27.163 0-15.151 11.292-26.421 26.846-26.421 14.944 0 26.488 11.219 26.488 26.917zM192.047 192h42.667v128h-42.667V192z"/></svg>
            <span class="ms-3 font-semibold">About</span>
          </a>

          <a href="/speakers-list" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg class="w-6 h-6" fill="#000" viewBox="0 0 92.365 92.365"><path d="M66.761 42.935v12.532l-.086.001-.809.407c-.406.206-6.99 3.444-18.352 3.444-3.002 0-6.348-.231-9.992-.802l-3.311-.604c-2.453-.5-5.018-1.14-7.711-1.981l-.865-.271-.031-.192V42.935c0-7.158 4.9-13.18 11.52-14.929 2.377 2.219 5.557 3.588 9.059 3.588s6.68-1.37 9.06-3.588c5.146 1.36 9.241 5.307 10.813 10.36l.643 3.207c.022.449.044.903.044 1.362zM46.184 28.007c7.733 0 14.004-6.27 14.004-14.003C60.188 6.27 53.917 0 46.184 0 38.449 0 32.18 6.27 32.18 14.004c0 7.733 6.268 14.003 14.004 14.003zM63.518 58.225c-.358.181-6.188 3.049-16.246 3.049-2.658 0-5.619-.205-8.848-.709l-2.932-.536c-2.172-.443-4.441-1.009-6.826-1.753l-.637-.2c-.076.254-.129.519-.129.795l5.85 30.71c0 1.539 1.246 2.785 2.785 2.785h7.301V75.723c0-.949.77-1.717 1.719-1.717.949 0 1.717.77 1.717 1.717v16.643h7.623c1.537 0 2.785-1.246 2.785-2.785l6.631-30.71c0-.337-.07-.657-.181-.956l-1.692-1.19z"/></svg>
            <span class="ms-3 font-semibold">The Asian Galaxy</span>
          </a>

          <a href="/team-list" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <!-- <svg class="w-6 h-6" fill="#000" viewBox="0 0 92.365 92.365"><path d="M66.761 42.935v12.532l-.086.001-.809.407c-.406.206-6.99 3.444-18.352 3.444-3.002 0-6.348-.231-9.992-.802l-3.311-.604c-2.453-.5-5.018-1.14-7.711-1.981l-.865-.271-.031-.192V42.935c0-7.158 4.9-13.18 11.52-14.929 2.377 2.219 5.557 3.588 9.059 3.588s6.68-1.37 9.06-3.588c5.146 1.36 9.241 5.307 10.813 10.36l.643 3.207c.022.449.044.903.044 1.362zM46.184 28.007c7.733 0 14.004-6.27 14.004-14.003C60.188 6.27 53.917 0 46.184 0 38.449 0 32.18 6.27 32.18 14.004c0 7.733 6.268 14.003 14.004 14.003zM63.518 58.225c-.358.181-6.188 3.049-16.246 3.049-2.658 0-5.619-.205-8.848-.709l-2.932-.536c-2.172-.443-4.441-1.009-6.826-1.753l-.637-.2c-.076.254-.129.519-.129.795l5.85 30.71c0 1.539 1.246 2.785 2.785 2.785h7.301V75.723c0-.949.77-1.717 1.719-1.717.949 0 1.717.77 1.717 1.717v16.643h7.623c1.537 0 2.785-1.246 2.785-2.785l6.631-30.71c0-.337-.07-.657-.181-.956l-1.692-1.19z"/></svg> -->
            <i class="fa-solid fa-people-group"></i>
            <span class="ms-3 font-semibold">Our Team</span>
          </a>

            <a href="/partner-with-us" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <i class="fa-solid fa-handshake text-xl"></i>
            <span class="ms-3 font-semibold">Partner With Us</span>
          </a>


          <!-- <a href="/the-writing-lab" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <i class="fa-solid fa-feather-alt text-xl"></i>
            <span class="ms-3 font-semibold">The Writing Lab</span>
          </a>

          <a href="/the-kipenzi" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <img :src="kipenziIcon" class="w-6 h-6" alt="The Kipenzi" />
            <span class="ms-3 font-semibold">Kipenzi ALF Kids</span>
          </a> -->

          <a href="/events-schedule" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg class="w-6 h-6" viewBox="0 0 32 32" fill="#000"><path d="M24 8V4h-4v4h-8V4H8v4H4v20h24V8h-4zm-4 16h-4v-8h-4v-4h8v12z"/></svg>
            <span class="ms-3 font-semibold">Events Schedule</span>
          </a>

          <!-- <a href="/volunteer-with-us" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <i class="fa-solid fa-hand-holding-heart text-xl"></i>
            <span class="ms-3 font-semibold">Volunteer With Us</span>
          </a> -->

          <a href="/careers" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <i class="fa-solid fa-id-badge text-xl"></i>
            <span class="ms-3 font-semibold">Careers</span>
          </a>

        
          <a href="/contact-us" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none"><path d="M17.523 19.897C9.848 18.898 4.509 13.455 4.034 6.23A.83.83 0 0 1 4.957 5.225l3.847-.19c.43-.021.825.235.981.636l.693 1.778c.18.464-.008.99-.441 1.235l-2.225 1.254c-.573.323-.684 1.101-.224 1.571l4.763 4.867c.456.466 1.229.378 1.568-.178l1.389-2.277c.251-.412.761-.586 1.212-.413l1.775.681c.417.16.677.577.638 1.022l-.337 3.805c-.049.546-.53.954-1.074.883z" fill="#000" stroke="#000" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span class="ms-3 font-semibold">Contact Us</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import logoUrl from '/public/assets/img/logo.webp'
import trogonUrl from '/public/assets/img/trogon-logo.webp'
import kipenziIcon from '/public/assets/img/kipenzi-icon.webp'

const isDrawerOpen = ref(false)
</script>
