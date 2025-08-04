<template>
  <div>

    <div class="justify-between flex w-full p-4 bg-white dark:shadow-soft-dark-xl shadow-soft-xl rounded-xl dark:bg-gray-800 pb-2">
      <h4 class="dark:text-white text-lg">Speaker Types</h4>
      <button @click="openDrawer" class="px-4 py-1.5 bg-gray-800 text-white dark:bg-green-500 rounded-full text-sm font-semibold">
        Add Speaker
      </button>
    </div>

    
    <div class="relative overflow-x-auto shadow-md mt-7 sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th class="px-6 py-3 dark:text-white font-semibold">Type Name</th>

            <th class="px-6 py-3 dark:text-white font-semibold">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="speakerType in speakerTypes" :key="speakerType.id" class="border-b dark:border-gray-700">
            <td class="px-6 py-4 dark:text-white font-semibold">{{ speakerType.name }}</td>
            
            <td class="px-6 py-4 text-right flex gap-3 justify-end">
                <button @click="editFestival(speakerType)" class="text-green-500">
                    <i class="fa-solid fa-pen"></i>
                    </button>

                    <button @click="showDeleteConfirmation(speakerType)" class="text-red-500">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>


    <div v-if="drawerOpen" class="fixed inset-0 z-[990] bg-black bg-opacity-40" @click="closeDrawer"></div>
    <div :class="['fixed top-0 right-0 z-[990] h-screen w-96 transition-transform bg-white dark:bg-gray-800 p-6 overflow-y-auto', drawerOpen ? 'translate-x-0' : 'translate-x-full']">
      <div class="flex justify-between items-center mb-4">
        <h5 class="text-lg font-bold text-gray-800 dark:text-white">{{ editingId ? 'Edit speakerType' : 'New speakerType' }}</h5>
        <button @click="closeDrawer()" class="text-gray-500 hover:text-red-500">
          <i class="fa-solid fa-xmark text-xl"></i>
        </button>
      </div>

        <form @submit.prevent="saveSpeakerType">

            <div class="relative mb-5">
                <input
                v-model="form.name"
                type="text"
                id="speaker_type"
                placeholder=" "
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"
                required
                />
                <label
                for="speaker_type"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
                >Festival Name</label>
            </div>


            <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white py-2 rounded">
                {{ editingId ? 'Update speakerType' : 'Create speakerType' }}
            </button>
        </form>


    </div>


    <div v-if="showDeleteModal" class="fixed inset-0 z-[1001] bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-[90%] max-w-md shadow-xl">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Delete Speaker Type</h2>
        <p class="text-gray-600 dark:text-gray-300 mb-6">
          Are you sure you want to delete <span class="font-semibold">{{ speakerTypeToDelete?.name }}</span>?
        </p>
        <div class="flex justify-end gap-3">
          <button @click="cancelDeleteSpeakerType" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">Cancel</button>
          <button @click="confirmDeleteSpeakerType" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">Yes, Delete</button>
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

const speakerTypes = ref([])
const drawerOpen = ref(false)
const editingId = ref(null)
const form = ref({ name: '' })
const showDeleteModal = ref(false)
const speakerTypeToDelete = ref(null)

const fetchSpeakerTypes = async () => {
  try {
    const { data } = await axios.get('/api/speaker-types')
    speakerTypes.value = data
  } catch (error) {
    toast.error('Failed to load speaker types.')
  }
}

const openDrawer = () => {
  drawerOpen.value = true
  form.value = { name: '' }
  editingId.value = null
}

const closeDrawer = () => {
  drawerOpen.value = false
}

const editFestival = (speakerType) => {
  drawerOpen.value = true
  editingId.value = speakerType.id
  form.value = { name: speakerType.name }
}

const saveSpeakerType = async () => {
  try {
    if (editingId.value) {
      await axios.put(`/api/speaker-types/${editingId.value}`, form.value)
      toast.success('Speaker type updated successfully.')
    } else {
      await axios.post('/api/speaker-types', form.value)
      toast.success('Speaker type created successfully.')
    }
    await fetchSpeakerTypes()
    closeDrawer()
  } catch (error) {
    toast.error('Failed to save speaker type.')
  }
}

const showDeleteConfirmation = (speakerType) => {
  speakerTypeToDelete.value = speakerType
  showDeleteModal.value = true
}

const cancelDeleteSpeakerType = () => {
  showDeleteModal.value = false
  speakerTypeToDelete.value = null
}

const confirmDeleteSpeakerType = async () => {
  if (!speakerTypeToDelete.value) return

  try {
    await axios.delete(`/api/speaker-types/${speakerTypeToDelete.value.id}`)
    toast.success('Speaker type deleted successfully.')
    await fetchSpeakerTypes()
  } catch (error) {
    toast.error('Failed to delete speaker type.')
  } finally {
    showDeleteModal.value = false
  }
}

onMounted(fetchSpeakerTypes)

</script>