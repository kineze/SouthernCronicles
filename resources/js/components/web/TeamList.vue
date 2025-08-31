<template>
  <div>
    <h1 class="lg:text-6xl text-3xl mt-12 lg:mt-4 text-black font-extrabold tracking-widest uppercase text-center">
      Our Team
    </h1>

    <!-- Search -->
    <div class="flex justify-center w-full mt-10">
      <div class="lg:w-4/12 w-full">
        <div class="relative">
          <input
            type="search"
            v-model="searchQuery"
            placeholder=" "
            class="block px-6 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-full border border-gray-300 focus:outline-none focus:ring-0 focus:border-black peer"
          />
          <label
            class="absolute text-sm text-gray-700 font-semibold duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2
                   peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                   peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1 ml-5">
            Search
          </label>
        </div>
      </div>
    </div>

    <!-- Grouped Teams -->
    <div class="mt-10 space-y-12">
      <section v-for="group in groups" :key="group.key">
        <h2 class="text-xl font-bold uppercase text-center tracking-wide text-gray-700 mb-5">
          {{ group.title }}
        </h2>

        <div
          class="flex flex-wrap justify-center items-center"
        >
          <div
            v-for="team in group.items"
            :key="team.id"
            @click="openModal(team)"
            class="text-black font-semibold px-3 cursor-pointer transition duration-300 hover:bg-black hover:text-white overflow-hidden flex flex-col items-start h-full max-w-xs w-full"
          >
            <img :src="`/storage/${team.image}`" class="w-full lg:h-80 h-96 object-cover" />
            <div class="p-4 w-full text-center">
              <h3 class="font-bold uppercase text-lg">{{ team.name }}</h3>
              <p v-if="team.type" class="text-xs uppercase tracking-wide text-gray-500">{{ team.type.name }}</p>
            </div>
          </div>
        </div>

      </section>

      <!-- Empty state -->
      <div v-if="!groups.length" class="text-center text-gray-500">
        No teams found.
      </div>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="fixed inset-0 z-[1001] bg-black/50 flex items-center justify-center px-3">
      <div class="bg-white w-full max-w-lg lg:max-w-2xl rounded-lg shadow-lg relative max-h-screen overflow-y-auto">
        <button class="absolute top-3 right-3 text-gray-500 hover:text-red-600" @click="closeModal">
          <i class="fa-solid fa-xmark text-xl"></i>
        </button>

        <div class="p-5 text-center">
          <img :src="`/storage/${selectedTeam?.image}`" :alt="selectedTeam?.name" class="w-40 h-40 lg:w-60 lg:h-60 object-cover mx-auto mb-4" />
          <h3 class="text-xl font-bold text-black mb-1">{{ selectedTeam?.name }}</h3>
          <p v-if="selectedTeam?.type" class="text-xs uppercase tracking-wide text-gray-500 mb-2">{{ selectedTeam.type.name }}</p>
          <p class="text-gray-700 mb-4">{{ selectedTeam?.description }}</p>

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

const searchQuery = ref('')
const teams = ref([])

const selectedTeam = ref(null)
const showModal = ref(false)
const openModal = (team) => { selectedTeam.value = team; showModal.value = true }
const closeModal = () => { selectedTeam.value = null; showModal.value = false }

// Public list: show_on_home = 1, ordered by type.position -> team.position -> name (from controller)
const fetchTeams = async () => {
  const { data } = await axios.get('/api/get-teams')
  teams.value = data || []
}

// Search filter
const filteredTeams = computed(() => {
  const q = searchQuery.value.trim().toLowerCase()
  if (!q) return teams.value
  return teams.value.filter(t =>
    (t.name && t.name.toLowerCase().includes(q)) ||
    (t.description && t.description.toLowerCase().includes(q)) ||
    (t.type?.name && t.type.name.toLowerCase().includes(q))
  )
})

/** Build groups by team.type (title fallback “Uncategorized”)
 *  The API already returns ordered data, but we also sort within the group
 *  to be safe: position ASC, then name ASC.
 */
const groups = computed(() => {
  const map = new Map()
  const fallbackIndex = new Map()
  let nextIdx = 0

  for (const t of filteredTeams.value) {
    const key   = t?.type?.id ?? 'uncategorized'
    const title = t?.type?.name ?? 'Uncategorized'
    const pos   = Number.isInteger(t?.type?.position) ? t.type.position : null

    if (!map.has(key)) {
      // use type.position when available; otherwise assign first-seen index
      const orderIndex = pos ?? (fallbackIndex.has(key) ? fallbackIndex.get(key) : (fallbackIndex.set(key, nextIdx), nextIdx++))
      map.set(key, { key, title, orderIndex, items: [] })
    }
    map.get(key).items.push(t)
  }

  // sort items in each group by team.position then name
  for (const g of map.values()) {
    g.items.sort((a, b) => (a.position ?? 0) - (b.position ?? 0) || a.name.localeCompare(b.name))
  }

  // sort groups by type.position (or by first-seen fallback), then title
  return Array.from(map.values()).sort((a, b) =>
    (a.orderIndex ?? Number.MAX_SAFE_INTEGER) - (b.orderIndex ?? Number.MAX_SAFE_INTEGER) ||
    String(a.title).localeCompare(String(b.title))
  )
})


onMounted(fetchTeams)
</script>
