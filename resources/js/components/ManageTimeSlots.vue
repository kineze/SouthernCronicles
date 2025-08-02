<template>
  <div>
    <!-- Header -->
    <div class="flex justify-between p-4 bg-white dark:bg-gray-800 shadow rounded-xl">
      <h4 class="text-lg dark:text-white">All Time Slots</h4>
      <button @click="openDrawer" class="px-4 py-1.5 bg-gray-800 text-white dark:bg-green-500 rounded-full text-sm font-semibold">
        Add Time Slot
      </button>
    </div>

    <!-- Grouped Time Slot Cards by Date -->
    <div class="mt-4 space-y-6">
      <div v-for="(slots, date) in groupedTimeSlots" :key="date">
        <div
          :class="[
            'cursor-pointer p-4 rounded shadow transition',
            expandedDates[date]
              ? 'bg-blue-100 dark:bg-green-600 border'
              : 'bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700'
          ]"
          @click="toggleDate(date)"
        >
          <div class="flex justify-between items-center">
            <h5 class="text-md font-semibold text-gray-700 dark:text-white">
              {{ date }}
            </h5>
            <button @click.stop="confirmDeleteDate(date)" class="text-red-500 hover:text-red-700">
              <i class="fas fa-trash"></i>
            </button>
          </div>
        </div>

        <div v-if="expandedDates[date]" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-2">
          <div
            v-for="slot in slots"
            :key="slot.id"
            class="bg-white dark:bg-gray-800 p-4 rounded shadow relative"
          >
            <div class="flex justify-between items-center">
              <p class="text-sm text-gray-700 dark:text-white">
                {{ formatTime(slot.start_time) }} - {{ formatTime(slot.end_time) }}
              </p>
              <label class="inline-flex items-center cursor-pointer">
                <input
                  type="checkbox"
                  class="sr-only peer"
                  :checked="slot.is_active"
                  :disabled="slot.booking"
                  @change="toggleStatus(slot)"
                >
                <div
                  class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300
                        dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700
                        peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full
                        peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px]
                        after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5
                        after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600
                        disabled:opacity-50 disabled:cursor-not-allowed"
                >
                </div>
              </label>


              <div class="text-right">
                <button
                  @click="!slot.booking && confirmDeleteSlot(slot.id)"
                  :disabled="slot.booking"
                  class="text-red-500 hover:text-red-700 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  <i class="fas fa-trash"></i>
                </button>
                <span v-if="slot.booking" class="block text-xs text-gray-400">Has booking</span>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>

    <!-- Drawer -->
    <div :class="['fixed top-0 right-0 z-[999] h-screen p-4 overflow-y-auto transition-transform bg-white dark:bg-gray-800 w-80', showDrawer ? 'translate-x-0' : 'translate-x-full']">
      <div class="flex justify-between items-center mb-4">
        <h5 class="text-base font-semibold text-gray-700 dark:text-white">Generate Time Slots</h5>
        <button @click="closeDrawer" class="text-gray-400 hover:text-gray-900 dark:hover:text-white">&times;</button>
      </div>

      <form @submit.prevent="generateSlots" class="space-y-6">
        <div class="relative">
          <input v-model="form.date" type="date" id="date" class="input text-black" />
        </div>

        <div class="relative">
          <input v-model="form.start_time" type="time" id="start_time" class="input text-black" />
        </div>

        <div class="relative">
          <input v-model="form.end_time" type="time" id="end_time" class="input text-black" />
        </div>

        <div class="relative">
          <input v-model="form.interval" type="number" min="1" id="interval" placeholder="Interval (min)" class="input text-black" />
        </div>

        <button type="submit" class="w-full py-2 bg-green-600 text-white rounded">Generate</button>
      </form>
    </div>

    <!-- Confirm Delete Modal -->
    <div v-if="showConfirmModal" class="fixed inset-0 bg-black bg-opacity-50 z-[1000] flex items-center justify-center">
      <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md w-full max-w-sm">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Delete Time Slot</h3>
        <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">Are you sure you want to delete this time slot? This action cannot be undone.</p>
        <div class="flex justify-end space-x-3">
          <button @click="cancelDelete" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-black dark:text-white rounded">Cancel</button>
          <button v-if="slotToDelete" @click="deleteSlot" class="px-4 py-2 bg-red-600 text-white rounded">Delete Slot</button>
          <button v-else-if="dateToDelete" @click="deleteDateSlots" class="px-4 py-2 bg-red-600 text-white rounded">Delete Date</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import axios from 'axios'
import { useToast } from 'vue-toastification'

const toast = useToast()
const showDrawer = ref(false)
const showConfirmModal = ref(false)
const timeSlots = ref([])
const expandedDates = ref({})
const slotToDelete = ref(null)
const dateToDelete = ref(null)

const form = ref({
  date: '',
  start_time: '',
  end_time: '',
  interval: 15
})

const toggleDate = (date) => {
  expandedDates.value[date] = !expandedDates.value[date]
}

const openDrawer = () => {
  resetForm()
  showDrawer.value = true
}

const closeDrawer = () => {
  showDrawer.value = false
}

const resetForm = () => {
  form.value = {
    date: '',
    start_time: '',
    end_time: '',
    interval: 15
  }
}

const groupedTimeSlots = computed(() => {
  const grouped = {}

  timeSlots.value.forEach(slot => {
    if (!grouped[slot.date]) grouped[slot.date] = []
    grouped[slot.date].push(slot)
  })

  // Sort each date's slots by start_time
  Object.keys(grouped).forEach(date => {
    grouped[date].sort((a, b) => a.start_time.localeCompare(b.start_time))
  })

  return grouped
})

const formatTime = (timeStr) => {
  const [hours, minutes] = timeStr.split(':').map(Number)
  const date = new Date()
  date.setHours(hours)
  date.setMinutes(minutes)
  return date.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit', hour12: true })
}

const fetchSlots = async () => {
  const res = await axios.get('/api/time-slots')
  timeSlots.value = res.data
}

const generateSlots = async () => {
  try {
    const res = await axios.post('/api/time-slots', form.value)
    toast.success('Time slots generated!')
    closeDrawer()
    timeSlots.value = [...timeSlots.value, ...res.data]
  } catch (err) {
    toast.error('Failed to generate slots.')
  }
}

const toggleStatus = async (slot) => {
  try {
    await axios.post(`/api/time-slots/${slot.id}/toggle`)
    toast.success(`Slot ${slot.is_active ? 'activated' : 'deactivated'}`)
  } catch (err) {
    toast.error('Failed to toggle slot status.')
  }
}

const confirmDeleteDate = (date) => {
  dateToDelete.value = date
  showConfirmModal.value = true
}

const deleteDateSlots = async () => {
  try {
    await axios.delete('/api/time-slots/by-date', {
      data: { date: dateToDelete.value }
    })
    toast.success('All time slots for the date deleted.')
    timeSlots.value = timeSlots.value.filter(slot => slot.date !== dateToDelete.value)
  } catch (err) {
    toast.error('Failed to delete slots.')
  } finally {
    showConfirmModal.value = false
    dateToDelete.value = null
  }
}


const cancelDelete = () => {
  slotToDelete.value = null
  dateToDelete.value = null
  showConfirmModal.value = false
}

const deleteSlot = async () => {
  try {
    await axios.delete(`/api/time-slots/${slotToDelete.value}`)
    toast.success('Time slot deleted.')
    timeSlots.value = timeSlots.value.filter(slot => slot.id !== slotToDelete.value)
  } catch (err) {
    toast.error('Failed to delete slot.')
  } finally {
    showConfirmModal.value = false
    slotToDelete.value = null
  }
}

fetchSlots()
</script>

<style scoped>
.input {
  @apply block px-3 py-2 border rounded w-full;
}
.translate-x-full {
  transform: translateX(100%);
}
.translate-x-0 {
  transform: translateX(0%);
}
</style>
