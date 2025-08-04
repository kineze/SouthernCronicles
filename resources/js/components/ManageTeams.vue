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
    <div class="relative overflow-x-auto mt-7 sm:rounded-lg">
      <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <div v-for="team in teams" :key="team.id" class="relative group rounded-lg overflow-hidden shadow-lg">
            <div class="absolute top-2 right-2 z-[990]">
                <label class="inline-flex items-center cursor-pointer">
                    <input
                    type="checkbox"
                    :checked="team.show_on_home"
                    @change="toggleShowOnHome(team)"
                    class="sr-only peer"
                    />
                    <div
                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300
                            dark:peer-focus:ring-green-800 rounded peer dark:bg-gray-700
                            peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full
                            peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px]
                            after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded
                            after:h-5 after:w-5 after:transition-all dark:border-gray-600
                            peer-checked:bg-green-600 dark:peer-checked:bg-green-600"
                    ></div>
                </label>
            </div>
          <img :src="`/storage/${team.image}`" alt="Team Image" class="w-full h-80 object-cover" />
          <div class="absolute inset-0 bg-black bg-opacity-70 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center text-white p-4 text-center">
            <h3 class="text-lg font-semibold mb-2">{{ team.name }}</h3>
            <!-- <p class="text-sm mb-2">{{ team.description }}</p> -->
            <div class="flex space-x-4 text-sm mt-4">
              <button @click="editTeam(team)" class="text-white"><i class="fa-solid fa-pen"></i></button>
              <button @click="showDeleteConfirmation(team)" class="text-rose-500"><i class="fa-solid fa-trash"></i></button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Drawer -->
     <div v-if="drawerOpen" class="fixed inset-0 z-[990] bg-black bg-opacity-40" @click="closeDrawer"></div>
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

        <!-- Name -->
        <div class="relative mb-5">
          <input
            v-model="form.name"
            type="text"
            id="team-name"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
            required
          />
          <label
            for="team-name"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2
            peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500
            peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
            peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
          >
            Team Name
          </label>
        </div>

        <!-- Facebook -->
        <div class="relative mb-5">
          <input
            v-model="form.facebook"
            type="text"
            id="facebook"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
          />
          <label
            for="facebook"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2
            peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500
            peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
            peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
          >
            Facebook
          </label>
        </div>

        <!-- Instagram -->
        <div class="relative mb-5">
          <input
            v-model="form.instagram"
            type="text"
            id="instagram"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
          />
          <label
            for="instagram"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2
            peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500
            peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
            peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
          >
            Instagram
          </label>
        </div>

        <!-- LinkedIn -->
        <div class="relative mb-5">
          <input
            v-model="form.linkedin"
            type="text"
            id="linkedin"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
          />
          <label
            for="linkedin"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2
            peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500
            peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
            peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
          >
            LinkedIn
          </label>
        </div>

        <!-- Description -->
        <div class="relative mb-5">
          <textarea
            v-model="form.description"
            id="team-description"
            rows="3"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
          ></textarea>
          <label
            for="team-description"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2
            peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500
            peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
            peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
          >
            Description
          </label>
        </div>

        <!-- Show on Home Toggle -->
        <!-- <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Show on Home</label>
          <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" v-model="form.show_on_home" class="sr-only peer" />
            <div
              class="relative w-11 h-6 bg-gray-200 rounded-full peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:bg-blue-600"
            >
              <div
                class="absolute top-[2px] left-[2px] bg-white w-5 h-5 rounded-full transition-transform peer-checked:translate-x-full"
              ></div>
            </div>
          </label>
        </div> -->

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
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useToast } from 'vue-toastification'

const toast = useToast()
const teams = ref([])
const drawerOpen = ref(false)
const editingId = ref(null)
const showDeleteModal = ref(false)
const teamToDelete = ref(null)
const previewImage = ref(null)

const form = ref({
  name: '',
  description: '',
  image: null,
  facebook: '',
  instagram: '',
  linkedin: ''
})

const fetchTeams = async () => {
  const res = await axios.get('/api/teams')
  teams.value = res.data
}

const openDrawer = () => {
  resetForm()
  drawerOpen.value = true
}

const closeDrawer = () => {
  drawerOpen.value = false
  editingId.value = null
}

const resetForm = () => {
  form.value = { name: '', description: '', image: null }
  previewImage.value = null
  editingId.value = null
}

const handleImageUpload = (e) => {
  const file = e.target.files[0]
  if (file) {
    form.value.image = file
    previewImage.value = URL.createObjectURL(file)
  }
}

const removeImage = () => {
  form.value.image = null
  previewImage.value = null
}

const saveTeam = async () => {
  const formData = new FormData()
  for (const key in form.value) {
    if (form.value[key] !== null) formData.append(key, form.value[key])
  }

  try {
    if (editingId.value) {
      formData.append('_method', 'PUT')
      await axios.post(`/api/teams/${editingId.value}`, formData)
      toast.success('Team updated')
    } else {
      await axios.post('/api/teams', formData)
      toast.success('Team created')
    }
    fetchTeams()
    closeDrawer()
  } catch (err) {
    toast.error('Error saving team')
  }
}

const toggleShowOnHome = async (team) => {
  try {
    await axios.put(`/api/teams/${team.id}/toggle-status`)
    toast.success('Team status updated')
    fetchTeams()
  } catch (err) {
    toast.error('Failed to update status')
  }
}


const editTeam = (team) => {
  form.value = {
    name: team.name,
    description: team.description,
    facebook: team.facebook ?? '',
    instagram: team.instagram ?? '',
    linkedin: team.linkedin ?? '',
    image: null
  }
  previewImage.value = `/storage/${team.image}`
  editingId.value = team.id
  drawerOpen.value = true
}

const showDeleteConfirmation = (team) => {
  teamToDelete.value = team
  showDeleteModal.value = true
}

const cancelDeleteTeam = () => {
  teamToDelete.value = null
  showDeleteModal.value = false
}

const confirmDeleteTeam = async () => {
  try {
    await axios.delete(`/api/teams/${teamToDelete.value.id}`)
    toast.success('Team deleted')
    fetchTeams()
  } catch (error) {
    toast.error('Error deleting team')
  } finally {
    cancelDeleteTeam()
  }
}

onMounted(() => {
  fetchTeams()
})
</script>

