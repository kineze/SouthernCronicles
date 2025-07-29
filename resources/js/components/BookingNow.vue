<template>
  <div class="max-w-6xl mx-auto bg-white dark:bg-gray-900 focus:border-black shadow">
    <h1 class="lg:text-6xl text-3xl mt-12 lg:mt-4 text-black font-extrabold tracking-widest uppercase text-center mb-10">Book Now</h1>

    <!-- Step 1: User Info -->
    <div v-if="step === 1">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Given Name -->
        <div class="relative">
        <input
            v-model="form.given_name"
            type="text"
            id="given_name"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent focus:border-black border border-gray-500 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-black peer"
        />
        <label
            for="given_name"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2
            peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
            Given Name
        </label>
        </div>

        <!-- Family Name -->
        <div class="relative">
        <input
            v-model="form.family_name"
            type="text"
            id="family_name"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent focus:border-black border border-gray-500 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-black peer"
        />
        <label for="family_name" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2
            peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
            Family Name
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

        <!-- Country -->
        <div class="relative col-span-1 md:col-span-2">
        <input
            v-model="form.country"
            type="text"
            id="country"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent focus:border-black border border-gray-500 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-black peer"
        />
        <label for="country" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2
            peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
            Country
        </label>
        </div>
    </div>

    <!-- Submission Text -->
    <div class="mt-4 relative">
        <textarea
        v-model="form.submission_text"
        id="submission_text"
        placeholder=" "
        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent focus:border-black border border-gray-500 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-black peer h-40 resize-none"
        ></textarea>
        <label for="submission_text" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2
        peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-20 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
        Describe your submission
        </label>
        <div class="text-sm text-gray-500 mt-1">
        Word Count: {{ wordCount }} / 3000
        </div>
    </div>

    <!-- Copyright Checkbox -->
    <div class="mt-4">
        <label class="inline-flex items-center">
        <input type="checkbox" v-model="form.is_copyright" class="mr-2">
        <span class="text-gray-700 dark:text-gray-300">Is this copyright material?</span>
        </label>

        <div v-if="form.is_copyright" class="mt-2 space-y-2">
        <div class="relative">
            <input
            v-model="form.copyright_holder"
            type="text"
            id="copyright_holder"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent focus:border-black border border-gray-500 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-black peer"
            />
            <label for="copyright_holder" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2
            peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
            Copyright Holder
            </label>
        </div>
        <div class="relative">
            <input
            v-model="form.copyright_contact"
            type="text"
            id="copyright_contact"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent focus:border-black border border-gray-500 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-black peer"
            />
            <label for="copyright_contact" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2
            peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
            Contact Info
            </label>
        </div>
        </div>
    </div>

    <!-- Consent -->
    <div class="mt-4">
        <label class="inline-flex items-start">
        <input type="checkbox" required class="mt-1 mr-2" />
        <span class="text-sm text-gray-700 dark:text-gray-300">
            I hereby give my consent to The Asian Festivals and its affiliates to publish in the printed and online form and use for research, other educational purposes, adaptation and for anthologies/collections.
        </span>
        </label>
    </div>

    <!-- Button -->
    <button
        @click="nextStep"
        :disabled="!isStep1Valid"
        class="px-6 py-2 mt-4 font-semibold tracking-wide transition-colors duration-300"
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
                class="bg-black text-white rounded hidden-input-calendar"
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
  given_name: '',
  family_name: '',
  email: '',
  contact_number: '',
  country: '',
  submission_text: '',
  is_copyright: false,
  copyright_holder: '',
  copyright_contact: '',
  booking_date: '',
  time_slot_id: null
})

const isSlotApproved = (slot) => {
  return slot.status === 'approved'
}

const wordCount = computed(() => {
  return form.value.submission_text.trim().split(/\s+/).filter(w => w.length > 0).length
})

const isStep1Valid = computed(() => {
  return (
    form.value.given_name.trim() &&
    form.value.family_name.trim() &&
    form.value.email.trim() &&
    form.value.contact_number.trim() &&
    form.value.country.trim() &&
    form.value.submission_text.trim() &&
    (!form.value.is_copyright || (
      form.value.copyright_holder.trim() &&
      form.value.copyright_contact.trim()
    ))
  )
})

// Calendar settings — block past dates, show full calendar
const fpConfig = {
  inline: true,
  dateFormat: 'Y-m-d',
  altInput: false,
  disableMobile: true,
  minDate: 'today',
  wrap: false
}

const filteredSlots = computed(() => {
  if (!form.value.booking_date) return []
  return timeSlots.value
})

const selectSlot = (id) => {
  form.value.time_slot_id = id
  console.log('Selected slot ID:', id)
}

const nextStep = () => {
  console.log('Step 1 form data:', form.value)
  step.value++
}

const submitForm = async () => {
  console.log('Submitting form:', form.value)
  try {
    const res = await axios.post('/api/launchpad/book', form.value)
    console.log('Server response:', res.data)
    toast.success('🎉 Booking submitted successfully!')
    resetForm()
    step.value = 1
  } catch (err) {
    console.error('Submission error:', err)
    toast.error('❌ Something went wrong. Please try again.')
  }
}

const resetForm = () => {
  form.value = {
    given_name: '',
    family_name: '',
    email: '',
    contact_number: '',
    country: '',
    submission_text: '',
    is_copyright: false,
    copyright_holder: '',
    copyright_contact: '',
    booking_date: '',
    time_slot_id: null
  }
}

const fetchTimeSlots = async () => {
  if (!form.value.booking_date) return

  try {
    const res = await axios.get('/api/launchpad/time-slots', {
      params: { booking_date: form.value.booking_date }
    })
    timeSlots.value = res.data
    console.log('Loaded time slots:', res.data)
  } catch (err) {
    console.error('Failed to load time slots:', err)
  }
}

// Refetch slots when booking date changes
watch(() => form.value.booking_date, (newDate) => {
  if (newDate) fetchTimeSlots()
})

// Initial load (if booking_date is pre-filled somehow)
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
  width: 100% !important;
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

  padding: 1rem;
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
  margin-top: -10px;
  margin-bottom: 10px;
  color: white !important;
}
.flatpickr-months .flatpickr-next-month,
.flatpickr-months .flatpickr-prev-month {
  color: black !important;
  font-weight: 600 !important;
  background-color: white !important;
  margin-top: 10px;
  border-radius: 5px;
}
.flatpickr-months .flatpickr-next-month {
  margin-right: 10px;
}


.flatpickr-months .flatpickr-prev-month {
  margin-left: 10px;
}


</style>
