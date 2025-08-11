<template>
  <div>
    <!-- Header -->
    <div class="justify-between flex w-full p-4 bg-white dark:bg-gray-800 dark:shadow-soft-dark-xl shadow-soft-xl rounded-xl pb-2">
      <h4 class="text-lg font-semibold dark:text-white">All Festivals</h4>
      <button @click="openDrawer()" class="px-4 py-1.5 bg-gray-800 text-white dark:bg-green-500 rounded-full text-sm font-semibold">
        New Festival
      </button>
    </div>

    <!-- Table -->
    <div class="relative overflow-x-auto shadow-md mt-7 sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th class="px-6 py-3 dark:text-white font-semibold">Festival Name</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Start</th>
            <th class="px-6 py-3 dark:text-white font-semibold">End</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Location</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="festival in festivals" :key="festival.id" class="border-b dark:border-gray-700">
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
            <td class="px-6 py-4 text-right flex gap-3 justify-end">
              <button @click="editFestival(festival)" class="text-green-500"><i class="fa-solid fa-pen"></i></button>
              <button @click="showDeleteConfirmation(festival)" class="text-red-500"><i class="fa-solid fa-trash"></i></button>
            </td>
          </tr>
        </tbody>
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
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
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
          <label
            for="start_at"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
          >Start Date & Time</label>
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
          <label
            for="end_at"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
          >End Date & Time</label>
        </div>

          <!-- Location (with Places Autocomplete) -->
          <div class="relative mb-5">
            <input
              ref="locationInput"
              v-model="form.location"
              type="text"
              id="location"
              placeholder=" "
              autocomplete="off"
              class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"
              required
            />
            <label
              for="location"
              class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
            >Location</label>
          </div>

          <!-- Small map preview -->
          <div class="mb-5">
            <div ref="mapEl" class="w-full h-40 border rounded-lg dark:border-gray-600"></div>
            <div class="mt-2 text-xs text-gray-600 dark:text-gray-300" v-if="form.location_lat != null && form.location_lng != null">
              <span class="font-semibold">Lat:</span> {{ form.location_lat }} &nbsp; 
              <span class="font-semibold">Lng:</span> {{ form.location_lng }}
            </div>
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
          <label
            for="site_url"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
          >Site URL (optional)</label>
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

const toast = useToast()

const festivals = ref([])
const drawerOpen = ref(false)
const editingId = ref(null)

const locationInput = ref(null)
const mapEl = ref(null)

let maps = null
let autocomplete = null
let map = null
let marker = null

let geocoder = null



const form = ref({
  name: '',
  start_at: '',
  end_at: '',
  location: '',
  site_url: '',
  image: null,

  // NEW:
  location_place_id: '',
  location_lat: null,
  location_lng: null,
})

let mapsApiPromise = null
function loadGoogleMaps () {
  if (window.google?.maps) return Promise.resolve(window.google.maps)
  if (mapsApiPromise) return mapsApiPromise

  const apiKey =
    document.querySelector('meta[name="gmaps-key"]')?.content ||
    (import.meta.env?.VITE_GOOGLE_MAPS_API_KEY ?? '')

  mapsApiPromise = new Promise((resolve, reject) => {
    if (!apiKey) return reject(new Error('Google Maps API key is missing'))
    const s = document.createElement('script')
    s.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&libraries=places&v=weekly`
    s.async = true
    s.defer = true
    s.onerror = () => reject(new Error('Failed to load Google Maps'))
    s.onload = () => resolve(window.google.maps)
    document.head.appendChild(s)
  })
  return mapsApiPromise
}

function setMarkerAndCenter(latLng, zoom = 15) {
  if (!marker) {
    marker = new maps.Marker({ map, draggable: true })
    marker.addListener('dragend', async () => {
      const newPos = marker.getPosition()
      await applyLatLng(newPos, { doReverseGeocode: true })
    })
  }
  marker.setPosition(latLng)
  map.setCenter(latLng)
  map.setZoom(zoom)
}


async function applyLatLng(latLng, { doReverseGeocode = true } = {}) {
  form.value.location_lat = latLng.lat()
  form.value.location_lng = latLng.lng()

  if (doReverseGeocode) {
    try {
      const results = await geocodeLatLng(latLng)
      // prefer formatted address if available
      const addr = results?.[0]?.formatted_address ?? ''
      form.value.location = addr || form.value.location || ''
      // save place_id if available
      form.value.location_place_id = results?.[0]?.place_id || ''
    } catch (e) {
      console.warn('Reverse geocode failed', e)
      // keep lat/lng only
    }
  }
}

function geocodeLatLng(latLng) {
  return new Promise((resolve, reject) => {
    if (!geocoder) geocoder = new maps.Geocoder()
    geocoder.geocode({ location: latLng }, (results, status) => {
      if (status === 'OK') return resolve(results || [])
      reject(new Error(status))
    })
  })
}



function initMap () {
  if (!mapEl.value || !maps) return
  map = new maps.Map(mapEl.value, {
    center: { lat: 7.8731, lng: 80.7718 }, // Sri Lanka center
    zoom: 7,
    mapTypeControl: false,
    streetViewControl: false,
  })

  // Click to place/relocate
  map.addListener('click', async (ev) => {
    const latLng = ev.latLng
    setMarkerAndCenter(latLng)
    await applyLatLng(latLng, { doReverseGeocode: true })
  })
}


function initPlacesAutocomplete () {
  if (!locationInput.value || !maps) return

  autocomplete = new maps.places.Autocomplete(locationInput.value, {
    fields: ['place_id', 'formatted_address', 'geometry', 'name'],

    types: ['geocode'],
  })

autocomplete.addListener('place_changed', () => {
  const place = autocomplete.getPlace()
  if (!place || !place.geometry) {
    toast.error('Please pick a location from the suggestions')
    return
  }

  // Write to your form
  form.value.location = place.formatted_address || place.name || ''
  form.value.location_place_id = place.place_id || ''
  form.value.location_lat = place.geometry.location.lat()
  form.value.location_lng = place.geometry.location.lng()

  // Update map + marker
  const pos = place.geometry.location
  setMarkerAndCenter(pos)

  // ensure draggable + reverse geocode on drag end
  if (marker) {
    marker.setDraggable(true)
    marker.addListener('dragend', async () => {
      const newPos = marker.getPosition()
      await applyLatLng(newPos, { doReverseGeocode: true })
    })
  }
})

}


const previewImage = ref(null)

const showDeleteModal = ref(false)
const festivalToDelete = ref(null)

const fetchFestivals = async () => {
  const res = await axios.get('/api/festivals')
  festivals.value = res.data
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

    // NEW:
    location_place_id: '',
    location_lat: null,
    location_lng: null,
  }
  previewImage.value = null
  editingId.value = null

  // Reset map view
  if (maps && map) {
    map.setCenter({ lat: 7.8731, lng: 80.7718 })
    map.setZoom(7)
    if (marker) marker.setMap(null)
    marker = null
  }
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

    // NEW:
    if (form.value.location_place_id) fd.append('location_place_id', form.value.location_place_id)
    if (form.value.location_lat != null) fd.append('location_lat', String(form.value.location_lat))
    if (form.value.location_lng != null) fd.append('location_lng', String(form.value.location_lng))

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

    fetchFestivals()
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
    start_at: festival.start_at ? festival.start_at.slice(0,16) : '',
    end_at: festival.end_at ? festival.end_at.slice(0,16) : '',
    location: festival.location || '',
    site_url: festival.site_url || '',
    image: null,

    // NEW:
    location_place_id: festival.location_place_id || '',
    location_lat: festival.location_lat ?? null,
    location_lng: festival.location_lng ?? null,
  }
  previewImage.value = festival.image ? `/storage/${festival.image}` : null
  drawerOpen.value = true

  // move map marker if lat/lng exist
  if (maps && map && (form.value.location_lat != null) && (form.value.location_lng != null)) {
    const pos = new maps.LatLng(form.value.location_lat, form.value.location_lng)
    setMarkerAndCenter(pos)
  }
}


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
    fetchFestivals()
  } catch (error) {
    toast.error('Error deleting festival')
  } finally {
    cancelDeleteFestival()
  }
}

// Extracts "HH:mm" (or HH:mm:ss) from common DB/ISO strings and prints AM/PM
function formatTimeAMPM(dtStr) {
  if (!dtStr) return ''
  const s = String(dtStr)
  // works for "YYYY-MM-DD HH:mm:ss", "YYYY-MM-DDTHH:mm:ss", "...Z", etc.
  const m = s.match(/(?:T|\s)(\d{2}):(\d{2})(?::\d{2})?/)
  if (!m) return s // fallback if no time found
  let h = parseInt(m[1], 10)
  const min = m[2]
  const ampm = h >= 12 ? 'PM' : 'AM'
  h = h % 12
  if (h === 0) h = 12
  return `${h}:${min} ${ampm}`
}

// Optional: show a simple date without timezone conversion (YYYY-MM-DD)
function formatDateYMD(dtStr) {
  if (!dtStr) return ''
  const m = String(dtStr).match(/^(\d{4})-(\d{2})-(\d{2})/)
  return m ? `${m[1]}-${m[2]}-${m[3]}` : dtStr
}


onMounted(async () => {
  await fetchFestivals()

  try {
    maps = await loadGoogleMaps()
    initMap()
    initPlacesAutocomplete()
  } catch (e) {
    console.error(e)
    toast.error('Failed to load Google Maps')
  }
})

</script>
