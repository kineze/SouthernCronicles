<template>
    <div>
        <!-- Header -->
        <div class="flex justify-between p-4 bg-white dark:bg-gray-800 shadow rounded-xl">
            <h4 class="text-lg dark:text-white">All Time Slots</h4>
            <button @click="openDrawer" class="px-4 py-1.5 bg-gray-800 text-white dark:bg-green-500 rounded-full text-sm font-semibold">
                Add Time Slot
            </button>
        </div>

        <!-- Time Slot Cards -->
        <div class="grid grid-cols-5 gap-4 mt-4">
            <div v-for="slot in timeSlots" :key="slot.id" class="bg-white dark:bg-gray-800 p-4 rounded shadow relative">
                <h3 class="font-semibold text-lg dark:text-white">{{ slot.title }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ slot.start_time }} - {{ slot.end_time }}</p>

                    <!-- Actions -->
                    <div class="absolute right-4 bottom-4 flex gap-3">
                    <i class="fas fa-pen text-blue-500 cursor-pointer" @click="editSlot(slot)"></i>
                    <i class="fas fa-trash text-red-500 cursor-pointer" @click="deleteSlot(slot.id)"></i>
                </div>
            </div>
        </div>

        <!-- Drawer -->
        <div :class="['fixed top-0 right-0 z-[999] h-screen p-4 overflow-y-auto transition-transform bg-white dark:bg-gray-800 w-80', showDrawer ? 'translate-x-0' : 'translate-x-full']">
            <div class="flex justify-between items-center mb-4">
                <h5 class="text-base font-semibold text-gray-700 dark:text-white">Time Slot Form</h5>
                <button @click="closeDrawer" class="text-gray-400 hover:text-gray-900 dark:hover:text-white">&times;</button>
            </div>

<form @submit.prevent="submitForm" class="space-y-6">

  <!-- Title Field -->
  <div class="relative">
    <input
      v-model="form.title"
      type="text"
      id="title"
      placeholder=" "
      class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
    />
    <label for="title"
      class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2
             peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2
             peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
      Title
    </label>
  </div>

  <!-- Start Time Field -->
  <div class="relative">
    <input
      v-model="form.start_time"
      type="time"
      id="start_time"
      placeholder=" "
      class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
    />
    <label for="start_time"
      class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2
             peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2
             peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
      Start Time
    </label>
  </div>

  <!-- End Time Field -->
  <div class="relative">
    <input
      v-model="form.end_time"
      type="time"
      id="end_time"
      placeholder=" "
      class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
    />
    <label for="end_time"
      class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2
             peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2
             peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
      End Time
    </label>
  </div>

  <!-- Submit Button -->
  <button type="submit" class="w-full py-2 bg-green-600 text-white rounded">
    {{ form.id ? 'Update' : 'Create' }}
  </button>
</form>

        </div>
    </div>

    <div v-if="showConfirmModal" class="fixed inset-0 bg-black bg-opacity-50 z-[1000] flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-96">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Are you sure?</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-6">Do you really want to delete this time slot? This action cannot be undone.</p>
            <div class="flex justify-end gap-4">
            <button @click="cancelDelete" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-black dark:text-white rounded">Cancel</button>
            <button @click="confirmDelete" class="px-4 py-2 bg-red-600 text-white rounded">Delete</button>
            </div>
        </div>
    </div>
</template>

<script>
import {nextTick } from 'vue';
import axios from 'axios'
import { useToast } from 'vue-toastification'

const toast = useToast()

export default {
  data() {
    return {
      showDrawer: false,
      showConfirmModal: false,
      timeSlots: [],
      form: {
        id: null,
        title: '',
        start_time: '',
        end_time: ''
      },
      slotToDelete: null
    }
  },
  setup() {
    const toast = useToast()
    return { toast }
  },
  methods: {
    fetchSlots() {
      axios.get('/api/time-slots').then(res => this.timeSlots = res.data)
    },
    openDrawer() {
      this.resetForm()
      this.showDrawer = true
    },
    closeDrawer() {
      this.showDrawer = false
    },
    resetForm() {
      this.form = { id: null, title: '', start_time: '', end_time: '' }
    },
    submitForm() {
      const action = this.form.id
        ? axios.put(`/api/time-slots/${this.form.id}`, this.form)
        : axios.post('/api/time-slots', this.form)

      action
        .then(() => {
          this.fetchSlots()
          this.closeDrawer()
          toast.success(this.form.id ? 'Time slot updated!' : 'Time slot created!')
        })
        .catch(() => {
          toast.error('Something went wrong.')
        })
    },
    editSlot(slot) {
      this.resetForm()
      this.form = { ...slot }
      nextTick(() => {
        this.showDrawer = true
      })
    },
    deleteSlot(id) {
      this.slotToDelete = id
      this.showConfirmModal = true
    },
    cancelDelete() {
      this.showConfirmModal = false
      this.slotToDelete = null
    },
    confirmDelete() {
      axios.delete(`/api/time-slots/${this.slotToDelete}`)
        .then(() => {
          toast.success('Time slot deleted.')
          this.fetchSlots()
        })
        .catch(() => {
          toast.error('Failed to delete time slot.')
        })
        .finally(() => {
          this.showConfirmModal = false
          this.slotToDelete = null
        })
    }
  },
  mounted() {
    this.fetchSlots()
  }
}

</script>

<style scoped>
.translate-x-full {
  transform: translateX(100%);
}
.translate-x-0 {
  transform: translateX(0%);
}
</style>
