<!-- resources/js/components/admin/AllFestivals.vue -->
<template>
  <div>
    <!-- Header -->
    <div class="justify-between flex w-full p-4 bg-white dark:bg-gray-800 dark:shadow-soft-dark-xl shadow-soft-xl rounded-xl pb-2">
      <h4 class="text-lg font-semibold dark:text-white">All Festivals</h4>
      <div class="flex items-center gap-2">
        <button
          v-if="orderDirty"
          :disabled="ordering"
          @click="persistOrder"
          class="px-4 py-1.5 rounded-full text-sm font-semibold border"
          :class="ordering ? 'bg-gray-200 text-gray-600' : 'bg-black text-white'"
          title="Save new order"
        >
          {{ ordering ? 'Saving…' : 'Save Order' }}
        </button>

        <button @click="openDrawer()" class="px-4 py-1.5 bg-gray-800 text-white dark:bg-green-500 rounded-full text-sm font-semibold">
          New Festival
        </button>
      </div>
    </div>

    <!-- Table -->
    <div class="relative overflow-x-auto shadow-md mt-7 sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th class="w-10 px-3 py-3 dark:text-white font-semibold"></th>
            <th class="px-6 py-3 dark:text-white font-semibold">Festival Name</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Start</th>
            <th class="px-6 py-3 dark:text-white font-semibold">End</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Location</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Default</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Actions</th>
          </tr>
        </thead>

        <!-- Draggable tbody -->
        <draggable
          v-model="festivals"
          item-key="id"
          tag="tbody"
          handle=".drag-handle"
          ghost-class="drag-ghost"
          animation="200"
          @start="dragging = true"
          @end="onDragEnd"
        >
          <template #item="{ element: festival }">
            <tr :key="festival.id" class="border-b dark:border-gray-700">
              <!-- Drag handle -->
              <td class="px-3 py-4 text-gray-400">
                <button class="drag-handle cursor-grab active:cursor-grabbing" title="Drag to reorder">
                  <i class="fa-solid fa-grip-lines text-lg"></i>
                </button>
              </td>

              <td class="px-6 py-4 dark:text-white font-semibold">
                <div class="flex items-center gap-3">
                  <img v-if="festival.image" :src="`/storage/${festival.image}`" class="w-10 h-10 rounded object-cover" alt="thumb" />
                  <div>
                    <div>{{ festival.name }}</div>
                    <a v-if="festival.site_url" :href="festival.site_url" target="_blank" rel="noopener" class="text-xs text-green-600 hover:underline">
                      {{ festival.site_url }}
                    </a>
                  </div>
                </div>
              </td>

              <td class="px-6 py-4 dark:text-white font-semibold">
                {{ formatTimeAMPM(festival.start_at) }}
              </td>
              <td class="px-6 py-4 dark:text-white font-semibold">
                {{ formatTimeAMPM(festival.end_at) }}
              </td>

              <td class="px-6 py-4 dark:text-white font-semibold">{{ festival.location }}</td>

              <td class="px-6 py-4">
                <label class="inline-flex items-center cursor-pointer">
                  <input
                    type="checkbox"
                    :checked="!!festival.is_default"
                    @change="toggleDefault(festival)"
                    class="sr-only peer"
                  />
                  <div
                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300
                          dark:peer-focus:ring-green-800 rounded peer dark:bg-gray-700
                          peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full
                          peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px]
                          after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded
                          after:h-5 after:w-5 after:transition-all dark:border-gray-600
                          peer-checked:bg-green-600 dark:peer-checked:bg-green-600">
                  </div>
                </label>
              </td>


              <td class="px-6 py-4 text-right flex gap-3 justify-end">
                <button @click="editFestival(festival)" class="text-green-500"><i class="fa-solid fa-pen"></i></button>
                <button @click="showDeleteConfirmation(festival)" class="text-red-500"><i class="fa-solid fa-trash"></i></button>
              </td>
            </tr>
          </template>
        </draggable>
      </table>
    </div>

    <!-- Backdrop -->
    <div v-if="drawerOpen" class="fixed inset-0 z-[990] bg-black bg-opacity-40" @click="closeDrawer"></div>

    <!-- Drawer -->
    <div :class="['fixed top-0 right-0 z-[990] h-screen w-96 transition-transform bg-white dark:bg-gray-800 p-6 overflow-y-auto', drawerOpen ? 'translate-x-0' : 'translate-x-full']">
      <div class="flex justify-between items-center mb-4">
        <h5 class="text-lg font-bold text-gray-800 dark:text-white">{{ editingId ? 'Edit Festival' : 'New Festival' }}</h5>
        <button @click="closeDrawer()" class="text-gray-500 hover:text-red-500">
          <i class="fa-solid fa-xmark text-xl"></i>
        </button>
      </div>

      <form @submit.prevent="saveFestival">
        <!-- Image -->
        <div class="mb-6">
          <label class="block text-sm font-medium dark:text-white mb-1">Image</label>
          <div
            class="relative w-32 h-32 border border-dashed rounded bg-gray-50 dark:bg-gray-700 cursor-pointer flex items-center justify-center"
            @click="$refs.imageInput.click()"
          >
            <template v-if="previewImage">
              <img :src="previewImage" class="w-full h-full object-contain" />
              <button
                @click.stop="removeImage"
                class="absolute top-0 right-0 bg-red-600 text-white p-1 rounded-full text-xs"
              >
                <i class="fa fa-xmark"></i>
              </button>
            </template>
            <template v-else>
              <span class="text-sm text-gray-400">Click to upload</span>
            </template>
          </div>
          <input ref="imageInput" type="file" class="hidden" @change="handleImageUpload" accept="image/*" />
        </div>

        <!-- Festival Name -->
        <div class="relative mb-5">
          <input
            v-model="form.name"
            type="text"
            id="festival_name"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"
            required
          />
          <label
            for="festival_name"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 bg-white dark:bg-gray-800 px-2"
          >Festival Name</label>
        </div>

        <!-- Start Date & Time -->
        <div class="relative mb-5">
          <input
            v-model="form.start_at"
            type="datetime-local"
            id="start_at"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"
            required
          />
          <label for="start_at" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 bg-white dark:bg-gray-800 px-2">
            Start Date & Time
          </label>
        </div>

        <!-- End Date & Time -->
        <div class="relative mb-5">
          <input
            v-model="form.end_at"
            type="datetime-local"
            id="end_at"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"
            required
          />
          <label for="end_at" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 bg-white dark:bg-gray-800 px-2">
            End Date & Time
          </label>
        </div>

        <!-- Location -->
        <div class="relative mb-5">
          <input
            v-model="form.location"
            type="text"
            id="location"
            placeholder=" "
            autocomplete="off"
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"
            required
          />
          <label for="location" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 bg-white dark:bg-gray-800 px-2">
            Location
          </label>
        </div>

        <!-- Site URL -->
        <div class="relative mb-5">
          <input
            v-model="form.site_url"
            type="url"
            id="site_url"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"
          />
          <label for="site_url" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 bg-white dark:bg-gray-800 px-2">
            Site URL (optional)
          </label>
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
import draggable from 'vuedraggable'

const toast = useToast()

const festivals = ref([])
const drawerOpen = ref(false)
const editingId = ref(null)
const ordering = ref(false)
const orderDirty = ref(false)
const dragging = ref(false)

const form = ref({
  name: '',
  start_at: '',
  end_at: '',
  location: '',
  site_url: '',
  image: null,
})

const previewImage = ref(null)

const showDeleteModal = ref(false)
const festivalToDelete = ref(null)

// ===== CRUD =====
const fetchFestivals = async () => {
  const res = await axios.get('/api/festivals', { params: { ordered: 1 } })
  festivals.value = Array.isArray(res.data) ? res.data : []
  orderDirty.value = false
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
  form.value = {
    name: '',
    start_at: '',
    end_at: '',
    location: '',
    site_url: '',
    image: null,
  }
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

const saveFestival = async () => {
  try {
    const fd = new FormData()
    fd.append('name', form.value.name)
    fd.append('start_at', form.value.start_at)
    fd.append('end_at', form.value.end_at)
    fd.append('location', form.value.location)
    fd.append('site_url', form.value.site_url || '')
    if (form.value.image) fd.append('image', form.value.image)

    if (editingId.value) {
      fd.append('_method', 'PUT')
      await axios.post(`/api/festivals/${editingId.value}`, fd, {
        headers: { 'Content-Type': 'multipart/form-data' }
      })
      toast.success('Festival updated')
    } else {
      await axios.post('/api/festivals', fd, {
        headers: { 'Content-Type': 'multipart/form-data' }
      })
      toast.success('Festival created')
    }

    await fetchFestivals()
    closeDrawer()
  } catch (err) {
    if (err.response?.status === 422) {
      console.error(err.response.data.errors)
      toast.error('Validation failed — check console')
    } else {
      toast.error('Error saving festival')
    }
  }
}

const editFestival = (festival) => {
  editingId.value = festival.id
  form.value = {
    name: festival.name,
    start_at: festival.start_at ? String(festival.start_at).slice(0,16) : '',
    end_at: festival.end_at ? String(festival.end_at).slice(0,16) : '',
    location: festival.location || '',
    site_url: festival.site_url || '',
    image: null,
  }
  previewImage.value = festival.image ? `/storage/${festival.image}` : null
  drawerOpen.value = true
}

async function toggleDefault(festival) {
  const desired = !festival.is_default;

  try {
    // optimistic: if turning on, everything else off
    festivals.value = festivals.value.map(f => ({
      ...f,
      is_default: desired ? f.id === festival.id : (f.id === festival.id ? false : f.is_default)
    }));

    const { data } = await axios.post(`/api/festivals/${festival.id}/toggle-default`, { value: desired });

    // server is source of truth
    if (data?.is_default) {
      festivals.value = festivals.value.map(f => ({ ...f, is_default: f.id === festival.id }));
    } else {
      festivals.value = festivals.value.map(f => ({ ...f, is_default: f.id === festival.id ? false : f.is_default }));
    }

    toast.success(data?.message || 'Updated');
  } catch (e) {
    await fetchFestivals(); // rollback
    toast.error('Failed to update default festival');
  }
}


// ===== Delete =====
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
    await fetchFestivals()
  } catch (error) {
    toast.error('Error deleting festival')
  } finally {
    cancelDeleteFestival()
  }
}

// ===== Reorder =====
function onDragEnd() {
  dragging.value = false
  orderDirty.value = true
  persistOrder()
}

async function persistOrder() {
  if (!orderDirty.value) return
  ordering.value = true
  try {
    const payload = {
      order: festivals.value.map((f, idx) => ({ id: f.id, position: idx + 1 }))
    }
    await axios.post('/api/festivals/reorder', payload)
    orderDirty.value = false
    toast.success('Order updated')
  } catch (e) {
    console.error(e?.response?.data || e.message)
    toast.error('Failed to save order')
  } finally {
    ordering.value = false
    // Refetch to ensure positions remain consistent
    await fetchFestivals()
  }
}

// ===== Helpers =====
function formatTimeAMPM(dtStr) {
  if (!dtStr) return ''
  const s = String(dtStr)
  const m = s.match(/(?:T|\s)(\d{2}):(\d{2})(?::\d{2})?/)
  if (!m) return s
  let h = parseInt(m[1], 10)
  const min = m[2]
  const ampm = h >= 12 ? 'PM' : 'AM'
  h = h % 12
  if (h === 0) h = 12
  return `${h}:${min} ${ampm}`
}

onMounted(async () => {
  await fetchFestivals()
})
</script>

<style scoped>
.drag-ghost {
  opacity: 0.5;
  background-color: rgba(0,0,0,0.04);
}
</style>
