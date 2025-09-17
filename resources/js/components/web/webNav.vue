<template>
  <nav class="w-full absolute top-0 left-0 z-50">
    <div class="w-full max-w-screen-2xl bg-transparent mx-auto px-4 py-4">
      <div class="w-full flex justify-between ">
        <div class="w-full flex justify-between">
          <div class="relative">
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

        <div class=" w-4/12 flex  justify-end items-center z-50 rounded-es-3xl">
          <div class="">
          <a href="/" >
            <img
              :src="trogonUrl"
              class="inline-block max-w-full transition-all lg:w-40 w-32  duration-200 ease-soft-in-out"
              alt="main_logo"
            />
          </a>
          <a href="/">
            <img
              :src="logoUrl"
              class="inline-block max-w-full transition-all  lg:w-20 w-20 duration-200 ease-soft-in-out "
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
    <div class="flex items-center justify-between">
      <h5 id="drawer-navigation-label" class="text-sm font-semibold text-black uppercase dark:text-gray-400">
        Odisha Art & Literature Festival
      </h5>

      <button
        type="button"
        @click="isDrawerOpen = false"
        class="text-gray-400 bg-transparent hover:text-gray-900 rounded-lg bg-opacity-30 text-sm w-9 h-9 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white"
      >
        <svg class="rotate-180" width="32" height="32" viewBox="0 0 24 24" fill="none">
          <path d="M4 6H20M4 12H14M4 18H9" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="sr-only">Close menu</span>
      </button>
    </div>

    <div class="mt-4">
      <ul class="space-y-1">
        <li v-for="item in navItems" :key="item.href || item.id">
          <a
            :href="item.href || '#'"
            :aria-current="item.href && isActive(item.href) ? 'page' : undefined"
            :class="drawerLinkClass(item.href || '')"
            @click.prevent="handleNavClick(item, true)"
          >
            <span v-html="item.icon" class="w-6 h-6 inline-block"></span>
            <span class="font-medium">{{ item.label }}</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const logoUrl = '/assets/img/logo-new.webp'
const trogonUrl = '/assets/img/sou-logo.webp'
const kipenziIcon = '/assets/img/kipenzi-icon.webp'

const isDrawerOpen = ref(false)
const currentPath = ref('/')

onMounted(() => {
  currentPath.value = window.location.pathname || '/'
})

const navItems = [
  { id: 'home', label: 'Home', href: '/', icon: `<i class="fa-solid fa-home text-base"></i>` },
  { id: 'about', label: 'About Us', href: '/about-us', icon: `<i class="fa-solid fa-book-open text-base"></i>` },
  { id: 'speakers', label: 'Speakers', href: '/speakers-list', icon: `<i class="fa-solid fa-person-chalkboard text-base"></i>` },
  { id: 'schedule', label: 'The Writing Lab', href: '/the-writing-lab', icon: `<i class='fa-solid fa-feather-pointed text-base'></i>` },
  { id: 'kipenzi', label: 'Kipenzi ALF Kids', href: '/the-kipenzi', icon: `<img src="${kipenziIcon}" class="w-6 h-6 inline-block object-contain" alt="Kipenzi" />` },
  { id: 'kipenzi-kids', label: 'Kipenzi Kids Stories', href: '/kipenzi-kids-stories', icon: `<i class="fa-solid fa-wand-magic-sparkles text-base"></i>` },
  { id: 'schedule', label: 'Events Schedule', href: '/events-schedule', icon: `<i class='fa-solid fa-calendar-check text-base'></i>` },
  { id: 'volunteerwithus', label: 'Volunteer With Us', href: '/volunteer-with-us', icon: `<i class='fa-solid fa-hand-holding-heart text-base'></i>` },
  // { id: 'gallery', label: 'Gallery', href: '/oalf-2026-gallery', icon: `<i class='fa-solid fa-photo-film text-base'></i>` },
  // { id: 'videos', label: 'Videos', href: '/oalf-2026-videos', icon: `<i class='fa-solid fa-video text-base'></i>` },
  // { id: 'archive', label: 'Archive', href: '/all-oalf-festivals', icon: `<i class="fa-solid fa-box-archive text-base"></i>` },
  { id: 'contact', label: 'Contact Us', href: '/contact-us', icon: `<i class='fa-solid fa-phone text-base'></i>` }
]

// ---- helpers you referenced but didn't define ----
function closeDrawer() {
  isDrawerOpen.value = false
}

function isActive(href = '') {
  // simple exact match; tweak if you need startsWith, query/hash, etc.
  return currentPath.value === href
}

function drawerLinkClass(href = '') {
  const base = 'flex items-center gap-3 px-3 py-2 rounded-lg transition'
  return isActive(href)
    ? `${base} bg-black/10 text-black dark:bg-white/10 dark:text-white`
    : `${base} text-gray-800 hover:bg-black/5 dark:text-gray-200 dark:hover:bg-white/10`
}

// ---- central navigation ----
function navigate(path) {
  // Replace with router.push(path) if you’re using Vue Router
  window.location.href = path
}

function handleNavClick(item, fromDrawer = false) {
  if (!item?.href) return
  if (fromDrawer) closeDrawer()
  navigate(item.href)
}
</script>

