<template>
  <section class="max-w-screen-2xl mx-auto lg:px-4 lg:py-10 py-6">
    <h1 class="lg:text-6xl text-3xl mt-12 lg:mt-4 text-black font-extrabold tracking-widest uppercase text-center">
      Career Updates
    </h1>

    <!-- Search -->
    <div class="mt-8 flex flex-col md:flex-row gap-3 md:items-center md:justify-between">
      <div class="relative w-full md:w-96">
        <i
          class="fa-solid fa-magnifying-glass text-sm absolute left-4 top-6 -translate-y-2.5 text-black pointer-events-none"
          aria-hidden="true"
        ></i>

        <input
          id="career-search"
          type="search"
          v-model="search"
          placeholder=" "
          @input="onSearchInput"
          class="peer block w-full rounded-full border bg-white text-sm text-gray-900
                 px-10 pr-10 pb-2.5 pt-4 border-gray-300 focus:outline-none focus:ring-0
                 focus:border-black dark:bg-gray-800 dark:text-white dark:border-gray-600
                 dark:focus:border-white appearance-none"
          autocomplete="off"
        />

        <label
          for="career-search"
          class="absolute text-sm font-semibold text-gray-700
                 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0]
                 bg-white px-2 left-10
                 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                 peer-placeholder-shown:top-1/2
                 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4
                 dark:text-gray-300 dark:bg-gray-800"
        >
          Search Careers
        </label>

        <button
          v-if="search"
          @click="clearSearch"
          type="button"
          class="absolute right-4 top-6 -translate-y-2 text-black hover:text-gray-600"
          aria-label="Clear search"
          title="Clear"
        >
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
    </div>

    <!-- List -->
    <div class="mt-6">
      <div v-if="loading && items.length === 0" class="py-14 text-center text-gray-500">Loading…</div>

      <div v-else-if="!loading && items.length === 0" class="py-14 text-center text-gray-500">
        No careers found.
      </div>

      <div v-else class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <article
          v-for="c in items"
          :key="c.id"
          class="group relative border rounded border-black/10 bg-white dark:bg-gray-800 p-4 md:p-5
                 hover:shadow-xl hover:border-black/10 transition flex items-start gap-4"
        >
          <!-- LEFT: icon -->
          <!-- <div class="shrink-0 rounded-xl bg-black text-white w-14 h-14 md:w-16 md:h-16 grid place-items-center">
            <i class="fa-solid fa-briefcase text-xl"></i>
          </div> -->

          <!-- RIGHT: everything else -->
          <div class="flex-1 min-w-0">
            <!-- Title -->
            <a :href="careerUrl(c)" class="block">
              <h3 class="font-semibold text-gray-900 dark:text-white line-clamp-2">
                {{ c.title }}
              </h3>
            </a>

            <!-- Small description -->
            <p v-if="c.small_description" class="mt-1 text-sm text-gray-700 dark:text-gray-200 line-clamp-2">
              {{ c.small_description }}
            </p>

            <!-- Meta row -->
            <div class="mt-2 flex flex-wrap items-center gap-2 text-xs">
              <span
                class=" items-center gap-1 rounded-full font-semibold"
                :class="statusPillClass(c)"
                title="Status"
              >
                <i class="fa-solid" :class="isClosed(c) ? 'fa-lock text-rose-500' : 'fa-unlock text-green-600'"></i>
                {{ isClosed(c) ? 'Closed' : 'Open' }}
              </span>

              <span class="text-gray-600 dark:text-gray-300">
                <template v-if="c.closing_date">Closing Date: {{ formatDate(c.closing_date) }}</template>
                <template v-else>Open until filled</template>
              </span>

              <span class="text-gray-500 dark:text-gray-400">•</span>
              <span class="text-gray-600 dark:text-gray-300">Posted: {{ formatDateTime(c.created_at) }}</span>
            </div>

            <!-- CTA + Share -->
            <div class="mt-3 flex items-center justify-between gap-3">
              
              <div class="flex items-center gap-2 text-gray-600">
                <button
                  class="text-[11px] px-2 py-1 rounded border hover:bg-gray-50 dark:border-gray-700 flex items-center gap-1"
                  @click="copyLink(c)"
                  title="Copy link"
                >
                  <i class="fas fa-link"></i>
                </button>
                <a
                  class="text-[11px] px-2 py-1 rounded border hover:bg-gray-50 dark:border-gray-700 flex items-center gap-1"
                  :href="waShare(c)" target="_blank" rel="noopener" title="WhatsApp"
                >
                  <i class="fab fa-whatsapp text-green-600"></i>
                </a>
                <a
                  class="text-[11px] px-2 py-1 rounded border hover:bg-gray-50 dark:border-gray-700 flex items-center gap-1"
                  :href="fbShare(c)" target="_blank" rel="noopener" title="Facebook"
                >
                  <i class="fab fa-facebook text-blue-600"></i>
                </a>
                <a
                  class="text-[11px] px-2 py-1 rounded border hover:bg-gray-50 dark:border-gray-700 flex items-center gap-1"
                  :href="xShare(c)" target="_blank" rel="noopener" title="X"
                >
                  <i class="fab fa-x-twitter"></i>
                </a>
              </div>

              <a
                :href="careerUrl(c)"
                class="inline-flex items-center gap-2 px-3 py-1 text-xs font-semibold
                       bg-black text-white hover:bg-black/90 dark:bg-white dark:text-black dark:hover:bg-white/90"
              >
                View More
                <!-- <i class="fa-solid fa-arrow-right text-[10px]"></i> -->
              </a>
            </div>
          </div>
        </article>
      </div>

      <!-- Load more -->
      <div class="mt-10 text-center" v-if="hasMore">
        <button
          @click="loadMore"
          :disabled="loadingMore"
          class="inline-flex items-center gap-2 px-5 py-2 rounded-xl border border-gray-300 hover:bg-gray-50 disabled:opacity-60"
        >
          <svg v-if="loadingMore" class="animate-spin h-4 w-4" viewBox="0 0 24 24" fill="none">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"/>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v3A5 5 0 007 12H4z"/>
          </svg>
          <span>{{ loadingMore ? 'Loading…' : 'Load more' }}</span>
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import { onMounted, ref, computed, watchEffect } from 'vue'
import { useToast } from 'vue-toastification'

const toast = useToast()

const API_URL = '/api/careers'

const items = ref([])
const meta = ref(null)
const page = ref(1)
const perPage = ref(12)
const search = ref('')

const loading = ref(false)
const loadingMore = ref(false)
let debounceTimer = null

const onlyVisible = true   // client-side filter
const hideClosed = false   // set true to hide closed roles on UI

const hasMore = computed(() => {
  if (!meta.value) return false
  return meta.value.current_page < meta.value.last_page
})

function clearSearch() {
  search.value = ''
  onSearchInput()
}

onMounted(() => {
  fetchPage(1, true)
})

function onSearchInput() {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(() => {
    fetchPage(1, true)
  }, 400)
}

async function fetchPage(targetPage = 1, replace = false) {
  if (replace) loading.value = true
  else loadingMore.value = true

  try {
    const params = new URLSearchParams({
      page: String(targetPage),
      per_page: String(perPage.value),
    })
    if (search.value.trim() !== '') params.set('search', search.value.trim())
    // Backend filter example:
    // if (onlyVisible) params.set('status', '1')

    const res = await fetch(`${API_URL}?${params.toString()}`)
    const json = await res.json()

    let list = json.data ?? []

    // Client-side filters (optional)
    if (onlyVisible) list = list.filter(x => !!x.status)
    if (hideClosed) list = list.filter(x => !isClosed(x))

    if (replace) items.value = list
    else items.value = items.value.concat(list)

    meta.value = json.meta ?? null
    page.value = meta.value?.current_page ?? targetPage
  } catch (e) {
    toast.error('Failed to load careers')
  } finally {
    loading.value = false
    loadingMore.value = false
  }
}

function loadMore() {
  if (!hasMore.value || loadingMore.value) return
  fetchPage(page.value + 1, false)
}

function careerUrl(c) {
  return `/view-career/${c.id}`
}

function formatDateTime(d) {
  if (!d) return ''
  const dt = new Date(d)
  if (Number.isNaN(dt.getTime())) return ''
  const date = dt.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: '2-digit' })
  const time = dt.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true })
  return `${date}`
}

function formatDate(d) {
  if (!d) return ''
  const dt = new Date(d)
  if (Number.isNaN(dt.getTime())) return ''
  const date = dt.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: '2-digit' })
//   const time = dt.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true })
  return `${date}`
}

function isClosed(c) {
  if (!c?.closing_date) return false
  const now = new Date()
  const end = new Date(c.closing_date)
  return !Number.isNaN(end.getTime()) && end.getTime() < now.getTime()
}

function statusPillClass(c) {
  if (isClosed(c)) return ' '
  return c.status ? ' ' : 'bg-gray-200 text-gray-700'
}

/* Share helpers */
function pageShareData(c) {
  const url = careerUrl(c).startsWith('http')
    ? careerUrl(c)
    : `${window.location.origin}${careerUrl(c)}`
  return { url, title: c.title ?? 'Career', text: c.title ?? 'Career' }
}
function waShare(c) {
  const { url, title } = pageShareData(c)
  return `https://wa.me/?text=${encodeURIComponent(`${title} ${url}`)}`
}
function fbShare(c) {
  const { url } = pageShareData(c)
  return `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`
}
function xShare(c) {
  const { url, title } = pageShareData(c)
  return `https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(url)}`
}
async function copyLink(c) {
  const { url } = pageShareData(c)
  try {
    await navigator.clipboard.writeText(url)
    toast.success('Link copied to clipboard!', {
      timeout: 2000,
      position: 'top-right',
      closeOnClick: true,
      pauseOnHover: false,
    })
  } catch {
    window.prompt('Copy link:', url)
  }
}

/* React to perPage changes */
watchEffect(() => {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(() => {
    fetchPage(1, true)
  }, 150)
})
</script>

<style scoped>
/* Hide default clear (×) in Chrome/Edge/Safari (WebKit) */
#career-search::-webkit-search-cancel-button,
#career-search::-webkit-search-decoration,
#career-search::-webkit-search-results-button,
#career-search::-webkit-search-results-decoration {
  -webkit-appearance: none;
  appearance: none;
  display: none;
}
/* Hide default clear in old Edge/IE */
#career-search::-ms-clear {
  display: none;
  width: 0;
  height: 0;
}
</style>
