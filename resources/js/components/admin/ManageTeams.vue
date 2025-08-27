<template>
  <div>
    <!-- Header -->
    <div class="justify-between flex w-full p-4 bg-white dark:shadow-soft-dark-xl shadow-soft-xl rounded-xl dark:bg-gray-800 pb-2">
      <h4 class="dark:text-white text-lg">All Teams</h4>
      <button @click="openDrawer" class="px-4 py-1.5 bg-gray-800 text-white dark:bg-green-500 rounded-full text-sm font-semibold">
        Add Team
      </button>
    </div>

    <!-- Team Cards -->
<!-- Team Cards -->
<div class="relative overflow-x-auto mt-7 sm:rounded-lg">
  <!-- Main teams row (centered) -->
  <div v-if="mainTeams.length" class="mb-8">
    <h5 class="text-sm font-semibold text-gray-600 mb-3">Main Teams</h5>

    <!-- widths mirror a 2/3/4-col grid with gap-6 -->
    <div class="flex flex-wrap justify-center gap-6">
      <div
        v-for="team in mainTeams"
        :key="`main-${team.id}`"
        class="relative group rounded-lg overflow-hidden shadow-lg
               w-full sm:w-[calc(50%-0.75rem)] md:w-[calc(33.333%-0.75rem)] lg:w-[calc(25%-0.75rem)]"
      >
        <!-- switches -->
        <div class="absolute top-2 right-2 z-[990] flex gap-2">
          <!-- Show on home -->
          <label class="inline-flex items-center cursor-pointer" aria-label="Show on home">
            <input
              type="checkbox"
              :checked="team.show_on_home"
              @change="toggleShowOnHome(team)"
              class="sr-only peer"
            />
            <div
              class="relative w-11 h-6 bg-gray-200 rounded
                     peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300
                     dark:peer-focus:ring-green-800 dark:bg-gray-700
                     after:content-[''] after:absolute after:top-[2px] after:start-[2px]
                     after:bg-white after:border-gray-300 after:border after:rounded
                     after:h-5 after:w-5 after:transition-all
                     peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full
                     peer-checked:bg-green-600"
            ></div>
          </label>

          <!-- Main -->
          <label class="inline-flex items-center cursor-pointer" title="Mark as main">
            <input
              type="checkbox"
              :checked="team.is_main"
              @change="toggleMain(team)"
              class="sr-only peer"
            />
            <div
              class="relative w-11 h-6 bg-gray-200 rounded
                     peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300
                     dark:peer-focus:ring-amber-800 dark:bg-gray-700
                     after:content-[''] after:absolute after:top-[2px] after:start-[2px]
                     after:bg-white after:border-gray-300 after:border after:rounded
                     after:h-5 after:w-5 after:transition-all
                     peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full
                     peer-checked:bg-amber-500"
            ></div>
          </label>
        </div>

        <img :src="`/storage/${team.image}`" alt="Team Image" class="w-full h-80 object-cover" />

        <div
          class="absolute inset-0 bg-black/70 opacity-0 group-hover:opacity-100 transition-opacity duration-300
                 flex flex-col items-center justify-center text-white p-4 text-center"
        >
          <h3 class="text-lg font-semibold mb-1">{{ team.name }}</h3>
          <p v-if="team.type" class="text-xs uppercase tracking-wide text-emerald-300">{{ team.type.name }}</p>
          <div class="flex space-x-4 text-sm mt-4">
            <button @click="editTeam(team)" class="text-white"><i class="fa-solid fa-pen"></i></button>
            <button @click="showDeleteConfirmation(team)" class="text-rose-500"><i class="fa-solid fa-trash"></i></button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Other teams grid -->
  <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
    <div
      v-for="team in otherTeams"
      :key="`other-${team.id}`"
      class="relative group rounded-lg overflow-hidden shadow-lg"
    >
      <div class="absolute top-2 right-2 z-[990] flex gap-2">
        <!-- Show on home -->
        <label class="inline-flex items-center cursor-pointer">
          <input
            type="checkbox"
            :checked="team.show_on_home"
            @change="toggleShowOnHome(team)"
            class="sr-only peer"
          />
          <div
            class="relative w-11 h-6 bg-gray-200 rounded
                   peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300
                   dark:peer-focus:ring-green-800 dark:bg-gray-700
                   after:content-[''] after:absolute after:top-[2px] after:start-[2px]
                   after:bg-white after:border-gray-300 after:border after:rounded
                   after:h-5 after:w-5 after:transition-all
                   peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full
                   peer-checked:bg-green-600"
          ></div>
        </label>

        <!-- Main -->
        <label class="inline-flex items-center cursor-pointer" title="Mark as main">
          <input
            type="checkbox"
            :checked="team.is_main"
            @change="toggleMain(team)"
            class="sr-only peer"
          />
          <div
            class="relative w-11 h-6 bg-gray-200 rounded
                   peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300
                   dark:peer-focus:ring-amber-800 dark:bg-gray-700
                   after:content-[''] after:absolute after:top-[2px] after:start-[2px]
                   after:bg-white after:border-gray-300 after:border after:rounded
                   after:h-5 after:w-5 after:transition-all
                   peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full
                   peer-checked:bg-amber-500"
          ></div>
        </label>
      </div>

      <img :src="`/storage/${team.image}`" alt="Team Image" class="w-full h-80 object-cover" />

      <div
        class="absolute inset-0 bg-black/70 opacity-0 group-hover:opacity-100 transition-opacity duration-300
               flex flex-col items-center justify-center text-white p-4 text-center"
      >
        <h3 class="text-lg font-semibold mb-1">{{ team.name }}</h3>
        <p v-if="team.type" class="text-xs uppercase tracking-wide text-emerald-300">{{ team.type.name }}</p>
        <div class="flex space-x-4 text-sm mt-4">
          <button @click="editTeam(team)" class="text-white"><i class="fa-solid fa-pen"></i></button>
          <button @click="showDeleteConfirmation(team)" class="text-rose-500"><i class="fa-solid fa-trash"></i></button>
        </div>
      </div>
    </div>
  </div>
</div>


    <!-- Backdrop -->
    <div v-if="drawerOpen" class="fixed inset-0 z-[990] bg-black/40" @click="closeDrawer"></div>

    <!-- Drawer -->
    <div :class="['fixed top-0 right-0 z-[990] h-screen w-96 transition-transform bg-white dark:bg-gray-800 p-6 overflow-y-auto', drawerOpen ? 'translate-x-0' : 'translate-x-full']">
      <div class="flex justify-between items-center mb-4">
        <h5 class="text-lg font-bold text-gray-800 dark:text-white">{{ editingId ? 'Edit Team' : 'Add Team' }}</h5>
        <button @click="closeDrawer" class="text-gray-500 hover:text-red-500">
          <i class="fa-solid fa-xmark text-xl"></i>
        </button>
      </div>

      <form @submit.prevent="saveTeam">
        <!-- Image Upload -->
        <div class="mb-6">
          <label class="block text-sm font-medium dark:text-white mb-1">Image</label>
          <div
            class="relative w-32 h-32 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center cursor-pointer bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:border-gray-600"
            @click="$refs.imageInput.click()"
          >
            <template v-if="previewImage">
              <img :src="previewImage" alt="Preview" class="w-full h-full object-cover rounded-lg" />
              <button
                @click.stop="removeImage"
                type="button"
                class="absolute top-1 right-1 bg-red-600 hover:bg-red-700 text-white rounded-full p-1 text-xs"
              >
                <i class="fa-solid fa-xmark"></i>
              </button>
            </template>
            <template v-else>
              <span class="text-sm text-gray-400 dark:text-gray-300 text-center px-2">Click to upload</span>
            </template>
          </div>
          <input type="file" accept="image/*" ref="imageInput" @change="handleImageUpload" class="hidden" />
        </div>

        <!-- Team Type -->
        <div class="relative mb-5">
          <select
            v-model="form.team_type_id"
            id="team-type"
            required
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"
          >
            <option class="text-black" disabled value="">Select a team type</option>
            <option class="text-black" v-for="t in teamTypes" :key="t.id" :value="t.id">{{ t.name }}</option>
          </select>
          <label
            for="team-type"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2
            peer-focus:px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500
            peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
            peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
          >
            Team Type
          </label>
        </div>

        <!-- Name -->
        <div class="relative mb-5">
          <input
            v-model="form.name"
            type="text"
            id="team-name"
            placeholder=" "
            required
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"
          />
          <label for="team-name" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2
                 peer-focus:px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500
                 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
            Team Name
          </label>
        </div>

        <!-- Socials -->
        <div class="relative mb-5">
          <input v-model="form.facebook" type="url" id="facebook" placeholder=" " class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer" />
          <label for="facebook" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">Facebook</label>
        </div>

        <div class="relative mb-5">
          <input v-model="form.instagram" type="url" id="instagram" placeholder=" " class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer" />
          <label for="instagram" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">Instagram</label>
        </div>

        <div class="relative mb-5">
          <input v-model="form.linkedin" type="url" id="linkedin" placeholder=" " class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer" />
          <label for="linkedin" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">LinkedIn</label>
        </div>

        <!-- Description -->
        <div class="relative mb-5">
          <textarea v-model="form.description" id="team-description" rows="3" placeholder=" " class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"></textarea>
          <label for="team-description" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">Description</label>
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white py-2 rounded">
          {{ editingId ? 'Update Team' : 'Add Team' }}
        </button>
      </form>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 z-[1001] bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-[90%] max-w-md shadow-xl">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Delete Team</h2>
        <p class="text-gray-600 dark:text-gray-300 mb-6">
          Are you sure you want to delete <span class="font-semibold">{{ teamToDelete?.name }}</span>?
        </p>
        <div class="flex justify-end gap-3">
          <button @click="cancelDeleteTeam" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">Cancel</button>
          <button @click="confirmDeleteTeam" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">Yes, Delete</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import { useToast } from 'vue-toastification'

const toast = useToast()
const teams = ref([])
const teamTypes = ref([])
const drawerOpen = ref(false)
const editingId = ref(null)
const showDeleteModal = ref(false)
const teamToDelete = ref(null)
const previewImage = ref(null)

const form = ref({
  name: '', description: '', image: null,
  facebook: '', instagram: '', linkedin: '',
  team_type_id: '',
  is_main: false,                   // ⬅️ new
})

const fetchTeams = async () => {
  const res = await axios.get('/api/teams', { params: { ordered: true }})
  teams.value = res.data
}

const mainTeams  = computed(() => teams.value.filter(t => t.is_main))
const otherTeams = computed(() => teams.value.filter(t => !t.is_main))

// toggles
const toggleShowOnHome = async (team) => {
  try {
    await axios.put(`/api/teams/${team.id}/toggle-status`)
    toast.success('Team status updated')
    fetchTeams()
  } catch { toast.error('Failed to update status') }
}

const toggleMain = async (team) => {
  try {
    await axios.put(`/api/teams/${team.id}/toggle-main`)
    toast.success(team.is_main ? 'Removed from main' : 'Marked as main')
    fetchTeams()
  } catch { toast.error('Failed to update main flag') }
}

// drawer helpers
const openDrawer = () => { resetForm(); drawerOpen.value = true }
const closeDrawer = () => { drawerOpen.value = false; editingId.value = null }
const resetForm = () => {
  form.value = { name:'', description:'', image:null, facebook:'', instagram:'', linkedin:'', team_type_id:'', is_main:false }
  previewImage.value = null; editingId.value = null
}
const handleImageUpload = (e) => {
  const file = e.target.files[0]; if (!file) return
  form.value.image = file; previewImage.value = URL.createObjectURL(file)
}
const removeImage = () => { form.value.image = null; previewImage.value = null }

const saveTeam = async () => {
  const fd = new FormData()
  Object.entries(form.value).forEach(([k, v]) => {
    if (v !== null && v !== undefined) fd.append(k, v)
  })
  try {
    if (editingId.value) {
      fd.append('_method', 'PUT')
      await axios.post(`/api/teams/${editingId.value}`, fd)
      toast.success('Team updated')
    } else {
      await axios.post('/api/teams', fd)
      toast.success('Team created')
    }
    await fetchTeams(); closeDrawer()
  } catch (err) { toast.error(err?.response?.data?.message || 'Error saving team') }
}

const editTeam = (team) => {
  form.value = {
    name: team.name,
    description: team.description ?? '',
    facebook: team.facebook ?? '',
    instagram: team.instagram ?? '',
    linkedin: team.linkedin ?? '',
    team_type_id: team.team_type_id ?? '',
    is_main: !!team.is_main,            // ⬅️ prefill
    image: null,
  }
  previewImage.value = team.image ? `/storage/${team.image}` : null
  editingId.value = team.id
  drawerOpen.value = true
}

const showDeleteConfirmation = (team) => { teamToDelete.value = team; showDeleteModal.value = true }
const cancelDeleteTeam = () => { teamToDelete.value = null; showDeleteModal.value = false }
const confirmDeleteTeam = async () => {
  try { await axios.delete(`/api/teams/${teamToDelete.value.id}`); toast.success('Team deleted'); fetchTeams() }
  catch { toast.error('Error deleting team') }
  finally { cancelDeleteTeam() }
}

const fetchTeamTypes = async () => {
  const res = await axios.get('/api/team-types')
  teamTypes.value = res.data
}

onMounted(async () => { await Promise.all([fetchTeams(), fetchTeamTypes()]) })
</script>
