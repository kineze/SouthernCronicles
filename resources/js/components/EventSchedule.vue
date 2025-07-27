<template>
  <div>
    <h1 class="lg:text-6xl text-3xl mt-12 lg:mt-4 text-black font-extrabold tracking-widest uppercase text-center">Events Agenda</h1>

    <!-- Filter -->
<!-- Filter -->
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


    <!-- Events Accordion -->
    <div class="mt-8 space-y-4">
      <div v-for="(event, idx) in events.slice(0, visibleCount)" :key="event.id" class="overflow-hidden shadow-md">
        <button
          class="w-full flex justify-between items-center px-6 py-4 bg-black text-white font-semibold border-b border-black"
          @click="openIndex = openIndex === idx ? null : idx">
          <span class="text-left font-semibold uppercase">
            {{ event.name }} - {{ formatDate(event.event_date) }} ---- ({{ formatTime(event.time_in) }} - {{ formatTime(event.time_out) }})
          </span>
          <svg :class="{'rotate-180': openIndex === idx}" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
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
            v-show="openIndex === idx"
            class="px-6 py-4 border-b border-l border-r border-black text-black space-y-6 bg-gray-50"
          >
            <!-- Row 1: Venue / Moderator / Book Signing -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
              <p><strong>Venue:</strong> {{ event.venue }}</p>
              <p><strong>Moderator:</strong> {{ event.moderator?.name ?? 'N/A' }}</p>
              <p><strong>Book Signing:</strong> {{ event.book_signing ? 'Yes' : 'No' }}</p>
            </div>

            <!-- Row 2: Speakers / Event Type (styled like description row) -->
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
              
              <p class="text-gray-900 whitespace-pre-line capitalize break-words max-w-screen-2xl">{{ event.description }}</p>
            </div>

          </div>

        </Transition>

      </div>

          <div v-if="visibleCount < events.length" class="flex justify-center mt-6">
            <button
              @click="visibleCount += increment"
              class="bg-black text-white px-6 py-2 font-semibold hover:bg-gray-800 transition">
              Load More
            </button>
          </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted,computed } from 'vue'
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
const openIndex = ref(null)

// ✅ Use prop value for initial visible count
const visibleCount = ref(count)

const fetchDates = async () => {
  const res = await axios.get('/api/events/dates')
  eventDates.value = res.data
}

const fetchEvents = async () => {
  const res = await axios.get('/api/get-events', {
    params: filterDate.value ? { date: filterDate.value } : {}
  })
  events.value = res.data

  visibleCount.value = count
  openIndex.value = null
}

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
  console.log('showFilter from parent (resolved):', showFilter.value) // ✅ add .value
  fetchDates()
  fetchEvents()
})
</script>

