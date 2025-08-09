<template>
  <div class="relative bg-white bg-opacity-30 md:pt-6 backdrop-blur-xl ">
    <div>
      <h1 class="lg:text-6xl text-3xl text-black font-extrabold tracking-widest uppercase text-center">OUR Team</h1>
    </div>

    <div class="py-8 w-full max-w-screen-2xl flex flex-col">
      <Carousel 
        :itemsToShow="4"
        :wrapAround="true"
        :itemsToScroll="1"
        :autoplay="2000"
        :pauseAutoplayOnHover="false"
        :mouseDrag="true"
        snapAlign="start"
        v-model="currentSlide"
        :breakpoints="{
            0: { itemsToShow: 1 },
            768: { itemsToShow: 2 },
            1024: { itemsToShow: 4 }
        }"
      >
        <Slide v-for="team in teams" :key="team.id" class="!flex !items-start h-full">
          <div class="p-3 cursor-pointer" @click="openModal(team)">
            <div class="overflow-hidden dark:bg-gray-800">
              <img :src="`/storage/${team.image}`" :alt="team.name" class="w-full h-80 object-cover aspect-square" />
              <div class="p-4 text-center">
                <h3 class="font-semibold text-gray-800 dark:text-white uppercase leading-tight">
                  <span class="block">{{ team.nameParts[0] }}</span>
                  <span v-if="team.nameParts[1]" class="block">{{ team.nameParts[1] }}</span>
                </h3>
              </div>
            </div>
          </div>
        </Slide>
      </Carousel>

    </div>

    <!-- Modal (Teleport to body) -->
    <Teleport to="body" class="py-6">
      <div v-if="showModal" class="fixed inset-0 z-[1001] bg-black bg-opacity-50 flex items-center justify-center px-3">
        <div class="bg-white dark:bg-gray-900 w-full max-w-lg lg:max-w-2xl rounded-lg shadow-lg relative max-h-screen overflow-y-auto">
          <button
            class="absolute top-3 right-3 text-gray-500 hover:text-red-600"
            @click="closeModal"
          >
            <i class="fa-solid fa-xmark text-xl"></i>
          </button>

          <div class="p-5 text-center">
            <img
              :src="`/storage/${selectedTeam?.image}`"
              :alt="selectedTeam?.name"
              class="w-40 h-40 lg:w-60 lg:h-60 object-cover mx-auto mb-4"
            />
            <h3 class="text-xl font-bold text-black dark:text-white mb-2">{{ selectedTeam?.name }}</h3>
            <p class="text-gray-700 dark:text-gray-300 mb-4">{{ selectedTeam?.description }}</p>

            <div class="flex justify-center gap-6 text-2xl text-gray-500 mb-4">
              <a v-if="selectedTeam?.facebook" :href="selectedTeam.facebook" target="_blank" class="hover:text-blue-600">
                <i class="fa-brands fa-facebook"></i>
              </a>
              <a v-if="selectedTeam?.instagram" :href="selectedTeam.instagram" target="_blank" class="hover:text-pink-500">
                <i class="fa-brands fa-instagram"></i>
              </a>
              <a v-if="selectedTeam?.linkedin" :href="selectedTeam.linkedin" target="_blank" class="hover:text-blue-400">
                <i class="fa-brands fa-linkedin"></i>
              </a>
            </div>
          </div>

          <div class="bg-black p-2"></div>
        </div>
      </div>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { Carousel, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'

const teams = ref([])
const currentSlide = ref(0)

const showModal = ref(false)
const selectedTeam = ref(null)

// Split into [first, rest] (rest = second word or more, joined)
const formatName = (name) => {
  if (!name) return ['', '']
  const parts = name.trim().split(/\s+/)
  const first = parts.shift() || ''
  const rest  = parts.join(' ') || ''
  return [first, rest]
}

const fetchTeams = async () => {
  const res = await axios.get('/api/get-teams')
  teams.value = res.data.map(t => ({
    ...t,
    nameParts: formatName(t.name),
  }))
}

const openModal = (team) => {
  // ensure modal also has the preformatted parts
  selectedTeam.value = {
    ...team,
    nameParts: team.nameParts ?? formatName(team.name)
  }
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  selectedTeam.value = null
}

onMounted(fetchTeams)

</script>
