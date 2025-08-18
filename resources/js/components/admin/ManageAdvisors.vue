<template>
  <div>
    <!-- Header -->
    <div class="justify-between flex w-full p-4 bg-white dark:bg-gray-800 shadow rounded-xl">
      <h4 class="dark:text-white text-lg">All Advisors</h4>
      <button @click="openDrawer" class="px-4 py-1.5 bg-gray-800 text-white dark:bg-green-500 rounded-full text-sm font-semibold">
        Add Advisor
      </button>
    </div>

    <!-- Cards (DRAGGABLE) -->
    <div class="relative overflow-x-auto mt-7 sm:rounded-lg px-1">
      <draggable
        v-model="advisors"
        item-key="id"
        group="advisors"
        handle=".drag-handle"
        ghost-class="bg-yellow-100"
        @end="onDragEnd"
        class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
      >
        <template #item="{ element: a }">
          <div class="relative group rounded-lg overflow-hidden shadow-lg bg-white dark:bg-gray-800">
            <!-- drag handle -->
            <div class="absolute top-2 left-2 z-10 cursor-move drag-handle text-gray-600 dark:text-gray-300">
              <i class="fa-solid fa-up-down"></i>
            </div>

            <!-- toggle show_on_home -->
            <div class="absolute top-2 right-2 z-[990]">
              <label class="inline-flex items-center cursor-pointer">
                <input
                  type="checkbox"
                  :checked="!!a.show_on_home"
                  @change="toggleShowOnHome(a)"
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
            </div>

            <img :src="a.image ? `/storage/${a.image}` : 'https://via.placeholder.com/800x800?text=Advisor'"
                 alt="" class="w-full h-80 object-cover" />

            <div class="absolute inset-0 bg-black/70 opacity-0 group-hover:opacity-100 transition-opacity duration-300
                        flex flex-col items-center justify-center text-white p-4 text-center">
              <h3 class="text-lg font-semibold mb-1">{{ a.name }}</h3>
              <p v-if="a.type" class="text-xs uppercase tracking-wide text-emerald-300">{{ a.type.name }}</p>
              <div class="flex space-x-4 text-sm mt-4">
                <button @click="editAdvisor(a)" class="text-white" title="Edit"><i class="fa-solid fa-pen"></i></button>
                <button @click="showDeleteConfirmation(a)" class="text-rose-500" title="Delete"><i class="fa-solid fa-trash"></i></button>
              </div>
            </div>
          </div>
        </template>
      </draggable>
    </div>

    <!-- Backdrop -->
    <div v-if="drawerOpen" class="fixed inset-0 z-[990] bg-black/40" @click="closeDrawer"></div>

    <!-- Drawer -->
    <div :class="['fixed top-0 right-0 z-[990] h-screen w-96 transition-transform bg-white dark:bg-gray-800 p-6 overflow-y-auto', drawerOpen ? 'translate-x-0' : 'translate-x-full']">
      <div class="flex justify-between items-center mb-4">
        <h5 class="text-lg font-bold text-gray-800 dark:text-white">{{ editingId ? 'Edit Advisor' : 'Add Advisor' }}</h5>
        <button @click="closeDrawer" class="text-gray-500 hover:text-red-500">
          <i class="fa-solid fa-xmark text-xl"></i>
        </button>
      </div>

      <form @submit.prevent="saveAdvisor">
        <!-- Image upload -->
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

        <!-- Advisor Type -->
        <div class="relative mb-5">
          <select
            v-model="form.advisor_type_id"
            id="advisor-type"
            required
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"
          >
            <option class="text-black" disabled value="">Select an advisor type</option>
            <option class="text-black" v-for="t in advisorTypes" :key="t.id" :value="t.id">{{ t.name }}</option>
          </select>
          <label
            for="advisor-type"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2
            peer-focus:px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500
            peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
            peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
          >
            Advisor Type
          </label>
        </div>

        <!-- Name -->
        <div class="relative mb-5">
          <input
            v-model="form.name"
            type="text"
            id="advisor-name"
            placeholder=" "
            required
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"
          />
          <label for="advisor-name" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2">
            Advisor Name
          </label>
        </div>

        <!-- Socials -->
        <div class="relative mb-5">
          <input v-model="form.facebook" type="url" id="facebook" placeholder=" " class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer" />
          <label for="facebook" class="absolute text-sm text-gray-500 dark:text-gray-400 -translate-y-4 scale-75 top-2 z-10 bg-white dark:bg-gray-800 px-2">Facebook</label>
        </div>

        <div class="relative mb-5">
          <input v-model="form.instagram" type="url" id="instagram" placeholder=" " class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer" />
          <label for="instagram" class="absolute text-sm text-gray-500 dark:text-gray-400 -translate-y-4 scale-75 top-2 z-10 bg-white dark:bg-gray-800 px-2">Instagram</label>
        </div>

        <div class="relative mb-5">
          <input v-model="form.linkedin" type="url" id="linkedin" placeholder=" " class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer" />
          <label for="linkedin" class="absolute text-sm text-gray-500 dark:text-gray-400 -translate-y-4 scale-75 top-2 z-10 bg-white dark:bg-gray-800 px-2">LinkedIn</label>
        </div>

        <!-- Description -->
        <div class="relative mb-5">
          <textarea v-model="form.description" id="advisor-description" rows="3" placeholder=" " class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"></textarea>
          <label for="advisor-description" class="absolute text-sm text-gray-500 dark:text-gray-400 -translate-y-4 scale-75 top-2 z-10 bg-white dark:bg-gray-800 px-2">Description</label>
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white py-2 rounded">
          {{ editingId ? 'Update Advisor' : 'Add Advisor' }}
        </button>
      </form>
    </div>

    <!-- Delete modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 z-[1001] bg-black/50 flex items-center justify-center">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-[90%] max-w-md shadow-xl">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Delete Advisor</h2>
        <p class="text-gray-600 dark:text-gray-300 mb-6">
          Are you sure you want to delete <span class="font-semibold">{{ advisorToDelete?.name }}</span>?
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
import draggable from 'vuedraggable'

const toast = useToast()

const advisors = ref([])
const advisorTypes = ref([])
const drawerOpen = ref(false)
const editingId = ref(null)
const showDeleteModal = ref(false)
const advisorToDelete = ref(null)
const previewImage = ref(null)

const form = ref({
  name: '',
  description: '',
  image: null,
  facebook: '',
  instagram: '',
  linkedin: '',
  advisor_type_id: ''
})

async function fetchAdvisors () {
  const res = await axios.get('/api/advisors?ordered=true')
  advisors.value = res.data
}
async function fetchAdvisorTypes () {
  const res = await axios.get('/api/advisor-types?ordered=true')
  advisorTypes.value = res.data
}

function openDrawer () { resetForm(); drawerOpen.value = true }
function closeDrawer () { drawerOpen.value = false; editingId.value = null }
function resetForm () {
  form.value = { name:'', description:'', image:null, facebook:'', instagram:'', linkedin:'', advisor_type_id:'' }
  previewImage.value = null
  editingId.value = null
}
function handleImageUpload (e) {
  const file = e.target.files[0]
  if (file) { form.value.image = file; previewImage.value = URL.createObjectURL(file) }
}
function removeImage () { form.value.image = null; previewImage.value = null }

async function saveAdvisor () {
  const fd = new FormData()
  Object.entries(form.value).forEach(([k, v]) => { if (v !== null && v !== undefined) fd.append(k, v) })

  try {
    if (editingId.value) {
      fd.append('_method', 'PUT')
      await axios.post(`/api/advisors/${editingId.value}`, fd)
      toast.success('Advisor updated')
    } else {
      await axios.post('/api/advisors', fd)
      toast.success('Advisor created')
    }
    await fetchAdvisors()
    closeDrawer()
  } catch (err) {
    toast.error(err?.response?.data?.message || 'Error saving advisor')
  }
}

async function toggleShowOnHome (a) {
  try {
    await axios.put(`/api/advisors/${a.id}/toggle-status`)
    toast.success('Advisor status updated')
    fetchAdvisors()
  } catch {
    toast.error('Failed to update status')
  }
}

function editAdvisor (a) {
  form.value = {
    name: a.name,
    description: a.description ?? '',
    facebook: a.facebook ?? '',
    instagram: a.instagram ?? '',
    linkedin: a.linkedin ?? '',
    advisor_type_id: a.advisor_type_id ?? '',
    image: null
  }
  previewImage.value = a.image ? `/storage/${a.image}` : null
  editingId.value = a.id
  drawerOpen.value = true
}

function showDeleteConfirmation (a) { advisorToDelete.value = a; showDeleteModal.value = true }
function cancelDelete () { advisorToDelete.value = null; showDeleteModal.value = false }
async function confirmDelete () {
  try {
    await axios.delete(`/api/advisors/${advisorToDelete.value.id}`)
    toast.success('Advisor deleted')
    fetchAdvisors()
  } catch {
    toast.error('Error deleting advisor')
  } finally { cancelDelete() }
}

/* NEW: persist drag order */
async function onDragEnd () {
  try {
    const ordered = advisors.value.map((a, idx) => ({ id: a.id, position: idx }))
    await axios.post('/api/advisors/reorder', { order: ordered })
    toast.success('Reordered successfully')
  } catch (e) {
    toast.error('Error saving order')
    // optional: refetch to revert local order if server fails
    fetchAdvisors()
  }
}

onMounted(async () => {
  await Promise.all([fetchAdvisors(), fetchAdvisorTypes()])
})
</script>
