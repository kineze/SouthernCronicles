<template>
  <div>
    <h1 class="lg:text-6xl text-3xl mt-12 lg:mt-4 text-black font-extrabold tracking-widest uppercase text-center">
      Advisors
    </h1>

    <!-- Filters -->
    <div class="flex flex-wrap justify-between items-center w-full mt-10">
      <!-- Search -->
      <div class="lg:w-4/12 w-full">
        <div class="relative">
          <input
            type="search"
            v-model="searchQuery"
            placeholder=" "
            class="block px-6 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-full border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black peer"
          />
          <label
            class="absolute text-sm text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1 ml-5"
          >
            Search Advisors
          </label>
        </div>
      </div>

      <!-- Type chips -->
      <div class="lg:w-auto w-full mt-4 lg:mt-0">
        <div class="px-2.5 py-2.5 border rounded-full border-1 border-gray-300 flex flex-wrap gap-2">
          <button
            @click="activeType = null"
            :class="['font-semibold rounded-full px-3 py-1.5 transition-all duration-300', activeType === null ? 'bg-black text-white' : 'bg-white text-black']"
          >
            All
          </button>
          <button
            v-for="type in types"
            :key="type.id"
            @click="activeType = type.id"
            :class="['font-semibold rounded-full px-3 py-1.5 transition-all duration-300', activeType === type.id ? 'bg-black text-white' : 'bg-white text-black']"
          >
            {{ type.name }}
          </button>
        </div>
      </div>
    </div>

    <!-- Results -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-10 items-start">
      <div
        v-for="advisor in filteredAdvisors"
        :key="advisor.id"
        @click="openModal(advisor)"
        class="text-black font-semibold cursor-pointer transition duration-300 hover:bg-black hover:text-white overflow-hidden flex flex-col items-start h-full"
      >
        <img
          :src="imageSrc(advisor.image)"
          :alt="advisor.name"
          class="w-full lg:h-80 h-96 object-cover"
          @error="onImgError"
        />
        <div class="p-4 w-full text-center">
          <h3 class="font-bold uppercase text-lg">{{ advisor.name }}</h3>
          <p v-if="advisor.type?.name" class="text-xs text-gray-500 mt-1 uppercase tracking-wide">
            {{ advisor.type.name }}
          </p>
        </div>
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
            :src="imageSrc(selectedAdvisor?.image)"
            :alt="selectedAdvisor?.name"
            class="w-40 h-40 lg:w-60 lg:h-60 object-cover rounded-none mx-auto mb-4"
            @error="onImgError"
          />
          <h3 class="text-xl font-bold text-black dark:text-white mb-2">{{ selectedAdvisor?.name }}</h3>
          <p class="text-gray-700 dark:text-gray-300 mb-2" v-if="selectedAdvisor?.type?.name">
            <span class="uppercase tracking-wide text-xs">{{ selectedAdvisor.type.name }}</span>
          </p>
          <p class="text-gray-700 dark:text-gray-300 mb-4">{{ selectedAdvisor?.description }}</p>

          <div class="flex justify-center gap-6 text-2xl text-gray-500 mb-4">
            <a v-if="selectedAdvisor?.facebook" :href="selectedAdvisor.facebook" target="_blank" class="hover:text-blue-600" aria-label="Facebook">
              <i class="fa-brands fa-facebook"></i>
            </a>
            <a v-if="selectedAdvisor?.instagram" :href="selectedAdvisor.instagram" target="_blank" class="hover:text-pink-500" aria-label="Instagram">
              <i class="fa-brands fa-instagram"></i>
            </a>
            <a v-if="selectedAdvisor?.linkedin" :href="selectedAdvisor.linkedin" target="_blank" class="hover:text-blue-400" aria-label="LinkedIn">
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
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'

const types = ref([])
const advisors = ref([])
const activeType = ref(null)
const searchQuery = ref('')

const selectedAdvisor = ref(null)
const showModal = ref(false)

const placeholder = '/assets/img/placeholder-portrait.webp'
const imageSrc = (path) => (path ? `/storage/${path}` : placeholder)
const onImgError = (e) => { e.target.src = placeholder }

const openModal = (advisor) => {
  selectedAdvisor.value = advisor
  showModal.value = true
}
const closeModal = () => {
  showModal.value = false
  selectedAdvisor.value = null
}

const fetchTypes = async () => {
  const res = await axios.get('/api/advisor-types') // assumes you have this endpoint (like speaker-types)
  types.value = res.data
}
const fetchAdvisors = async () => {
  // returns Advisors with 'type' relation; ordered by position then id
  const res = await axios.get('/api/advisors', { params: { ordered: true } })
  advisors.value = res.data
}

// Single computed for both search + type filtering
const filteredAdvisors = computed(() => {
  const q = searchQuery.value.trim().toLowerCase()
  return advisors.value.filter(a => {
    const matchType = activeType.value ? String(a.advisor_type_id) === String(activeType.value) : true
    const matchSearch = q ? (a.name?.toLowerCase().includes(q) || a.type?.name?.toLowerCase().includes(q)) : true
    return matchType && matchSearch
  })
})

onMounted(() => {
  fetchTypes()
  fetchAdvisors()
})
</script>
