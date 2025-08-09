<template>
  <div class="max-w-screen-2xl mx-auto bg-white dark:bg-gray-900 py-10">
    <h1 class="lg:text-6xl text-3xl mt-4 text-black dark:text-white font-extrabold tracking-widest uppercase text-center mb-8">
      Upcoming Festivals
    </h1>

    <div class="grid grid-cols-1 py-3 gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <article
        v-for="ev in events"
        :key="ev.id"
        class="rounded  bg-yellow-50 dark:bg-gray-800 hover:shadow-md transition-all"
      >
        <div class="flex items-start justify-between p-4">
          <div class="text-sm">
            <div class="font-semibold text-gray-900 dark:text-white">
              {{ formatDate(ev) }}
            </div>
            <div v-if="formatTime(ev)" class="mt-1 flex items-center gap-2 text-gray-600 dark:text-gray-300 text-sm">
              <i class="fa-regular fa-clock"></i>
              <span>{{ formatTime(ev) }}</span>
            </div>
          </div>

          <div class="flex items-center gap-3">
            <span v-if="ev.format" class="inline-block rounded-full px-3 py-1 text-xs font-bold text-white bg-gradient-to-r from-red-600 to-pink-600">
              {{ ev.format }}
            </span>
            <div class="flex items-center gap-2 text-gray-600 dark:text-gray-300 text-sm">
              <i class="fa-solid fa-location-dot"></i>
              <span class="truncate max-w-[140px]">{{ ev.venue }}</span>
            </div>
          </div>
        </div>

        <hr class="border-t border-black/30" />

        <div class="p-4">
          <h3 class="text-xl font-extrabold tracking-tight text-black dark:text-white">
            {{ ev.title }}
          </h3>
          <!-- <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">
            <span class="font-semibold">Speakers:</span>
            <span>{{ (ev.speakers || []).join(', ') }}</span>
          </p> -->
        </div>
      </article>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const events = ref([
  {
    id: 1,
    starts_at: '2025-10-03T08:00:00',
    ends_at:   '2025-10-05T18:00:00',
    title: 'The Asian Literary Festival 2025',
    // speakers: ['Student Ensembles'],
    venue: 'Brussels',
    // format: 'FESTIVAL',
  },
   {
    id: 2,
    starts_at: '2026-01-03T08:00:00',
    ends_at:   '2026-01-44T18:00:00',
    title: 'Kerala Chronicles 2026',
    // speakers: ['Student Ensembles'],
    venue: 'Kerala',
    // format: 'FESTIVAL',
  },
  {
    id: 2,
    starts_at: '2026-01-21T08:00:00',
    ends_at:   '2026-01-24T18:00:00',
    title: 'Southern Chronicles 2026',
    // speakers: ['Student Ensembles'],
    venue: 'Abu Dhabi',
    // format: 'FESTIVAL',
  },
  
  
])

const dFmt = new Intl.DateTimeFormat(undefined, { year: 'numeric', month: 'short', day: 'numeric' })
const tFmt = new Intl.DateTimeFormat(undefined, { hour: 'numeric', minute: '2-digit' })

const sameDay = (a, b) => a.getFullYear()===b.getFullYear() && a.getMonth()===b.getMonth() && a.getDate()===b.getDate()

const formatDate = (ev) => {
  const start = new Date(ev.starts_at)
  if (isNaN(start)) return ''
  if (!ev.ends_at) return dFmt.format(start)

  const end = new Date(ev.ends_at)
  if (isNaN(end) || sameDay(start, end)) return dFmt.format(start)

  // e.g., "Oct 3–5, 2025" or "Oct 31 – Nov 2, 2025"
  const sameMonth = start.getFullYear()===end.getFullYear() && start.getMonth()===end.getMonth()
  const y = start.getFullYear()
  if (sameMonth) {
    const m = new Intl.DateTimeFormat(undefined, { month: 'short' }).format(start)
    return `${m} ${start.getDate()}–${end.getDate()}, ${y}`
  } else {
    const m1 = new Intl.DateTimeFormat(undefined, { month: 'short', day: 'numeric' }).format(start)
    const m2 = new Intl.DateTimeFormat(undefined, { month: 'short', day: 'numeric' }).format(end)
    return `${m1} – ${m2}, ${y}`
  }
}

const formatTime = (ev) => {
  const start = new Date(ev.starts_at)
  return isNaN(start) ? '' : tFmt.format(start)
}
</script>
