<template>
  <div class="max-w-screen-2xl mx-auto bg-white dark:bg-gray-900 shadow py-10">
    <h1 class="lg:text-6xl text-3xl mt-4 text-black dark:text-white font-extrabold tracking-widest uppercase text-center mb-8">
      Partner With Us
    </h1>

    <div class="flex flex-wrap">
      <!-- Left: Copy -->
      <div class="max-w-7xl lg:w-7/12 mt-10 lg:p-4 space-y-6 text-gray-700 dark:text-gray-300 text-base leading-relaxed">
        <h2 class="text-lg font-semibold text-black dark:text-white">Why Partner With Us?</h2>
        <p class="text-justify">
          Join us to champion cultural preservation and creative innovation. Your brand helps safeguard living heritage while connecting with engaged audiences through meaningful programs, performances, and education.
        </p>

        <h2 class="text-lg font-semibold text-black dark:text-white">Benefits</h2>
        <ul class="list-disc pl-6 space-y-2">
          <li>Brand visibility across festivals, stages, and digital channels.</li>
          <li>Community impact through preservation of living heritage.</li>
          <li>Co-created campaigns, showcases, and thought-leadership opportunities.</li>
          <li>Access to exclusive cultural experiences and VIP engagements.</li>
        </ul>

        <h2 class="text-lg font-semibold text-black dark:text-white">Let’s Build Together</h2>
        <p class="text-justify">
          Tell us about your brand and why you’d like to partner. We’ll get in touch with tailored collaboration options aligned with your goals.
        </p>

      </div>

      <!-- Right: Form -->
      <div class="mt-10 max-w-4xl lg:w-5/12 lg:p-4 mx-auto bg-white dark:bg-gray-800 rounded-lg shadow space-y-6 lg:sticky lg:top-4 lg:max-h-[100svh] lg:overflow-y-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- First Name -->
          <div class="relative">
            <input v-model.trim="form.first_name" type="text" id="first_name" placeholder=" "
                   class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer" required />
            <label for="first_name"
                   class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]">
              First Name
            </label>
          </div>

          <!-- Last Name -->
          <div class="relative">
            <input v-model.trim="form.last_name" type="text" id="last_name" placeholder=" "
                   class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer" required />
            <label for="last_name"
                   class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]">
              Last Name
            </label>
          </div>

          <!-- Brand Name -->
          <div class="relative md:col-span-2">
            <input v-model.trim="form.brand_name" type="text" id="brand_name" placeholder=" "
                   class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer" required />
            <label for="brand_name"
                   class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]">
              Brand Name
            </label>
          </div>

          <!-- Email -->
          <div class="relative md:col-span-2">
            <input v-model.trim="form.email" type="email" id="email" placeholder=" "
                   class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer" required />
            <label for="email"
                   class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]">
              Email Address
            </label>
          </div>

          <!-- Phone (vue3-tel-input) -->
          <div class="relative md:col-span-2">
            <VueTelInput
              ref="telRef"
              v-model="form.phoneRaw"
              :mode="'international'"
              :input-options="{ showDialCode: true, placeholder: 'Contact Number' }"
              :autoDefaultCountry="true"
              @country-changed="onCountry"
              @validate="onValidate"
              class="!text-sm !rounded-none pb-1.5"
            />
          </div>
        </div>

        <!-- Description -->
        <div class="relative">
          <textarea v-model.trim="form.description" id="description" rows="4" placeholder=" "
                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer"></textarea>
          <label for="description"
                 class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]">
            Why partner with us? (optional)
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

            <!-- Our Products -->
        <section class="mt-10">
            <h1 class="lg:text-4xl text-3xl mt-4 text-black dark:text-white font-extrabold tracking-widest uppercase text-center mb-8">
            Our Products
            </h1>

          <div class="grid grid-cols-1 sm:grid-cols-4 gap-6">
            <article
              v-for="p in products"
              :key="p.key"
              class="group border rounded-lg overflow-hidden bg-white dark:bg-gray-800 shadow hover:shadow-xl transition"
            >
              <!-- Video with fixed aspect ratio (16:9) -->
              <div class="relative pt-[56.25%] bg-white">
                <video
                  class="absolute inset-0 w-40 h-40 mx-auto my-auto object-contain"
                  :poster="p.poster || ''"
                  :aria-label="p.title"
                  playsinline
                  muted
                  loop
                  autoplay
                  preload="none"
                  disablepictureinpicture
                  controlslist="nodownload noplaybackrate noremoteplayback"
                >
                  <source :src="p.video" type="video/webm" />
                  Your browser does not support the video tag.
                </video>
              </div>

              <div class="p-4">

                <a
                    :href="p.url"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="hover:underline hover:text-blue-600 dark:hover:text-blue-400 transition"
                  >
                <h3 class="font-semibold text-gray-900 dark:text-white text-lg">
                  {{ p.title }}
                </h3>

                </a>
                <p class="mt-1 text-sm text-gray-700 dark:text-gray-200">
                  {{ p.description }}
                </p>

              </div>
            </article>
          </div>
        </section>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useToast } from 'vue-toastification'
import { VueTelInput } from 'vue3-tel-input'
import 'vue3-tel-input/dist/vue3-tel-input.css'

const toast = useToast()
const submitting = ref(false)
const telRef = ref(null)

/* --- Our Products (videos under /public/videos, posters under /public/images/products) --- */
const products = ref([
  {
    key: 'writing-lab',
    title: 'The Asian group of Literature',
    video: '/assets/img/writinglab.webm',
    poster: '/images/products/writing-lab.jpg',
    description:
      'A collective dedicated to celebrating Asian literature—mentoring emerging writers, nurturing diverse narratives, and amplifying voices across cultures.',
    url: '/asian-group-of-literature'   // ✅ Add URL here
  },
  {
    key: 'kipenzi',
    title: 'Kipenzi',
    video: '/assets/img/kipenzigirl.webm',
    poster: '/images/products/kipenzi.jpg',
    description:
      'A living-heritage platform celebrating diverse cultures through performances, workshops, and immersive experiences.',
    url: '/the-kipenzi'
  },
  {
    key: 'kipenzi-toys-books',
    title: 'Kipenzi Toys & Books',
    video: '/assets/img/kipenzytoys.webm',
    poster: '/images/products/kipenzi-toys-books.jpg',
    description:
      'Playful learning tools that bring folklore and tradition to life—designed for curious minds at home and in the classroom.',
    url: '#'
  },
  {
    key: 'purple-umbrella',
    title: 'Purple Umbrella Franchise',
    video: '/assets/img/umbrella.webm',
    poster: '/images/products/purple-umbrella.jpg',
    description:
      'A community-first franchise model that empowers local partners to host cultural events and micro-festivals under one vibrant umbrella.',
    url: '/the-purple-umbrella'
  }
])


/* --- Form state --- */
const form = ref({
  first_name: '',
  last_name: '',
  brand_name: '',
  email: '',
  phoneRaw: '',            // v-model for the component (can be string or object)
  phone_normalized: '',    // best normalized value (E.164 if available)
  country_iso2: '',
  dial_code: '',
  description: ''
})

/* Normalize helper (resilient to lib variations) */
function normalizePhone(val) {
  if (typeof val === 'string') return val.replace(/\s+/g, '')
  if (val && typeof val === 'object') {
    const e164 = val.e164 || val.E164 || ''
    const intl = val.international || val.number || val.national || ''
    const best = e164 || intl
    return (best || '').toString().replace(/\s+/g, '')
  }
  return ''
}

/* vue-tel-input events */
function onCountry(c){
  form.value.country_iso2 = c?.iso2 ? String(c.iso2).toUpperCase() : ''
  form.value.dial_code = c?.dialCode ? `+${String(c.dialCode).replace(/^\+/, '')}` : ''
}

function onValidate(payload){
  // New signature payload object
  if (payload && typeof payload === 'object') {
    const { country } = payload
    if (country?.iso2) form.value.country_iso2 = String(country.iso2).toUpperCase()
    if (country?.dialCode) form.value.dial_code = `+${String(country.dialCode).replace(/^\+/, '')}`
    form.value.phone_normalized =
      payload?.number?.e164 ??
      payload?.formattedNumber?.e164 ??
      payload?.number?.international ??
      payload?.number ??
      form.value.phoneRaw
    return
  }
  // Legacy signature: (phone, isValid, country)
  const [phone, , country] = arguments
  if (country?.iso2) form.value.country_iso2 = String(country.iso2).toUpperCase()
  if (country?.dialCode) form.value.dial_code = `+${String(country.dialCode).replace(/^\+/, '')}`
  form.value.phone_normalized = phone || form.value.phoneRaw
}

const clearForm = () => {
  form.value = {
    first_name: '',
    last_name: '',
    brand_name: '',
    email: '',
    phoneRaw: '',
    phone_normalized: '',
    country_iso2: '',
    dial_code: '',
    description: ''
  }
}

const submitForm = async () => {
  // Build best phone value: normalized -> model -> getNumber()
  let phoneFull = (form.value.phone_normalized || normalizePhone(form.value.phoneRaw) || '').trim()
  try {
    const api = telRef.value
    if (api && typeof api.getNumber === 'function') {
      let n; try { n = api.getNumber('E164') } catch {}
      if (!n) { try { n = api.getNumber() } catch {} }
      if (n) phoneFull = String(n).trim()
    }
  } catch {}

  const first = form.value.first_name?.trim()
  const last  = form.value.last_name?.trim()
  const brand = form.value.brand_name?.trim()
  const email = form.value.email?.trim()
  const phoneDigits = (phoneFull || '').replace(/\D/g, '')

  if (!first || !last || !brand || !email || phoneDigits.length < 6) {
    toast.error('Please fill all required fields.')
    return
  }

  try {
    submitting.value = true
    await axios.post('/api/partner-inquiries', {
      first_name: first,
      last_name: last,
      brand_name: brand,
      email,
      phone: phoneFull,
      country_iso2: form.value.country_iso2 || '',
      dial_code: form.value.dial_code || '',
      description: form.value.description || ''
    })
    toast.success('✅ Thank you! We will contact you soon.')
    clearForm()
  } catch (e) {
    toast.error(e?.response?.data?.message || '❌ Submission failed. Please try again.')
  } finally {
    submitting.value = false
  }
}
</script>
