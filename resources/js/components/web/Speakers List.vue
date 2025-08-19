<template>
  <div>
    <h1 class="lg:text-6xl text-3xl mt-12 lg:mt-4 text-black font-extrabold tracking-widest uppercase text-center">
      Speakers
    </h1>

    <!-- Filters -->
    <div class="flex flex-wrap justify-between items-center w-full mt-10">
      <div class="lg:w-4/12 w-full">
        <div class="relative">
          <input
            type="search"
            v-model="searchQuery"
            placeholder=" "
            class="block px-6 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-full border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black peer"
          />
          <label
            class="absolute text-sm text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1 ml-5">
            Search Speakers
          </label>
        </div>
      </div>

      <div class="lg:w-auto w-full mt-4 lg:mt-0">
        <div class="px-2.5 py-2.5 border rounded-full border-1 border-gray-300 flex flex-wrap gap-2">
          <button
            @click="filterByType(null)"
            :class="['font-semibold rounded-full px-3 py-1.5 transition-all duration-300', activeType === null ? 'bg-black text-white' : 'bg-white text-black']">
            All
          </button>
          <button
            v-for="type in types"
            :key="type.id"
            @click="filterByType(type.id)"
            :class="['font-semibold rounded-full px-3 py-1.5 transition-all duration-300', activeType === type.id ? 'bg-black text-white' : 'bg-white text-black']">
            {{ type.name }}
          </button>
        </div>
      </div>
    </div>

    <!-- Honeycomb Grid -->
    <div class="mt-10 hidden lg:block">
      <HexHoneyGrid
        v-if="imgSrcs.length"
        :images="imgSrcs"
        :radius="62"
        :stroke-width="6"
        stroke-color="#ffffff"
        :shuffle="true"         
        :interval-ms="3000"
        :fade-ms="600"
        :batch-size="60"           
        :avoid-duplicates="false"
        dedupe-key="exact"
        :rows-desktop="desktopRows"
        :rows-mobile="mobileRows"
        :pad="12"
        interactive
        @hex-click="handleHexClick"
      />
      <div v-else class="w-full h-40 grid place-items-center text-gray-500">
        No speakers found.
      </div>
    </div>

    <div class="mt-10 lg:hidden">
      <HexHoneyGrid
        v-if="imgSrcs.length"
        :images="imgSrcs"
        :radius="62"
        :stroke-width="6"
        stroke-color="#ffffff"
        :shuffle="true"         
        :interval-ms="3000"
        :fade-ms="600"
        :batch-size="10"           
        :avoid-duplicates="false"
        dedupe-key="exact"
        :rows-desktop="desktopRows"
        :rows-mobile="mobileRows"
        :pad="12"
        interactive
        @hex-click="handleHexClick"
      />
      <div v-else class="w-full h-40 grid place-items-center text-gray-500">
        No speakers found.
      </div>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="fixed inset-0 z-[1001] bg-black bg-opacity-50 flex items-center justify-center px-3">
      <div class="bg-white dark:bg-gray-900 w-full max-w-lg lg:max-w-2xl rounded-lg shadow-lg relative max-h-screen overflow-y-auto">
        <button class="absolute top-3 right-3 text-gray-500 hover:text-red-600" @click="closeModal">
          <i class="fa-solid fa-xmark text-xl"></i>
        </button>

        <div class="p-5 text-center">
          <img
            :src="selectedSrc"
            :alt="selectedSpeaker?.name"
            class="w-40 h-40 lg:w-60 lg:h-60 object-cover rounded-none mx-auto mb-4"
          />
          <h3 class="text-xl font-bold text-black dark:text-white mb-2">{{ selectedSpeaker?.name }}</h3>
          <p class="text-gray-700 dark:text-gray-300 mb-4">{{ selectedSpeaker?.description }}</p>

          <div class="flex justify-center gap-6 text-2xl text-gray-500 mb-4">
            <a v-if="selectedSpeaker?.facebook" :href="selectedSpeaker.facebook" target="_blank" class="hover:text-blue-600">
              <i class="fa-brands fa-facebook"></i>
            </a>
            <a v-if="selectedSpeaker?.instagram" :href="selectedSpeaker.instagram" target="_blank" class="hover:text-pink-500">
              <i class="fa-brands fa-instagram"></i>
            </a>
            <a v-if="selectedSpeaker?.linkedin" :href="selectedSpeaker.linkedin" target="_blank" class="hover:text-blue-400">
              <i class="fa-brands fa-linkedin"></i>
            </a>
          </div>
        </div>

        <div class="bg-black p-2"></div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import HexHoneyGrid from './SpeakerListHex.vue'

const types = ref([])
const speakers = ref([])
const activeType = ref(null)
const searchQuery = ref('')

/** Grid shape (enough capacity for many speakers) */
const desktopRows = ref([14, 13, 14, 13, 14, 13, 14, 13, 14, 13, 14, 13,14]) // 12 rows
const mobileRows  = ref([5, 4, 5, 4, 5, 4, 5, 4])

/** Filtered list from API */
const filteredSpeakers = computed(() => {
  const q = (searchQuery.value || '').toLowerCase()
  return (speakers.value || []).filter(s => {
    if (activeType.value && s.speaker_type_id !== activeType.value) return false
    if (q && !String(s.name || '').toLowerCase().includes(q)) return false
    return true
  })
})

/** Build image srcs with a unique query so animated pool treats them distinctly */
const imgSrcs = computed(() =>
  filteredSpeakers.value.map((s, i) => `/storage/${s.image}?v=${i}`)
)

/** Map: src (with ?v=i) -> speaker (so clicks are stable while animating) */
const imageToSpeaker = computed(() => {
  const map = Object.create(null)
  filteredSpeakers.value.forEach((s, i) => {
    map[`/storage/${s.image}?v=${i}`] = s
  })
  return map
})

/* ---- Modal ---- */
const showModal = ref(false)
const selectedSpeaker = ref(null)
const selectedSrc = ref('')

function handleHexClick({ src }) {
  // Use the src from the grid (includes ?v=i) to find the correct speaker
  const sp = imageToSpeaker.value[src]
  if (!sp) return
  selectedSpeaker.value = sp
  selectedSrc.value = `/storage/${sp.image}`
  showModal.value = true
}
function closeModal() {
  showModal.value = false
  selectedSpeaker.value = null
  selectedSrc.value = ''
}

/* ---- Data ---- */
async function fetchTypes () {
  const { data } = await axios.get('/api/speaker-types')
  types.value = Array.isArray(data) ? data : []
}
async function fetchSpeakers () {
  const { data } = await axios.get('/api/speakers', { params: { ordered: true } })
  speakers.value = Array.isArray(data) ? data : []
}

function filterByType(typeId){ activeType.value = typeId }

onMounted(() => {
  fetchTypes()
  fetchSpeakers()
})
</script>
