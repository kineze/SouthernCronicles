<template>
  <div>
    <h1 class="lg:text-6xl text-3xl mt-12 lg:mt-4 text-black font-extrabold tracking-widest uppercase text-center">
      Our Teams
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
            class="block px-6 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-full border border-gray-300 dark:text-white dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black peer"
          />
          <label
            class="absolute text-sm text-gray-700 font-semibold dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1 ml-5">
            Search
          </label>
        </div>
      </div>

      <!-- Type pills -->
      <div class="lg:w-auto w-full mt-4 lg:mt-0">
        <div class="px-2.5 py-2.5 border rounded-full border-gray-300 flex flex-wrap gap-2">
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

    <!-- Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-10 items-start">
      <div
        v-for="team in filteredTeams"
        :key="team.id"
        @click="openModal(team)"
        class="text-black font-semibold cursor-pointer transition duration-300 hover:bg-black hover:text-white overflow-hidden flex flex-col items-start h-full"
      >
        <img :src="`/storage/${team.image}`" class="w-full lg:h-80 h-96 object-cover" />
        <div class="p-4 w-full text-center">
          <h3 class="font-bold uppercase text-lg">{{ team.name }}</h3>
          <p v-if="team.type" class="text-xs uppercase tracking-wide text-gray-500">{{ team.type.name }}</p>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="fixed inset-0 z-[1001] bg-black/50 flex items-center justify-center px-3">
      <div class="bg-white dark:bg-gray-900 w-full max-w-lg lg:max-w-2xl rounded-lg shadow-lg relative max-h-screen overflow-y-auto">
        <button class="absolute top-3 right-3 text-gray-500 hover:text-red-600" @click="closeModal">
          <i class="fa-solid fa-xmark text-xl"></i>
        </button>

        <div class="p-5 text-center">
          <img :src="`/storage/${selectedTeam?.image}`" :alt="selectedTeam?.name" class="w-40 h-40 lg:w-60 lg:h-60 object-cover mx-auto mb-4" />
          <h3 class="text-xl font-bold text-black dark:text-white mb-1">{{ selectedTeam?.name }}</h3>
          <p v-if="selectedTeam?.type" class="text-xs uppercase tracking-wide text-gray-500 mb-2">{{ selectedTeam.type.name }}</p>
          <p class="text-gray-700 dark:text-gray-300 mb-4">{{ selectedTeam?.description }}</p>

          <div class="flex justify-center gap-6 text-2xl text-gray-500 mb-4">
            <a v-if="selectedTeam?.facebook"  :href="selectedTeam.facebook"  target="_blank" class="hover:text-blue-600"><i class="fa-brands fa-facebook"></i></a>
            <a v-if="selectedTeam?.instagram" :href="selectedTeam.instagram" target="_blank" class="hover:text-pink-500"><i class="fa-brands fa-instagram"></i></a>
            <a v-if="selectedTeam?.linkedin"  :href="selectedTeam.linkedin"  target="_blank" class="hover:text-blue-400"><i class="fa-brands fa-linkedin"></i></a>
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
const teams = ref([])
const activeType = ref(null)
const searchQuery = ref('')

const selectedTeam = ref(null)
const showModal = ref(false)

const openModal = (team) => {
  selectedTeam.value = team
  showModal.value = true
}
const closeModal = () => {
  selectedTeam.value = null
  showModal.value = false
}

const fetchTypes = async () => {
  const { data } = await axios.get('/api/team-types')
  types.value = data
}

// For public web view, this returns only teams with show_on_home=1 (and already includes type via controller)
const fetchTeams = async () => {
  const { data } = await axios.get('/api/get-teams')
  teams.value = data
}

const filterByType = (typeId) => {
  activeType.value = typeId
}

const filteredTeams = computed(() => {
  const q = searchQuery.value.trim().toLowerCase()
  return teams.value.filter(t => {
    const matchType = activeType.value === null || t.team_type_id === activeType.value
    const matchSearch = !q || (t.name?.toLowerCase().includes(q) || t.description?.toLowerCase().includes(q))
    return matchType && matchSearch
  })
})

onMounted(async () => {
  await Promise.all([fetchTypes(), fetchTeams()])
})
</script>
