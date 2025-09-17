<template>
  <section class="max-w-screen-2xl bg-gray-100 dark:bg-gray-900 mx-auto px-4 py-10 my-12">
    <h1 class="lg:text-6xl text-3xl mt-4 text-primary-blue dark:text-white rounded-xl font-extrabold tracking-widest uppercase text-center mb-8">
      Our Festivals
    </h1>

    <!-- Grid -->
    <div v-if="events.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <article
        v-for="ev in events"
        :key="ev.id"
        class="bg-white dark:bg-gray-800 rounded shadow hover:shadow-lg transition p-3 flex flex-col"
      >
        <!-- Image -->
        <a v-if="ev.site_url" :href="ev.site_url" target="_blank" rel="noopener" class="block overflow-hidden bg-gray-100 w-full rounded">
          <img
            v-if="ev.image"
            :src="imageUrl(ev.image)"
            :alt="ev.name || 'festival image'"
            class="w-full h-48 bg-cover object-cover"
            loading="lazy"
          />
          <div v-else class="w-full h-48 bg-gray-100 grid place-items-center text-gray-400 text-sm">
            No image
          </div>
        </a>
        <div v-else class="block overflow-hidden bg-gray-100 w-full rounded">
          <img
            v-if="ev.image"
            :src="imageUrl(ev.image)"
            :alt="ev.name || 'festival image'"
            class="w-full h-48 bg-cover object-cover"
            loading="lazy"
          />
          <div v-else class="w-full h-48 bg-gray-100 grid place-items-center text-gray-400 text-sm">
            No image
          </div>
        </div>

        <!-- Body -->
        <div class="flex-1 pt-3">
          <div class="space-y-1">
            <!-- Title -->
            <a v-if="ev.site_url" :href="ev.site_url" target="_blank" rel="noopener" class="block">
              <h3 class="font-extrabold tracking-tight text-primary-blue dark:text-white line-clamp-2">
                {{ ev.name }}
              </h3>
            </a>
            <h3 v-else class="font-extrabold tracking-tight text-primary-blue dark:text-white line-clamp-2">
              {{ ev.name }}
            </h3>

            <!-- Date -->
            <p class="text-xs text-black dark:text-gray-200 font-semibold">
              {{ formatDate(ev.start_at, ev.end_at) }}
              <span v-if="formatTime(ev.start_at)"> • {{ formatTime(ev.start_at) }}</span>
            </p>

            <!-- Location -->
            <p class="mt-1 flex items-center gap-2 text-black dark:text-gray-300 text-sm">
              <i class="fa-solid fa-location-dot"></i>
              <span class="line-clamp-1">{{ ev.location }}</span>
            </p>
          </div>
        </div>

        <!-- Footer -->
        <div class="mt-4 flex items-center justify-between">
          <div class="text-xs text-black">
            <!-- You can add tags or category here if available -->
          </div>

          <a
            v-if="ev.site_url"
            :href="ev.site_url"
            target="_blank" rel="noopener"
            class="text-xs font-medium text-primary-blue dark:text-white hover:underline"
          >
            Explore →
          </a>
        </div>
      </article>
    </div>

    <!-- Empty state -->
    <div v-else class="text-center text-black dark:text-gray-300">
      No festivals found.
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const events = ref([])

const dFmt = new Intl.DateTimeFormat(undefined, { year: 'numeric', month: 'short', day: 'numeric' })
const tFmt = new Intl.DateTimeFormat(undefined, { hour: 'numeric', minute: '2-digit' })

const sameDay = (a, b) =>
  a.getFullYear() === b.getFullYear() &&
  a.getMonth() === b.getMonth() &&
  a.getDate() === b.getDate()

const formatDate = (startISO, endISO) => {
  const start = new Date(startISO)
  if (isNaN(start)) return ''
  if (!endISO) return dFmt.format(start)

  const end = new Date(endISO)
  if (isNaN(end) || sameDay(start, end)) return dFmt.format(start)

  const sameMonth = start.getFullYear() === end.getFullYear() && start.getMonth() === end.getMonth()
  const y = start.getFullYear()
  if (sameMonth) {
    const m = new Intl.DateTimeFormat(undefined, { month: 'short' }).format(start)
    return `${m} ${start.getDate()}–${end.getDate()}, ${y}`
  } else {
    const m1 = new Intl.DateTimeFormat(undefined, { month: 'short', day: 'numeric' }).format(start)
    const m2 = new Intl.DateTimeFormat(undefined, { month: 'short', day: 'numeric' }).format(end)
    const y2 = end.getFullYear() !== y ? `, ${end.getFullYear()}` : ''
    return `${m1}, ${y} – ${m2}${y2}`
  }
}

const formatTime = (startISO) => {
  const start = new Date(startISO)
  return isNaN(start) ? '' : tFmt.format(start)
}

function imageUrl(path) {
  // mirrors your News component helper
  return `/storage/${path}`
}

onMounted(async () => {
  try {
    const { data } = await axios.get('/api/festivals', { params: { ordered: 1 } })
    events.value = Array.isArray(data) ? data : []
  } catch (e) {
    console.error(e.response?.data || e.message)
  }
})
</script>
