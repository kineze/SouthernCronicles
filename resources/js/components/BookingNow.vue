<template>
    <div class=" bg-white dark:bg-gray-900 focus:border-black shadow">
        <h1 class="lg:text-6xl text-3xl mt-12 lg:mt-4 text-black font-extrabold tracking-widest uppercase text-center mb-4">
        Book Now
        </h1>

    <!-- Launchpad 1000 Description -->
<div class="flex flex-wrap">
      <div class="lg:w-6/12 lg:p-4  text-center text-gray-700 dark:text-gray-300 mb-10 text-sm leading-relaxed px-4">
      <p class="mb-3 font-semibold text-lg text-gray-900 dark:text-white">
          Launchpad 1000 Global Literary Pitching Platform
      </p>
      <p class="mb-2">
          Launchpad 1000 is The Asian Literary Festivals' live manuscript pitching platform, connecting writers worldwide with industry professionals. We seek fresh talent and welcome established authors across all genres.
      </p>
      <p class="mb-2">
          The Asian Literary Agency, our talent management wing, hosts live pitching sessions at festival locations. Our platform features two distinct tracks: an original manuscript submission desk for unpublished work and a translation pitching deck for published titles seeking international markets.
      </p>
      <p>
          Book your slot and present your work directly to agents actively seeking compelling narratives and market-ready content. Whether you're submitting debut manuscripts or published works for translation opportunities, Launchpad 1000 provides the essential gateway to advance your literary career on the global stage.
      </p>
    </div>

    <div class="lg:w-6/12 w-full lg:p-4">
          <div v-if="step === 1">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Full Name -->
            <div class="relative col-span-1 md:col-span-2">
              <input
                v-model="form.full_name"
                type="text"
                id="full_name"
                placeholder=" "
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent focus:border-black border border-gray-500 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-black peer"
              />
              <label for="full_name" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2
                peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
                Full Name
              </label>
              
            </div>

            <!-- Email -->
            <div class="relative">
              <input
                v-model="form.email"
                type="email"
                id="email"
                placeholder=" "
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent focus:border-black border border-gray-500 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-black peer"
              />
              <label for="email" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2
                peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
                Email Address
              </label>
            </div>

            <!-- Contact Number -->
            <div class="relative">
              <input
                v-model="form.contact_number"
                type="text"
                id="contact_number"
                placeholder=" "
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent focus:border-black border border-gray-500 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-black peer"
              />
              <label for="contact_number" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2
                peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
                Contact Number
              </label>
            </div>
          </div>

          <button
            @click="nextStep"
            :disabled="!isStep1Valid"
            class="px-6 py-2 mt-6 font-semibold tracking-wide transition-colors duration-300"
            :class="isStep1Valid ? 'bg-black text-white cursor-pointer' : 'bg-gray-400 text-gray-200 cursor-not-allowed'"
          >
            Next
          </button>
        </div>

        <!-- Step 2: Date & Time Slot -->
        <div v-else>
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
            <div>
              <label class="block mb-2 text-black font-semibold dark:text-gray-300">Select Date</label>
              <Flatpickr
                v-model="form.booking_date"
                :config="fpConfig"
                class="bg-black text-white w-full rounded hidden-input-calendar"
                placeholder="Choose a date"
              />
            </div>

            <div v-if="form.booking_date" class="mt-4 lg:mt-0">
              <h3 class="mb-2 text-black font-semibold dark:text-gray-300">Available Time</h3>
              <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                <button
                  v-for="slot in filteredSlots"
                  :key="slot.id"
                  @click="!isSlotApproved(slot) && selectSlot(slot.id)"
                  :disabled="isSlotApproved(slot)"
                  :class="[
                    'font-semibold p-2 text-center border rounded transition-colors duration-200',
                    isSlotApproved(slot)
                      ? 'bg-gray-300 text-gray-600 border-gray-500 cursor-not-allowed'
                      : form.time_slot_id === slot.id
                      ? 'bg-black text-white border-black'
                      : 'bg-white text-black border-black hover:bg-black hover:text-white'
                  ]"
                >
                  {{ slot.start_time }} - {{ slot.end_time }}
                </button>
              </div>
            </div>
          </div>
          <div class="mt-6 flex justify-between">
            <button @click="step--" class="px-6 py-2 bg-gray-700 font-semibold tracking-wide text-white">Back</button>
            <button @click="submitForm" class="px-6 py-2 bg-black font-semibold text-white">Book Now</button>
          </div>
        </div>
    </div>
</div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import axios from 'axios'
import Flatpickr from 'vue-flatpickr-component'
import 'flatpickr/dist/flatpickr.css'
import { useToast } from 'vue-toastification'

const toast = useToast()

const step = ref(1)
const timeSlots = ref([])

const form = ref({
  full_name: '',
  email: '',
  contact_number: '',
  booking_date: '',
  time_slot_id: null
})

const isSlotApproved = (slot) => slot.status === 'approved'

const isStep1Valid = computed(() => {
  return (
    form.value.full_name.trim() &&
    form.value.email.trim() &&
    form.value.contact_number.trim()
  )
})

const fpConfig = {
  inline: true,
  dateFormat: 'Y-m-d',
  disableMobile: true,
  minDate: '2025-10-03',
  enable: ['2025-10-03', '2025-10-04', '2025-10-05'],
  onReady: (selectedDates, dateStr, instance) => {
    // Hide previous and next month buttons
    const prev = instance.calendarContainer.querySelector('.flatpickr-prev-month')
    const next = instance.calendarContainer.querySelector('.flatpickr-next-month')
    if (prev) prev.style.display = 'none'
    if (next) next.style.display = 'none'
  }
}


const filteredSlots = computed(() => {
  if (!form.value.booking_date) return []
  return timeSlots.value
})

const selectSlot = (id) => {
  form.value.time_slot_id = id
}

const nextStep = () => step.value++

const submitForm = async () => {
  try {
    await axios.post('/api/launchpad/book', form.value)
    toast.success('🎉 Booking submitted successfully!')
    resetForm()
    step.value = 1
  } catch (err) {
    toast.error('❌ Something went wrong. Please try again.')
  }
}

const resetForm = () => {
  form.value = {
    full_name: '',
    email: '',
    contact_number: '',
    booking_date: '',
    time_slot_id: null
  }
}

const fetchTimeSlots = async () => {
  timeSlots.value = [] // clear old slots
  if (!form.value.booking_date) return

  try {
    const res = await axios.get('/api/launchpad/time-slots', {
      params: { booking_date: form.value.booking_date }
    })
    timeSlots.value = res.data
  } catch (err) {
    console.error('Failed to load time slots:', err)
  }
}

watch(() => form.value.booking_date, (newDate) => {
  if (newDate) fetchTimeSlots()
})

onMounted(() => {
  if (form.value.booking_date) {
    fetchTimeSlots()
  }
})
</script>



<style>

.flatpickr-day {
  width: 100% !important;
  border-radius: 0% !important;
  position: relative;
}
.hidden-input-calendar {
  display: none !important;
}
.flatpickr-weekdaycontainer .flatpickr-weekday,
.flatpickr-days .flatpickr-day {
  color: white;
}
.flatpickr-days .flatpickr-disabled {
  /* background-color: #4d4d4d; */
  color: #4d4d4d;
  cursor: not-allowed;
  margin: 2px;
}


.flatpickr-day.flatpickr-disabled:hover {
  background-color: transparent !important;
  color: #4d4d4d !important;
}

.flatpickr-days .prevMonthDay,
.flatpickr-days .nextMonthDay {
  color: rgb(148, 148, 148);
}

.flatpickr-days .prevMonthDay {
  color: rgb(148, 148, 148);
}

.flatpickr-days .nextMonthDay {
  color: rgb(148, 148, 148);
}

.flatpickr-calendar.inline {
  background-color: black;
  color: white;
  padding: 0px;
  box-shadow: none;
}


.flatpickr-day.today:not(.selected) {
  border: 2px solid white !important;
  /* border-radius: 0.5rem !important; */
  background: transparent !important;
  color: white !important;
}


.flatpickr-day.selected {
  background-color: white !important;
  color: black !important;
  font-weight: 700;
  border: none !important;
}


.flatpickr-day.today.selected {
  background-color: white !important;
  color: black !important;
  border: none !important;
}

.flatpickr-day.today,
.flatpickr-day.selected {
  background-color: transparent !important;
  color: white !important;
}

/* Today day (default): lime border */
.flatpickr-day.today {
  border: 2px solid white !important;
  /* border-radius: 0.5rem !important; */
}

/* Selected day (user clicked): lime background */
.flatpickr-day.selected:not(.today) {
  background-color: white !important;
  color: black !important;
  border: none !important;
} 


.flatpickr-day.disabled {
  background-color: #dc2626 !important;
  color: white !important;
  cursor: not-allowed;
  opacity: 0.6;
}
.flatpickr-calendar .flatpickr-months .flatpickr-month {
  /* margin-top: -10px;
  margin-bottom: 10px; */
  color: white !important;
}
.flatpickr-months .flatpickr-next-month,
.flatpickr-months .flatpickr-prev-month {
  color: white !important;
  font-weight: 600 !important;
  background-color: white !important;
  margin-top: 4px;
  border-radius: 50px;
}
.flatpickr-months .flatpickr-next-month {
  margin-right: 10px;
}


.flatpickr-months .flatpickr-prev-month {
  margin-left: 10px;
}


</style>
