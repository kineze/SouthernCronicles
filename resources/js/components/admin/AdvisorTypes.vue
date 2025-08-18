<template>
  <div>

    <div class="flex justify-between p-4 bg-white dark:bg-gray-800 dark:shadow-soft-dark-xl shadow rounded-xl">
      <h4 class="text-lg font-semibold dark:text-white">Advisor Types</h4>
      <button @click="openDrawer" class="px-4 py-1.5 bg-gray-800 text-white dark:bg-green-500 rounded-full text-sm font-semibold">
        Add Advisor Type
      </button>
    </div>


    <div class="relative overflow-x-auto mt-6 sm:rounded-lg px-4">
      <draggable
        v-model="types"
        item-key="id"
        group="advisor-types"
        handle=".drag-handle"
        ghost-class="bg-yellow-100"
        @end="onDragEnd"
        class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5"
      >
        <template #item="{ element: t }">
          <div class="relative bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden">
            <!-- drag handle -->
            <div class="absolute top-2 left-2 z-10 cursor-move drag-handle text-gray-600 dark:text-gray-300">
              <i class="fa-solid fa-up-down"></i>
            </div>

            <div class="p-4 ml-8 flex items-center justify-between">
              <div class="text-left">
                <h5 class="font-medium dark:text-white">{{ t.name }}</h5>
                <p v-if="t.description" class="mt-2 text-sm text-gray-600 dark:text-gray-300 line-clamp-3">
                  {{ t.description }}
                </p>
              </div>

              <div class="flex justify-center text-sm gap-3">
                <button @click="editType(t)" class="text-green-600" title="Edit"><i class="fa fa-pen"></i></button>
                <button @click="confirmDelete(t)" class="text-red-600" title="Delete"><i class="fa fa-trash"></i></button>
              </div>
            </div>
          </div>
        </template>
      </draggable>
    </div>


    <div v-if="drawerOpen" class="fixed inset-0 z-[990] bg-black bg-opacity-40" @click="closeDrawer"></div>

    <div
      :class="[
        'fixed top-0 right-0 w-96 h-screen z-[990] bg-white dark:bg-gray-800 shadow-lg transform transition-transform overflow-y-auto p-6',
        drawerOpen ? 'translate-x-0' : 'translate-x-full'
      ]"
    >
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-bold dark:text-white">{{ editingId ? 'Edit Advisor Type' : 'Add Advisor Type' }}</h3>
        <button @click="closeDrawer" class="text-gray-500 hover:text-red-600"><i class="fa fa-times"></i></button>
      </div>

      <form @submit.prevent="saveType">
        <!-- Name -->
        <div class="relative mb-5">
          <input
            v-model.trim="form.name"
            type="text"
            id="name"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"
            required
          />
          <label
            for="name"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2
                   peer-focus:px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500
                   peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                   peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
          >
            Advisor Type
          </label>
        </div>


        <div class="relative mb-5">
          <textarea
            v-model.trim="form.description"
            id="description"
            rows="4"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"
          ></textarea>
          <label
            for="description"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2
                   peer-focus:px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500
                   peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-10
                   peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
          >
            Description (optional)
          </label>
        </div>

        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded">
          {{ editingId ? 'Update' : 'Create' }}
        </button>
      </form>
    </div>


    <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[999]">
      <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-md w-full">
        <h3 class="text-lg font-semibold mb-3 dark:text-white">Delete Advisor Type</h3>
        <p class="mb-4 dark:text-gray-300">
          Are you sure you want to delete <strong>{{ typeToDelete?.name }}</strong>?
        </p>
        <div class="flex justify-end gap-3">
          <button @click="showDeleteModal = false" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
          <button @click="deleteType" class="px-4 py-2 bg-red-600 text-white rounded">Delete</button>
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
const types = ref([])
const drawerOpen = ref(false)
const editingId = ref(null)
const showDeleteModal = ref(false)
const typeToDelete = ref(null)

const form = ref({ name: '', description: '' })

const fetchTypes = async () => {
  const { data } = await axios.get('/api/advisor-types?ordered=true')
  types.value = data
}

const onDragEnd = async () => {
  try {
    const ordered = types.value.map((t, idx) => ({ id: t.id, position: idx }))
    await axios.post('/api/advisor-types/reorder', { order: ordered })
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
  form.value = { name: '', description: '' }
  editingId.value = null
}

const saveType = async () => {
  try {
    if (editingId.value) {
      await axios.put(`/api/advisor-types/${editingId.value}`, form.value)
      toast.success('Advisor type updated')
    } else {
      await axios.post('/api/advisor-types', form.value)
      toast.success('Advisor type created')
    }
    await fetchTypes()
    closeDrawer()
  } catch (error) {
    if (error.response?.status === 422) {
      console.error('Validation:', error.response.data.errors)
      toast.error('Validation failed — check console')
    } else {
      toast.error('Error saving advisor type')
    }
  }
}

const editType = (t) => {
  editingId.value = t.id
  form.value = { name: t.name, description: t.description || '' }
  drawerOpen.value = true
}

const confirmDelete = (t) => {
  typeToDelete.value = t
  showDeleteModal.value = true
}

const deleteType = async () => {
  try {
    await axios.delete(`/api/advisor-types/${typeToDelete.value.id}`)
    toast.success('Advisor type deleted')
    await fetchTypes()
  } catch {
    toast.error('Error deleting advisor type')
  } finally {
    showDeleteModal.value = false
  }
}

onMounted(fetchTypes)
</script>
