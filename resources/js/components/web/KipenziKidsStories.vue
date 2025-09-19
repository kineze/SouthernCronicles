<template>
  <div class="max-w-screen-2xl mx-auto bg-white dark:bg-gray-900 shadow py-10">
    <h1 class="lg:text-6xl text-3xl mt-4 text-primary-blue dark:text-white font-extrabold tracking-widest uppercase text-center mb-8">
      Share your magical story with the world!
    </h1>

    <div class="flex flex-wrap">

      <div class="lg:w-5/12 lg:pr-6">
    <div class="lg:sticky lg:top-3">
      <div class="relative lg:h-[850px] h-[400px] w-full overflow-hidden rounded-3xl ring-1 ring-black/10">
        <video
          src="/public/assets/img/alfkids.webm"
          autoplay
          muted
          loop
          playsinline
          class="absolute inset-0 w-full h-full object-cover aspect-auto bg-black"
        ></video>

        <div class="bg-white text-end p-2 z-50 text-white font-bold w-full absolute bottom-0 bg-opacity-20 backdrop-blur-2xl -mt-12">
          KIPENZI™
        </div>
      </div>
    </div>
  </div>

      <div
        class="mt-10 max-w-4xl lg:w-7/12 lg:p-4 mx-auto bg-white dark:bg-gray-800 rounded-lg shadow space-y-6"
      >

        <p class="text-justify">
          <strong class="text-primary-blue dark:text-white text-lg">Hello, young author! 📖✨</strong> <br>
          We love stories made with heart, imagination, and joy. Fill out this form to share your story with Kipenzi Kids.
        </p>

        <section class="space-y-4">
          <h3 class="font-semibold text-lg text-primary-blue dark:text-white">Your Info</h3>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div class="relative">
              <input
                v-model.trim="form.first_name"
                type="text"
                id="first_name"
                placeholder=" "
                required
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent
                       border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0
                       focus:border-black dark:focus:border-blue-500 peer"
              />
              <label
                for="first_name"
                class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-2
                       duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]
                       peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                       peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75
                       peer-focus:-translate-y-4 start-1"
              >Your First Name *</label>
            </div>

            <div class="relative">
              <input
                v-model.number="form.age"
                type="number"
                min="4"
                max="18"
                id="age"
                placeholder=" "
                required
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent
                       border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0
                       focus:border-black dark:focus:border-blue-500 peer"
              />
              <label for="age" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-2
                       duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]
                       peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                       peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75
                       peer-focus:-translate-y-4 start-1">Your Age (years) *</label>
            </div>

            <div class="relative md:col-span-2">
              <input
                v-model.trim="form.location"
                type="text"
                id="location"
                placeholder=" "
                required
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent
                       border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0
                       focus:border-black dark:focus:border-blue-500 peer"
              />
              <label for="location" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-2
                       duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]
                       peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                       peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75
                       peer-focus:-translate-y-4 start-1">Where You Live (City/Country) *</label>
            </div>

            <div class="relative">
              <input
                v-model.trim="form.guardian_name"
                type="text"
                id="guardian_name"
                placeholder=" "
                required
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent
                       border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0
                       focus:border-black dark:focus:border-blue-500 peer"
              />
              <label for="guardian_name" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-2
                       duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]
                       peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                       peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75
                       peer-focus:-translate-y-4 start-1">Parent/Guardian Name *</label>
            </div>

            <div class="relative">
              <input
                v-model.trim="form.guardian_email"
                type="email"
                id="guardian_email"
                placeholder=" "
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent
                       border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0
                       focus:border-black dark:focus:border-blue-500 peer"
              />
              <label for="guardian_email" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-2
                       duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]
                       peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                       peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75
                       peer-focus:-translate-y-4 start-1">Parent/Guardian Email (optional)</label>
            </div>
          </div>
        </section>

        <section class="space-y-4">
          <h3 class="font-semibold text-lg text-primary-blue dark:text-white">Your Story Info</h3>

          <div class="relative">
            <input
              v-model.trim="form.title"
              type="text"
              id="title"
              placeholder=" "
              required
              class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent
                     border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0
                     focus:border-black dark:focus:border-blue-500 peer"
            />
            <label for="title" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-2
                     duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]
                     peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                     peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75
                     peer-focus:-translate-y-4 start-1">Title of Your Story *</label>
          </div>

          <div>
            <label class="block text-sm mb-2 text-black dark:text-gray-300">What kind of story is it? (choose any)</label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
              <label
                v-for="opt in genreOptions"
                :key="opt.value"
                class="inline-flex items-center gap-2 px-3 py-2 rounded border border-gray-500 dark:border-gray-600
                       bg-white dark:bg-gray-800 cursor-pointer text-sm"
              >
                <input type="checkbox" class="accent-emerald-600" :value="opt.value" v-model="form.genres" />
                <span>{{ opt.label }}</span>
              </label>
            </div>
            <div v-if="form.genres.includes('other')" class="relative mt-3">
              <input
                v-model.trim="form.genre_other"
                type="text"
                id="genre_other"
                placeholder=" "
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent
                       border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0
                       focus:border-black dark:focus:border-blue-500 peer"
              />
              <label for="genre_other" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]
                       peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                       peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75
                       peer-focus:-translate-y-4 start-1">Other (type here)</label>
            </div>
          </div>

          <div class="relative">
            <textarea
              v-model.trim="form.main_characters"
              id="main_characters"
              placeholder=" "
              rows="5"
              required
              class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent
                     border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0
                     focus:border-black dark:focus:border-blue-500 peer"
            ></textarea>
            <label for="main_characters" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-2
                     duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]
                     peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                     peer-placeholder-shown:top-6 peer-focus:top-2 peer-focus:scale-75
                     peer-focus:-translate-y-4 start-1">
              Main Character(s) * — include your favourite animals 🐾
            </label>
          </div>
        </section>

        <section class="space-y-3">
          <h3 class="font-semibold text-lg text-primary-blue dark:text-white">Your Story</h3>

          <div class="relative">
            <label class="block text-sm mb-2 text-black dark:text-gray-300">
              Write or paste your story (max 500 words) *
            </label>

            <QuillEditor
              ref="quillRef"
              :key="editorKey"
              theme="snow"
              toolbar="essential"
              contentType="html"
              v-model:content="form.story_html"
              class="bg-white dark:bg-gray-900 text-black dark:text-white border border-gray-500 dark:border-gray-600 rounded"
              :styles="{ height: '280px' }"
              placeholder="Start your magical tale here…"
            />
          </div>

          <div :class="storyWordCount > 500 ? 'text-red-600' : 'text-gray-500'" class="text-sm">
            Word count: {{ storyWordCount }} / 500
          </div>
        </section>

        <section class="space-y-2">
          <h3 class="font-semibold text-lg text-primary-blue dark:text-white">Draw Your Character</h3>

          <div
            class="relative border-2 border-dashed border-gray-400 dark:border-gray-600 rounded-lg p-6 text-center
                   bg-white dark:bg-gray-800 hover:border-black transition"
          >
            <label
              v-if="!selectedFileName"
              for="drawing_upload"
              class="flex flex-col items-center justify-center space-y-2 text-sm text-gray-600 dark:text-gray-300 cursor-pointer"
            >
              <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                   viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M7 16v-4m0 0V4m0 8H4m3 0h3m5 4v-4m0 0V4m0 8h-3m3 0h3" />
              </svg>
              <span class="font-medium">Drag & drop or click to upload a drawing</span>
              <span class="text-xs text-gray-400 dark:text-gray-500">(JPG/PNG — up to 5MB)</span>
            </label>

            <div v-else class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-300">
              <span class="truncate max-w-[80%]">📎 {{ selectedFileName }}</span>
              <button
                @click="removeSelectedFile"
                type="button"
                class="ml-2 px-2 py-1 text-red-600 hover:text-white hover:bg-red-600 rounded text-xs transition"
              >
                ✕ Remove
              </button>
            </div>

            <input
              id="drawing_upload"
              type="file"
              accept="image/png,image/jpeg"
              @change="onFileChange"
              class="absolute inset-0 opacity-0 cursor-pointer"
            />
          </div>

          <p class="text-xs text-gray-500">
            Prefer email? You (or a parent) can send it to <strong>hello@kipenzi.com</strong>
          </p>
        </section>

        <!-- Permission -->
        <section class="space-y-4">
          <h3 class="font-semibold text-lg text-primary-blue dark:text-white">Parent/Guardian Permission</h3>

          <label class="inline-flex items-start text-sm text-black dark:text-gray-300">
            <input type="checkbox" v-model="form.consent" class="mt-1 mr-2 accent-emerald-600" />
            <span>
              I am the parent/guardian and I grant <strong>Kipenzi Kids</strong> the right to
              <strong>publish, distribute, and share</strong> my child’s story (and drawing)
              across Kipenzi Kids’ platforms (website, apps, social channels, newsletters, and print).
              Only my child’s first name and age will be shown.
            </span>
          </label>


          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div class="relative">
              <input
                v-model.trim="form.guardian_signature"
                type="text"
                id="guardian_signature"
                placeholder=" "
                required
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent
                       border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0
                       focus:border-black dark:focus:border-blue-500 peer"
              />
              <label for="guardian_signature" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-2
                       duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]
                       peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                       peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75
                       peer-focus:-translate-y-4 start-1">Parent/Guardian Signature *</label>
            </div>

            <div class="relative">
              <input
                v-model="form.consent_date"
                type="date"
                id="consent_date"
                placeholder=" "
                required
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent
                       border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0
                       focus:border-black dark:focus:border-blue-500 peer"
              />
              <label for="consent_date" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-2
                       duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]
                       peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                       peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75
                       peer-focus:-translate-y-4 start-1">Date *</label>
            </div>
          </div>
        </section>

        <!-- Actions -->
        <div class="flex items-center gap-3">
          <button
            type="button"
            @click="onSubmit"
            :disabled="!canSubmit || isSubmitting"
            class="px-6 py-2 bg-black text-white font-semibold rounded hover:bg-gray-800 transition
                   disabled:opacity-50 disabled:cursor-not-allowed"
          >
            {{ isSubmitting ? 'Submitting...' : 'Submit Story' }}
          </button>

          <button
            type="button"
            @click="resetForm"
            class="px-6 py-2 border border-gray-500 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-700 transition"
          >
            Reset
          </button>
        </div>

        <p class="text-xs text-gray-500">
          Prefer offline? You can also email your story to <strong>hello@kipenzi.com</strong> or mail it to:
          Kipenzi Kids, 123 Story Lane, Imagination City, IC 12345.
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, nextTick } from 'vue'
import axios from 'axios'
import { useToast } from 'vue-toastification'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'

const toast = useToast()
const isSubmitting = ref(false)
const selectedFileName = ref('')

const quillRef   = ref(null)
const editorKey  = ref(0)  

async function clearQuillEditor() {
  // reset bound model
  form.value.story_html = ''
  await nextTick()
  // try API helper on the wrapper first
  if (quillRef.value?.setHTML) {
    quillRef.value.setHTML('')
  } else if (quillRef.value?.getQuill) {
    // fallback to raw Quill instance
    quillRef.value.getQuill().setText('')
  } else {
    // last resort: re-mount the component
    editorKey.value += 1
  }
}

// genre options
const genreOptions = [
  { value: 'adventure', label: 'Adventure' },
  { value: 'funny', label: 'Funny' },
  { value: 'magical', label: 'Magical' },
  { value: 'animal', label: 'Animal Tale' },
  { value: 'friendship', label: 'Friendship' },
  { value: 'other', label: 'Other' },
]

const form = ref({
  first_name: '',
  age: null,
  location: '',
  guardian_name: '',
  guardian_email: '',

  title: '',
  genres: [],
  genre_other: '',
  main_characters: '',

  story_html: '',

  drawing_file: null,

  consent: false,
  guardian_signature: '',
  consent_date: ''
})


function toPlainText(html) {
  const safe = (html || '')
    .replace(/<style[\s\S]*?<\/style>/gi, '')
    .replace(/<script[\s\S]*?<\/script>/gi, '')
    .replace(/<[^>]+>/g, ' ')
  return safe.replace(/\s+/g, ' ').trim()
}

const storyWordCount = computed(() => {
  const text = toPlainText(form.value.story_html)
  if (!text) return 0
  return text.split(/\s+/).filter(Boolean).length
})

const canSubmit = computed(() => {
  const f = form.value
  const storyText = toPlainText(f.story_html)

  const hasBasics =
    f.first_name &&
    Number.isFinite(f.age) &&
    f.age >= 4 &&
    f.age <= 18 &&
    f.location &&
    f.guardian_name &&
    f.title &&
    f.main_characters &&
    storyText &&
    f.consent &&
    f.guardian_signature &&
    f.consent_date

  const wordsOk = storyWordCount.value <= 500
  const emailOk = !f.guardian_email || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(f.guardian_email)

  return hasBasics && wordsOk && emailOk
})

function onFileChange(e) {
  const file = e.target.files?.[0]
  if (!file) {
    form.value.drawing_file = null
    selectedFileName.value = ''
    return
  }
  if (file.size > 5 * 1024 * 1024) {
    toast.error('File too large. Max 5MB.')
    e.target.value = ''
    form.value.drawing_file = null
    selectedFileName.value = ''
    return
  }
  form.value.drawing_file = file
  selectedFileName.value = file.name
}

function removeSelectedFile() {
  form.value.drawing_file = null
  selectedFileName.value = ''
  const input = document.getElementById('drawing_upload')
  if (input) input.value = ''
}

async function resetForm() {
  form.value = {
    first_name: '',
    age: null,
    location: '',
    guardian_name: '',
    guardian_email: '',
    title: '',
    genres: [],
    genre_other: '',
    main_characters: '',
    story_html: '',
    drawing_file: null,
    consent: false,
    guardian_signature: '',
    consent_date: ''
  }
  selectedFileName.value = ''
  await clearQuillEditor() 
}

async function onSubmit() {
  if (!canSubmit.value) {
    toast.error('Please complete all required fields and keep the story under 500 words.')
    return
  }

  try {
    isSubmitting.value = true
    const fd = new FormData()
    const f = form.value
    const storyText = toPlainText(f.story_html)

    fd.append('first_name', f.first_name)
    fd.append('age', String(f.age))
    fd.append('location', f.location)
    fd.append('guardian_name', f.guardian_name)
    if (f.guardian_email) fd.append('guardian_email', f.guardian_email)

    fd.append('title', f.title)
    fd.append('genres', JSON.stringify(f.genres))
    if (f.genre_other) fd.append('genre_other', f.genre_other)
    fd.append('main_characters', f.main_characters)

    fd.append('story_html', f.story_html || '')
    fd.append('story', storyText || '')

    if (f.drawing_file) fd.append('drawing_file', f.drawing_file)

    fd.append('guardian_signature', f.guardian_signature)
    fd.append('consent_date', f.consent_date)

    await axios.post('/api/kids-stories', fd, {
      headers: { 'Content-Type': 'multipart/form-data' }
    })

    toast.success('Thank you! Your story has been submitted. 💖')
    resetForm()
  } catch (err) {
    console.error(err)
    toast.error(err?.response?.data?.message || 'Submission failed. Please try again.')
  } finally {
    isSubmitting.value = false
  }
}
</script>

<style>

.vc-green {
  --vc-accent-50: #f0fdf4;
  --vc-accent-100: #dcfce7;
  --vc-accent-200: #bbf7d0;
  --vc-accent-300: #86efac;
  --vc-accent-400: #4ade80;
  --vc-accent-500: #40AF00;
  --vc-accent-600: #40AF00;
  --vc-accent-700: #15803d;
  --vc-accent-800: #166534;
  --vc-accent-900: #14532d;
}
</style>
