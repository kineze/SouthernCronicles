<template>
  <div>
    <h1 class="lg:text-6xl text-3xl mt-12 lg:mt-4 text-black font-extrabold tracking-widest uppercase text-center">Events Agenda</h1>

    <div v-if="showFilter" class="flex flex-wrap justify-end items-center w-full mt-10">
      <div class="lg:w-auto w-full mt-4 lg:mt-0">
        <div class="px-2.5 py-2.5 border rounded-full border-gray-300 flex flex-wrap gap-2">
          <button
            @click="filterDate = null; fetchEvents()"
            :class="['font-semibold rounded-full px-3 py-1.5 transition-all duration-300', !filterDate ? 'bg-black text-white' : 'bg-white text-black']">
            All
          </button>

          <button
            v-for="date in eventDates"
            :key="date.raw"
            @click="filterDate = date.raw; fetchEvents()"
            :class="['font-semibold rounded-full px-3 py-1.5 transition-all duration-300',
              filterDate === date.raw ? 'bg-black text-white' : 'bg-white text-black']">
            {{ date.label }}
          </button>
        </div>
      </div>
    </div>

    
<div class="mt-8 space-y-4">
  <div
    v-for="group in groupedEvents.slice(0, visibleGroupCount)"
    :key="group.key"
    class="overflow-hidden shadow-md"
  >
    <!-- PARENT ACCORDION (group) -->
    <button
      class="w-full flex justify-between items-center px-6 py-4 text-white font-semibold border-b border-black"
      :style="{ backgroundColor: group.color || '#000000' }"
      @click="toggleGroup(group.key)"
    >
      <span class="text-left font-semibold uppercase">
        {{ formatDate(group.event_date) }} — ({{ formatTime(group.time_in) }} - {{ formatTime(group.time_out) }})
        <span class="opacity-90">• {{ group.items.length }} {{ group.items.length === 1 ? 'Event' : 'Events' }}</span>
      </span>
      <svg :class="{'rotate-180': isGroupOpen(group.key)}" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
      </svg>
    </button>

    <Transition
      enter-active-class="transition-all duration-800 ease-in-out"
      leave-active-class="transition-all duration-800 ease-in-out"
      enter-from-class="max-h-0 opacity-0"
      enter-to-class="max-h-full opacity-100"
      leave-from-class="max-h-full opacity-100"
      leave-to-class="max-h-0 opacity-0"
    >
      <div
        v-show="isGroupOpen(group.key)"
        class="px-0 py-0 border-b border-l border-r border-black text-black bg-gray-50"
      >
        <!-- SUB ACCORDIONS -->
        <div v-for="(event, idx) in group.items" :key="event.id" class="border-b border-gray-100">
          <button
            class="w-full flex justify-between items-center px-6 py-3 text-white font-semibold bg-gray-900"
            @click="toggleSub(group.key, idx)"
          >
            <span class="text-left">
              {{ event.name }}
              <span v-if="event.venue" class="opacity-70"> — {{ event.venue }}</span>
            </span>
            <svg :class="{'rotate-180': isSubOpen(group.key, idx)}" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>

          <Transition
            enter-active-class="transition-all duration-500 ease-in-out"
            leave-active-class="transition-all duration-500 ease-in-out"
            enter-from-class="max-h-0 opacity-0"
            enter-to-class="max-h-full opacity-100"
            leave-from-class="max-h-full opacity-100"
            leave-to-class="max-h-0 opacity-0"
          >
            <div v-show="isSubOpen(group.key, idx)" class="px-6 py-4 bg-gray-50 space-y-6">
              <!-- Row 1 -->
              <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <p><strong>Venue:</strong> {{ event.venue }}</p>
                <p><strong>Moderator:</strong> {{ event.moderator?.name ?? 'N/A' }}</p>
                <p><strong>Book Signing:</strong> {{ event.book_signing ? 'Yes' : 'No' }}</p>
              </div>

              <!-- Row 2 -->
              <div class="pt-4 border-t border-gray-200 grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div>
                  <p><strong>Speakers:</strong></p>
                  <ul class="list-disc list-inside">
                    <li v-for="s in event.speakers" :key="s.id">{{ s.name }}</li>
                  </ul>
                </div>
                <div>
                  <p><strong>Event Type:</strong> {{ event.event_type }}</p>
                </div>
              </div>

              <div v-if="event.description" class="pt-4 border-t border-gray-200">
                <p class="text-gray-900 whitespace-pre-line capitalize break-words max-w-screen-2xl">
                  {{ event.description }}
                </p>
              </div>
            </div>
          </Transition>
        </div>
      </div>
    </Transition>
  </div>

  <!-- LOAD MORE groups -->
  <div v-if="visibleGroupCount < groupedEvents.length" class="flex justify-center mt-6">
    <button
      @click="visibleGroupCount += increment"
      class="bg-black text-white px-6 py-2 font-semibold hover:bg-gray-800 transition"
    >
      Load More
    </button>
  </div>
</div>

  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'

const { count, increment, showFilter: rawShowFilter } = defineProps({
  count: { type: Number, default: 10 },
  increment: { type: Number, default: 10 },
  showFilter: { type: [Boolean, String], default: false }
})

const showFilter = computed(() => rawShowFilter === true || rawShowFilter === 'true')

const eventDates = ref([])
const events = ref([])
const filterDate = ref(null)

// open state maps
const openGroups = ref({})     // key => boolean
const openSubs = ref({})       // key => subindex or null

// visible groups count (replaces visibleCount for groups)
const visibleGroupCount = ref(count)

const fetchDates = async () => {
  const res = await axios.get('/api/events/dates')
  eventDates.value = res.data
}

const fetchEvents = async () => {
  const res = await axios.get('/api/get-events', {
    params: filterDate.value ? { date: filterDate.value } : {}
  })
  events.value = res.data

  // reset UI state
  visibleGroupCount.value = count
  openGroups.value = {}
  openSubs.value = {}
}

// GROUP: date + time range
const groupedEvents = computed(() => {
  const map = new Map()
  for (const e of events.value) {
    const key = `${e.event_date}|${e.time_in}|${e.time_out}`
    if (!map.has(key)) {
      map.set(key, {
        key,
        event_date: e.event_date,
        time_in: e.time_in,
        time_out: e.time_out,
        // pick a color from the first item (fallback handled in template)
        color: e.has_color ? e.color : null,
        items: []
      })
    }
    map.get(key).items.push(e)
  }

  // Sort by date then time
  const arr = Array.from(map.values())
  arr.sort((a, b) => {
    const ad = a.event_date.localeCompare(b.event_date)
    if (ad !== 0) return ad
    const at = a.time_in.localeCompare(b.time_in)
    if (at !== 0) return at
    return a.time_out.localeCompare(b.time_out)
  })
  return arr
})

// helpers for open/close
const toggleGroup = (key) => {
  openGroups.value[key] = !openGroups.value[key]
  // when closing a group, also close its sub
  if (!openGroups.value[key]) openSubs.value[key] = null
}
const isGroupOpen = (key) => !!openGroups.value[key]

const toggleSub = (key, idx) => {
  openSubs.value[key] = openSubs.value[key] === idx ? null : idx
}
const isSubOpen = (key, idx) => openSubs.value[key] === idx

const formatDate = (dateStr) => {
  const options = { year: 'numeric', month: 'long', day: 'numeric' }
  return new Date(dateStr).toLocaleDateString('en-US', options)
}

const formatTime = (timeStr) => {
  return new Date(`1970-01-01T${timeStr}`).toLocaleTimeString('en-US', {
    hour: 'numeric',
    minute: '2-digit',
    hour12: true
  })
}

onMounted(() => {
  fetchDates()
  fetchEvents()
})

</script>

