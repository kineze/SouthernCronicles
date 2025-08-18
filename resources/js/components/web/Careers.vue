<template>
  <section class="max-w-screen-2xl mx-auto lg:px-4 lg:py-10 py-6">
    <h1 class="lg:text-6xl text-3xl mt-12 lg:mt-4 text-black font-extrabold tracking-widest uppercase text-center">
      Career Updates
    </h1>

    <!-- three cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-8">
      <!-- Internships -->
      <button
        @click="openCard('internship')"
        class="group border rounded p-4 bg-white dark:bg-gray-800 hover:shadow-lg text-left"
      >
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-black">Internships</h3>
          <!-- <i class="fa-solid" :class="isOpen('internship') ? 'fa-chevron-up' : 'fa-chevron-down'"></i> -->
        </div>
        <p class="mt-2 text-sm text-gray-600">
          Apply for internship opportunities.
        </p>
      </button>

      <!-- Volunteers -->
      <button
        @click="openCard('volunteer')"
        class="group border rounded p-4 bg-white dark:bg-gray-800 hover:shadow-lg text-left"
      >
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-black">Volunteers</h3>
          <!-- <i class="fa-solid" :class="isOpen('volunteer') ? 'fa-chevron-up' : 'fa-chevron-down'"></i> -->
        </div>
        <p class="mt-2 text-sm text-gray-600">
          Join as a volunteer for events and initiatives.
        </p>
      </button>

      <!-- Careers -->
      <button
        @click="openCard('careers')"
        class="group border rounded p-4 bg-white dark:bg-gray-800 hover:shadow-lg text-left"
      >
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-black">Careers</h3>
          <!-- <i class="fa-solid" :class="isOpen('careers') ? 'fa-chevron-up' : 'fa-chevron-down'"></i> -->
        </div>
        <p class="mt-2 text-sm text-gray-600">
          Browse current openings and apply.
        </p>
      </button>
    </div>

    <!-- COLLAPSIBLE SECTIONS -->
    <div class="mt-6 space-y-6">
      <!-- Internship form -->
      <transition @enter="collapseEnter" @after-enter="collapseAfterEnter" @leave="collapseLeave">
        <div v-show="isOpen('internship')" ref="internshipEl" class="border rounded p-5 bg-white dark:bg-gray-800">
          <h3 class="text-lg font-semibold mb-4 text-black">Internship Application</h3>
          <form @submit.prevent="submitInternship" class="grid md:grid-cols-2 gap-4">
            <!-- First Name -->
            <div class="relative">
              <input
                v-model.trim="internship.first_name"
                type="text"
                id="intern_first_name"
                placeholder=" "
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent
                      border border-gray-500 focus:outline-none focus:ring-0 focus:border-black
                      peer "
                required
              />
              <label
                for="intern_first_name"
                class="absolute text-sm text-gray-500 bg-white px-2 duration-300 transform
                      scale-75 -translate-y-4 top-2 z-10 origin-[0]
                      peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                      peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75
                      peer-focus:-translate-y-4 start-1"
              >First Name</label>
            </div>

            <!-- Last Name -->
            <div class="relative">
              <input
                v-model.trim="internship.last_name"
                type="text"
                id="intern_last_name"
                placeholder=" "
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent
                      border border-gray-500 focus:outline-none focus:ring-0 focus:border-black
                      peer "
                required
              />
              <label
                for="intern_last_name"
                class="absolute text-sm text-gray-500 bg-white px-2 duration-300 transform
                      scale-75 -translate-y-4 top-2 z-10 origin-[0]
                      peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                      peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75
                      peer-focus:-translate-y-4 start-1"
              >Last Name</label>
            </div>

            <!-- Email -->
            <div class="relative">
              <input
                v-model.trim="internship.email"
                type="email"
                id="intern_email"
                placeholder=" "
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent
                      border border-gray-500 focus:outline-none focus:ring-0 focus:border-black
                      peer "
                required
              />
              <label
                for="intern_email"
                class="absolute text-sm text-gray-500 bg-white px-2 duration-300 transform
                      scale-75 -translate-y-4 top-2 z-10 origin-[0]
                      peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                      peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75
                      peer-focus:-translate-y-4 start-1"
              >Email</label>
            </div>

            <!-- Phone (vue-tel-input) -->
            <div class="">
              <!-- <label class="block text-sm text-gray-600 font-medium mb-1" for="intern_phone">Contact Number</label> -->
              <VueTelInput
                id="intern_phone"
                ref="internshipTelRef"
                v-model="internship.phoneRaw"
                mode="international"
                :autoDefaultCountry="true"
                @country-changed="onInternshipCountry"
                @validate="onInternshipValidate"
                class="!text-sm !rounded-none pb-1.5"
              />
            </div>

            <!-- CV upload -->
            <div class="md:col-span-2">
              <label class="block text-sm font-medium mb-1">CV (PDF/DOC, max 5MB) *</label>
              <div
                class="border-2 border-dashed rounded p-6 text-center hover:bg-gray-50 dark:hover:bg-gray-700 coursor-pointer"
                :class="dragOver ? 'border-black' : 'border-gray-300'"
                @dragover.prevent="dragOver = true"
                @dragleave.prevent="dragOver = false"
                @drop.prevent="onDropCV"
                @click="cvFileInput?.click()"
              >
                <input ref="cvFileInput" type="file" accept=".pdf,.doc,.docx" class="hidden" @change="onPickCV" />
                <div v-if="!internship.cvFile" class="space-y-2">
                  <p class="text-sm">Drag & drop your CV here, or</p>
                  <button type="button" class="btn" >Choose file</button>
                </div>
                <div v-else class="flex items-center justify-between text-left">
                  <div>
                    <p class="font-medium">{{ internship.cvFile.name }}</p>
                    <p class="text-xs text-gray-500">Size: {{ prettyBytes(internship.cvFile.size) }}</p>
                  </div>
                  <button type="button" class="px-3 py-1 text-sm border rounded" @click="removeCV">Remove</button>
                </div>
              </div>
            </div>

            <!-- Submit -->
            <div class="md:col-span-2 flex items-center gap-3">
              <button :disabled="submittingIntern" class="btn-primary px-4 py-1.5 bg-black text-white font-semibold">
                <span v-if="submittingIntern">Submitting…</span>
                <span v-else>Submit</span>
              </button>
              <!-- <p class="text-xs text-gray-500">We’ll contact you via email/phone.</p> -->
            </div>
          </form>

        </div>
      </transition>

      <!-- Volunteer form -->
      <transition @enter="collapseEnter" @after-enter="collapseAfterEnter" @leave="collapseLeave">
        <div v-show="isOpen('volunteer')" ref="volunteerEl" class="border rounded-xl p-5 bg-white dark:bg-gray-800">
          <h3 class="text-lg font-semibold mb-4 text-black">Volunteer Application</h3>
          <form @submit.prevent="submitVolunteer" class="grid md:grid-cols-2 gap-4">
            <!-- First Name -->
            <div class="relative">
              <input
                v-model.trim="volunteer.first_name"
                type="text"
                id="vol_first_name"
                placeholder=" "
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent
                      border border-gray-500 focus:outline-none focus:ring-0 focus:border-black
                      peer "
                required
              />
              <label
                for="vol_first_name"
                class="absolute text-sm text-gray-500 bg-white px-2 duration-300 transform
                      scale-75 -translate-y-4 top-2 z-10 origin-[0]
                      peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                      peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75
                      peer-focus:-translate-y-4 start-1"
              >First Name</label>
            </div>

            <!-- Last Name -->
            <div class="relative">
              <input
                v-model.trim="volunteer.last_name"
                type="text"
                id="vol_last_name"
                placeholder=" "
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent
                      border border-gray-500 focus:outline-none focus:ring-0 focus:border-black
                      peer "
                required
              />
              <label
                for="vol_last_name"
                class="absolute text-sm text-gray-500 bg-white px-2 duration-300 transform
                      scale-75 -translate-y-4 top-2 z-10 origin-[0]
                      peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                      peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75
                      peer-focus:-translate-y-4 start-1"
              >Last Name</label>
            </div>

            <!-- Email -->
            <div class="relative">
              <input
                v-model.trim="volunteer.email"
                type="email"
                id="vol_email"
                placeholder=" "
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent
                      border border-gray-500 focus:outline-none focus:ring-0 focus:border-black
                      peer "
                required
              />
              <label
                for="vol_email"
                class="absolute text-sm text-gray-500 bg-white px-2 duration-300 transform
                      scale-75 -translate-y-4 top-2 z-10 origin-[0]
                      peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                      peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75
                      peer-focus:-translate-y-4 start-1"
              >Email</label>
            </div>

            <!-- Phone -->
            <div class="">
              <!-- <label class="block text-sm text-gray-600 font-medium mb-1" for="vol_phone">Contact Number</label> -->
              <VueTelInput
                id="vol_phone"
                ref="volunteerTelRef"
                v-model="volunteer.phoneRaw"
                mode="international"
                :autoDefaultCountry="true"
                @country-changed="onVolunteerCountry"
                @validate="onVolunteerValidate"
                class="!text-sm pb-1.5 !border-black/50 !border"
              />
            </div>

            <!-- Why -->
            <div class="relative md:col-span-2">
              <textarea
                v-model.trim="volunteer.why"
                id="vol_why"
                placeholder=" "
                rows="4"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent
                      border border-gray-500 focus:outline-none focus:ring-0 focus:border-black
                      peer rounded"
              ></textarea>
              <label
                for="vol_why"
                class="absolute text-sm text-gray-500 bg-white px-2 duration-300 transform
                      scale-75 -translate-y-4 top-2 z-10 origin-[0]
                      peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                      peer-placeholder-shown:top-6 peer-focus:top-2 peer-focus:scale-75
                      peer-focus:-translate-y-4 start-1"
              >Why do you want to volunteer? <span class="text-gray-400">(optional)</span></label>
            </div>

            <!-- Submit -->
            <div class="md:col-span-2 flex items-center gap-3">
              <button :disabled="submittingVol" class="btn-primary px-4 py-1.5 bg-black text-white font-semibold">
                <span v-if="submittingVol">Submitting…</span>
                <span v-else>Submit</span>
              </button>
            </div>
          </form>

        </div>
      </transition>

      <!-- Careers list -->
      <transition @enter="collapseEnter" @after-enter="collapseAfterEnter" @leave="collapseLeave">
        <div v-show="isOpen('careers')" ref="careersEl" class="border rounded p-5 bg-white dark:bg-gray-800">
          <div>
            <div class="mt-1 flex flex-col md:flex-row gap-3 md:items-center md:justify-between">
              <div class="relative w-full md:w-96">
                <i class="fa-solid fa-magnifying-glass text-sm absolute left-4 top-6 -translate-y-1.5 text-black pointer-events-none"></i>
                <input
                  id="career-search"
                  type="search"
                  v-model="search"
                  placeholder=" "
                  @input="onSearchInput"
                  class="peer block w-full rounded-full border bg-white text-sm text-gray-900
                        px-10 pr-10 pb-2.5 pt-4 border-gray-300 focus:outline-none focus:ring-0
                        focus:border-black dark:bg-gray-800 dark:text-white dark:border-gray-600
                        dark:focus:border-white appearance-none"
                  autocomplete="off"
                />
                <label
                  for="career-search"
                  class="absolute text-sm font-semibold text-gray-700 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0]
                        bg-white px-2 left-10 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                        peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4
                        dark:text-gray-300 dark:bg-gray-800">
                  Search Careers
                </label>
                <button
                  v-if="search"
                  @click="clearSearch"
                  type="button"
                  class="absolute right-4 top-6 -translate-y-2 text-black hover:text-gray-600"
                  aria-label="Clear search"
                  title="Clear">
                  <i class="fa-solid fa-xmark"></i>
                </button>
              </div>
            </div>

            <div class="mt-6">
              <div v-if="loading && items.length === 0" class="py-14 text-center text-gray-500">Loading…</div>
              <div v-else-if="!loading && items.length === 0" class="py-14 text-center text-gray-500">No careers found.</div>

              <div v-else class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <article
                  v-for="c in items"
                  :key="c.id"
                  class="group relative border rounded border-black/10 bg-white dark:bg-gray-800 p-4 md:p-5
                        hover:shadow-xl hover:border-black/10 transition flex items-start gap-4"
                >
                  <div class="flex-1 min-w-0">
                    <a :href="careerUrl(c)" class="block">
                      <h3 class="font-semibold text-gray-900 dark:text-white line-clamp-2">{{ c.title }}</h3>
                    </a>
                    <p v-if="c.small_description" class="mt-1 text-sm text-gray-700 dark:text-gray-200 line-clamp-2">
                      {{ c.small_description }}
                    </p>
                    <div class="mt-2 flex flex-wrap items-center gap-2 text-xs">
                      <span class="items-center gap-1 rounded-full font-semibold" :class="statusPillClass(c)" title="Status">
                        <i class="fa-solid" :class="isClosed(c) ? 'fa-lock text-rose-500' : 'fa-unlock text-green-600'"></i>
                        {{ isClosed(c) ? 'Closed' : 'Open' }}
                      </span>
                      <span class="text-gray-600 dark:text-gray-300">
                        <template v-if="c.closing_date">Closing Date: {{ formatDate(c.closing_date) }}</template>
                        <template v-else>Open until filled</template>
                      </span>
                      <span class="text-gray-500 dark:text-gray-400">•</span>
                      <span class="text-gray-600 dark:text-gray-300">Posted: {{ formatDateTime(c.created_at) }}</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between gap-3">
                      <div class="flex items-center gap-2 text-gray-600">
                        <button class="text-[11px] px-2 py-1 rounded border hover:bg-gray-50 dark:border-gray-700 flex items-center gap-1"
                                @click="copyLink(c)" title="Copy link">
                          <i class="fas fa-link"></i>
                        </button>
                        <a class="text-[11px] px-2 py-1 rounded border hover:bg-gray-50 dark:border-gray-700 flex items-center gap-1"
                           :href="waShare(c)" target="_blank" rel="noopener" title="WhatsApp">
                          <i class="fab fa-whatsapp text-green-600"></i>
                        </a>
                        <a class="text-[11px] px-2 py-1 rounded border hover:bg-gray-50 dark:border-gray-700 flex items-center gap-1"
                           :href="fbShare(c)" target="_blank" rel="noopener" title="Facebook">
                          <i class="fab fa-facebook text-blue-600"></i>
                        </a>
                        <a class="text-[11px] px-2 py-1 rounded border hover:bg-gray-50 dark:border-gray-700 flex items-center gap-1"
                           :href="xShare(c)" target="_blank" rel="noopener" title="X">
                          <i class="fab fa-x-twitter"></i>
                        </a>
                      </div>
                      <a :href="careerUrl(c)"
                         class="inline-flex items-center gap-2 px-3 py-1 text-xs font-semibold bg-black text-white hover:bg-black/90
                                dark:bg-white dark:text-black dark:hover:bg-white/90">
                        View More
                      </a>
                    </div>
                  </div>
                </article>
              </div>

              <div class="mt-10 text-center" v-if="hasMore">
                <button
                  @click="loadMore"
                  :disabled="loadingMore"
                  class="inline-flex items-center gap-2 px-5 py-2 rounded-xl border border-gray-300 hover:bg-gray-50 disabled:opacity-60"
                >
                  <svg v-if="loadingMore" class="animate-spin h-4 w-4" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a 8 8 0 018-8v3A5 5 0 007 12H4z"/>
                  </svg>
                  <span>{{ loadingMore ? 'Loading…' : 'Load more' }}</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </section>
</template>

<script setup>
import { onMounted, ref, computed, watchEffect } from 'vue'
import { useToast } from 'vue-toastification'
import { VueTelInput } from 'vue3-tel-input'
import 'vue3-tel-input/dist/vue3-tel-input.css'

const toast = useToast()

/* ---------- Collapsible ---------- */
const openSection = ref(null)
function isOpen(k){ return openSection.value === k }
function openCard(k){ openSection.value = openSection.value === k ? null : k }

/* ---------- Refs ---------- */
const internshipEl = ref(null)
const volunteerEl  = ref(null)
const careersEl    = ref(null)

const internshipTelRef = ref(null)
const volunteerTelRef  = ref(null)

/* ---------- Collapse transitions ---------- */
function collapseEnter(el){
  el.style.transition = 'height 240ms ease'
  el.style.overflow = 'hidden'
  el.style.height = '0px'
  const h = el.scrollHeight
  requestAnimationFrame(() => { el.style.height = h + 'px' })
}
function collapseAfterEnter(el){
  el.style.height = 'auto'
  el.style.overflow = ''
  el.style.transition = ''
}
function collapseLeave(el){
  el.style.transition = 'height 240ms ease'
  el.style.overflow = 'hidden'
  el.style.height = el.scrollHeight + 'px'
  requestAnimationFrame(() => { el.style.height = '0px' })
}

/* ---------- Shared helpers ---------- */
const dragOver = ref(false)
const cvFileInput = ref(null)
const prettyBytes = (n) => {
  if (!n && n !== 0) return ''
  const units = ['B','KB','MB','GB']; let i=0; while(n>=1024 && i<units.length-1){ n/=1024; i++ }
  return `${n.toFixed(1)} ${units[i]}`
}

/* ---------- Phone normalization (works regardless of emitted type) ---------- */
function normalizePhone(val) {
  if (typeof val === 'string') return val.replace(/\s+/g, '')
  if (val && typeof val === 'object') {
    // vue3-tel-input variants
    const e164 = val.e164 || val.E164 || ''
    const intl = val.international || val.number || val.national || ''
    const best = e164 || intl
    return best?.toString().replace(/\s+/g, '')
  }
  return ''
}

/* ---------- Internship form ---------- */
const internship = ref({
  first_name: '', last_name: '', email: '',
  phoneRaw: '',              // v-model of VueTelInput
  phone_normalized: '',      // filled by @validate (and used as first choice)
  phone_country_iso2: '', dial_code: '',
  cvFile: null
})
function onInternshipCountry(c){
  internship.value.phone_country_iso2 = c?.iso2 || ''
  internship.value.dial_code = c?.dialCode ? `+${String(c.dialCode).replace(/^\+/, '')}` : ''
}
function onInternshipValidate(payload){
  if (payload && typeof payload === 'object') {
    const { country } = payload
    if (country?.iso2) internship.value.phone_country_iso2 = String(country.iso2).toUpperCase()
    if (country?.dialCode) internship.value.dial_code = `+${String(country.dialCode).replace(/^\+/, '')}`
    internship.value.phone_normalized =
      payload?.number?.e164 ??
      payload?.formattedNumber?.e164 ??
      payload?.number?.international ??
      payload?.number ??
      internship.value.phoneRaw
    return
  }
  // legacy signature: (phone, isValid, country)
  const [phone, , country] = arguments
  if (country?.iso2) internship.value.phone_country_iso2 = String(country.iso2).toUpperCase()
  if (country?.dialCode) internship.value.dial_code = `+${String(country.dialCode).replace(/^\+/, '')}`
  internship.value.phone_normalized = phone || internship.value.phoneRaw
}
function onPickCV(e){
  const f = e.target.files?.[0]
  if (!f) return
  if (f.size > 5 * 1024 * 1024) { toast.error('File too large (max 5MB)'); return }
  internship.value.cvFile = f
}
function onDropCV(e){
  dragOver.value = false
  const f = e.dataTransfer?.files?.[0]
  if (!f) return
  if (f.size > 5 * 1024 * 1024) { toast.error('File too large (max 5MB)'); return }
  internship.value.cvFile = f
}
function removeCV(){
  internship.value.cvFile = null
  if (cvFileInput.value) cvFileInput.value.value = ''
}
const submittingIntern = ref(false)
async function submitInternship(){
  if (!internship.value.cvFile) { toast.error('Please upload your CV'); return }
  submittingIntern.value = true
  try{
    // Build best phone value (normalized -> model -> getNumber fallback)
    let phoneFull = (internship.value.phone_normalized || normalizePhone(internship.value.phoneRaw) || '').trim()
    try {
      const api = internshipTelRef.value
      if (api && typeof api.getNumber === 'function') {
        let n; try { n = api.getNumber('E164') } catch {}
        if (!n) { try { n = api.getNumber() } catch {} }
        if (n) phoneFull = String(n).trim()
      }
    } catch {}

    const fd = new FormData()
    fd.append('first_name', internship.value.first_name)
    fd.append('last_name',  internship.value.last_name)
    fd.append('email',      internship.value.email)

    if (phoneFull) fd.append('phone', phoneFull) // only append if non-empty
    fd.append('phone_country_iso2', internship.value.phone_country_iso2 || '')
    fd.append('dial_code',          internship.value.dial_code || '')
    fd.append('cv',                 internship.value.cvFile)

    const res = await fetch('/api/internships', { method:'POST', body: fd })
    if (!res.ok) throw await res.json().catch(()=>({message:'Submit failed'}))
    toast.success('Submitted! We’ll be in touch.')

    internship.value = {
      first_name:'', last_name:'', email:'',
      phoneRaw:'', phone_normalized:'', phone_country_iso2:'', dial_code:'',
      cvFile:null
    }
  }catch(err){
    toast.error(err?.message || 'Submission failed')
  }finally{
    submittingIntern.value = false
  }
}

/* ---------- Volunteer form ---------- */
const volunteer = ref({
  first_name: '', last_name: '', email: '',
  phoneRaw: '',              // v-model of VueTelInput
  phone_normalized: '',      // filled by @validate (and used as first choice)
  phone_country_iso2: '', dial_code: '',
  why: ''
})
function onVolunteerCountry(c){
  volunteer.value.phone_country_iso2 = c?.iso2 || ''
  volunteer.value.dial_code = c?.dialCode ? `+${String(c.dialCode).replace(/^\+/, '')}` : ''
}
function onVolunteerValidate(payload){
  if (payload && typeof payload === 'object') {
    const { country } = payload
    if (country?.iso2) volunteer.value.phone_country_iso2 = String(country.iso2).toUpperCase()
    if (country?.dialCode) volunteer.value.dial_code = `+${String(country.dialCode).replace(/^\+/, '')}`
    volunteer.value.phone_normalized =
      payload?.number?.e164 ??
      payload?.formattedNumber?.e164 ??
      payload?.number?.international ??
      payload?.number ??
      volunteer.value.phoneRaw
    return
  }
  // legacy signature: (phone, isValid, country)
  const [phone, , country] = arguments
  if (country?.iso2) volunteer.value.phone_country_iso2 = String(country.iso2).toUpperCase()
  if (country?.dialCode) volunteer.value.dial_code = `+${String(country.dialCode).replace(/^\+/, '')}`
  volunteer.value.phone_normalized = phone || volunteer.value.phoneRaw
}
const submittingVol = ref(false)
async function submitVolunteer(){
  submittingVol.value = true
  try{
    // Build best phone value (normalized -> model -> getNumber fallback)
    let phoneFull = (volunteer.value.phone_normalized || normalizePhone(volunteer.value.phoneRaw) || '').trim()
    try {
      const api = volunteerTelRef.value
      if (api && typeof api.getNumber === 'function') {
        let n; try { n = api.getNumber('E164') } catch {}
        if (!n) { try { n = api.getNumber() } catch {} }
        if (n) phoneFull = String(n).trim()
      }
    } catch {}

    const fd = new FormData()
    fd.append('first_name', volunteer.value.first_name)
    fd.append('last_name',  volunteer.value.last_name)
    fd.append('email',      volunteer.value.email)

    if (phoneFull) fd.append('phone', phoneFull) // only append if non-empty
    fd.append('phone_country_iso2', volunteer.value.phone_country_iso2 || '')
    fd.append('dial_code',          volunteer.value.dial_code || '')
    if (volunteer.value.why) fd.append('why', volunteer.value.why)

    const res = await fetch('/api/volunteers', { method:'POST', body: fd })
    if (!res.ok) throw await res.json().catch(()=>({message:'Submit failed'}))
    toast.success('Thanks for volunteering!')

    volunteer.value = {
      first_name:'', last_name:'', email:'',
      phoneRaw:'', phone_normalized:'', phone_country_iso2:'', dial_code:'',
      why:''
    }
  }catch(err){
    toast.error(err?.message || 'Submission failed')
  }finally{
    submittingVol.value = false
  }
}

/* ---------- Careers list (existing logic) ---------- */
const API_URL = '/api/careers'
const items = ref([])
const meta = ref(null)
const page = ref(1)
const perPage = ref(12)
const search = ref('')
const loading = ref(false)
const loadingMore = ref(false)
let debounceTimer = null
const onlyVisible = true
const hideClosed = false
const hasMore = computed(() => meta.value && meta.value.current_page < meta.value.last_page)

onMounted(()=>{ fetchPage(1, true) })

function clearSearch(){ search.value=''; onSearchInput() }
function onSearchInput(){
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(()=>{ fetchPage(1, true) }, 400)
}

async function fetchPage(targetPage=1, replace=false){
  if (replace) loading.value = true
  else loadingMore.value = true
  try{
    const params = new URLSearchParams({ page: String(targetPage), per_page: String(perPage.value) })
    if (search.value.trim()) params.set('search', search.value.trim())
    const res = await fetch(`${API_URL}?${params.toString()}`)
    const json = await res.json()
    let list = json.data ?? []
    if (onlyVisible) list = list.filter(x => !!x.status)
    if (hideClosed) list = list.filter(x => !isClosed(x))
    items.value = replace ? list : items.value.concat(list)
    meta.value = json.meta ?? null
    page.value = meta.value?.current_page ?? targetPage
  }catch(e){
    toast.error('Failed to load careers')
  }finally{
    loading.value = false
    loadingMore.value = false
  }
}
function loadMore(){ if (hasMore.value && !loadingMore.value) fetchPage(page.value + 1, false) }
function careerUrl(c){ return `/view-career/${c.id}` }
function formatDateTime(d){ if(!d) return ''; const dt=new Date(d); if(Number.isNaN(dt)) return ''; return dt.toLocaleDateString('en-US',{year:'numeric',month:'short',day:'2-digit'}) }
function formatDate(d){ return formatDateTime(d) }
function isClosed(c){ if(!c?.closing_date) return false; const end=new Date(c.closing_date); return !Number.isNaN(end) && end.getTime()<Date.now() }
function statusPillClass(c){ return isClosed(c) ? '' : (c.status ? '' : 'bg-gray-200 text-gray-700') }
function pageShareData(c){
  const url = careerUrl(c).startsWith('http') ? careerUrl(c) : `${window.location.origin}${careerUrl(c)}`
  return { url, title: c.title ?? 'Career', text: c.title ?? 'Career' }
}
function waShare(c){ const {url,title}=pageShareData(c); return `https://wa.me/?text=${encodeURIComponent(`${title} ${url}`)}` }
function fbShare(c){ const {url}=pageShareData(c); return `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}` }
function xShare(c){ const {url,title}=pageShareData(c); return `https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(url)}` }
async function copyLink(c){ const {url}=pageShareData(c); try{ await navigator.clipboard.writeText(url); toast.success('Link copied!',{timeout:1500}) }catch{ window.prompt('Copy link:', url) } }

/* react to perPage change */
watchEffect(()=>{
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(()=>{ fetchPage(1, true) }, 150)
})
</script>
