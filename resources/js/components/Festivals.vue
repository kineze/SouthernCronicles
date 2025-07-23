<template>
  <div>
    <!-- Header -->
    <div class="justify-between flex w-full p-4 bg-white shadow-soft-xl rounded-xl dark:bg-gray-800 pb-2">
      <h4 class="dark:text-white text-lg">All Festivals</h4>
      <button @click="openDrawer()" class="px-4 py-1.5 bg-gray-800 text-white dark:bg-green-500 rounded-full text-sm font-semibold">
        New Festival
      </button>
    </div>

    <!-- Table -->
    <div class="relative overflow-x-auto shadow-md mt-7 sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th class="px-6 py-3 dark:text-white font-semibold">Festival Name</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Start</th>
            <th class="px-6 py-3 dark:text-white font-semibold">End</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Location</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="festival in festivals" :key="festival.id" class="border-b dark:border-gray-700">
            <td class="px-6 py-4 dark:text-white font-semibold">{{ festival.name }}</td>
            <td class="px-6 py-4 dark:text-white font-semibold">{{ formatDate(festival.start_at) }}</td>
            <td class="px-6 py-4 dark:text-white font-semibold">{{ formatDate(festival.end_at) }}</td>
            <td class="px-6 py-4 dark:text-white font-semibold">{{ festival.location }}</td>
            <td class="px-6 py-4 text-right flex gap-3 justify-end">
              <button @click="editFestival(festival)" class="text-blue-500"><i class="fa-solid fa-pen"></i></button>
              <button @click="showDeleteConfirmation(festival)" class="text-red-500"><i class="fa-solid fa-trash"></i></button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Drawer -->
    <div :class="['fixed top-0 right-0 z-[990] h-screen w-96 transition-transform bg-white dark:bg-gray-800 p-6 overflow-y-auto', drawerOpen ? 'translate-x-0' : 'translate-x-full']">
      <div class="flex justify-between items-center mb-4">
        <h5 class="text-lg font-bold text-gray-800 dark:text-white">{{ editingId ? 'Edit Festival' : 'New Festival' }}</h5>
        <button @click="closeDrawer()" class="text-gray-500 hover:text-red-500">
          <i class="fa-solid fa-xmark text-xl"></i>
        </button>
      </div>

        <form @submit.prevent="saveFestival">
        <!-- Festival Name -->
        <div class="relative mb-5">
            <input
            v-model="form.name"
            type="text"
            id="festival_name"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
            required
            />
            <label
            for="festival_name"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
            >Festival Name</label>
        </div>

        <!-- Start Date & Time -->
        <div class="relative mb-5">
            <input
            v-model="form.start_at"
            type="datetime-local"
            id="start_at"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
            required
            />
            <label
            for="start_at"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
            >Start Date & Time</label>
        </div>

        <!-- End Date & Time -->
        <div class="relative mb-5">
            <input
            v-model="form.end_at"
            type="datetime-local"
            id="end_at"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
            required
            />
            <label
            for="end_at"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
            >End Date & Time</label>
        </div>

        <!-- Location -->
        <div class="relative mb-6">
            <input
            v-model="form.location"
            type="text"
            id="location"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
            required
            />
            <label
            for="location"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
            >Location</label>
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white py-2 rounded">
            {{ editingId ? 'Update Festival' : 'Create Festival' }}
        </button>
        </form>


    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 z-[1001] bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-[90%] max-w-md shadow-xl">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Delete Festival</h2>
        <p class="text-gray-600 dark:text-gray-300 mb-6">
          Are you sure you want to delete <span class="font-semibold">{{ festivalToDelete?.name }}</span>?
        </p>
        <div class="flex justify-end gap-3">
          <button @click="cancelDeleteFestival" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">Cancel</button>
          <button @click="confirmDeleteFestival" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">Yes, Delete</button>
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

const festivals = ref([])
const drawerOpen = ref(false)
const editingId = ref(null)
const form = ref({
  name: '',
  start_at: '',
  end_at: '',
  location: ''
})

const showDeleteModal = ref(false)
const festivalToDelete = ref(null)

const fetchFestivals = async () => {
  const res = await axios.get('/api/festivals')
  festivals.value = res.data
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
  form.value = { name: '', start_at: '', end_at: '', location: '' }
  editingId.value = null
}

const saveFestival = async () => {
  try {
    if (editingId.value) {
      await axios.put(`/api/festivals/${editingId.value}`, form.value)
      toast.success('Festival updated')
    } else {
      await axios.post('/api/festivals', form.value)
      toast.success('Festival created')
    }
    fetchFestivals()
    closeDrawer()
  } catch (err) {
    toast.error('Error saving festival')
  }
}

const editFestival = (festival) => {
  form.value = { ...festival }
  editingId.value = festival.id
  drawerOpen.value = true
}

const showDeleteConfirmation = (festival) => {
  festivalToDelete.value = festival
  showDeleteModal.value = true
}

const cancelDeleteFestival = () => {
  festivalToDelete.value = null
  showDeleteModal.value = false
}

const confirmDeleteFestival = async () => {
  try {
    await axios.delete(`/api/festivals/${festivalToDelete.value.id}`)
    toast.success('Festival deleted')
    fetchFestivals()
  } catch (error) {
    toast.error('Error deleting festival')
  } finally {
    cancelDeleteFestival()
  }
}

const formatDate = (dt) => new Date(dt).toLocaleString()

onMounted(() => fetchFestivals())
</script>
