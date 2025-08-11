<template>
  <div>
    <div class="flex justify-between p-4 bg-white dark:bg-gray-800 dark:shadow-soft-dark-xl shadow rounded-xl">
      <h4 class="text-lg font-semibold dark:text-white">Partners</h4>
      <button @click="openDrawer"  class="px-4 py-1.5 bg-gray-800 text-white dark:bg-green-500 rounded-full text-sm font-semibold">Add Partner</button>
    </div>

    <div class="relative overflow-x-auto mt-6 sm:rounded-lg px-4">
      <draggable
        v-model="partners"
        item-key="id"
        group="partners"
        handle=".drag-handle"
        ghost-class="bg-yellow-100"
        @end="onDragEnd"
        class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
      >
        <template #item="{ element: partner }">
          <div class="relative bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden">
            <!-- drag handle -->
            <div class="absolute top-2 left-2 z-10 cursor-move drag-handle text-gray-600 dark:text-gray-300">
              <i class="fa-solid fa-up-down"></i>
            </div>

            <img :src="`/storage/${partner.image}`" alt="Partner"
                 class="w-full h-40 object-cover bg-white" />
            <div class="p-4 text-center">
              <p v-if="partner.partner_type?.name" class="text-xs text-gray-500 mt-1">
                {{ partner.partner_type.name }}
              </p>
              <h5 class="font-medium dark:text-white">{{ partner.title }}</h5>

              <div class="flex justify-center mt-2 gap-3">
                <button @click="editPartner(partner)" class="text-green-600"><i class="fa fa-pen"></i></button>
                <button @click="confirmDelete(partner)" class="text-red-600"><i class="fa fa-trash"></i></button>
              </div>

            </div>
          </div>
        </template>
      </draggable>
    </div>

    <!-- Drawer -->
     <div v-if="drawerOpen" class="fixed inset-0 z-[990] bg-black bg-opacity-40" @click="closeDrawer"></div>
    <div :class="['fixed top-0 right-0 w-96 h-screen z-[990] bg-white dark:bg-gray-800 shadow-lg transform transition-transform overflow-y-auto p-6', drawerOpen ? 'translate-x-0' : 'translate-x-full']">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-bold dark:text-white">{{ editingId ? 'Edit Partner' : 'Add Partner' }}</h3>
        <button @click="closeDrawer" class="text-gray-500 hover:text-red-600"><i class="fa fa-times"></i></button>
      </div>

      <form @submit.prevent="savePartner">

        <div class="mb-5">
          <label class="block text-sm font-medium dark:text-white mb-1">Logo</label>
          <div class="relative w-32 h-32 border border-dashed rounded bg-gray-50 dark:bg-gray-700 cursor-pointer flex items-center justify-center" @click="$refs.imageInput.click()">
            <template v-if="previewImage">
              <img :src="previewImage" class="w-full h-full object-contain" />
              <button @click.stop="removeImage" class="absolute top-0 right-0 bg-red-600 text-white p-1 rounded-full text-xs"><i class="fa fa-xmark"></i></button>
            </template>
            <template v-else>
              <span class="text-sm text-gray-400">Click to upload</span>
            </template>
          </div>
          <input ref="imageInput" type="file" class="hidden" @change="handleImageUpload" accept="image/*" />
        </div>

        <div class="mb-5">
          <label class="block text-sm font-medium dark:text-white mb-1">Partner Type</label>
          <select
            v-model="form.partner_type_id"
            class="w-full px-3 py-2 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 dark:text-white"
          >
            <option disabled class="text-black dark:text-white">Select Type</option>
            <option v-for="t in types" :key="t.id" :value="String(t.id)">
              {{ t.name }}
            </option>
          </select>
        </div>

        <div class="relative mb-5">
        <input
            v-model="form.title"
            type="text"
            id="title"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"
            required
        />
        <label
            for="title"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 
            peer-focus:px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500 
            peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 
            peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
        >
            Title
        </label>
        </div>

        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded">{{ editingId ? 'Update' : 'Create' }}</button>
      </form>
    </div>

    <!-- Delete Confirmation -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[999]">
      <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-md w-full">
        <h3 class="text-lg font-semibold mb-3 dark:text-white">Delete Partner</h3>
        <p class="mb-4 dark:text-gray-300">Are you sure you want to delete <strong>{{ partnerToDelete?.title }}</strong>?</p>
        <div class="flex justify-end gap-3">
          <button @click="showDeleteModal = false" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
          <button @click="deletePartner" class="px-4 py-2 bg-red-600 text-white rounded">Delete</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useToast } from 'vue-toastification'
import draggable from 'vuedraggable'

const toast = useToast()

const partners = ref([])
const drawerOpen = ref(false)
const editingId = ref(null)
const showDeleteModal = ref(false)
const partnerToDelete = ref(null)
const previewImage = ref(null)
const form = ref({ title: '', image: null, partner_type_id: null })

const types = ref([])


const fetchTypes = async () => {
  try {
    const { data } = await axios.get('/api/partner-types?ordered=true')
    types.value = data
  } catch (e) {
    console.error(e.response?.data || e.message)
  }
}


const fetchPartners = async () => {
  const { data } = await axios.get('/api/partners?ordered=true') // ordered fetch
  partners.value = data
}

const onDragEnd = async () => {
  try {
    const ordered = partners.value.map((p, idx) => ({ id: p.id, order: idx }))
    await axios.post('/api/partners/reorder', { order: ordered })
    toast.success('Reordered successfully')
  } catch (e) {
    toast.error('Error saving order')
  }
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
  form.value = { title: '', image: null, partner_type_id: null }
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

const savePartner = async () => {
  const formData = new FormData()
  for (const key in form.value) {
    // include null as empty string so backend sees the key
    const v = form.value[key]
    formData.append(key, v == null ? '' : v)
  }

  try {
    if (editingId.value) {
      formData.append('_method', 'PUT')
      await axios.post(`/api/partners/${editingId.value}`, formData)
      toast.success('Partner updated')
    } else {
      await axios.post('/api/partners', formData)
      toast.success('Partner created')
    }
    fetchPartners()
    closeDrawer()
  } catch (error) {
    toast.error('Error saving partner')
  }
}

const editPartner = (partner) => {
  editingId.value = partner.id
  form.value = {
    title: partner.title,
    image: null,
    partner_type_id: partner.partner_type_id ?? null
  }
  previewImage.value = `/storage/${partner.image}`
  drawerOpen.value = true
}


const confirmDelete = (partner) => {
  partnerToDelete.value = partner
  showDeleteModal.value = true
}

const deletePartner = async () => {
  try {
    await axios.delete(`/api/partners/${partnerToDelete.value.id}`)
    toast.success('Partner deleted')
    fetchPartners()
  } catch {
    toast.error('Error deleting partner')
  } finally {
    showDeleteModal.value = false
  }
}

onMounted(() => {
  fetchPartners()
  fetchTypes()
})

</script>