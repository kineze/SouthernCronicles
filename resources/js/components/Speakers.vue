<template>
  <div>
    <!-- Header -->
    <div class="justify-between flex w-full p-4 bg-white shadow-soft-xl rounded-xl dark:bg-gray-800 pb-2">
      <h4 class="dark:text-white text-lg">All Speakers</h4>
      <button @click="openDrawer" class="px-4 py-1.5 bg-gray-800 text-white dark:bg-green-500 rounded-full text-sm font-semibold">
        Add Speaker
      </button>
    </div>


    <div class="relative overflow-x-auto  mt-7 sm:rounded-lg">
        <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
        <div v-for="speaker in speakers" :key="speaker.id" class="relative group rounded-lg overflow-hidden shadow-lg" >

            <div class="absolute top-2 right-2 z-[990]">
            <label class="inline-flex items-center cursor-pointer">
                <input
                type="checkbox"
                :checked="speaker.show_on_home"
                @change="toggleShowOnHome(speaker)"
                class="sr-only peer"
                />
                <div
                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300
                        dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700
                        peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full
                        peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px]
                        after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full
                        after:h-5 after:w-5 after:transition-all dark:border-gray-600
                        peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"
                ></div>
            </label>
            </div>

            <!-- Speaker Image -->
            <img :src="`/storage/${speaker.image}`"
                alt="Speaker"
                class="w-full h-80 object-cover"
            />


            <div class="absolute inset-0 bg-black bg-opacity-70 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center text-white p-4 text-center">

                <h3 class="text-lg font-semibold mb-2">{{ speaker.name }}</h3>

                <div class="flex space-x-4 text-xl">
                    <a
                    v-if="speaker.facebook"
                    :href="speaker.facebook"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="hover:text-blue-500 transition"
                    >
                    <i class="fa-brands fa-facebook"></i>
                    </a>

                    <a
                    v-if="speaker.instagram"
                    :href="speaker.instagram"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="hover:text-pink-500 transition"
                    >
                    <i class="fa-brands fa-instagram"></i>
                    </a>

                    <a
                    v-if="speaker.linkedin"
                    :href="speaker.linkedin"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="hover:text-blue-400 transition"
                    >
                    <i class="fa-brands fa-linkedin"></i>
                    </a>
                </div>
                <div class="flex space-x-4 text-sm mt-5">
                    <button @click="editSpeaker(speaker)" class="text-white"><i class="fa-solid fa-pen"></i></button>
                    <button @click="showDeleteConfirmation(speaker)" class="text-rose-500"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>
        </div>
        </div>

    </div>

    <!-- Drawer -->
    <div :class="['fixed top-0 right-0 z-[990] h-screen w-96 transition-transform bg-white dark:bg-gray-800 p-6 overflow-y-auto', drawerOpen ? 'translate-x-0' : 'translate-x-full']">
      <div class="flex justify-between items-center mb-4">
        <h5 class="text-lg font-bold text-gray-800 dark:text-white">{{ editingId ? 'Edit Speaker' : 'Add Speaker' }}</h5>
        <button @click="closeDrawer" class="text-gray-500 hover:text-red-500">
          <i class="fa-solid fa-xmark text-xl"></i>
        </button>
      </div>

        <form @submit.prevent="saveSpeaker">

        <div class="mb-6">
            <label class="block text-sm font-medium dark:text-white mb-1">Image</label>
            <div class="relative w-32 h-32 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center cursor-pointer bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:border-gray-600"
                @click="$refs.imageInput.click()">
                <template v-if="previewImage">
                <img :src="previewImage" alt="Preview" class="w-full h-full object-cover rounded-lg" />
                <button
                    @click.stop="removeImage"
                    type="button"
                    class="absolute top-1 right-1 bg-red-600 hover:bg-red-700 text-white rounded-full p-1 text-xs"
                    title="Remove image"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>
                </template>
                <template v-else>
                <span class="text-sm text-gray-400 dark:text-gray-300 text-center px-2">Click to upload</span>
                </template>
            </div>
            <input
                type="file"
                accept="image/*"
                ref="imageInput"
                @change="handleImageUpload"
                class="hidden"
            />
        </div>

        <!-- Name -->
        <div class="relative mb-5">
            <input
            v-model="form.name"
            type="text"
            id="name"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
            required
            />
            <label
            for="name"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 
            peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 
            peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 
            peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
            >Name</label>
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
            >Facebook</label>
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
            >Instagram</label>
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
            >LinkedIn</label>
        </div>

        <div class="relative mb-5">
            <select
                v-model="form.speaker_type_id"
                id="speaker_type"
                required
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
            >
                <option :value="null" disabled selected>Select Type</option>
                <option v-for="type in speakerTypes" :key="type.id" :value="type.id" class="text-black">
                {{ type.name }}
                </option>
            </select>
            <label
                for="speaker_type"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2
                peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500
                peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
            >
                Speaker Type
            </label>
        </div>


        <div class="relative mb-5">
            <textarea
                v-model="form.description"
                id="description"
                rows="3"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
            ></textarea>
            <label
                for="description"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2
                peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500
                peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
            >
                Description
            </label>
        </div>


        <!-- Submit -->
        <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white py-2 rounded">
            {{ editingId ? 'Update Speaker' : 'Add Speaker' }}
        </button>
        </form>

    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 z-[1001] bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-[90%] max-w-md shadow-xl">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Delete Speaker</h2>
        <p class="text-gray-600 dark:text-gray-300 mb-6">
          Are you sure you want to delete <span class="font-semibold">{{ speakerToDelete?.name }}</span>?
        </p>
        <div class="flex justify-end gap-3">
          <button @click="cancelDeleteSpeaker" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">Cancel</button>
          <button @click="confirmDeleteSpeaker" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">Yes, Delete</button>
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
const speakers = ref([])
const drawerOpen = ref(false)
const editingId = ref(null)
const showDeleteModal = ref(false)
const speakerToDelete = ref(null)
const previewImage = ref(null)
const form = ref({
  name: '',
  facebook: '',
  instagram: '',
  linkedin: '',
  description: '',
  speaker_type_id: null,
  show_on_home: false,
  image: null
})


const speakerTypes = ref([])

const fetchSpeakerTypes = async () => {
  const res = await axios.get('/api/speaker-types')
  speakerTypes.value = res.data
}


const fetchSpeakers = async () => {
  const res = await axios.get('/api/speakers')
  speakers.value = res.data
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
  form.value = { name: '', facebook: '', instagram: '', linkedin: '', image: null }
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

const saveSpeaker = async () => {
  const formData = new FormData()
  for (const key in form.value) {
    if (form.value[key] !== null) formData.append(key, form.value[key])
  }

  try {
    if (editingId.value) {
      formData.append('_method', 'PUT')
      await axios.post(`/api/speakers/${editingId.value}`, formData)
      toast.success('Speaker updated')
    } else {
      await axios.post('/api/speakers', formData)
      toast.success('Speaker created')
    }
    fetchSpeakers()
    closeDrawer()
  } catch (err) {
    toast.error('Error saving speaker')
  }
}

const editSpeaker = (speaker) => {
    form.value = {
        name: speaker.name,
        facebook: speaker.facebook,
        instagram: speaker.instagram,
        linkedin: speaker.linkedin,
        description: speaker.description,
        speaker_type_id: speaker.speaker_type_id,
        show_on_home: speaker.show_on_home,
        image: null
    }
    previewImage.value = `/storage/${speaker.image}`
    editingId.value = speaker.id
    drawerOpen.value = true
}

const showDeleteConfirmation = (speaker) => {
  speakerToDelete.value = speaker
  showDeleteModal.value = true
}

const cancelDeleteSpeaker = () => {
  speakerToDelete.value = null
  showDeleteModal.value = false
}

const confirmDeleteSpeaker = async () => {
  try {
    await axios.delete(`/api/speakers/${speakerToDelete.value.id}`)
    toast.success('Speaker deleted')
    fetchSpeakers()
  } catch (error) {
    toast.error('Error deleting speaker')
  } finally {
    cancelDeleteSpeaker()
  }
}

const toggleShowOnHome = async (speaker) => {
  try {
    await axios.put(`/api/speakers/${speaker.id}`, {
        show_on_home: !speaker.show_on_home,
        name: speaker.name,
        facebook: speaker.facebook,
        instagram: speaker.instagram,
        linkedin: speaker.linkedin,
        description: speaker.description,
        speaker_type_id: speaker.speaker_type_id
    })
    toast.success('Updated home preview status')
    fetchSpeakers()
  } catch (err) {
    toast.error('Error toggling home preview')
  }
}

onMounted(() => {
  fetchSpeakers()
  fetchSpeakerTypes()
})
</script>

