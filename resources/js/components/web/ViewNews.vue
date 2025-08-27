<template>
  <section class="max-w-screen-2xl mx-auto py-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
      <!-- MAIN ARTICLE -->
      <article class="lg:col-span-8">
        <div v-if="loadingArticle" class="text-gray-500">Loading article…</div>
        <div v-else-if="!article" class="text-gray-500">News not found.</div>

        <template v-else>
          <img
            v-if="article.image"
            :src="imageUrl(article.image)"
            :alt="article.title"
            class="w-full max-h-[600px] bg-cover rounded"
            loading="lazy"
          />

          <h1 class="mt-6 text-3xl lg:text-4xl font-extrabold text-black">
            {{ article.title }}
          </h1>

          <p class="mt-2 text-sm text-gray-600">
            {{ formatDate(article.published_at) }} • {{ formatTime(article.created_at) }}
            <span v-if="article.published_by" class="font-semibold"> • {{ article.published_by }}</span>
          </p>

          <!-- <p v-if="article.small_description" class="mt-4 text-gray-700">
            {{ article.small_description }}
          </p> -->

          <div class="mt-8 prose max-w-none ql-render news-content" v-html="article.content"></div>
        </template>
      </article>

      
      <aside class="lg:col-span-4">

        <div class="lg:sticky lg:top-4 space-y-6">

        <div class="rounded border border-gray-200 p-4">
          <h3 class="text-lg font-bold tracking-wider text-black mb-3">Share</h3>
          <div class="flex flex-wrap gap-2 text-gray-600">
            <button
              class="px-3 py-2 rounded border hover:bg-gray-50 flex items-center gap-2"
              @click="copyCurrentLink"
              title="Copy link"
            >
              <i class="fas fa-link"></i>
            </button>
            <a
              class="px-3 py-2 rounded border hover:bg-gray-50 flex items-center gap-2"
              :href="waShare(article)"
              target="_blank" rel="noopener" title="Share on WhatsApp"
            >
              <i class="fab fa-whatsapp text-green-600"></i>
            </a>
            <a
              class="px-3 py-2 rounded border hover:bg-gray-50 flex items-center gap-2"
              :href="fbShare(article)"
              target="_blank" rel="noopener" title="Share on Facebook"
            >
              <i class="fab fa-facebook text-blue-600"></i>
            </a>
            <a
              class="px-3 py-2 rounded border hover:bg-gray-50 flex items-center gap-2"
              :href="xShare(article)"
              target="_blank" rel="noopener" title="Share on X"
            >
              <i class="fab fa-x-twitter"></i>
            </a>
          </div>
        </div>


        <div class="rounded border hidden lg:block border-gray-200 p-4 mt-6">
          <h3 class="text-lg text-black tracking-wider font-bold mb-4">Latest News</h3>

          <!-- Search -->
          <div class="relative mb-4">
            <i
              class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"
              aria-hidden="true"
            ></i>

            <input
              id="latest-search"
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
              for="latest-search"
              class="absolute text-sm font-semibold text-gray-700
                     duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0]
                     bg-white px-2 left-10
                     peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                     peer-placeholder-shown:top-1/2
                     peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4
                     dark:text-gray-300 dark:bg-gray-800"
            >
              Search News
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

          <!-- Horizontal cards -->
          <div class="space-y-3">
            <article
              v-for="n in latest"
              :key="n.id"
              class="flex gap-3 p-2 rounded-lg border border-gray-100 hover:bg-gray-50"
            >
              <a :href="newsUrl(n)" class="shrink-0">
                <img
                  v-if="n.image"
                  :src="imageUrl(n.image)"
                  :alt="n.title"
                  class="w-32 h-20 object-cover rounded"
                  loading="lazy"
                />
                <div v-else class="w-24 h-16 bg-gray-100 grid place-items-center text-gray-400 text-xs rounded">
                  No image
                </div>
              </a>

              <div class="min-w-0 flex-1">
                <a :href="newsUrl(n)" class="block">
                  <h4 class="text-sm font-semibold text-gray-900 line-clamp-2">
                    {{ n.title }}
                  </h4>
                </a>
                <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                  {{ n.small_description || '—' }}
                </p>

                <div class="mt-2 flex items-center gap-2 text-black text-xs">
                  <a :href="waShare(n)" target="_blank" rel="noopener" title="WhatsApp" class="hover:text-green-600">
                    <i class="fab fa-whatsapp"></i>
                  </a>
                  <a :href="fbShare(n)" target="_blank" rel="noopener" title="Facebook" class="hover:text-blue-600">
                    <i class="fab fa-facebook"></i>
                  </a>
                  <a :href="xShare(n)" target="_blank" rel="noopener" title="X" class="hover:text-black">
                    <i class="fab fa-x-twitter"></i>
                  </a>
                  <button @click="copyLink(n)" class="ml-auto text-xs font-semibold hover:underline">Copy link</button>
                </div>
              </div>
            </article>

            <!-- Loading more indicator -->
            <div v-if="loadingMore" class="text-center text-gray-500 py-2">Loading…</div>

            <!-- Sentinel for infinite scroll -->
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

const openedId = computed(() => Number(props.newsId))

/** ======= Props (pass :news-id from Blade) ======= */
const props = defineProps({
  newsId: { type: [String, Number], required: true },
  // optional: control per page in sidebar
  sidebarPerPage: { type: Number, default: 8 },
})

/** ======= API endpoints ======= */
const API_BASE = '/api/news' // index + show

/** ======= Main article ======= */
const article = ref(null)
const loadingArticle = ref(false)

async function fetchArticle() {
  loadingArticle.value = true
  try {
    const res = await fetch(`${API_BASE}/${props.newsId}`)
    if (!res.ok) throw new Error('Failed to fetch article')
    article.value = await res.json()
  } catch (e) {
    console.error(e)
    article.value = null
  } finally {
    loadingArticle.value = false
  }
}

/** ======= Sidebar: latest list with search + infinite scroll ======= */
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
    // reset and fetch fresh
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

    // 🔽 exclude the opened article
    const incoming = (json.data ?? []).filter(
      n => Number(n.id) !== openedId.value
    )

    if (replace) {
      latest.value = incoming
    } else {
      latest.value = latest.value.concat(incoming)
    }

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

/** ======= Share helpers ======= */
function imageUrl(path) { return `/storage/${path}` }
function newsUrl(n) { return `/view-news/${n.id}` }
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

function pageShareData(obj) {
  if (!obj) return { url: location.href, title: document.title }
  const url = newsUrl(obj).startsWith('http') ? newsUrl(obj) : `${window.location.origin}${newsUrl(obj)}`
  return { url, title: obj.title ?? 'News' }
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

/** ======= Lifecycle ======= */
onMounted(async () => {
  await fetchArticle()

  // initial latest batch
  await fetchLatest(true)

  // setup IntersectionObserver for infinite scroll
  io = new IntersectionObserver((entries) => {
    entries.forEach((e) => {
      if (e.isIntersecting) loadMoreIfNeeded()
    })
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
#latest-search::-webkit-search-cancel-button,
#latest-search::-webkit-search-decoration,
#latest-search::-webkit-search-results-button,
#latest-search::-webkit-search-results-decoration {
  -webkit-appearance: none;
  appearance: none;
  display: none;
}
#latest-search::-ms-clear { display: none; width: 0; height: 0; }

.news-content .ql-align-center { text-align: center; }
.news-content .ql-align-right  { text-align: right; }
.news-content .ql-align-justify{ text-align: justify; }

/* Optional: handle indentation if you use it */
.news-content .ql-indent-1 { margin-left: 3em; }
.news-content .ql-indent-2 { margin-left: 6em; }
</style>
