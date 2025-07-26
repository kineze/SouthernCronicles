<template>
  <div>
    <!-- Heading -->
    <h1 class="lg:text-6xl text-3xl mt-12 lg:mt-4 text-black font-extrabold tracking-widest uppercase text-center">Speakers</h1>

    <!-- Filter Section -->
    <div class="flex flex-wrap justify-between items-center w-full mt-10">
      <!-- Search -->
      <div class="lg:w-4/12 w-full">
        <div class="relative">
          <input type="search" v-model="searchQuery" placeholder=" "
            class="block px-6 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-full border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black peer" />
          <label
            class="absolute text-sm text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1 ml-5">
            Search Speakers
          </label>
        </div>
      </div>

      <!-- Types -->
      <div class="lg:w-auto w-full mt-4 lg:mt-0">
        <div class="px-2.5 py-2.5 border rounded-full border-1 border-gray-300 flex flex-wrap gap-2">
          <button
            @click="filterByType(null)"
            :class="['font-semibold rounded-full px-3 py-1.5 transition-all duration-300', activeType === null ? 'bg-black text-white' : 'bg-white text-black']">
            All
          </button>
          <button v-for="type in types" :key="type.id" @click="filterByType(type.id)"
            :class="['font-semibold rounded-full px-3 py-1.5 transition-all duration-300', activeType === type.id ? 'bg-black text-white' : 'bg-white text-black']">
            {{ type.name }}
          </button>
        </div>
      </div>
    </div>

    <!-- Results -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-10">
      <div v-for="speaker in filteredSpeakers" :key="speaker.id"  @click="openModal(speaker)" class=" text-black font-semibold cursor-pointer transition duration-300 hover:bg-black hover:text-white overflow-hidden">
        <img :src="`/storage/${speaker.image}`" class="w-full lg:h-80 h-96 object-cover"  />
        <div class="p-4 text-center">
          <h3 class="font-bold text-lg">{{ speaker.name }}</h3>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
<div v-if="showModal" class="fixed inset-0 z-[1001] bg-black bg-opacity-50 flex items-center justify-center px-3 ">


  <div class="bg-white dark:bg-gray-900 w-full max-w-lg lg:max-w-2xl rounded-lg shadow-lg relative max-h-screen overflow-y-auto ">
    <button
      class="absolute top-3 right-3 text-gray-500 hover:text-red-600"
      @click="closeModal"
    >
      <i class="fa-solid fa-xmark text-xl"></i>
    </button>

    <div class="p-5 text-center">
      <img
        :src="`/storage/${selectedSpeaker?.image}`"
        :alt="selectedSpeaker?.name"
        class="w-40 h-40 lg:w-60 lg:h-60 object-cover rounded-none mx-auto mb-4"
      />
      <h3 class="text-xl font-bold text-black dark:text-white mb-2">{{ selectedSpeaker?.name }}</h3>
      <p class="text-gray-700 dark:text-gray-300 mb-4">{{ selectedSpeaker?.description }}</p>

      <div class="flex justify-center gap-6 text-2xl text-gray-500 mb-4">
        <a
          v-if="selectedSpeaker?.facebook"
          :href="selectedSpeaker.facebook"
          target="_blank"
          class="hover:text-blue-600"
        >
          <i class="fa-brands fa-facebook"></i>
        </a>
        <a
          v-if="selectedSpeaker?.instagram"
          :href="selectedSpeaker.instagram"
          target="_blank"
          class="hover:text-pink-500"
        >
          <i class="fa-brands fa-instagram"></i>
        </a>
        <a
          v-if="selectedSpeaker?.linkedin"
          :href="selectedSpeaker.linkedin"
          target="_blank"
          class="hover:text-blue-400"
        >
          <i class="fa-brands fa-linkedin"></i>
        </a>
      </div>
    </div>

    <!-- Bottom Border -->
    <div class="bg-black p-2"></div>
  </div>
</div>



</template>


<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'

const types = ref([])
const speakers = ref([])
const activeType = ref(null)
const searchQuery = ref('')


const selectedSpeaker = ref(null)
const showModal = ref(false)

const openModal = (speaker) => {
  selectedSpeaker.value = speaker
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  selectedSpeaker.value = null
}


const fetchTypes = async () => {
  const res = await axios.get('/api/speaker-types')
  types.value = res.data
}

const fetchSpeakers = async () => {
  const res = await axios.get('/api/speakers')
  speakers.value = res.data
}

const filterByType = async (typeId) => {
  activeType.value = typeId
  if (!typeId) {
    fetchSpeakers()
  } else {
    const res = await axios.get(`/api/speakers/by-type/${typeId}`)
    speakers.value = res.data
  }
}

const filteredSpeakers = computed(() => {
  return speakers.value.filter(s =>
    s.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
})

onMounted(() => {
  fetchTypes()
  fetchSpeakers()
})
</script>
