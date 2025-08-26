<template>
  <div>
    <!-- Header -->
    <div class="justify-between flex w-full p-4 bg-white dark:shadow-soft-dark-xl shadow-soft-xl rounded-xl dark:bg-gray-800 pb-2">
      <h4 class="dark:text-white text-lg">News</h4>
      <button @click="openDrawer" class="px-4 py-1.5 bg-gray-800 text-white dark:bg-green-500 rounded-full text-sm font-semibold">
        Add News
      </button>
    </div>

    <!-- Filters -->
    <div class="mt-4 flex flex-col md:flex-row gap-3 md:items-center md:justify-between">
      <div class="relative w-full md:w-96">
        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
        <input
          v-model="search"
          type="text"
          placeholder="Search by title…"
          class="w-full pl-10 pr-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500"
        />
      </div>

      <div class="flex items-center gap-2">
        <label for="per-page" class="text-sm dark:text-gray-200">Per page</label>
        <select id="per-page" v-model.number="perPage"
          class="px-2 py-1 text-sm rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 dark:text-white">
          <option :value="6">6</option>
          <option :value="9">9</option>
          <option :value="12">12</option>
          <option :value="24">24</option>
        </select>
      </div>
    </div>

    <!-- News Cards -->
    <div class="relative overflow-x-auto mt-4 sm:rounded-lg">
      <div v-if="loading" class="py-14 text-center text-gray-500 dark:text-gray-300">Loading…</div>

      <div v-else-if="news.length === 0" class="py-14 text-center text-gray-500 dark:text-gray-300">
        No news found.
      </div>

      <div v-else class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
        <div
          v-for="item in news"
          :key="item.id"
          class="relative group rounded-lg overflow-hidden shadow-lg bg-white dark:bg-gray-800"
        >


            <div class="flex space-x-6 text-lg top-3 mb-3 justify-end right-4 items-center relative">
              <div class="relative -mb-2 z-[990]">
                <label class="inline-flex items-center cursor-pointer">
                  <input
                    type="checkbox"
                    :checked="item.status"
                    @change="toggleStatus(item)"
                    class="sr-only peer"
                  />
                  <div
                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300
                          dark:peer-focus:ring-green-800 rounded peer dark:bg-gray-700
                          peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full
                          peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px]
                          after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded
                          after:h-5 after:w-5 after:transition-all dark:border-gray-600
                          peer-checked:bg-green-600 dark:peer-checked:bg-green-600"
                  ></div>
                </label>
              </div>
              <button @click="editNews(item)" class="hover:text-green-400"><i class="fa-solid fa-pen"></i></button>
              <button @click="showDeleteConfirmation(item)" class="text-rose-500 hover:text-rose-400"><i class="fa-solid fa-trash"></i></button>
            </div>


          <!-- Content -->
          <div class="p-4">
            <img v-if="item.image" :src="`/storage/${item.image}`" alt="News" class="w-full h-48 object-cover rounded-lg" />
            <h3 class="text-base font-semibold text-gray-900 dark:text-white mt-4 line-clamp-2">
              {{ item.title }}
            </h3>
            <p class="text-xs text-gray-500 dark:text-gray-300 mt-1">
              {{ formatDisplayDate(item.published_at) }} · {{ item.published_by || '—' }}
            </p>
            <!-- Collapsed: 100-word plain-text preview -->

                <div
                v-if="!isExpanded(item.id)"
                class="mt-3 text-sm text-gray-700 dark:text-gray-200"
                v-html="truncatedContentWithSeeMore(item.content, item.id, 100)"
                @click="handleInlineClick"
                ></div>

                <!-- Expanded: full content + inline See Less -->
                <div v-else class="mt-3 text-sm text-gray-700 dark:text-gray-200 news-content">
                <div v-html="item.content"></div>
                <span
                    class="text-white font-semibold cursor-pointer hover:underline"
                    @click="toggleExpanded(item.id)"
                >
                    See less
                </span>
                </div>

          </div>

          <!-- Hover actions -->
          <!-- <div class="absolute inset-0 bg-black/70 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center text-white"> -->

          <!-- </div> -->
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="meta && meta.total > 0" class="mt-6 flex items-center justify-between flex-wrap gap-3">
        <div class="text-sm text-gray-600 dark:text-gray-300">
          Page {{ meta.current_page }} of {{ meta.last_page }} · {{ meta.total }} results
        </div>

        <div class="flex items-center gap-1">
          <button
            class="px-3 py-1.5 text-sm rounded border border-gray-300 dark:border-gray-600 dark:text-white disabled:opacity-40"
            :disabled="meta.current_page <= 1"
            @click="goToPage(meta.current_page - 1)"
          >
            Prev
          </button>

          <!-- windowed page numbers -->
          <button
            v-for="p in pageWindow"
            :key="p"
            class="px-3 py-1.5 text-sm rounded border border-gray-300 dark:border-gray-600"
            :class="p === meta.current_page ? 'bg-green-600 text-white border-green-600' : 'bg-white dark:bg-gray-800 dark:text-white'"
            @click="goToPage(p)"
          >
            {{ p }}
          </button>

          <button
            class="px-3 py-1.5 text-sm rounded border border-gray-300 dark:border-gray-600 dark:text-white disabled:opacity-40"
            :disabled="meta.current_page >= meta.last_page"
            @click="goToPage(meta.current_page + 1)"
          >
            Next
          </button>
        </div>
      </div>
    </div>

    <!-- Backdrop -->
    <div v-if="drawerOpen" class="fixed inset-0 z-[990] bg-black bg-opacity-40" @click="closeDrawer"></div>

    <!-- Drawer -->
    <div :class="['fixed top-0 right-0 z-[990] h-screen w-[60rem] max-w-full transition-transform bg-white dark:bg-gray-800 p-6 overflow-y-auto', drawerOpen ? 'translate-x-0' : 'translate-x-full']">
      <div class="flex justify-between items-center mb-4">
        <h5 class="text-lg font-bold text-gray-800 dark:text-white">{{ editingId ? 'Edit News' : 'Add News' }}</h5>
        <button @click="closeDrawer" class="text-gray-500 hover:text-red-500">
          <i class="fa-solid fa-xmark text-xl"></i>
        </button>
      </div>

      <form @submit.prevent="saveNews">
        <!-- Image Upload -->
        <div class="mb-6">
          <label class="block text-sm font-medium dark:text-white mb-1">Image</label>
          <div
            class="relative w-32 h-32 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center cursor-pointer bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:border-gray-600"
            @click="$refs.imageInput.click()"
          >
            <template v-if="previewImage">
              <img :src="previewImage" alt="Preview" class="w-full h-full object-cover rounded-lg" />
              <button
                @click.stop="removeImage"
                type="button"
                class="absolute top-1 right-1 bg-red-600 hover:bg-red-700 text-white rounded-full p-1 text-xs"
                title="Remove image"
              >
                <i class="fa-solid fa-xmark"></i>
              </button>
            </template>
            <template v-else>
              <span class="text-sm text-gray-400 dark:text-gray-300 text-center px-2">Click to upload</span>
            </template>
          </div>
          <input
            type="file"
            accept="image/*"
            ref="imageInput"
            @change="handleImageUpload"
            class="hidden"
          />
        </div>

        <!-- Title -->
        <div class="relative mb-5">
          <input
            v-model="form.title"
            type="text"
            id="news-title"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"
            required
          />
          <label
            for="news-title"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2
                   peer-focus:px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500
                   peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                   peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
          >
            Title
          </label>
        </div>

        <!-- Date & Time -->
        <div class="relative mb-5">
          <input
            v-model="form.published_at"
            type="datetime-local"
            id="published-at"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"
            required
          />
          <label
            for="published-at"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2
                   peer-focus:px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500
                   peer-placeholder-shown:scale-100 
                   peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-placeholder-shown:-translate-y-4 start-1"
          >
            Date & Time
          </label>
        </div>

        <!-- Published By -->
        <div class="relative mb-5">
          <input
            v-model="form.published_by"
            type="text"
            id="published-by"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"
          />
          <label
            for="published-by"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2
                   peer-focus:px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500
                   peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                   peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
          >
            Published By
          </label>
        </div>


        <div class="mb-5">
          <div class="flex items-center justify-between mb-1">
            <label class="block text-sm font-medium dark:text-white">Small Description</label>
            <span class="text-xs text-gray-500 dark:text-gray-400">
              {{ (form.small_description || '').length }} / 200
            </span>
          </div>

          <textarea
            v-model="form.small_description"
            @input="enforceCharLimit(200)"
            :maxlength="200"
            rows="3"
            placeholder="Short summary shown in lists and previews"
            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 dark:text-white text-sm p-2 focus:outline-none focus:ring-2 focus:ring-green-500"
          ></textarea>
          <p class="mt-1 text-xs text-gray-500">Max 200 characters.</p>
        </div>


        <!-- Status -->
        <div class="mb-5">
          <label class="block text-sm font-medium text-gray-700 dark:text-white mb-2">Status (Visible)</label>
          <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" v-model="form.status" class="sr-only peer" />
            <div
              class="relative w-11 h-6 bg-gray-200 rounded-full peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 dark:bg-gray-700 peer-checked:bg-green-600"
            >
              <div class="absolute top-[2px] left-[2px] bg-white w-5 h-5 rounded-full transition-transform peer-checked:translate-x-full"></div>
            </div>
          </label>
        </div>

        <!-- News Content (Quill) -->
        <div class="mb-6">
          <label class="block text-sm font-medium dark:text-white mb-2">News Content</label>
          <!-- <QuillEditor
            theme="snow"
            v-model:content="form.content"
            contentType="html"
            toolbar="full"
            class="bg-white dark:bg-gray-900 dark:text-white rounded-lg"
          /> -->

          <QuillEditor
            :key="editorKey"
            theme="snow"
            v-model:content="form.content"
            contentType="html"
            toolbar="full"
            class="bg-white dark:bg-gray-900 dark:text-white rounded-lg"
          />
        </div>

        <button
          type="submit"
          :disabled="!form.title || !form.content"
          class="w-full bg-green-500 hover:bg-green-700 disabled:opacity-50 text-white py-2 rounded"
        >
          {{ editingId ? 'Update News' : 'Add News' }}
        </button>
      </form>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 z-[1001] bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-[90%] max-w-md shadow-xl">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Delete News</h2>
        <p class="text-gray-600 dark:text-gray-300 mb-6">
          Are you sure you want to delete <span class="font-semibold">{{ newsToDelete?.title }}</span>?
        </p>
        <div class="flex justify-end gap-3">
          <button @click="cancelDelete" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">Cancel</button>
          <button @click="confirmDelete" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">Yes, Delete</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch, computed , nextTick} from 'vue'
import axios from 'axios'
import { useToast } from 'vue-toastification'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'

const toast = useToast()
const news = ref([])
const drawerOpen = ref(false)
const editingId = ref(null)
const showDeleteModal = ref(false)
const newsToDelete = ref(null)

const loading = ref(false)
const search = ref('')
const page = ref(1)
const perPage = ref(12)
const meta = ref(null)

const editorKey = ref(0)

const form = ref({
  title: '',
  small_description: '', 
  published_at: '',
  content: '',
  published_by: '',
  status: true,
  image: null
})

const forceResetEditor = async () => {
  // Clear the bound model, then remount the editor
  form.value.content = ''
  await nextTick()
  editorKey.value++
}

const expanded = ref(new Set())
const isExpanded = (id) => expanded.value.has(id)
const toggleExpanded = (id) => {
  const next = new Set(expanded.value)
  next.has(id) ? next.delete(id) : next.add(id)
  expanded.value = next
}

const textFromHtml = (html) => {
  if (!html) return ''
  const div = document.createElement('div')
  div.innerHTML = html
  return (div.textContent || div.innerText || '').trim()
}

const truncatedContentWithSeeMore = (html, id, limit = 100) => {
  const text = textFromHtml(html)
  const words = text.split(/\s+/).filter(Boolean)
  if (words.length <= limit) return text // no truncation needed

  return (
    words.slice(0, limit).join(' ') +
    '… ' +
    `<span class="text-gray-300 font-semibold text-xs cursor-pointer hover:underline" data-id="${id}">See more</span>`
  )
}

const handleInlineClick = (e) => {
  if (e.target && e.target.dataset.id) {
    const id = Number(e.target.dataset.id)
    toggleExpanded(id)
  }
}


const isTruncatable = (html, limit = 100) => {
  const text = textFromHtml(html)
  return text.split(/\s+/).filter(Boolean).length > limit
}


const previewImage = ref(null)

/* ---------- helpers ---------- */
const pad = (n) => String(n).padStart(2, '0')

const toServerDate = (val) => {
  const d = new Date(val)
  const yyyy = d.getFullYear()
  const mm = pad(d.getMonth() + 1)
  const dd = pad(d.getDate())
  const hh = pad(d.getHours())
  const mi = pad(d.getMinutes())
  return `${yyyy}-${mm}-${dd} ${hh}:${mi}:00`
}

const formatForInput = (dateish) => {
  const d = new Date(dateish)
  const yyyy = d.getFullYear()
  const mm = pad(d.getMonth() + 1)
  const dd = pad(d.getDate())
  const hh = pad(d.getHours())
  const mi = pad(d.getMinutes())
  return `${yyyy}-${mm}-${dd}T${hh}:${mi}`
}

const formatDisplayDate = (dateish) => {
  const d = new Date(dateish)
  return d.toLocaleString()
}

/* ---------- image handlers ---------- */
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

/* ---------- pagination helpers ---------- */
const pageWindow = computed(() => {
  if (!meta.value) return []
  const total = meta.value.last_page
  const current = meta.value.current_page
  const radius = 2
  const start = Math.max(1, current - radius)
  const end = Math.min(total, current + radius)
  const arr = []
  for (let p = start; p <= end; p++) arr.push(p)
  return arr
})
const goToPage = (p) => {
  if (!meta.value) return
  const target = Math.min(Math.max(p, 1), meta.value.last_page)
  if (target !== page.value) {
    page.value = target
    fetchNews()
    window.scrollTo({ top: 0, behavior: 'smooth' })
  }
}

/* ---------- crud ---------- */
const fetchNews = async () => {
  loading.value = true
  try {
    const res = await axios.get('/api/news', {
      params: {
        search: search.value || undefined,
        page: page.value,
        per_page: perPage.value
      }
    })
    news.value = res.data.data || []
    meta.value = res.data.meta || null
  } catch (e) {
    toast.error('Failed to load news')
  } finally {
    loading.value = false
  }
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
    title: '',
    small_description: '',
    published_at: formatForInput(new Date()),
    content: '',
    published_by: '',
    status: true,
    image: null
  }
  previewImage.value = null
  editingId.value = null
  editorKey.value++ 
}

const saveNews = async () => {
  try {
    const fd = new FormData()
    fd.append('title', form.value.title)
    fd.append('small_description', form.value.small_description || '') 
    fd.append('published_at', toServerDate(form.value.published_at))
    fd.append('content', form.value.content || '')
    fd.append('published_by', form.value.published_by || '')
    fd.append('status', form.value.status ? 1 : 0)
    if (form.value.image) fd.append('image', form.value.image)

    if (editingId.value) {
    fd.append('_method', 'PUT') // method override in body
    await axios.post(`/api/news/${editingId.value}`, fd, {
        headers: { 'Content-Type': 'multipart/form-data' }
    })
    toast.success('News updated')
    } else {
    await axios.post('/api/news', fd, {
        headers: { 'Content-Type': 'multipart/form-data' }
    })
    toast.success('News created')
    }
    await fetchNews()
    await forceResetEditor()
    closeDrawer()
  } catch (e) {
    if (e.response?.status === 422) {
      console.error('Validation errors:', e.response.data.errors)
      toast.error('Validation failed — check console')
    } else {
      toast.error('Error saving news')
    }
  }
}

const editNews = (item) => {
  editingId.value = item.id
  form.value = {
    title: item.title,
    small_description: item.small_description || '',
    published_at: formatForInput(item.published_at),
    content: item.content || '',
    published_by: item.published_by || '',
    status: !!item.status,
    image: null
  }
  previewImage.value = item.image ? `/storage/${item.image}` : null
  editorKey.value++  
  drawerOpen.value = true
}

const toggleStatus = async (item) => {
  try {
    await axios.put(`/api/news/${item.id}/toggle-status`)
    toast.success('Visibility updated')
    await fetchNews()
  } catch (e) {
    toast.error('Failed to update visibility')
  }
}

const showDeleteConfirmation = (item) => {
  newsToDelete.value = item
  showDeleteModal.value = true
}
const cancelDelete = () => {
  newsToDelete.value = null
  showDeleteModal.value = false
}
const confirmDelete = async () => {
  try {
    await axios.delete(`/api/news/${newsToDelete.value.id}`)
    toast.success('News deleted')
    await fetchNews()
  } catch (e) {
    toast.error('Error deleting news')
  } finally {
    cancelDelete()
  }
}

/* ---------- reactive triggers ---------- */
// debounce search
let searchTimer = null
watch(search, () => {
  clearTimeout(searchTimer)
  searchTimer = setTimeout(() => {
    page.value = 1
    fetchNews()
  }, 400)
})

// per-page change resets to first page
watch(perPage, () => {
  page.value = 1
  fetchNews()
})

onMounted(fetchNews)

</script>

<style>
/* Apply Quill’s alignment outside the editor */
.news-content .ql-align-center { text-align: center; }
.news-content .ql-align-right  { text-align: right; }
.news-content .ql-align-justify{ text-align: justify; }

/* Optional: handle indentation if you use it */
.news-content .ql-indent-1 { margin-left: 3em; }
.news-content .ql-indent-2 { margin-left: 6em; }
</style>
