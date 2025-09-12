<template>
  <section class="w-full">
    <div>
      <div
        class="px-6 lg:px-12 py-12 bg-black flex flex-col lg:flex-row items-center justify-between gap-6"
      >
        <!-- Left: Date + Location -->
        <div
          v-if="festivalReady"
          class="flex flex-col items-start text-center lg:w-6/12 lg:text-left"
        >
          <h2 class="font-semibold text-white uppercase text-2xl lg:text-3xl">
            {{ formattedDateRange }}
          </h2>
          <h1
            class="tracking-[10px] lg:tracking-[12px] text-xl lg:text-3xl uppercase font-bold text-white leading-tight mt-2"
          >
            {{ locationInline }}
          </h1>
        </div>

        <div v-else class="flex flex-col items-start">
          <h2 class="text-active-purple uppercase text-3xl lg:text-5xl">
            Coming Soon
          </h2>
        </div>

        <!-- Middle: Countdown -->
        <div
          v-if="festivalReady"
          id="countdown"
          class="flex flex-wrap justify-center gap-4"
        >
          <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 min-w-[90px] text-center">
            <span class="text-2xl font-bold text-white">{{ days }}</span>
            <p class="text-white text-sm mb-0">Days</p>
          </div>
          <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 min-w-[90px] text-center">
            <span class="text-2xl font-bold text-white">{{ hours }}</span>
            <p class="text-white text-sm mb-0">Hours</p>
          </div>
          <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 min-w-[90px] text-center">
            <span class="text-2xl font-bold text-white">{{ minutes }}</span>
            <p class="text-white text-sm mb-0">Minutes</p>
          </div>
          <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 min-w-[90px] text-center">
            <span class="text-2xl font-bold text-white">{{ seconds }}</span>
            <p class="text-white text-sm mb-0">Seconds</p>
          </div>
        </div>

        <!-- Right: Optional action slot -->
        <div class="flex justify-center items-center lg:mt-0" v-if="$slots.action">
          <slot name="action" />
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, watch, onMounted, onBeforeUnmount } from 'vue'
import axios from 'axios'

/**
 * Props:
 * - Pass either `festival` or `nextFestival`.
 * - If neither is provided, the component will GET /api/festival.
 */
const props = defineProps({
  festival: { type: Object, default: null },
  nextFestival: { type: Object, default: null },
  /** Optional: override the fetch URL if needed */
  fetchUrl: { type: String, default: '/api/festival' }
})

/* state */
const f = ref(props.festival ?? props.nextFestival ?? null)
const loading = ref(false)

/* fetch if nothing was passed */
async function loadLatestIfNeeded() {
  if (f.value) return
  loading.value = true
  try {
    const { data } = await axios.get(props.fetchUrl)
    f.value = data || null
  } catch (e) {
    // swallow error, keep null -> "Coming Soon"
  } finally {
    loading.value = false
  }
}

/* sync when parent updates either prop */
watch(() => props.festival, v => { if (v !== undefined) f.value = v })
watch(() => props.nextFestival, v => { if (v !== undefined) f.value = v })

onMounted(loadLatestIfNeeded)

/* helpers */
const festivalReady = computed(() => !!f.value?.start_at)

/* --- Date formatting helpers --- */
const monthNames = [
  'January','February','March','April','May','June',
  'July','August','September','October','November','December'
]
function ordinal (d) {
  const v = d % 100
  if (v >= 11 && v <= 13) return 'th'
  switch (d % 10) { case 1: return 'st'; case 2: return 'nd'; case 3: return 'rd'; default: return 'th' }
}
function parts (dStr) {
  const d = new Date(dStr)
  const day = d.getDate()
  const monthIdx = d.getMonth()
  const year = d.getFullYear()
  return {
    day,
    ord: ordinal(day),
    monthName: monthNames[monthIdx],
    monthShort: monthNames[monthIdx].slice(0, 3),
    year
  }
}

/**
 * Formats:
 * - Only start date or same day: "27th December 2025"
 * - Same month & year:          "27th to 29th December 2025"
 * - Same year, diff months:     "27th Dec to 2nd Jan 2025"
 * - Different years:            "31st Dec 2025 to 1st Jan 2026"
 */
const formattedDateRange = computed(() => {
  if (!f.value?.start_at) return ''

  const p1 = parts(f.value.start_at)
  const hasEnd = !!f.value?.end_at
  if (!hasEnd) {
    return `${p1.day}${p1.ord} ${p1.monthName} ${p1.year}`
  }

  const p2 = parts(f.value.end_at)

  // Same day
  if (p1.day === p2.day && p1.monthName === p2.monthName && p1.year === p2.year) {
    return `${p1.day}${p1.ord} ${p1.monthName} ${p1.year}`
  }

  // Same month + year
  if (p1.monthName === p2.monthName && p1.year === p2.year) {
    return `${p1.day}${p1.ord} to ${p2.day}${p2.ord} ${p1.monthName} ${p1.year}`
  }

  // Same year, different month
  if (p1.year === p2.year) {
    return `${p1.day}${p1.ord} ${p1.monthShort} to ${p2.day}${p2.ord} ${p2.monthShort} ${p1.year}`
  }

  // Different years
  return `${p1.day}${p1.ord} ${p1.monthShort} ${p1.year} to ${p2.day}${p2.ord} ${p2.monthShort} ${p2.year}`
})

/* Location inline (fallbacks to name if no location) */
const locationInline = computed(() => {
  const raw = String(f.value?.location || '').trim()
  if (raw) return raw
  return f.value?.name || 'Festival'
})

/* --- Countdown (to start_at) --- */
const days = ref(0)
const hours = ref(0)
const minutes = ref(0)
const seconds = ref(0)
let timer = null

function tick () {
  if (!f.value?.start_at) return
  const target = new Date(f.value.start_at).getTime()
  const now = Date.now()
  const diff = target - now

  if (diff <= 0) {
    days.value = hours.value = minutes.value = seconds.value = 0
    return
  }

  const s = 1000
  const m = 60 * s
  const h = 60 * m
  const d = 24 * h

  days.value    = Math.floor(diff / d)
  hours.value   = Math.floor((diff % d) / h)
  minutes.value = Math.floor((diff % h) / m)
  seconds.value = Math.floor((diff % m) / s)
}

onMounted(() => {
  tick()
  timer = setInterval(tick, 1000)
})
onBeforeUnmount(() => { if (timer) clearInterval(timer) })

// Re-run countdown if the start date changes at runtime
watch(() => f.value?.start_at, () => tick())
</script>

<style scoped>
/* Keep the rounded corners crisp on dark backgrounds (optional) */
</style>
