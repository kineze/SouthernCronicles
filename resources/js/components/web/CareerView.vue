<!-- resources/js/components/web/CareerView.vue -->
<template>
  <section class="max-w-screen-2xl mx-auto py-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
      <!-- MAIN -->
      <article class="lg:col-span-8">
        <div v-if="loadingCareer" class="text-gray-500">Loading career…</div>
        <div v-else-if="!career" class="text-gray-500">Career not found.</div>

        <template v-else>
          <!-- Header -->
          <div class="flex items-start gap-4">
            <div class="min-w-0">
              <h1 class="text-3xl lg:text-4xl font-extrabold text-black">
                {{ career.title }}
              </h1>
              <div class="mt-3 flex flex-wrap items-center gap-2 text-sm">
                <span class="inline-flex items-center gap-1 font-semibold">
                  <i class="fa-solid" :class="isClosed(career) ? 'fa-lock text-rose-500' : 'fa-unlock text-green-600'"></i>
                  {{ isClosed(career) ? 'Closed' : 'Open' }}
                </span>

                <div class="flex items-end justify-end">
                  <span v-if="career.closing_date" class="text-gray-700">
                    Closes: {{ formatDateOnly(career.closing_date) }}
                  </span>
                  <span v-else class="text-gray-700">Open until filled</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Content (Quill HTML) -->
          <div class="mt-8 prose max-w-none ql-render news-content" v-html="career.content"></div>

          <!-- Apply button -->
          <div class="mt-5 flex justify-center">
            <button
              class="text-white bg-black hover:bg-black/90 px-5 py-2 font-bold"
              @click="applyOpen = !applyOpen"
              :disabled="isClosed(career)"
            >
              {{ applyOpen ? 'Close Form' : 'Apply Now' }}
            </button>
          </div>

          <!-- Inline apply form (smooth reveal below the button) -->
          <transition name="slide-down">
            <div v-show="applyOpen" class="mt-6 overflow-hidden rounded border border-gray-200 p-5 lg:p-8 bg-white">
              <h3 class="text-lg text-black font-bold mb-4">Apply for: {{ career?.title }}</h3>

              <form @submit.prevent="submitApplication" class="space-y-4">
                <!-- Row: First/Last -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <!-- First Name -->
                  <div class="relative">
                    <input
                      v-model.trim="form.first_name"
                      type="text"
                      id="first_name"
                      placeholder=" "
                      class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent
                             border border-gray-500 focus:outline-none focus:ring-0 focus:border-black
                             peer rounded"
                      required
                    />
                    <label
                      for="first_name"
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
                      v-model.trim="form.last_name"
                      type="text"
                      id="last_name"
                      placeholder=" "
                      class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent
                             border border-gray-500 focus:outline-none focus:ring-0 focus:border-black
                             peer rounded"
                      required
                    />
                    <label
                      for="last_name"
                      class="absolute text-sm text-gray-500 bg-white px-2 duration-300 transform
                             scale-75 -translate-y-4 top-2 z-10 origin-[0]
                             peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                             peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75
                             peer-focus:-translate-y-4 start-1"
                    >Last Name</label>
                  </div>
                </div>

                <!-- Email -->
                <div class="relative">
                  <input
                    v-model.trim="form.email"
                    type="email"
                    id="email"
                    placeholder=" "
                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent
                           border border-gray-500 focus:outline-none focus:ring-0 focus:border-black
                           peer rounded"
                    required
                  />
                  <label
                    for="email"
                    class="absolute text-sm text-gray-500 bg-white px-2 duration-300 transform
                           scale-75 -translate-y-4 top-2 z-10 origin-[0]
                           peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                           peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75
                           peer-focus:-translate-y-4 start-1"
                  >Email Address</label>
                </div>

                <!-- Phone (vue3-tel-input) -->
                <div>
                  <label class="block text-sm text-gray-600 font-medium mb-1" for="tel">Contact Number</label>
                  <vue-tel-input
                    ref="telRef"
                    id="tel"
                    v-model="form.phone"
                    :preferredCountries="preferredCountries"
                    :dropdownOptions="{
                      showFlags: true,
                      showDialCodeInList: true,
                      showSearchBox: true,
                    }"
                    :inputOptions="{
                      showDialCode: true,
                      placeholder: 'Your phone number',
                      maxlength: 20
                    }"
                    @country-changed="onCountryChanged"
                    @validate="onValidate"
                    @open="telOpen = true"
                    @close="telOpen = false"
                    class="!text-sm"
                  />
                </div>

                <!-- CV Upload (drag & drop) -->
                <div>
                  <label class="block text-sm font-medium mb-1">Upload CV</label>
                  <div
                    class="relative border-2 border-dashed rounded-lg p-5 text-center"
                    :class="dropActive ? 'border-black bg-black/5' : 'border-gray-300 hover:border-black cursor-pointer'"
                    @dragenter.prevent="dropActive = true"
                    @dragover.prevent="dropActive = true"
                    @dragleave.prevent="dropActive = false"
                    @drop.prevent="handleDrop"
                    @click="$refs.cvInput.click()"
                  >
                    <template v-if="cvPreview">
                      <div class="flex items-center justify-between gap-3 bg-gray-50 rounded p-3">
                        <div class="flex items-center gap-3">
                          <i class="fa-regular fa-file-lines text-2xl text-gray-500"></i>
                          <div class="text-left">
                            <div class="text-sm font-semibold break-all">{{ cvPreview.name }}</div>
                            <div class="text-xs text-gray-500">{{ prettyBytes(cvPreview.size) }}</div>
                          </div>
                        </div>
                        <button type="button" @click="removeCv" class="text-rose-600 hover:text-rose-700">
                          <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                      </div>
                    </template>
                    <template v-else>
                      <p class="text-sm text-gray-600">
                        Click to upload or drag & drop your CV (PDF/DOC/DOCX, max 5 MB)
                      </p>
                      <button
                        type="button"
                        class="mt-3 inline-flex items-center gap-2 px-4 py-2 rounded text-gray-600 font-semibold"
                        @click="$refs.cvInput.click()"
                      >
                        Choose file
                      </button>
                    </template>

                    <input
                      ref="cvInput"
                      type="file"
                      class="hidden"
                      accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                      @change="onCvChange"
                    />
                  </div>
                  <p class="mt-1 text-xs text-gray-500">We accept .pdf, .doc, .docx up to 5 MB.</p>
                </div>

                <!-- Submit -->
                <div class="pt-2 flex items-center justify-end gap-3">
                  <button type="button" class="px-4 py-2 rounded border" @click="applyOpen = false">Cancel</button>
                  <button
                    type="submit"
                    class="px-5 py-2 rounded bg-black text-white font-bold disabled:opacity-60"
                    :disabled="submitting || !canSubmit"
                  >
                    <span v-if="submitting">Submitting…</span>
                    <span v-else>Submit Application</span>
                  </button>
                </div>
              </form>
            </div>
          </transition>
        </template>
      </article>

      <!-- SIDEBAR -->
      <aside class="lg:col-span-4">
        <div class="lg:sticky lg:top-4 space-y-6">
          <!-- Share -->
          <div class="rounded border border-gray-200 p-4">
            <h3 class="text-lg font-bold tracking-wider text-black mb-3">Share</h3>
            <div class="flex flex-wrap gap-2 text-gray-600">
              <button class="px-3 py-2 rounded border hover:bg-gray-50 flex items-center gap-2" @click="copyCurrentLink" title="Copy link">
                <i class="fas fa-link"></i>
              </button>
              <a class="px-3 py-2 rounded border hover:bg-gray-50 flex items-center gap-2" :href="waShare(career)" target="_blank" rel="noopener" title="WhatsApp">
                <i class="fab fa-whatsapp text-green-600"></i>
              </a>
              <a class="px-3 py-2 rounded border hover:bg-gray-50 flex items-center gap-2" :href="fbShare(career)" target="_blank" rel="noopener" title="Facebook">
                <i class="fab fa-facebook text-blue-600"></i>
              </a>
              <a class="px-3 py-2 rounded border hover:bg-gray-50 flex items-center gap-2" :href="xShare(career)" target="_blank" rel="noopener" title="X">
                <i class="fab fa-x-twitter"></i>
              </a>
            </div>
          </div>

          <!-- Latest Careers -->
          <div class="rounded border hidden lg:block border-gray-200 p-4 mt-6">
            <h3 class="text-lg text-black tracking-wider font-bold mb-4">Latest Careers</h3>

            <!-- Search -->
            <div class="relative mb-4">
              <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
              <input
                id="latest-career-search"
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
                for="latest-career-search"
                class="absolute text-sm font-semibold text-gray-700
                       duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0]
                       bg-white px-2 left-10
                       peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                       peer-placeholder-shown:top-1/2
                       peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4
                       dark:text-gray-300 dark:bg-gray-800"
              >
                Search Careers
              </label>
              <button
                v-if="search"
                @click="clearSearch"
                type="button"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                aria-label="Clear search"
                title="Clear"
              >
                <i class="fa-solid fa-xmark"></i>
              </button>
            </div>

            <!-- Horizontal list -->
            <div class="space-y-3">
              <article
                v-for="c in latest"
                :key="c.id"
                class="flex gap-3 p-2 rounded-lg border border-gray-100 hover:bg-gray-50"
              >
                <div class="min-w-0 flex-1">
                  <a :href="careerUrl(c)" class="block">
                    <h4 class="text-sm font-semibold text-gray-900 line-clamp-2">
                      {{ c.title }}
                    </h4>
                  </a>

                  <div class="mt-1 flex flex-wrap items-center gap-2 text-[11px]">
                    <span class="inline-flex items-center gap-1 font-semibold">
                      <i class="fa-solid" :class="isClosed(c) ? 'fa-lock text-rose-500' : 'fa-unlock text-green-600'"></i>
                      {{ isClosed(c) ? 'Closed' : 'Open' }}
                    </span>
                    <span v-if="c.closing_date" class="text-gray-600">Closes: {{ shortDate(c.closing_date) }}</span>
                  </div>

                  <div class="mt-2 flex items-center gap-2 text-black text-xs">
                    <a :href="waShare(c)" target="_blank" rel="noopener" title="WhatsApp" class="hover:text-green-600">
                      <i class="fab fa-whatsapp"></i>
                    </a>
                    <a :href="fbShare(c)" target="_blank" rel="noopener" title="Facebook" class="hover:text-blue-600">
                      <i class="fab fa-facebook"></i>
                    </a>
                    <a :href="xShare(c)" target="_blank" rel="noopener" title="X" class="hover:text-black">
                      <i class="fab fa-x-twitter"></i>
                    </a>
                    <button @click="copyLink(c)" class="ml-auto text-xs font-semibold hover:underline">Copy link</button>
                  </div>
                </div>
              </article>

              <div v-if="loadingMore" class="text-center text-gray-500 py-2">Loading…</div>
              <div ref="sentinel" class="h-6"></div>
            </div>
          </div>
        </div>
      </aside>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, computed } from 'vue'
import { useToast } from 'vue-toastification'

const toast = useToast()

/** Props */
const props = defineProps({
  careerId: { type: [String, Number], required: true },
  sidebarPerPage: { type: Number, default: 8 },
})

const openedId = computed(() => Number(props.careerId))
const API_BASE = '/api/careers'

/** Main career */
const career = ref(null)
const loadingCareer = ref(false)

async function fetchCareer() {
  loadingCareer.value = true
  try {
    const res = await fetch(`${API_BASE}/${props.careerId}`)
    if (!res.ok) throw new Error('Failed to fetch career')
    career.value = await res.json()
  } catch (e) {
    console.error(e)
    career.value = null
  } finally {
    loadingCareer.value = false
  }
}

/** Sidebar latest list */
const latest = ref([])
const meta = ref(null)
const page = ref(1)
const perPage = ref(props.sidebarPerPage)
const search = ref('')
const loadingMore = ref(false)
let debounceTimer = null
let io = null
const sentinel = ref(null)

function clearSearch() {
  search.value = ''
  onSearchInput()
}
function onSearchInput() {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(() => {
    latest.value = []
    page.value = 1
    fetchLatest(true)
  }, 350)
}

async function fetchLatest(replace = false) {
  loadingMore.value = true
  try {
    const params = new URLSearchParams({
      page: String(page.value),
      per_page: String(perPage.value),
    })
    if (search.value.trim()) params.set('search', search.value.trim())

    const res = await fetch(`${API_BASE}?${params.toString()}`)
    const json = await res.json()

    const incoming = (json.data ?? []).filter(c => Number(c.id) !== openedId.value)
    if (replace) latest.value = incoming
    else latest.value = latest.value.concat(incoming)

    meta.value = json.meta ?? null
  } catch (e) {
    console.error(e)
  } finally {
    loadingMore.value = false
  }
}

function canLoadMore() {
  if (!meta.value) return false
  return meta.value.current_page < meta.value.last_page
}
function loadMoreIfNeeded() {
  if (!loadingMore.value && canLoadMore()) {
    page.value += 1
    fetchLatest()
  }
}

/** Helpers */
function careerUrl(c) { return `/view-career/${c.id}` }
function shortDate(d) {
  const dt = new Date(d); if (Number.isNaN(dt.getTime())) return ''
  return dt.toLocaleDateString('en-US', { month: 'short', day: '2-digit' })
}
function formatDateOnly(d) {
  const dt = new Date(d); if (Number.isNaN(dt.getTime())) return ''
  return dt.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: '2-digit' })
}
function isClosed(c) {
  if (!c?.closing_date) return false
  const now = new Date()
  const end = new Date(c.closing_date)
  return !Number.isNaN(end.getTime()) && end.getTime() < now.getTime()
}

/** Share */
function pageShareData(obj) {
  if (!obj) return { url: location.href, title: document.title }
  const url = careerUrl(obj).startsWith('http') ? careerUrl(obj) : `${window.location.origin}${careerUrl(obj)}`
  return { url, title: obj.title ?? 'Career' }
}
function waShare(c) { const { url, title } = pageShareData(c); return `https://wa.me/?text=${encodeURIComponent(`${title} ${url}`)}` }
function fbShare(c) { const { url } = pageShareData(c); return `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}` }
function xShare(c)  { const { url, title } = pageShareData(c); return `https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(url)}` }
async function copyLink(c) { const { url } = pageShareData(c); try { await navigator.clipboard.writeText(url); toast.success('Link copied!', { timeout: 1500 }) } catch { window.prompt('Copy link:', url) } }
async function copyCurrentLink() { try { await navigator.clipboard.writeText(location.href); toast.success('Link copied!', { timeout: 1500 }) } catch {} }

/** Apply form state (inline) */
const applyOpen = ref(false)

/** Form */
const form = ref({
  first_name: '',
  last_name: '',
  email: '',
  phone: '',           // v-model from vue-tel-input
  phone_normalized: '',// <-- add this
  country_iso2: '',
  dial_code: '',
})

const submitting = ref(false)

/** vue-tel-input helpers */
const telRef = ref(null)
const telOpen = ref(false)
const preferredCountries = ['LK', 'IN', 'AE', 'SG'] // tweak if you like
const isPhoneValid = ref(false) // <-- track validity via @validate
const phoneRequired = false     // <-- set to true if you want phone to be mandatory

function onCountryChanged({ iso2, dialCode }) {
  form.value.country_iso2 = iso2?.toUpperCase() || ''
  form.value.dial_code = dialCode ? `+${dialCode.replace(/^\+/, '')}` : ''
}

function onValidate(payload) {
  // Newer versions: payload is an object
  if (payload && typeof payload === 'object') {
    const { isValid, country } = payload
    isPhoneValid.value = !!isValid

    if (country?.iso2) form.value.country_iso2 = String(country.iso2).toUpperCase()
    if (country?.dialCode) form.value.dial_code = `+${String(country.dialCode).replace(/^\+/, '')}`

    // Try several properties for the normalized number
    form.value.phone_normalized =
      payload?.number?.e164 ??
      payload?.formattedNumber?.e164 ??
      payload?.number?.international ??
      payload?.number ??
      form.value.phone
    return
  }

  // Older signature: onValidate(phone, isValid, country)
  const [phone, isValid, country] = arguments
  isPhoneValid.value = !!isValid
  if (country?.iso2) form.value.country_iso2 = String(country.iso2).toUpperCase()
  if (country?.dialCode) form.value.dial_code = `+${String(country.dialCode).replace(/^\+/, '')}`
  form.value.phone_normalized = phone || form.value.phone
}


const canSubmit = computed(() => {
  const basic = !!form.value.first_name && !!form.value.last_name && !!form.value.email && !!cvFile.value
  // Phone optional unless phoneRequired = true. If provided, must be valid.
  const hasPhone = !!form.value.phone?.trim()
  const phoneOk = phoneRequired ? isPhoneValid.value : (!hasPhone || isPhoneValid.value)
  return basic && phoneOk
})

/** CV upload */
const cvFile = ref(null)
const cvPreview = ref(null)
const dropActive = ref(false)
const cvInput = ref(null)

function onCvChange(e){
  const file = e.target.files?.[0]
  acceptCv(file)
}
function handleDrop(e){
  dropActive.value = false
  const file = e.dataTransfer?.files?.[0]
  acceptCv(file)
}
function acceptCv(file){
  if (!file) return
  const okTypes = ['application/pdf','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document']
  const extOk = /\.(pdf|docx?)$/i.test(file.name)
  if (!(okTypes.includes(file.type) || extOk)){
    toast.error('Please upload PDF/DOC/DOCX')
    return
  }
  if (file.size > 5 * 1024 * 1024){
    toast.error('File too large (max 5MB)')
    return
  }
  cvFile.value = file
  cvPreview.value = { name: file.name, size: file.size }
}
function removeCv(){
  cvFile.value = null
  cvPreview.value = null
  if (cvInput.value) cvInput.value.value = ''
}
function prettyBytes(n){
  if (n < 1024) return `${n} B`
  if (n < 1024*1024) return `${(n/1024).toFixed(1)} KB`
  return `${(n/1024/1024).toFixed(1)} MB`
}

/** Submit */
function csrf(){
  const meta = document.querySelector('meta[name="csrf-token"]')
  return meta?.getAttribute('content') || ''
}
async function submitApplication() {
  if (!career.value) return
  if (!cvFile.value) {
    toast.error('Please upload your CV')
    return
  }
  if (phoneRequired && !isPhoneValid.value) {
    toast.error('Please enter a valid phone number')
    return
  }

  submitting.value = true
  try {
    // Prefer normalized number captured in onValidate; then v-model; then library getNumber()
    let phoneFull = (form.value.phone_normalized || form.value.phone || '').trim()

    try {
      const api = telRef.value
      if (api && typeof api.getNumber === 'function') {
        // Try to force E.164 if supported, else default getNumber()
        let n
        try { n = api.getNumber('E164') } catch {}
        if (!n) { try { n = api.getNumber() } catch {} }
        if (n) phoneFull = String(n).trim()
      }
      // Some builds expose the last parsed number
      if (!phoneFull && api?.phoneNumber) {
        phoneFull = String(api.phoneNumber).trim()
      }
    } catch {}

    const fd = new FormData()
    fd.append('first_name', form.value.first_name)
    fd.append('last_name',  form.value.last_name)
    fd.append('email',      form.value.email)
    if (form.value.country_iso2) fd.append('country_iso2', form.value.country_iso2)
    if (form.value.dial_code)    fd.append('dial_code', form.value.dial_code)
    if (phoneFull)               fd.append('phone', phoneFull)
    fd.append('cv', cvFile.value)

    const res = await fetch(`${API_BASE}/${career.value.id}/apply`, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': csrf() },
      body: fd
    })

    if (!res.ok) {
      let message = 'Failed to submit'
      try {
        const j = await res.json()
        if (j?.errors) {
          const firstKey = Object.keys(j.errors)[0]
          message = Array.isArray(j.errors[firstKey]) ? j.errors[firstKey][0] : (j.message || message)
        } else if (j?.message) {
          message = j.message
        }
      } catch {}
      throw new Error(message)
    }

    toast.success('Application submitted. Thank you!')
    form.value = { first_name:'', last_name:'', email:'', phone:'', phone_normalized:'', country_iso2:'', dial_code:'' }
    isPhoneValid.value = false
    removeCv()
    applyOpen.value = false
  } catch (e) {
    toast.error(e.message || 'Submission failed')
  } finally {
    submitting.value = false
  }
}

/** Lifecycle */
onMounted(async () => {
  await fetchCareer()
  await fetchLatest(true)

  io = new IntersectionObserver((entries) => {
    entries.forEach((e) => { if (e.isIntersecting) loadMoreIfNeeded() })
  }, { root: null, rootMargin: '200px', threshold: 0 })
  if (sentinel.value) io.observe(sentinel.value)
})
onBeforeUnmount(() => {
  clearTimeout(debounceTimer)
  if (io && sentinel.value) io.unobserve(sentinel.value)
  if (io) io.disconnect()
})
</script>

<style scoped>
/* Hide default clear icon in WebKit search fields */
#latest-career-search::-webkit-search-cancel-button,
#latest-career-search::-webkit-search-decoration,
#latest-career-search::-webkit-search-results-button,
#latest-career-search::-webkit-search-results-decoration {
  -webkit-appearance: none;
  appearance: none;
  display: none;
}
#latest-career-search::-ms-clear { display: none; width: 0; height: 0; }

/* Quill output helpers */
.news-content .ql-align-center { text-align: center; }
.news-content .ql-align-right  { text-align: right; }
.news-content .ql-align-justify{ text-align: justify; }
.news-content .ql-indent-1 { margin-left: 3em; }
.news-content .ql-indent-2 { margin-left: 6em; }

/* Slide down transition (inline reveal) */
.slide-down-enter-from,
.slide-down-leave-to { opacity: 0; transform: translateY(-8px); }
.slide-down-enter-active,
.slide-down-leave-active { transition: all .22s ease; }

/* tighten vue-tel-input */
:deep(.vue-tel-input) {
  --vti-border-radius: 0.375rem;
  --vti-input-border: 1px solid #6b7280;
  --vti-input-focus-border: 1px solid #000;
  --vti-input-padding: 0.5rem 0.75rem;
  font-size: .875rem;
}
.vue-tel-input .vti__flag {
  filter: none !important;
  background-color: transparent !important;
}
</style>
