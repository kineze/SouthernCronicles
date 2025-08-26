<template>
  <section class="relative max-w-screen-2xl mx-auto bg-white dark:bg-gray-900 shadow py-10 font-poppins">
    <!-- Title -->
    <div class="px-4">
      <h1 class="text-3xl lg:text-6xl text-black dark:text-white font-extrabold tracking-widest uppercase text-center">
        The Galaxy
      </h1>
      <p class="text-center mt-2 text-gray-600 dark:text-gray-300">
        A Constellation of Creative Excellence
      </p>
    </div>

    <div class="flex flex-wrap px-4 w-full lg:px-6 gap-6">
      <!-- Left: Content -->
      <div class="w-full lg:w-6/12 mt-8 space-y-5 text-gray-700 dark:text-gray-300 leading-relaxed">
        <p>
          The Galaxy is our carefully curated collective of writers, thinkers, and artists—the creative stars who
          illuminate The Asian Literary Festival network. Each year, we roster these exceptional voices to mobilize across
          our interconnected festival ecosystem, creating opportunities for our Galaxy members to explore the world
          through our expanding network of cultural destinations.
        </p>
        <p>
          More than just a membership program, The Galaxy serves as a dynamic creative database developed exclusively
          for The Asian Literary Festival. This living constellation grows annually as new voices join our existing stars,
          ensuring a continuous evolution of diverse perspectives and artistic excellence.
        </p>
        <p>
          Membership in The Galaxy comes through two pathways: by invitation for outstanding creators who catch our
          attention through their exceptional work, or by application for passionate artists ready to contribute to our
          global mission of creative excellence and cultural exchange.
        </p>
        <p>
          As part of the world's fastest-growing literary and art festival network, Galaxy members gain access to
          international festival participation opportunities, global networking with fellow creatives, cultural exchange
          programs across our network, and professional development through collaborative projects that span continents
          and cultures.
        </p>
        <h2 class="text-xl font-semibold text-black dark:text-white mt-4">Ready to Join Our Galaxy?</h2>
        <p>
          To become part of this extraordinary creative constellation, submit your application using the form. While we
          cannot respond to every application individually, if you possess the skills and vision we seek, we will surely
          reach out to you. Your creative journey across the world begins with a single step into The Galaxy.
        </p>

        <button
          @click="scrollToForm"
          type="button"
          class="mt-2 inline-flex items-center gap-2 px-5 py-2 rounded bg-black text-white hover:bg-gray-800 transition"
        >
          Apply Now
          <i class="fa-solid fa-arrow-right-long"></i>
        </button>
      </div>

      <!-- Right: Form -->
      <div
        ref="formBox"
        class="mt-4 w-full lg:w-5/12 lg:p-4 mx-auto bg-white dark:bg-gray-800 rounded-lg shadow space-y-6 lg:sticky lg:top-6"
      >
        <h3 class="text-lg font-semibold text-black dark:text-white">Galaxy Application Form</h3>

        <form @submit.prevent="submitGalaxy" class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- First Name -->
          <div class="relative">
            <input
              v-model.trim="galaxy.first_name"
              type="text"
              id="gal_first_name"
              placeholder=" "
              class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-400 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer rounded"
              required
            />
            <label
              for="gal_first_name"
              class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]
                     peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4">
              First name
            </label>
          </div>

          <!-- Last Name -->
          <div class="relative">
            <input
              v-model.trim="galaxy.last_name"
              type="text"
              id="gal_last_name"
              placeholder=" "
              class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-400 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer rounded"
              required
            />
            <label
              for="gal_last_name"
              class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]
                     peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4">
              Last name
            </label>
          </div>

          <!-- Email -->
          <div class="relative md:col-span-2">
            <input
              v-model.trim="galaxy.email"
              type="email"
              id="gal_email"
              placeholder=" "
              class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-400 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer rounded"
              required
            />
            <label
              for="gal_email"
              class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]
                     peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4">
              Email
            </label>
          </div>

          <!-- Phone (vue3-tel-input) -->
          <div class="md:col-span-2">
            <label class="block text-sm text-gray-600 dark:text-gray-300 mb-1">Phone number</label>
            <VueTelInput
              id="gal_phone"
              ref="galaxyTelRef"
              v-model="galaxy.phoneRaw"
              mode="international"
              :autoDefaultCountry="true"
              :preferredCountries="['LK','AE','IN','AU','GB']"
              @country-changed="onGalaxyCountry"
              @validate="onGalaxyValidate"
              class="!text-sm pb-1.5 !border-black/50 !border"
            />
            <small class="text-gray-500 dark:text-gray-400">International format preferred.</small>
          </div>

          <!-- Description (optional) -->
          <div class="relative md:col-span-2">
            <textarea
              v-model.trim="galaxy.description"
              id="gal_description"
              rows="4"
              placeholder=" "
              class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-400 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer rounded"
            ></textarea>
            <label
              for="gal_description"
              class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]
                     peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4">
              Describe your creative practice / strengths (optional)
            </label>
          </div>

          <!-- Submit -->
          <div class="md:col-span-2 text-start">
            <button
              :disabled="submitting"
              type="submit"
              class="px-6 py-2 bg-black text-white font-semibold hover:bg-gray-800 transition disabled:opacity-60 rounded"
            >
              {{ submitting ? 'Submitting…' : 'Submit Application' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import { useToast } from 'vue-toastification'
import { VueTelInput } from 'vue3-tel-input'
import 'vue3-tel-input/dist/vue3-tel-input.css'

const toast = useToast()

/* -------- Helpers (same approach as your “belve” component) -------- */
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

/* -------- State -------- */
const formBox = ref(null)
const galaxyTelRef = ref(null)

const galaxy = ref({
  first_name: '',
  last_name:  '',
  email:      '',
  phoneRaw:   '',   // v-model of VueTelInput
  phone_norm: '',   // set by @validate (preferred)
  phone_country_iso2: '',
  dial_code: '',
  description: ''
})

/* -------- Tel events match your pattern -------- */
function onGalaxyCountry(c){
  galaxy.value.phone_country_iso2 = c?.iso2 || ''
  galaxy.value.dial_code = c?.dialCode ? `+${String(c.dialCode).replace(/^\+/, '')}` : ''
}
function onGalaxyValidate(payload){
  if (payload && typeof payload === 'object') {
    const { country } = payload
    if (country?.iso2)    galaxy.value.phone_country_iso2 = String(country.iso2).toUpperCase()
    if (country?.dialCode) galaxy.value.dial_code = `+${String(country.dialCode).replace(/^\+/, '')}`

    galaxy.value.phone_norm =
      payload?.number?.e164 ??
      payload?.formattedNumber?.e164 ??
      payload?.number?.international ??
      payload?.number ??
      galaxy.value.phoneRaw
    return
  }
  // legacy signature (phone, isValid, country)
  const [phone, , country] = arguments
  if (country?.iso2)    galaxy.value.phone_country_iso2 = String(country.iso2).toUpperCase()
  if (country?.dialCode) galaxy.value.dial_code = `+${String(country.dialCode).replace(/^\+/, '')}`
  galaxy.value.phone_norm = phone || galaxy.value.phoneRaw
}

/* -------- UX -------- */
const submitting = ref(false)
function scrollToForm(){ formBox.value?.scrollIntoView({ behavior: 'smooth', block: 'start' }) }

/* -------- Submit (FormData + fetch, like your sample) -------- */
async function submitGalaxy(){
  // Build best phone value: normalized -> model -> getNumber fallback
  let phoneFull = (galaxy.value.phone_norm || normalizePhone(galaxy.value.phoneRaw) || '').trim()
  try {
    const api = galaxyTelRef.value
    if (api && typeof api.getNumber === 'function') {
      let n; try { n = api.getNumber('E164') } catch {}
      if (!n) { try { n = api.getNumber() } catch {} }
      if (n) phoneFull = String(n).trim()
    }
  } catch {}

  // Basic front-end checks (server also validates)
  if (!galaxy.value.first_name || !galaxy.value.last_name || !galaxy.value.email || !phoneFull) {
    toast.error('Please fill in first name, last name, email, and phone.')
    return
  }

  submitting.value = true
  try {
    const fd = new FormData()
    fd.append('first_name', galaxy.value.first_name)
    fd.append('last_name',  galaxy.value.last_name)
    fd.append('email',      galaxy.value.email)
    fd.append('phone',      phoneFull)
    fd.append('phone_country_iso2', galaxy.value.phone_country_iso2 || '')
    fd.append('dial_code',          galaxy.value.dial_code || '')
    if (galaxy.value.description) fd.append('description', galaxy.value.description)

    const res = await fetch('/api/galaxy-applications', { method: 'POST', body: fd })
    if (!res.ok) throw await res.json().then(j => j).catch(() => ({ message: 'Submit failed' }))

    toast.success('✅ Application submitted! We’ll review and reach out if selected.')
    galaxy.value = {
      first_name: '', last_name: '', email: '',
      phoneRaw: '', phone_norm: '', phone_country_iso2: '', dial_code: '',
      description: ''
    }
  } catch (err) {
    toast.error(err?.message || '❌ Submission failed. Please try again.')
  } finally {
    submitting.value = false
  }
}
</script>

<style scoped>
label { pointer-events: none; }
</style>
