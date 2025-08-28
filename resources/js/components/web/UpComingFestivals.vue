<template>
  <div class="max-w-screen-2xl bg-gray-100 mx-auto p-4 my-12 dark:bg-gray-900 py-10">
    <h1 class="lg:text-6xl text-3xl mt-4 text-black dark:text-white rounded-xl font-extrabold tracking-widest uppercase text-center mb-8">
      Our Festivals
    </h1>

    <div class="grid grid-cols-1 py-3 gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <article v-for="ev in events" :key="ev.id" class="rounded bg-white dark:bg-gray-800 hover:shadow-md transition-all flex">

        <a v-if="ev.site_url" :href="ev.site_url" target="_blank" rel="noopener" class="flex">
          <div class="p-2">
            <img v-if="ev.image" :src="`/storage/${ev.image}`" class="w-28 h-28 rounded object-cover" alt="thumb" />
          </div>

          <div>
            <div class="p-2 space-y-1 flex flex-col items-start justify-center h-full">

              <a v-if="ev.site_url" :href="ev.site_url" target="_blank" rel="noopener">
                <h3 class="text-xl font-extrabold tracking-tight text-black dark:text-white">
                  {{ ev.name }}
                </h3>
              </a>

              <div class="font-semibold text-gray-900 dark:text-white">
                {{ formatDate(ev.start_at, ev.end_at) }}
              </div>

              <div v-if="formatTime(ev.start_at)" class="mt-1 flex items-center gap-2 text-gray-600 dark:text-gray-300 text-sm">
                <i class="fa-regular fa-clock"></i>
                <span>{{ formatTime(ev.start_at) }}</span>
              </div>

              <div class="flex items-center gap-2 text-gray-600 dark:text-gray-300 text-sm">
                <i class="fa-solid fa-location-dot"></i>
                <span class="">{{ ev.location }}</span>
              </div>
            </div>
          </div>
        </a>

      </article>
    </div>
  </div>
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
    // If the year spills over, show both years explicitly:
    const y2 = end.getFullYear() !== y ? `, ${end.getFullYear()}` : ''
    return `${m1}, ${y} – ${m2}${y2}`
  }
}

const formatTime = (startISO) => {
  const start = new Date(startISO)
  return isNaN(start) ? '' : tFmt.format(start)
}

onMounted(async () => {
  try {
    const { data } = await axios.get('/api/festivals/upcoming') // see controller below
    events.value = Array.isArray(data) ? data : []
  } catch (e) {
    console.error(e.response?.data || e.message)
  }
})
</script>
