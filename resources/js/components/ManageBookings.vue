<template>
  <div class="p-4">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white dark:bg-gray-800 shadow rounded-xl p-4">
      <h4 class="text-lg font-semibold dark:text-white">All Bookings</h4>
    </div>

    <!-- Filter and Search -->
    <div class="flex flex-wrap justify-between items-center mt-6 gap-4">
      <select v-model="statusFilter" class="border px-3 py-2 rounded text-sm dark:bg-gray-800 dark:text-white">
        <option value="all">All</option>
        <option value="pending">Pending</option>
        <option value="approved">Approved</option>
        <option value="canceled">Canceled</option>
      </select>

      <input
        v-model="search"
        type="text"
        placeholder="Search by name..."
        class="border px-3 py-2 rounded text-sm w-64 dark:bg-gray-800 dark:text-white"
      />
    </div>

    <!-- Booking Table -->
    <div class="relative overflow-x-auto shadow-md mt-7 sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th class="px-6 py-3 dark:text-white font-semibold">Name</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Email</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Date</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Time</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Status</th>
            <th class="px-6 py-3 dark:text-white font-semibold text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="booking in bookings" :key="booking.id" class="border-b dark:border-gray-700">
            <td class="px-6 py-4 dark:text-white">{{ booking.full_name }}</td>
            <td class="px-6 py-4 dark:text-white">{{ booking.email }}</td>
            <td class="px-6 py-4 dark:text-white">{{ booking.booking_date }}</td>
            <td class="px-6 py-4 dark:text-white">{{ booking.time_slot?.start_time }} - {{ booking.time_slot?.end_time }}</td>
            <td class="px-6 py-4 capitalize dark:text-white">{{ booking.status }}</td>
            <td class="px-6 py-4 flex justify-end gap-3 text-right">
              <button @click="openDrawer(booking)" class="text-blue-500" title="View">
                <i class="fa-solid fa-eye"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-end mt-4 space-x-2">
      <button
        v-for="page in pagination.last_page"
        :key="page"
        @click="fetchBookings(page)"
        :class="[
          'px-3 py-1 rounded border text-sm',
          pagination.current_page === page
            ? 'bg-black text-white border-black'
            : 'bg-white text-black border-gray-300 hover:bg-gray-100 dark:bg-gray-700 dark:text-white'
        ]"
      >
        {{ page }}
      </button>
    </div>

    <!-- Drawer (View) -->
    <div v-if="showDrawer" class="fixed inset-0 z-[990] bg-black bg-opacity-40" @click="closeDrawer"></div>
    <div
      class="fixed top-0 right-0 z-[990] h-screen w-96 p-4 overflow-y-auto transition-transform bg-white dark:bg-gray-800"
      :class="showDrawer ? 'translate-x-0' : 'translate-x-full'"
      tabindex="-1"
    >
      <h5 class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400">
        <i class="fa-solid fa-eye mr-2"></i> Booking Details
      </h5>
      <button
        type="button"
        @click="closeDrawer"
        class="text-gray-400 hover:text-gray-900 dark:hover:text-white absolute top-2.5 right-2.5 rounded-lg text-sm w-8 h-8 inline-flex items-center justify-center"
      >
        <i class="fa-solid fa-xmark"></i>
      </button>

      <div class="text-sm text-gray-700 dark:text-gray-200 space-y-4">

        <p><strong>Name:</strong> {{ selectedBooking?.full_name }}</p>
        <p><strong>Email:</strong> {{ selectedBooking?.email }}</p>
        <p><strong>Contact:</strong> {{ selectedBooking?.contact_number }}</p>
        <p><strong>Date:</strong> {{ selectedBooking?.booking_date }}</p>
        <p><strong>Time:</strong> {{ selectedBooking?.time_slot?.start_time }} - {{ selectedBooking?.time_slot?.end_time }}</p>
        <p><strong>Status:</strong> {{ selectedBooking?.status }}</p>


        <div class="flex gap-2 mt-4">
          <button
            v-if="selectedBooking?.status !== 'approved'"
            @click="triggerConfirm('approved')"
            class="bg-green-600 text-white px-4 py-2 rounded"
          >
            Approve
          </button>
          <button
            v-if="selectedBooking?.status !== 'canceled'"
            @click="triggerConfirm('canceled')"
            class="bg-red-600 text-white px-4 py-2 rounded"
          >
            Cancel
          </button>
        </div>
      </div>
    </div>

    <!-- Confirm Modal -->
    <div v-if="confirmStatus" class="fixed inset-0 z-[999] bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white dark:bg-gray-900 rounded-lg p-6 max-w-sm w-full">
        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Confirm</h3>
        <p class="mb-4 text-sm text-gray-600 dark:text-gray-300">
          Are you sure you want to <strong>{{ confirmStatus }}</strong> this booking?
        </p>
        <div class="flex justify-end gap-2">
          <button @click="confirmStatus = ''" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded">Cancel</button>
          <button @click="updateStatus" class="px-4 py-2 bg-green-600 text-white rounded">Confirm</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'
import { useToast } from 'vue-toastification'

const toast = useToast()
const bookings = ref([])
const selectedBooking = ref(null)
const showDrawer = ref(false)
const confirmStatus = ref('')
const targetBookingId = ref(null)

const search = ref('')
const statusFilter = ref('all')
const pagination = ref({ current_page: 1, last_page: 1 })

const fetchBookings = async (page = 1) => {
  try {
    const res = await axios.get('/api/launchpad/bookings', {
      params: {
        status: statusFilter.value !== 'all' ? statusFilter.value : undefined,
        search: search.value || undefined,
        page: page
      }
    })
    bookings.value = res.data.data
    pagination.value = {
      current_page: res.data.current_page,
      last_page: res.data.last_page
    }
  } catch (err) {
    toast.error('Failed to load bookings.')
  }
}

const openDrawer = (booking) => {
  selectedBooking.value = booking
  showDrawer.value = true
}

const closeDrawer = () => {
  showDrawer.value = false
  selectedBooking.value = null
}

const triggerConfirm = (action) => {
  confirmStatus.value = action
  targetBookingId.value = selectedBooking.value.id
}

const updateStatus = async () => {
  try {
    await axios.put(`/api/launchpad/bookings/${targetBookingId.value}/status`, {
      status: confirmStatus.value
    })
    toast.success(`Booking ${confirmStatus.value} successfully.`)
    confirmStatus.value = ''
    closeDrawer()
    fetchBookings(pagination.value.current_page)
  } catch (err) {
    toast.error('Failed to update status.')
  }
}

onMounted(() => {
  fetchBookings()
})

watch([search, statusFilter], () => {
  fetchBookings(1)
})
</script>
