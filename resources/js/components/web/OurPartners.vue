<template>
  <div class="max-w-screen-2xl mx-auto px-4 py-10">
    <h1 class="lg:text-6xl text-3xl text-primary-blue font-extrabold tracking-widest uppercase text-center mb-10">
      Our Partners
    </h1>

    <!-- Type Tabs -->
    <div class="flex flex-wrap justify-center gap-2 mb-8">
      <button
        v-for="(t) in typesSorted"
        :key="t.id"
        @click="setType(t.id)"
        :class="pillClass(activeType === t.id)"
      >
        {{ t.name }}
      </button>

      <button
        @click="setType(null)"
        :class="pillClass(activeType === null)"
      >
        All
      </button>
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-10 gap-2">
      <div
        v-for="partner in visiblePartners"
        :key="partner.id"
        class="overflow-hidden rounded bg-white"
      >
        <a
          v-if="partner.site_url"
          :href="partner.site_url"
          target="_blank"
          rel="noopener"
        >
          <img
            :src="`/storage/${partner.image}`"
            :alt="partner.title"
            class="w-full h-36 object-contain p-2 hover:scale-105 transition-transform"
          />
        </a>
        <img
          v-else
          :src="`/storage/${partner.image}`"
          :alt="partner.title"
          class="w-full h-36 object-contain p-2"
        />
      </div>
    </div>

    <!-- Load More -->
    <div class="text-center mt-10" v-if="visiblePartners.length < filteredPartners.length">
      <button
        @click="loadMore"
        class="px-6 py-3 text-white bg-primary-blue hover:bg-gray-800 rounded-full font-bold transition"
      >
        Load More
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed, watch } from 'vue'
import axios from 'axios'

const allPartners = ref([])        // full list from API (with partner_type_id)
const rowsToShow = ref(5)          // how many rows to show
const cols = 10                    // columns in the grid

const types = ref([])              // partner types from API
const activeType = ref(null)       // null = All (will be overridden to first type on load)

// --- Fetchers ---
const fetchTypes = async () => {
  const { data } = await axios.get('/api/partner-types')
  types.value = data || []
}

const fetchPartners = async () => {
  const { data } = await axios.get('/api/our-partners?ordered=true')
  allPartners.value = data || []
}

// --- Sorting types (by position if present; else by name) ---
const typesSorted = computed(() => {
  return [...types.value].sort((a, b) => {
    const pa = (a.position ?? 999999), pb = (b.position ?? 999999)
    if (pa !== pb) return pa - pb
    return (a.name || '').localeCompare(b.name || '')
  })
})

const pillClass = (isActive) =>
  [
    'px-3', 'py-1.5', 'rounded-full', 'font-semibold', 'transition',
    isActive ? 'bg-black text-white' : 'bg-white text-black border border-gray-300 hover:bg-gray-100'
  ].join(' ')

const filteredPartners = computed(() => {
  if (activeType.value === null) return allPartners.value
  return allPartners.value.filter(p => p.partner_type_id === activeType.value)
})

const visiblePartners = computed(() => {
  const max = rowsToShow.value * cols
  return filteredPartners.value.slice(0, max)
})

// --- UI actions ---
const setType = (typeId) => {
  activeType.value = typeId
}

const loadMore = () => {
  rowsToShow.value += 10
}

// Reset pagination when switching tabs
watch(activeType, () => {
  rowsToShow.value = 5
})

// ✅ Default to first type once types are loaded (and only if none selected yet)
watch(typesSorted, (list) => {
  if (list.length && activeType.value === null) {
    activeType.value = list[0].id
  }
}, { immediate: true })

onMounted(async () => {
  await Promise.all([fetchTypes(), fetchPartners()])
  // Safety: in case watch(typesSorted) didn't run due to timing (it will, but still)
  if (activeType.value === null && typesSorted.value.length) {
    activeType.value = typesSorted.value[0].id
  }
})
</script>
