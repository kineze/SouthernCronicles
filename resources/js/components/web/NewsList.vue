<template>
  <section class="max-w-screen-2xl mx-auto px-4 py-10">
    <h1 class="lg:text-6xl text-3xl mt-12 lg:mt-4 text-black font-extrabold tracking-widest uppercase text-center">
      News Updates
    </h1>


    <div class="mt-8 flex flex-col md:flex-row gap-3 md:items-center md:justify-between">

        <div class="relative w-full md:w-96">
        <!-- icon -->
        <i
            class="fa-solid fa-magnifying-glass text-sm absolute left-4 top-6 -translate-y-2.5 text-black pointer-events-none"
            aria-hidden="true"
        ></i>

        <!-- input -->
        <input
        id="news-search"
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

        <!-- floating label -->
        <label
            for="news-search"
            class="absolute text-sm font-semibold text-gray-700
                duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0]
                bg-white px-2
                left-10
                peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                peer-placeholder-shown:top-1/2
                peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4
                dark:text-gray-300 dark:bg-gray-800"
        >
            Search News
        </label>

        <!-- clear button -->
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

    <!-- Grid -->
    <div class="mt-6">
      <div v-if="loading && items.length === 0" class="py-14 text-center text-gray-500">Loading…</div>

      <div v-else-if="!loading && items.length === 0" class="py-14 text-center text-gray-500">
        No news found.
      </div>

      <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <article
          v-for="n in items"
          :key="n.id"
          class="bg-white rounded shadow hover:shadow-lg transition p-3 flex flex-col"
        >
          <a :href="newsUrl(n)" class="block overflow-hidden rounded">
            <img
              v-if="n.image"
              :src="imageUrl(n.image)"
              :alt="n.title"
              class="w-full h-44 object-cover"
              loading="lazy"
            />
            <div v-else class="w-full h-44 bg-gray-100 grid place-items-center text-gray-400 text-sm">
              No image
            </div>
          </a>

          <div class="flex-1 pt-3">
            <a :href="newsUrl(n)" class="block">
              <h3 class="font-semibold line-clamp-2 text-gray-900">
                {{ n.title }}
              </h3>
            </a>

            <p class="mt-2 text-xs text-gray-600">
              {{ formatDate(n.published_at) }} • {{ formatTime(n.created_at) }}
            </p>

            <p class="mt-2 text-xs text-gray-600">
              {{ n.small_description }}
            </p>

            <p class="mt-2 text-xs text-gray-600 font-semibold">
              {{ n.published_by }}
            </p>
          </div>

          <!-- Share row -->
          <div class="mt-4 flex items-center justify-between">
            <div class="flex gap-2 text-gray-600">
              <button
                class="text-xs px-2 py-1 rounded border hover:bg-gray-50 flex items-center gap-1"
                @click="copyLink(n)"
                title="Copy link"
              >
                <i class="fas fa-link"></i>
              </button>

              <a
                class="text-xs px-2 py-1 rounded border hover:bg-gray-50 flex items-center gap-1"
                :href="waShare(n)" target="_blank" rel="noopener" title="Share on WhatsApp"
              >
                <i class="fab fa-whatsapp text-green-600"></i>
              </a>

              <a
                class="text-xs px-2 py-1 rounded border hover:bg-gray-50 flex items-center gap-1"
                :href="fbShare(n)" target="_blank" rel="noopener" title="Share on Facebook"
              >
                <i class="fab fa-facebook text-blue-600"></i>
              </a>

              <a
                class="text-xs px-2 py-1 rounded border hover:bg-gray-50 flex items-center gap-1"
                :href="xShare(n)" target="_blank" rel="noopener" title="Share on X"
              >
                <i class="fab fa-x-twitter"></i>
              </a>
            </div>

            <a :href="newsUrl(n)" class="text-xs font-medium text-black hover:underline">
              Read More...
            </a>
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

const API_URL = '/api/news'

const items = ref([])
const meta = ref(null)
const page = ref(1)
const perPage = ref(12)
const search = ref('')

const loading = ref(false)
const loadingMore = ref(false)
let debounceTimer = null

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
  if (replace) {
    loading.value = true
  } else {
    loadingMore.value = true
  }

  try {
    const params = new URLSearchParams({
      page: String(targetPage),
      per_page: String(perPage.value),
    })
    if (search.value.trim() !== '') params.set('search', search.value.trim())

    const res = await fetch(`${API_URL}?${params.toString()}`)
    const json = await res.json()

    if (replace) items.value = json.data ?? []
    else items.value = items.value.concat(json.data ?? [])

    meta.value = json.meta ?? null
    page.value = meta.value?.current_page ?? targetPage
  } catch (e) {
    toast.error('Failed to load news')
  } finally {
    loading.value = false
    loadingMore.value = false
  }
}

function loadMore() {
  if (!hasMore.value || loadingMore.value) return
  fetchPage(page.value + 1, false)
}

function imageUrl(path) {
  return `/storage/${path}`
}
function newsUrl(n) {
  return `/news/${n.id}`
}
function formatDate(d) {
  if (!d) return ''
  const dt = new Date(d)
  return dt.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: '2-digit' })
}
function formatTime(d) {
  if (!d) return ''
  const dt = new Date(d)
  return dt.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true })
}

/* Share helpers */
function pageShareData(n) {
  const url = newsUrl(n).startsWith('http')
    ? newsUrl(n)
    : `${window.location.origin}${newsUrl(n)}`
  return { url, title: n.title ?? 'News', text: n.title ?? 'News' }
}
function waShare(n) {
  const { url, title } = pageShareData(n)
  return `https://wa.me/?text=${encodeURIComponent(`${title} ${url}`)}`
}
function fbShare(n) {
  const { url } = pageShareData(n)
  return `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`
}
function xShare(n) {
  const { url, title } = pageShareData(n)
  return `https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(url)}`
}
async function copyLink(n) {
  const { url } = pageShareData(n)
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
  // whenever perPage changes, refetch from page 1
  // small debounce to avoid double-fetch if user also types in search
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(() => {
    fetchPage(1, true)
  }, 150)
})
</script>

<style scoped>

/* Hide default clear (×) in Chrome/Edge/Safari (WebKit) */
#news-search::-webkit-search-cancel-button,
#news-search::-webkit-search-decoration,
#news-search::-webkit-search-results-button,
#news-search::-webkit-search-results-decoration {
  -webkit-appearance: none;
  appearance: none;
  display: none;
}

/* Hide default clear in old Edge/IE */
#news-search::-ms-clear {
  display: none;
  width: 0;
  height: 0;
}


</style>
