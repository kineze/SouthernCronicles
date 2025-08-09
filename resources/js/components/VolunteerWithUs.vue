<template>
  <div class="max-w-screen-2xl mx-auto bg-white dark:bg-gray-900 shadow py-10">
    <h1 class="lg:text-6xl text-3xl mt-4 text-black dark:text-white font-extrabold tracking-widest uppercase text-center mb-8">
      Volunteer With Us
    </h1>

    <div class="flex flex-wrap">
      <!-- Left content -->
        <div class="max-w-7xl lg:w-7/12 mt-10 lg:p-4 space-y-6 text-gray-700 dark:text-gray-300 text-base leading-relaxed">

            <!-- Subtitle 1 -->
            <h2 class="text-lg font-semibold text-black dark:text-white">Why Volunteer?</h2>
            <p class="text-justify">
                Across the world, stories, songs, rituals, and traditional skills are fading with each passing generation. By volunteering with us, you help protect this living heritage — the cultural knowledge and creative expressions that connect communities to their history and identity.
            </p>

            <!-- Subtitle 2 -->
            <h2 class="text-lg font-semibold text-black dark:text-white">Ways You Can Help</h2>
            <p class="text-justify">
                We welcome volunteers from all walks of life. Whether you excel at outreach and communication, enjoy documenting through photography or video, have translation or editing skills, or are skilled at research and archiving, your efforts will help safeguard wisdom for the future. Every role matters in preserving and sharing these traditions.
            </p>

            <!-- Subtitle 3 -->
            <h2 class="text-lg font-semibold text-black dark:text-white">Get Involved Today</h2>
            <p class="font-medium text-justify">
                If you’re passionate about honoring the past while empowering the future, join our volunteer network. Fill out the form, and our team will contact you with the next steps to start your journey with us.
            </p>

        </div>


      <!-- Right column: Form -->
      <div class="mt-10 max-w-4xl lg:w-5/12 lg:p-4 mx-auto bg-white dark:bg-gray-800 rounded-lg shadow space-y-6 lg:sticky lg:top-4 lg:max-h-[100svh] lg:overflow-y-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- First Name -->
          <div class="relative">
            <input v-model="form.first_name" type="text" id="first_name" placeholder=" "
                   class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer" required />
            <label for="first_name" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]">
              First Name
            </label>
          </div>

          <!-- Last Name -->
          <div class="relative">
            <input v-model="form.last_name" type="text" id="last_name" placeholder=" "
                   class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer" required />
            <label for="last_name" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]">
              Last Name
            </label>
          </div>

          <!-- Email -->
          <div class="relative md:col-span-2">
            <input v-model="form.email" type="email" id="email" placeholder=" "
                   class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer" required />
            <label for="email" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]">
              Email
            </label>
          </div>

          <!-- Contact Number -->
          <div class="relative md:col-span-2">
            <input v-model="form.contact_number" type="text" id="contact_number" placeholder=" "
                   class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer" required />
            <label for="contact_number" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]">
              Contact Number
            </label>
          </div>
        </div>

        <!-- Description (optional) -->
        <div class="relative">
          <textarea v-model="form.description" id="description" rows="4" placeholder=" "
                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer"></textarea>
          <label for="description" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]">
            Tell us about your skills / interests (optional)
          </label>
        </div>

        <!-- Submit -->
        <div class="text-start">
          <button @click="submitForm" :disabled="submitting"
                  class="px-6 py-2 bg-black text-white font-semibold hover:bg-gray-800 transition disabled:opacity-60">
            {{ submitting ? 'Submitting…' : 'Submit' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useToast } from 'vue-toastification'
import axios from 'axios'

const toast = useToast()
const submitting = ref(false)

const form = ref({
  email: '',
  first_name: '',
  last_name: '',
  contact_number: '',
  description: ''
})

const clearForm = () => {
  form.value = { email: '', first_name: '', last_name: '', contact_number: '', description: '' }
}

const submitForm = async () => {
  if (!form.value.email || !form.value.first_name || !form.value.last_name || !form.value.contact_number) {
    toast.error('Please fill all required fields.')
    return
  }
  try {
    submitting.value = true
    await axios.post('/api/volunteers', form.value)
    toast.success('✅ Thank you for volunteering! We will contact you soon.')
    clearForm()
  } catch (e) {
    toast.error(e?.response?.data?.message || '❌ Submission failed. Please try again.')
  } finally {
    submitting.value = false
  }
}
</script>
