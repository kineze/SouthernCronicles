<template>
  <section class="max-w-screen-2xl mx-auto px-4 py-10">
    <h1 class="lg:text-6xl text-3xl text-primary-blue font-extrabold tracking-widest uppercase text-center mb-10">
      Latest News
    </h1>

    <!-- Grid -->
    <div
      v-if="items.length"
      class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6"
    >
      <article
        v-for="n in items"
        :key="n.id"
        class="bg-white rounded shadow hover:shadow-lg transition p-3 flex flex-col"
      >
        <a :href="newsUrl(n)" class="block overflow-hidden bg-gray-100 w-full rounded">
          <img
            v-if="n.image"
            :src="imageUrl(n.image)"
            :alt="n.title"
            class="w-full h-48 bg-cover"
            loading="lazy"
          />
          <div
            v-else
            class="w-full h-48 bg-gray-100 grid place-items-center text-gray-400 text-sm"
          >
            No image
          </div>
        </a>

        <div class="flex-1 pt-3">
          <a :href="newsUrl(n)" class="block">
            <h3 class="font-semibold line-clamp-2 text-primary-blue">
              {{ n.title }}
            </h3>
          </a>

          <p class="mt-2 text-xs text-black">
            {{ formatDate(n.published_at) }} • {{ formatTime(n.created_at) }}
          </p>

          <p class="mt-2 text-xs text-black">
            {{ n.small_description}}
          </p>

            <p class="mt-2 text-xs text-black font-semibold">
                {{ n.published_by}}
            </p>
        </div>

        <!-- Share row -->
        <div class="mt-4 flex items-center justify-between">
            <div class="flex gap-2 text-black">
            <!-- Copy Link -->
            <button
                class="text-xs px-2 py-1 rounded border hover:bg-gray-50 flex items-center gap-1"
                @click="copyLink(n)"
                title="Copy link"
            >
                <i class="fas fa-link"></i>
            </button>

            <!-- WhatsApp -->
            <a
                class="text-xs px-2 py-1 rounded border hover:bg-gray-50 flex items-center gap-1"
                :href="waShare(n)"
                target="_blank" rel="noopener"
                title="Share on WhatsApp"
            >
                <i class="fab fa-whatsapp text-green-600"></i>
            </a>

            <!-- Facebook -->
            <a
                class="text-xs px-2 py-1 rounded border hover:bg-gray-50 flex items-center gap-1"
                :href="fbShare(n)"
                target="_blank" rel="noopener"
                title="Share on Facebook"
            >
                <i class="fab fa-facebook text-blue-600"></i>
            </a>

            <!-- X (Twitter) -->
            <a
                class="text-xs px-2 py-1 rounded border hover:bg-gray-50 flex items-center gap-1"
                :href="xShare(n)"
                target="_blank" rel="noopener"
                title="Share on X"
            >
                <i class="fab fa-x-twitter"></i>
            </a>
            </div>


          <a
            :href="newsUrl(n)"
            class="text-xs font-medium text-primary-blue hover:underline"
          >
            Read More...
          </a>
        </div>
      </article>
    </div>

    <!-- Empty state -->
    <div v-else-if="!loading" class="text-center text-gray-500">
      No news found.
    </div>

    <!-- View more (always shown when we have any items) -->
    <div class="mt-10 text-center" v-if="items.length">
      <a
        :href="allUrl"
        class="inline-flex items-center gap-2 px-5 py-2 bg-black text-white"
      >
        View more
      </a>
    </div>
  </section>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useToast } from 'vue-toastification'

const toast = useToast()

const API_URL = '/api/news'
const allUrl  = '/news-list'

const perPage = 8
const items = ref([])
const loading = ref(false)

onMounted(() => {
  loadNews()
})

async function loadNews() {
  loading.value = true
  try {
    const res = await fetch(`${API_URL}?per_page=${perPage}&page=1`)
    const json = await res.json()
    items.value = json.data ?? []
  } catch (e) {
    console.error(e)
  } finally {
    loading.value = false
  }
}

function imageUrl(path) {
  return `/storage/${path}`
}
function newsUrl(n) {
  return `/view-news/${n.id}`

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
</script>

