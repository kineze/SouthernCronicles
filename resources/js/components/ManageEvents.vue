<template>
  <div>
    <!-- Header -->
    <div class="flex justify-between p-4 bg-white dark:bg-gray-800 shadow dark:shadow-soft-dark-xl rounded-xl">
      <h4 class="text-lg font-semibold dark:text-white">Events</h4>
      <button @click="openDrawer()" class="px-4 py-1.5 bg-gray-800 text-white dark:bg-green-500 rounded-full text-sm font-semibold">
        Add Event
      </button>
    </div>

    <!-- Event List -->
    <!-- Event Table -->
<div class="relative overflow-x-auto shadow-md mt-7 sm:rounded-lg">
  <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
      <tr>
        <th class="px-6 py-3 dark:text-white font-semibold">Event Name</th>
        <th class="px-6 py-3 dark:text-white font-semibold">Type</th>
        <th class="px-6 py-3 dark:text-white font-semibold">Description</th>
        <th class="px-6 py-3 dark:text-white font-semibold">Date</th>
        <th class="px-6 py-3 dark:text-white font-semibold">Time</th>
        <th class="px-6 py-3 dark:text-white font-semibold">Venue</th>
        <th class="px-6 py-3 dark:text-white font-semibold">Speakers</th>
        <th class="px-6 py-3 dark:text-white font-semibold">Moderator</th>
        <th class="px-6 py-3 dark:text-white font-semibold">Color</th>
        <th class="px-6 py-3 dark:text-white font-semibold">Book Signing</th>
        <th class="px-6 py-3 dark:text-white font-semibold text-right">Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="event in events" :key="event.id" class="border-b dark:border-gray-700">
        <td class="px-6 py-4 dark:text-white font-semibold">{{ event.name }}</td>
        <td class="px-6 py-4 dark:text-white">{{ event.event_type }}</td>
        <td class="px-6 py-4 dark:text-white">
          {{ event.description?.length > 30 ? event.description.slice(0, 30) + '...' : event.description || '—' }}
        </td>
        <td class="px-6 py-4 dark:text-white">{{ formatDateForInput(event.event_date) }}</td>
        <td class="px-6 py-4 dark:text-white">{{ event.time_in }} - {{ event.time_out }}</td>
        <td class="px-6 py-4 dark:text-white">{{ event.venue }}</td>

        <!-- Speaker names -->
          <td class="px-6 py-4 dark:text-white">
            <ul v-if="event.speakers && event.speakers.length">
              <li v-for="speaker in event.speakers" :key="speaker.id" class="text-sm">{{ speaker.name }}</li>
            </ul>
            <span v-else class="text-gray-400 italic">No have</span>
          </td>

        <!-- Moderator name -->
        <td class="px-6 py-4 dark:text-white">
          {{ event.moderator?.name || '—' }}
        </td>

        <td class="px-6 py-4">
          <div v-if="event.has_color" class="flex items-center gap-2">
            <div
              class="w-5 h-5 rounded-full border border-gray-400"
              :style="{ backgroundColor: event.color }"
            ></div>
            <span class="text-xs font-mono dark:text-white">{{ event.color }}</span>
          </div>
          <span v-else class="text-gray-400 italic">No</span>
        </td>

        <!-- Book Signing -->
        <td class="px-6 py-4 dark:text-white">
          <span :class="event.book_signing ? 'text-green-500' : 'text-gray-400'">
            {{ event.book_signing ? 'Yes' : 'No' }}
          </span>
        </td>

        <!-- Actions -->
        <td class="px-6 py-4 flex justify-end gap-3 text-right">
          <button @click="editEvent(event)" class="text-blue-500" title="Edit">
            <i class="fa-solid fa-pen"></i>
          </button>
          <button @click="showDeleteConfirmation(event.id)" class="text-red-500" title="Delete">
            <i class="fa-solid fa-trash"></i>
          </button>
        </td>
      </tr>
    </tbody>

  </table>
</div>


    <!-- Drawer -->
    <div v-show="drawerOpen" class="fixed top-0 right-0 z-[990] h-screen p-4 overflow-y-auto bg-white w-96 dark:bg-gray-800 transition-all"
         :class="{ 'translate-x-0': drawerOpen, 'translate-x-full': !drawerOpen }">
        <div class="flex justify-between items-center mb-4">
            <h5 class="text-base font-semibold text-gray-500 dark:text-gray-400">{{ isEdit ? 'Edit Event' : 'Add Event' }}</h5>
            <button @click="drawerOpen = false" class="text-gray-400 hover:text-red-600">✖</button>
        </div>

        <form @submit.prevent="submitForm">
        <div class="space-y-6">
            <!-- Event Date -->
            <div class="relative">
                <input type="date" v-model="form.event_date" id="event_date" placeholder=" " class="floating-input peer" />
                <label for="event_date" class="floating-label">Event Date</label>
            </div>

            <!-- Time In -->
            <div class="relative">
                <input type="time" v-model="form.time_in" id="time_in" placeholder=" " class="floating-input peer" />
                <label for="time_in" class="floating-label">Start Time</label>
            </div>

            <!-- Time Out -->
            <div class="relative">
                <input type="time" v-model="form.time_out" id="time_out" placeholder=" " class="floating-input peer" />
                <label for="time_out" class="floating-label">End Time</label>
            </div>

            <!-- Venue -->
            <div class="relative">
                <input type="text" v-model="form.venue" id="venue" placeholder=" " class="floating-input peer" />
                <label for="venue" class="floating-label">Venue</label>
            </div>

            <!-- Event Name -->
            <div class="relative">
                <input type="text" v-model="form.name" id="event_name" placeholder=" " class="floating-input peer" />
                <label for="event_name" class="floating-label">Event Name</label>
            </div>

            <!-- Event Type -->
            <div class="relative">
            <select v-model="form.event_type" id="event_type" class="floating-input peer">
                <option disabled value="" class="text-gray-200 font-normal">Select Event Type</option>
                <option class="text-black font-normal" v-for="type in eventTypes" :key="type" :value="type">{{ type }}</option>
            </select>
            <label for="event_type" class="floating-label">Event Type</label>
            </div>

            <!-- Speakers -->
            <div class="relative">
                <label for="speaker_ids" class="mb-4">Speakers</label>
                <select ref="speakerSelect" id="speaker_ids" v-model="form.speaker_ids" multiple class="floating-input peer mt-2">
                    <option v-for="speaker in speakers" :key="speaker.id" :value="speaker.id">
                    {{ speaker.name }}
                    </option>
                </select>
            
            </div>

            <!-- Moderator -->
            <div class="relative">
                <label for="moderator_id" >Moderator</label>
                <select ref="moderatorSelect" id="moderator_id" v-model="form.moderator_id" class="floating-input peer mt-2">
                    <option value=""></option>
                    <option v-for="speaker in speakers" :key="speaker.id" :value="speaker.id">
                    {{ speaker.name }}
                    </option>
                </select>
            </div>

            <div class="relative">
              <textarea
                v-model="form.description"
                id="description"
                placeholder=" "
                rows="4"
                class="floating-input peer resize-none"
              ></textarea>
              <label for="description" class="floating-label">Description</label>
            </div>

            <label class="flex items-center">
              <input type="checkbox" v-model="form.has_color" class="mr-2" />
              Enable Custom Color
            </label>

            <!-- Color Picker (shown if checked) -->

            <div v-if="form.has_color" class="relative mt-2">
              <label for="color" class="block mb-2 text-sm font-medium dark:text-white">Pick Color</label>
              
              <div class="flex items-center gap-3">
                <!-- Visual Picker -->
                <input
                  type="color"
                  id="color"
                  v-model="form.color"
                  class="w-12 h-10 rounded border border-gray-300 dark:border-gray-700"
                />

                <!-- Manual Hex Code Input -->
                <input
                  type="text"
                  v-model="form.color"
                  placeholder="#000000"
                  class="w-28 px-2 py-1 text-sm rounded border border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-white"
                />

                <!-- Preview Circle -->
                <div
                  :style="{ backgroundColor: form.color }"
                  class="w-6 h-6 rounded-full border border-gray-400"
                ></div>
              </div>
            </div>


            <!-- Book Signing -->
            <label class="flex items-center">
            <input type="checkbox" v-model="form.book_signing" class="mr-2" />
            Book Signing
            </label>
        </div>

        <button type="submit" class="mt-6 w-full bg-green-600 text-white px-4 py-2 rounded">
            {{ isEdit ? 'Update' : 'Create' }}
        </button>
        </form>

    </div>
  </div>


<div v-if="showDeleteModal" class="fixed inset-0 z-[1000] bg-black bg-opacity-50 flex items-center justify-center">
  <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl w-full max-w-md">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Confirm Delete</h3>
    <p class="text-gray-600 dark:text-gray-300 mb-6">
      Are you sure you want to delete this event? This action cannot be undone.
    </p>
    <div class="flex justify-end space-x-3">
      <button @click="showDeleteModal = false" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 dark:text-white rounded hover:bg-gray-300 dark:hover:bg-gray-600">
        Cancel
      </button>
      <button @click="confirmDelete" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
        Delete
      </button>
    </div>
  </div>
</div>
</template>

<script setup>
import { ref, onMounted, watch, nextTick } from 'vue'
import axios from 'axios'
import TomSelect from 'tom-select'
import { useToast } from 'vue-toastification'

const toast = useToast()

const drawerOpen = ref(false)
const isEdit = ref(false)
const events = ref([])
const speakers = ref([])
const selectedId = ref(null)

const speakerSelect = ref(null)
const moderatorSelect = ref(null)
let speakerSelectInstance = null
let moderatorSelectInstance = null


const showDeleteModal = ref(false)
const eventToDeleteId = ref(null)

const showDeleteConfirmation = (id) => {
  eventToDeleteId.value = id
  showDeleteModal.value = true
}

const confirmDelete = async () => {
  if (!eventToDeleteId.value) return
  await deleteEvent(eventToDeleteId.value)
  showDeleteModal.value = false
  eventToDeleteId.value = null
}


const eventTypes = [
  'Speech', 'Performance', 'Recital', 'Moderated discussion',
  'Moderated discussion (Ticketed Event)', 'Workshop',
  'Presentation', 'Information Session'
]

const form = ref({
  event_date: '',
  time_in: '',
  time_out: '',
  venue: '',
  name: '',
  event_type: '',
  description: '',
  speaker_ids: [],
  moderator_id: null,
  book_signing: false,
  has_color: false,
  color: '#000000'
})

// Cleanup old TomSelect instances
const destroyTomSelects = () => {
  speakerSelectInstance?.destroy?.()
  moderatorSelectInstance?.destroy?.()
}

// Init TomSelect after DOM is rendered
const initializeTomSelects = () => {
  destroyTomSelects()

  if (speakerSelect.value) {
    speakerSelectInstance = new TomSelect(speakerSelect.value, {
      plugins: ['remove_button'],
      placeholder: 'Select speakers...',
      persist: false,
      create: false
    })
  }

  if (moderatorSelect.value) {
    moderatorSelectInstance = new TomSelect(moderatorSelect.value, {
      placeholder: 'Select moderator...',
      persist: false,
      create: false
    })
  }
}

// When drawer opens, init TomSelect
watch(drawerOpen, async (val) => {
  if (val) {
    await nextTick()
    initializeTomSelects()
  } else {
    destroyTomSelects()
  }
})

const fetchEvents = async () => {
  try {
    const res = await axios.get('/api/events')
    events.value = res.data
  } catch (error) {
    toast.error('Failed to load events.')
  }
}

const fetchSpeakers = async () => {
  try {
    const res = await axios.get('/api/get-speakers')
    speakers.value = res.data
  } catch (error) {
    toast.error('Failed to load speakers.')
  }
}

const openDrawer = () => {
  resetForm()
  drawerOpen.value = true
  isEdit.value = false
}

const editEvent = async (event) => {
  form.value = {
    ...event,
    event_date: formatDateForInput(event.event_date),
    speaker_ids: Array.isArray(event.speakers) ? event.speakers.map(s => s.id) : [],
    moderator_id: event.moderator_id ?? '',
    description: event.description ?? '',
    book_signing: !!event.book_signing,
    has_color: !!event.has_color, // ✅ include this
    color: event.color || '#000000' // ✅ include this too
  }

  selectedId.value = event.id
  isEdit.value = true
  drawerOpen.value = true

  await nextTick()
  initializeTomSelects()
  await nextTick()
  setTomSelectValues()
}



const formatDateForInput = (dateStr) => {
  if (!dateStr) return ''
  const date = new Date(dateStr)
  const year = date.getFullYear()
  const month = String(date.getMonth() + 1).padStart(2, '0')
  const day = String(date.getDate()).padStart(2, '0')
  return `${year}-${month}-${day}`
}


const setTomSelectValues = () => {
  if (speakerSelectInstance && Array.isArray(form.value.speaker_ids)) {
    // First clear then set to avoid residual values
    speakerSelectInstance.clear(true)
    speakerSelectInstance.setValue([...form.value.speaker_ids])
  }

  if (moderatorSelectInstance) {
    const modValue = form.value.moderator_id ?? ''
    moderatorSelectInstance.setValue(modValue)
  }
}

const resetForm = () => {
  form.value = {
    event_date: '',
    time_in: '',
    time_out: '',
    venue: '',
    name: '',
    event_type: '',
    description: '',
    speaker_ids: [],
    moderator_id: null,
    book_signing: false,
    has_color: false,
    color: '#000000'
  }
}

const submitForm = async () => {
  try {
    const url = isEdit.value ? `/api/events/${selectedId.value}` : '/api/events'
    const method = isEdit.value ? 'put' : 'post'

    await axios[method](url, form.value)
    await fetchEvents()
    drawerOpen.value = false

    toast.success(isEdit.value ? 'Event updated successfully!' : 'Event created successfully!')
  } catch (error) {
    toast.error('Something went wrong while saving the event.')
    console.error(error)
  }
}

const deleteEvent = async (id) => {
  try {
    await axios.delete(`/api/events/${id}`)
    await fetchEvents()
    toast.success('Event deleted successfully!')
  } catch (error) {
    toast.error('Failed to delete event.')
    console.error(error)
  }
}


onMounted(() => {
  fetchEvents()
  fetchSpeakers()
})
</script>

<style scoped>
.input {
  @apply border rounded px-3 py-2 w-full dark:bg-gray-700 dark:text-white;
}

.floating-input {
  @apply block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600;
}

.floating-label {
  @apply absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1;
}
</style>
