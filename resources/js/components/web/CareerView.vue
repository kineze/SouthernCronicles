<!-- resources/js/components/web/CareerView.vue -->
<template>
  <section class="max-w-screen-2xl mx-auto py-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
      <!-- MAIN -->
      <article class="lg:col-span-8">
        <div v-if="loadingCareer" class="text-gray-500">Loading career…</div>
        <div v-else-if="!career" class="text-gray-500">Career not found.</div>

        <template v-else>
          <!-- Header -->
          <div class="flex items-start gap-4">
            <!-- <div class="shrink-0 grid place-items-center rounded-xl bg-black text-white w-16 h-16">
              <i class="fa-solid fa-briefcase text-xl"></i>
            </div> -->
            <div class="min-w-0">
              <h1 class="text-3xl lg:text-4xl font-extrabold text-black">
                {{ career.title }}
              </h1>
              <div class="mt-3 flex flex-wrap items-center gap-2 text-sm">
                <span class="inline-flex items-center gap-1 font-semibold" :class="statusPillClass(career)">
                  <i class="fa-solid" :class="isClosed(career) ? 'fa-lock text-rose-500' : 'fa-unlock text-green-600'"></i>
                  {{ isClosed(career) ? 'Closed' : 'Open' }}
                </span>

                <div class="flex items-end justify-end">
                    <span v-if="career.closing_date" class="text-gray-700">
                  Closes: {{ formatDateTime(career.closing_date) }}
                </span>
                <span v-else class="text-gray-700">Open until filled</span>

                </div>
              </div>
<!-- 
              <p v-if="career.small_description" class="mt-3 text-gray-700">
                {{ career.small_description }}
              </p> -->
            </div>
          </div>

          <!-- Content (Quill HTML) -->
          <div class="mt-8 prose max-w-none ql-render news-content" v-html="career.content"></div>
        </template>
      </article>

      <!-- SIDEBAR -->
      <aside class="lg:col-span-4">
        <div class="lg:sticky lg:top-4 space-y-6">
          <!-- Share -->
          <div class="rounded border border-gray-200 p-4">
            <h3 class="text-lg font-bold tracking-wider text-black mb-3">Share</h3>
            <div class="flex flex-wrap gap-2 text-gray-600">
              <button class="px-3 py-2 rounded border hover:bg-gray-50 flex items-center gap-2" @click="copyCurrentLink" title="Copy link">
                <i class="fas fa-link"></i>
              </button>
              <a class="px-3 py-2 rounded border hover:bg-gray-50 flex items-center gap-2" :href="waShare(career)" target="_blank" rel="noopener" title="WhatsApp">
                <i class="fab fa-whatsapp text-green-600"></i>
              </a>
              <a class="px-3 py-2 rounded border hover:bg-gray-50 flex items-center gap-2" :href="fbShare(career)" target="_blank" rel="noopener" title="Facebook">
                <i class="fab fa-facebook text-blue-600"></i>
              </a>
              <a class="px-3 py-2 rounded border hover:bg-gray-50 flex items-center gap-2" :href="xShare(career)" target="_blank" rel="noopener" title="X">
                <i class="fab fa-x-twitter"></i>
              </a>
            </div>
          </div>

          <!-- Latest Careers -->
          <div class="rounded border hidden lg:block border-gray-200 p-4 mt-6">
            <h3 class="text-lg text-black tracking-wider font-bold mb-4">Latest Careers</h3>

            <!-- Search -->
            <div class="relative mb-4">
              <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
              <input
                id="latest-career-search"
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
                for="latest-career-search"
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
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                aria-label="Clear search"
                title="Clear"
              >
                <i class="fa-solid fa-xmark"></i>
              </button>
            </div>

            <!-- Horizontal list -->
            <div class="space-y-3">
              <article
                v-for="c in latest"
                :key="c.id"
                class="flex gap-3 p-2 rounded-lg border border-gray-100 hover:bg-gray-50"
              >
                <!-- <a :href="careerUrl(c)" class="shrink-0">
                  <div class="grid place-items-center w-16 h-16 rounded-lg bg-black text-white">
                    <i class="fa-solid fa-briefcase"></i>
                  </div>
                </a> -->

                <div class="min-w-0 flex-1">
                  <a :href="careerUrl(c)" class="block">
                    <h4 class="text-sm font-semibold text-gray-900 line-clamp-2">
                      {{ c.title }}
                    </h4>
                  </a>

                  <div class="mt-1 flex flex-wrap items-center gap-2 text-[11px]">
                    <span class="inline-flex items-center gap-1 font-semibold" :class="statusPillClass(c)">
                      <i class="fa-solid" :class="isClosed(c) ? 'fa-lock text-rose-500' : 'fa-unlock text-green-600'"></i>
                      {{ isClosed(c) ? 'Closed' : 'Open' }}
                    </span>
                    <span v-if="c.closing_date" class="text-gray-600">Closes: {{ shortDate(c.closing_date) }}</span>
                  </div>

                  <div class="mt-2 flex items-center gap-2 text-black text-xs">
                    <a :href="waShare(c)" target="_blank" rel="noopener" title="WhatsApp" class="hover:text-green-600">
                      <i class="fab fa-whatsapp"></i>
                    </a>
                    <a :href="fbShare(c)" target="_blank" rel="noopener" title="Facebook" class="hover:text-blue-600">
                      <i class="fab fa-facebook"></i>
                    </a>
                    <a :href="xShare(c)" target="_blank" rel="noopener" title="X" class="hover:text-black">
                      <i class="fab fa-x-twitter"></i>
                    </a>
                    <button @click="copyLink(c)" class="ml-auto text-xs font-semibold hover:underline">Copy link</button>
                  </div>
                </div>
              </article>

              <div v-if="loadingMore" class="text-center text-gray-500 py-2">Loading…</div>
              <div ref="sentinel" class="h-6"></div>
            </div>
          </div>
        </div>
      </aside>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, computed } from 'vue'
import { useToast } from 'vue-toastification'

const toast = useToast()

/** Props */
const props = defineProps({
  careerId: { type: [String, Number], required: true },
  sidebarPerPage: { type: Number, default: 8 },
})

const openedId = computed(() => Number(props.careerId))

/** Endpoints */
const API_BASE = '/api/careers'

/** Main career */
const career = ref(null)
const loadingCareer = ref(false)

async function fetchCareer() {
  loadingCareer.value = true
  try {
    const res = await fetch(`${API_BASE}/${props.careerId}`)
    if (!res.ok) throw new Error('Failed to fetch career')
    career.value = await res.json()
  } catch (e) {
    console.error(e)
    career.value = null
  } finally {
    loadingCareer.value = false
  }
}

/** Sidebar latest list */
const latest = ref([])
const meta = ref(null)
const page = ref(1)
const perPage = ref(props.sidebarPerPage)
const search = ref('')
const loadingMore = ref(false)
let debounceTimer = null
let io = null
const sentinel = ref(null)

function clearSearch() {
  search.value = ''
  onSearchInput()
}
function onSearchInput() {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(() => {
    latest.value = []
    page.value = 1
    fetchLatest(true)
  }, 350)
}

async function fetchLatest(replace = false) {
  loadingMore.value = true
  try {
    const params = new URLSearchParams({
      page: String(page.value),
      per_page: String(perPage.value),
    })
    if (search.value.trim()) params.set('search', search.value.trim())

    const res = await fetch(`${API_BASE}?${params.toString()}`)
    const json = await res.json()

    const incoming = (json.data ?? []).filter(c => Number(c.id) !== openedId.value)
    if (replace) latest.value = incoming
    else latest.value = latest.value.concat(incoming)

    meta.value = json.meta ?? null
  } catch (e) {
    console.error(e)
  } finally {
    loadingMore.value = false
  }
}

function canLoadMore() {
  if (!meta.value) return false
  return meta.value.current_page < meta.value.last_page
}
function loadMoreIfNeeded() {
  if (!loadingMore.value && canLoadMore()) {
    page.value += 1
    fetchLatest()
  }
}

/** Helpers */
function careerUrl(c) { return `/view-career/${c.id}` }
function shortDate(d) {
  const dt = new Date(d)
  if (Number.isNaN(dt.getTime())) return ''
  return dt.toLocaleDateString('en-US', { month: 'short', day: '2-digit' })
}
function formatDateTime(d) {
  if (!d) return ''
  const dt = new Date(d)
  if (Number.isNaN(dt.getTime())) return ''
  const date = dt.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: '2-digit' })
  const time = dt.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true })
  return `${date}`
}
function isClosed(c) {
  if (!c?.closing_date) return false
  const now = new Date()
  const end = new Date(c.closing_date)
  return !Number.isNaN(end.getTime()) && end.getTime() < now.getTime()
}
function statusPillClass(c) {
  if (isClosed(c)) return 'bg-rose-100 text-rose-700'
  return c.status ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700'
}

/** Share helpers */
function pageShareData(obj) {
  if (!obj) return { url: location.href, title: document.title }
  const url = careerUrl(obj).startsWith('http') ? careerUrl(obj) : `${window.location.origin}${careerUrl(obj)}`
  return { url, title: obj.title ?? 'Career' }
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
    toast.success('Link copied!', { timeout: 1500, position: 'top-right' })
  } catch {
    window.prompt('Copy link:', url)
  }
}
async function copyCurrentLink() {
  try {
    await navigator.clipboard.writeText(location.href)
    toast.success('Link copied!', { timeout: 1500, position: 'top-right' })
  } catch {}
}

/** Lifecycle */
onMounted(async () => {
  await fetchCareer()
  await fetchLatest(true)

  io = new IntersectionObserver((entries) => {
    entries.forEach((e) => { if (e.isIntersecting) loadMoreIfNeeded() })
  }, { root: null, rootMargin: '200px', threshold: 0 })
  if (sentinel.value) io.observe(sentinel.value)
})
onBeforeUnmount(() => {
  clearTimeout(debounceTimer)
  if (io && sentinel.value) io.unobserve(sentinel.value)
  if (io) io.disconnect()
})
</script>

<style scoped>
/* Hide default clear icon in WebKit search fields */
#latest-career-search::-webkit-search-cancel-button,
#latest-career-search::-webkit-search-decoration,
#latest-career-search::-webkit-search-results-button,
#latest-career-search::-webkit-search-results-decoration {
  -webkit-appearance: none;
  appearance: none;
  display: none;
}
#latest-career-search::-ms-clear { display: none; width: 0; height: 0; }

/* Quill output helpers (same as your news page) */
.news-content .ql-align-center { text-align: center; }
.news-content .ql-align-right  { text-align: right; }
.news-content .ql-align-justify{ text-align: justify; }
.news-content .ql-indent-1 { margin-left: 3em; }
.news-content .ql-indent-2 { margin-left: 6em; }
</style>
