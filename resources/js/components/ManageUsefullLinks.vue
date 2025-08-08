<template>
  <div>
    <!-- Header -->
    <div class="justify-between flex w-full p-4 bg-white dark:bg-gray-800 shadow-soft-xl rounded-xl pb-2">
      <h4 class="dark:text-white text-lg">Useful Links</h4>
      <button @click="openDrawer" class="px-4 py-1.5 bg-gray-800 text-white dark:bg-green-500 rounded-full text-sm font-semibold">
        Add Link
      </button>
    </div>

    <!-- Cards -->
    <div class="relative overflow-x-auto mt-7 sm:rounded-lg">
      <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <div v-for="link in links" :key="link.id" class="relative group rounded-lg overflow-hidden shadow-lg">
          <img :src="imageUrl(link.image)" alt="Link Image" class="w-full h-64 object-contain" />
          <div class="absolute inset-0 bg-black/70 opacity-0 group-hover:opacity-100 transition-opacity duration-300
                      flex flex-col items-center justify-center text-white p-4 text-center">
            <h3 class="text-base font-semibold mb-1 break-words">{{ link.title }}</h3>
            <p class="text-xs break-all">{{ link.url }}</p>
            <div class="flex space-x-4 text-sm mt-4">
              <button @click="editLink(link)" class="text-white"><i class="fa-solid fa-pen"></i></button>
              <button @click="showDeleteConfirmation(link)" class="text-rose-500"><i class="fa-solid fa-trash"></i></button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Backdrop -->
    <div v-if="drawerOpen" class="fixed inset-0 z-[990] bg-black/40" @click="closeDrawer"></div>

    <!-- Drawer -->
    <div :class="['fixed top-0 right-0 z-[991] h-screen w-96 transition-transform bg-white dark:bg-gray-800 p-6 overflow-y-auto',
                  drawerOpen ? 'translate-x-0' : 'translate-x-full']">
      <div class="flex justify-between items-center mb-4">
        <h5 class="text-lg font-bold text-gray-800 dark:text-white">{{ editingId ? 'Edit Link' : 'Add Link' }}</h5>
        <button @click="closeDrawer" class="text-gray-500 hover:text-red-500">
          <i class="fa-solid fa-xmark text-xl"></i>
        </button>
      </div>

      <form @submit.prevent="saveLink">
        <!-- Image -->
        <div class="mb-6">
          <label class="block text-sm font-medium dark:text-white mb-1">Image</label>
          <div
            class="relative w-32 h-32 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center cursor-pointer
                   bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:border-gray-600"
            @click="$refs.imageInput.click()">
            <template v-if="previewImage">
              <img :src="previewImage" alt="Preview" class="w-full h-full object-cover rounded-lg" />
              <button
                @click.stop="removeImage" type="button"
                class="absolute top-1 right-1 bg-red-600 hover:bg-red-700 text-white rounded-full p-1 text-xs">
                <i class="fa-solid fa-xmark"></i>
              </button>
            </template>
            <template v-else>
              <span class="text-sm text-gray-400 dark:text-gray-300 text-center px-2">Click to upload</span>
            </template>
          </div>
          <input type="file" accept="image/*" ref="imageInput" @change="handleImageUpload" class="hidden" />
        </div>

        <!-- Title -->
        <div class="relative mb-5">
          <input
            v-model="form.title" type="text" id="link-title" placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300
                   dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"
            required />
          <label
            for="link-title"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10
                   origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500
                   peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                   peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
            Title
          </label>
        </div>

        <!-- URL -->
        <div class="relative mb-5">
          <input
            v-model="form.url" type="url" id="link-url" placeholder="https://example.com"
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300
                   dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"
            required />
          <label
            for="link-url"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10
                   origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500
                   peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                   peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
            URL
          </label>
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white py-2 rounded">
          {{ editingId ? 'Update Link' : 'Add Link' }}
        </button>
      </form>
    </div>

    <!-- Delete Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 z-[1001] bg-black/50 flex items-center justify-center">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-[90%] max-w-md shadow-xl">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Delete Link</h2>
        <p class="text-gray-600 dark:text-gray-300 mb-6">
          Are you sure you want to delete <span class="font-semibold break-words">{{ linkToDelete?.title }}</span>?
        </p>
        <div class="flex justify-end gap-3">
          <button @click="cancelDelete" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">Cancel</button>
          <button @click="confirmDelete" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">Yes, Delete</button>
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

const links = ref([])
const drawerOpen = ref(false)
const editingId = ref(null)
const previewImage = ref(null)
const showDeleteModal = ref(false)
const linkToDelete = ref(null)

const form = ref({
  title: '',
  url: '',
  image: null, // File or null
})

const imageUrl = (path) => path ? `/storage/${path}` : '/placeholder.jpg'

const fetchLinks = async () => {
  const { data } = await axios.get('/api/useful-links')
  links.value = data
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
  form.value = { title: '', url: '', image: null }
  previewImage.value = null
  editingId.value = null
}

const handleImageUpload = (e) => {
  const file = e.target.files?.[0]
  if (file) {
    form.value.image = file
    previewImage.value = URL.createObjectURL(file)
  }
}
const removeImage = () => {
  form.value.image = null
  previewImage.value = null
}

const saveLink = async () => {
  const fd = new FormData()
  Object.entries(form.value).forEach(([k, v]) => {
    if (v !== null && v !== undefined) fd.append(k, v)
  })

  try {
    if (editingId.value) {
      fd.append('_method', 'PUT')
      await axios.post(`/api/useful-links/${editingId.value}`, fd)
      toast.success('Link updated')
    } else {
      await axios.post('/api/useful-links', fd)
      toast.success('Link created')
    }
    await fetchLinks()
    closeDrawer()
  } catch (e) {
    toast.error(e?.response?.data?.message || 'Error saving link')
  }
}

const editLink = (link) => {
  form.value = { title: link.title, url: link.url, image: null }
  previewImage.value = imageUrl(link.image)
  editingId.value = link.id
  drawerOpen.value = true
}

const showDeleteConfirmation = (link) => {
  linkToDelete.value = link
  showDeleteModal.value = true
}
const cancelDelete = () => {
  linkToDelete.value = null
  showDeleteModal.value = false
}
const confirmDelete = async () => {
  try {
    await axios.delete(`/api/useful-links/${linkToDelete.value.id}`)
    toast.success('Link deleted')
    await fetchLinks()
  } catch {
    toast.error('Error deleting link')
  } finally {
    cancelDelete()
  }
}

onMounted(fetchLinks)
</script>
