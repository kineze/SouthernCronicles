<template>
  <div>
    <!-- Header -->
    <div class="justify-between flex w-full p-4 bg-white dark:shadow-soft-dark-xl shadow-soft-xl rounded-xl dark:bg-gray-800 pb-2">
      <h4 class="dark:text-white text-lg">Careers</h4>
      <button @click="openDrawer" class="px-4 py-1.5 bg-gray-800 text-white dark:bg-green-500 rounded-full text-sm font-semibold">
        Add Career
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

    <!-- Cards -->
    <div class="relative overflow-x-auto mt-4 sm:rounded-lg">
      <div v-if="loading" class="py-14 text-center text-gray-500 dark:text-gray-300">Loading…</div>

      <div v-else-if="careers.length === 0" class="py-14 text-center text-gray-500 dark:text-gray-300">
        No careers found.
      </div>

      <div v-else class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
        <div
          v-for="item in careers"
          :key="item.id"
          class="relative group rounded-lg overflow-hidden shadow-lg bg-white dark:bg-gray-800"
        >
          <!-- Status toggle -->
          <div class="absolute top-4 right-4 z-[990]">
            <label class="inline-flex items-center cursor-pointer">
              <input
                type="checkbox"
                :checked="!!item.status"
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

          <!-- Content -->
          <div class="p-4">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white mt-1 line-clamp-2">
              {{ item.title }}
            </h3>

            <p class="text-xs text-gray-500 dark:text-gray-300 mt-1">
              <template v-if="item.closing_date">
                Closes: {{ formatDisplayDate(item.closing_date) }}
              </template>
              <template v-else>
                Open until filled
              </template>
              · <span :class="item.status ? 'text-green-600' : 'text-rose-500'">{{ item.status ? 'Visible' : 'Hidden' }}</span>
            </p>

            <p v-if="item.small_description" class="text-sm text-gray-700 break-words dark:text-gray-300 mt-2">
              {{ item.small_description }}
            </p>

            <!-- Collapsed preview -->
            <div
              v-if="!isExpanded(item.id)"
              class="mt-3 text-sm text-gray-700 dark:text-gray-200"
              v-html="truncatedContentWithSeeMore(item.content, item.id, 30)"
              @click="handleInlineClick"
            ></div>

            <!-- Expanded full -->
            <div v-else class="mt-3 text-sm text-gray-700 dark:text-gray-200 career-content">
              <div v-html="item.content"></div>
              <span
                class="text-white font-semibold cursor-pointer hover:underline"
                @click="toggleExpanded(item.id)"
              >
                See less
              </span>
            </div>
          </div>

          <div class="flex space-x-6 text-lg justify-end  bottom-4 right-4 relative">
            <button @click="editCareer(item)" class="hover:text-green-500" title="Edit">
              <i class="fa-solid fa-pen"></i>
            </button>
            <button @click="showDeleteConfirmation(item)" class="text-rose-500 hover:text-rose-400" title="Delete">
              <i class="fa-solid fa-trash"></i>
            </button>
          </div>
        </div>
      </div>


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
        <h5 class="text-lg font-bold text-gray-800 dark:text-white">{{ editingId ? 'Edit Career' : 'Add Career' }}</h5>
        <button @click="closeDrawer" class="text-gray-500 hover:text-red-500">
          <i class="fa-solid fa-xmark text-xl"></i>
        </button>
      </div>

      <form @submit.prevent="saveCareer">
        <!-- Title -->
        <div class="relative mb-5">
          <input
            v-model="form.title"
            type="text"
            id="career-title"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"
            required
          />
          <label
            for="career-title"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2
                   peer-focus:px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500
                   peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                   peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
          >
            Title
          </label>
        </div>

        <!-- Small Description -->
        <div class="mb-5">
          <div class="flex items-center justify-between mb-1">
            <label class="block text-sm font-medium dark:text-white">Small Description (optional)</label>
            <span class="text-xs text-gray-500 dark:text-gray-400">
              {{ (form.small_description || '').length }} / 200
            </span>
          </div>
          <textarea
            v-model="form.small_description"
            @input="enforceCharLimit(200)"
            :maxlength="200"
            rows="3"
            placeholder="Short teaser or blurb"
            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 dark:text-white text-sm p-2 focus:outline-none focus:ring-2 focus:ring-green-500"
          ></textarea>
          <p class="mt-1 text-xs text-gray-500">Max 200 characters.</p>
        </div>

        <!-- Closing Date -->
        <div class="relative mb-5">
          <input
            v-model="form.closing_date"
            type="date"
            id="closing-date"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"
          />
          <label
            for="closing-date"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2
                   peer-focus:px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500
                   peer-placeholder-shown:scale-100 
                   peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-placeholder-shown:-translate-y-4 start-1"
          >
            Closing Date (optional)
          </label>
        </div>

        <!-- Status -->
        <!-- <div class="mb-5">
          <label class="block text-sm font-medium text-gray-700 dark:text-white mb-2">Status (Visible)</label>
          <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" v-model="form.status" class="sr-only peer" />
            <div
              class="relative w-11 h-6 bg-gray-200 rounded-full peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 dark:bg-gray-700 peer-checked:bg-green-600"
            >
              <div class="absolute top-[2px] left-[2px] bg-white w-5 h-5 rounded-full transition-transform peer-checked:translate-x-full"></div>
            </div>
          </label>
        </div> -->

        <!-- Content (Quill) -->
        <div class="mb-6">
          <label class="block text-sm font-medium dark:text-white mb-2">Content</label>
          <QuillEditor
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
          {{ editingId ? 'Update Career' : 'Add Career' }}
        </button>
      </form>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 z-[1001] bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-[90%] max-w-md shadow-xl">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Delete Career</h2>
        <p class="text-gray-600 dark:text-gray-300 mb-6">
          Are you sure you want to delete <span class="font-semibold">{{ careerToDelete?.title }}</span>?
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
import { ref, onMounted, watch, computed } from 'vue'
import axios from 'axios'
import { useToast } from 'vue-toastification'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'

const toast = useToast()

/* State */
const careers = ref([])
const drawerOpen = ref(false)
const editingId = ref(null)
const showDeleteModal = ref(false)
const careerToDelete = ref(null)

const loading = ref(false)
const search = ref('')
const page = ref(1)
const perPage = ref(12)
const meta = ref(null)

/* Form */
const form = ref({
  title: '',
  small_description: '',
  closing_date: '',
  content: '',
  status: true
})

/* Expand/Collapse previews */
const expanded = ref(new Set())
const isExpanded = (id) => expanded.value.has(id)
const toggleExpanded = (id) => {
  const next = new Set(expanded.value)
  next.has(id) ? next.delete(id) : next.add(id)
  expanded.value = next
}

/* Text helpers */
const textFromHtml = (html) => {
  if (!html) return ''
  const div = document.createElement('div')
  div.innerHTML = html
  return (div.textContent || div.innerText || '').trim()
}
const truncatedContentWithSeeMore = (html, id, limit = 20) => {
  const text = textFromHtml(html)
  const words = text.split(/\s+/).filter(Boolean)
  if (words.length <= limit) return text
  return words.slice(0, limit).join(' ') + '… ' +
         `<span class="text-gray-300 font-semibold text-xs cursor-pointer hover:underline" data-id="${id}">See more</span>`
}
const handleInlineClick = (e) => {
  if (e.target && e.target.dataset.id) {
    const id = Number(e.target.dataset.id)
    toggleExpanded(id)
  }
}

/* Date helpers */
const pad = (n) => String(n).padStart(2, '0')
const toServerDate = (val) => {
  if (!val) return null
  const d = new Date(val)
  if (isNaN(d)) return null
  const yyyy = d.getFullYear()
  const mm = pad(d.getMonth() + 1)
  const dd = pad(d.getDate())
  const hh = pad(d.getHours())
  const mi = pad(d.getMinutes())
  return `${yyyy}-${mm}-${dd} ${hh}:${mi}:00`
}
const formatForInput = (dateish) => {
  if (!dateish) return ''
  const d = new Date(dateish)
  if (isNaN(d)) return ''
  const yyyy = d.getFullYear()
  const mm = pad(d.getMonth() + 1)
  const dd = pad(d.getDate())
  const hh = pad(d.getHours())
  const mi = pad(d.getMinutes())
  return `${yyyy}-${mm}-${dd}T${hh}:${mi}`
}
const formatDisplayDate = (dateish) => {
  const d = new Date(dateish)
  return isNaN(d) ? '' : d.toLocaleString()
}

/* Pagination window */
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
    fetchCareers()
    window.scrollTo({ top: 0, behavior: 'smooth' })
  }
}

/* CRUD */
const fetchCareers = async () => {
  loading.value = true
  try {
    const res = await axios.get('/api/careers', {
      params: {
        search: search.value || undefined,
        page: page.value,
        per_page: perPage.value
      }
    })
    careers.value = res.data.data || []
    meta.value = res.data.meta || null
  } catch (e) {
    toast.error('Failed to load careers')
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
    closing_date: '', // empty is allowed
    content: '',
    status: true
  }
  editingId.value = null
}

const saveCareer = async () => {
  try {
    const payload = {
      title: form.value.title,
      small_description: form.value.small_description || null,
      closing_date: toServerDate(form.value.closing_date), // may be null
      content: form.value.content || '',
      status: form.value.status ? 1 : 0
    }

    if (editingId.value) {
      await axios.put(`/api/careers/${editingId.value}`, payload)
      toast.success('Career updated')
    } else {
      await axios.post('/api/careers', payload)
      toast.success('Career created')
    }
    await fetchCareers()
    closeDrawer()
  } catch (e) {
    if (e.response?.status === 422) {
      console.error('Validation errors:', e.response.data.errors)
      toast.error('Validation failed — check console')
    } else {
      toast.error('Error saving career')
    }
  }
}

const editCareer = (item) => {
  editingId.value = item.id
  form.value = {
    title: item.title,
    small_description: item.small_description || '',
    closing_date: formatForInput(item.closing_date),
    content: item.content || '',
    status: !!item.status
  }
  drawerOpen.value = true
}

const toggleStatus = async (item) => {
  try {
    await axios.put(`/api/careers/${item.id}/toggle-status`)
    toast.success('Visibility updated')
    await fetchCareers()
  } catch (e) {
    toast.error('Failed to update visibility')
  }
}

/* Delete */
const showDeleteConfirmation = (item) => {
  careerToDelete.value = item
  showDeleteModal.value = true
}
const cancelDelete = () => {
  careerToDelete.value = null
  showDeleteModal.value = false
}
const confirmDelete = async () => {
  try {
    await axios.delete(`/api/careers/${careerToDelete.value.id}`)
    toast.success('Career deleted')
    await fetchCareers()
  } catch (e) {
    toast.error('Error deleting career')
  } finally {
    cancelDelete()
  }
}

/* Reactive triggers */
let searchTimer = null
watch(search, () => {
  clearTimeout(searchTimer)
  searchTimer = setTimeout(() => {
    page.value = 1
    fetchCareers()
  }, 400)
})
watch(perPage, () => {
  page.value = 1
  fetchCareers()
})

/* Small-description limit hint only */
const enforceCharLimit = (max) => {
  if ((form.value.small_description || '').length > max) {
    form.value.small_description = form.value.small_description.slice(0, max)
  }
}

onMounted(fetchCareers)
</script>

<style>
/* Apply Quill’s alignment outside the editor */
.career-content .ql-align-center { text-align: center; }
.career-content .ql-align-right  { text-align: right; }
.career-content .ql-align-justify{ text-align: justify; }
.career-content .ql-indent-1 { margin-left: 3em; }
.career-content .ql-indent-2 { margin-left: 6em; }
</style>
