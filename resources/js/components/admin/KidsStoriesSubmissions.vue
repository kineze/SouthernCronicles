<template>
  <div class="p-4">
    <!-- Header -->
    <div class="flex flex-wrap gap-3 justify-between items-center bg-white dark:bg-gray-800 shadow rounded-xl p-4">
      <h4 class="text-lg font-semibold dark:text-white">Kids Stories Submissions</h4>

      <div class="flex flex-wrap gap-2 items-center">
        <!-- Status chips -->
        <button
          v-for="s in statuses"
          :key="s.value"
          :class="[
            'px-3 py-1 rounded-full text-sm border',
            status === s.value
              ? 'bg-black text-white border-black'
              : 'bg-white dark:bg-gray-700 dark:text-gray-200 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600'
          ]"
          @click="changeStatus(s.value)"
        >
          {{ s.label }}
          <span class="ml-2 text-xs opacity-80">
            <span v-if="countsLoading"><i class="fa-solid fa-spinner animate-spin"></i></span>
            <span v-else>({{ counts[s.value] ?? 0 }})</span>
          </span>
        </button>

        <!-- Search -->
        <div class="relative">
          <input
            v-model="search"
            type="text"
            placeholder="Search name/title/location"
            class="pl-9 pr-3 py-2 rounded border text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
          />
          <i class="fa-solid fa-magnifying-glass absolute left-2 top-2.5 text-gray-400"></i>
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="relative overflow-x-auto shadow-md mt-7 sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
        <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
          <tr>
            <th class="px-6 py-3 font-semibold">Child</th>
            <th class="px-6 py-3 font-semibold">Age</th>
            <th class="px-6 py-3 font-semibold">Location</th>
            <th class="px-6 py-3 font-semibold">Title</th>
            <th class="px-6 py-3 font-semibold">Status</th>
            <th class="px-6 py-3 font-semibold">Drawing</th>
            <th class="px-6 py-3 font-semibold">Submitted</th>
            <th class="px-6 py-3 font-semibold text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="loading">
            <td colspan="8" class="px-6 py-6 text-center text-gray-400">
              <i class="fa-solid fa-spinner animate-spin mr-2"></i> Loading...
            </td>
          </tr>

          <tr v-for="story in filteredStories" :key="story.id" class="border-b dark:border-gray-700">
            <td class="px-6 py-4 dark:text-white">
              <div class="font-medium">{{ story.first_name }}</div>
              <div class="text-xs text-gray-400">Guardian: {{ story.guardian_name }}</div>
            </td>
            <td class="px-6 py-4 dark:text-white">{{ story.age }}</td>
            <td class="px-6 py-4 dark:text-white">{{ story.location }}</td>
            <td class="px-6 py-4 dark:text-white">
              <div class="font-medium">{{ story.title }}</div>
              <div class="text-xs text-gray-400" v-if="(story.genres || []).length">
                {{ (story.genres || []).join(', ') }}
              </div>
            </td>
            <td class="px-6 py-4">
              <span
                :class="[
                  'px-2 py-1 rounded text-xs font-semibold',
                  story.status === 'approved' ? 'bg-green-100 text-green-700' :
                  story.status === 'rejected' ? 'bg-red-100 text-red-700' :
                  'bg-yellow-100 text-yellow-800'
                ]"
              >{{ story.status }}</span>
            </td>
            <td class="px-6 py-4">
              <a v-if="fileUrl(story)" :href="fileUrl(story)" target="_blank" class="text-green-600 underline">Download</a>
              <span v-else>—</span>
            </td>
            <td class="px-6 py-4"><div class="text-xs">{{ formatDate(story.created_at) }}</div></td>
            <td class="px-6 py-4 flex justify-end gap-4">
              <button @click="openDrawer(story)" class="text-green-600" title="View">
                <i class="fa-solid fa-eye"></i>
              </button>

              <button
                v-if="story.status !== 'approved'"
                @click="askStatusChange(story, 'approved', 'list')"
                class="text-emerald-600"
                title="Approve"
              >
                <i class="fa-solid fa-check"></i>
              </button>

              <button
                v-if="story.status !== 'rejected'"
                @click="askStatusChange(story, 'rejected', 'list')"
                class="text-red-600"
                title="Reject"
              >
                <i class="fa-solid fa-xmark"></i>
              </button>

              <button @click="confirmDelete(story)" class="text-gray-500 hover:text-red-600" title="Delete">
                <i class="fa-solid fa-trash"></i>
              </button>
            </td>
          </tr>

          <tr v-if="!loading && !filteredStories.length">
            <td colspan="8" class="px-6 py-6 text-center text-gray-400">No submissions found</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination footer -->
    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
      <div class="text-sm text-gray-600 dark:text-gray-300">
        Showing <strong>{{ meta.from || 0 }}</strong> – <strong>{{ meta.to || 0 }}</strong> of
        <strong>{{ meta.total || 0 }}</strong> submissions
      </div>

      <div class="flex items-center gap-2">
        <label class="text-sm mr-1">Rows per page:</label>
        <select
          v-model.number="perPage"
          class="px-2 py-1 text-sm border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white"
        >
          <option :value="10">10</option>
          <option :value="20">20</option>
          <option :value="50">50</option>
          <option :value="100">100</option>
        </select>

        <div class="ml-3 flex items-center gap-1">
          <button class="px-2 py-1 border rounded disabled:opacity-50" :disabled="page === 1" @click="goFirst">
            <i class="fa-solid fa-angles-left"></i>
          </button>
          <button class="px-2 py-1 border rounded disabled:opacity-50" :disabled="page === 1" @click="goPrev">
            <i class="fa-solid fa-angle-left"></i>
          </button>

          <button
            v-for="n in pageNumbers"
            :key="n"
            class="px-3 py-1 border rounded"
            :class="n === page ? 'bg-black text-white border-black' : 'hover:bg-gray-100 dark:hover:bg-gray-700'"
            @click="goTo(n)"
          >{{ n }}</button>

          <button class="px-2 py-1 border rounded disabled:opacity-50" :disabled="page === meta.last_page" @click="goNext">
            <i class="fa-solid fa-angle-right"></i>
          </button>
          <button class="px-2 py-1 border rounded disabled:opacity-50" :disabled="page === meta.last_page" @click="goLast">
            <i class="fa-solid fa-angles-right"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Drawer overlay -->
    <div v-if="showDrawer" class="fixed inset-0 z-[990] bg-black/40" @click="closeDrawer"></div>

    <!-- Drawer -->
    <div
      class="fixed top-0 right-0 z-[990] h-screen w-full max-w-[900px] p-4 overflow-y-auto transition-transform bg-white dark:bg-gray-800"
      :class="showDrawer ? 'translate-x-0' : 'translate-x-full'"
      tabindex="-1"
    >
      <h5 class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-300">
        <i class="fa-solid fa-eye mr-2"></i> Submission Details
      </h5>
      <button
        type="button"
        @click="closeDrawer"
        class="text-gray-400 hover:text-gray-900 dark:hover:text-white absolute top-2.5 right-2.5 rounded-lg text-sm w-8 h-8 inline-flex items-center justify-center"
      >
        <i class="fa-solid fa-xmark"></i>
      </button>

      <div class="text-sm text-gray-700 dark:text-gray-200 grid grid-cols-2 gap-3">
        <p><strong>Child:</strong> <br /> {{ selected?.first_name }}</p>
        <p><strong>Age:</strong> <br /> {{ selected?.age }}</p>
        <p><strong>Location:</strong> <br /> {{ selected?.location }}</p>
        <p><strong>Guardian Name:</strong> <br /> {{ selected?.guardian_name }}</p>
        <p v-if="selected?.guardian_email"><strong>Guardian Email:</strong> <br /> {{ selected?.guardian_email }}</p>
        <p class="col-span-2"><strong>Title:</strong> <br /> {{ selected?.title }}</p>
        <p class="col-span-2" v-if="(selected?.genres || []).length">
          <strong>Genres:</strong> <br /> {{ (selected?.genres || []).join(', ') }}
        </p>
        <p class="col-span-2" v-if="selected?.genre_other">
          <strong>Other Genre:</strong> <br /> {{ selected?.genre_other }}
        </p>
        <p class="col-span-2" v-if="selected?.main_characters">
          <strong>Main Characters:</strong> <br /> {{ selected?.main_characters }}
        </p>
      </div>

      <div class="mt-6">
        <div class="flex items-center justify-between mb-2">
          <h5 class="font-semibold text-gray-800 dark:text-white">Story</h5>
          <div class="flex gap-2">
            <select
              v-model="inlineStatus"
              class="text-sm border rounded px-2 py-1 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
              @change="askStatusChange(selected, inlineStatus, 'drawer')"
            >
              <option value="pending">Pending</option>
              <option value="approved">Approved</option>
              <option value="rejected">Rejected</option>
            </select>

            <button
              @click="downloadPDF"
              class="px-3 py-1.5 text-sm font-semibold text-white bg-green-600 rounded hover:bg-green-700"
            >
              <i class="fa-solid fa-download mr-1"></i> Export PDF
            </button>
          </div>
        </div>

        <div class="p-4 border rounded bg-gray-50 dark:bg-white">
          <div ref="printRef" class="submission-content" v-html="sanitizeHTML(selected?.story_html || selected?.story)"></div>
        </div>

        <div class="mt-4 text-sm">
          <strong>Submitted:</strong> {{ formatDate(selected?.created_at) }}
          <span class="mx-2">•</span>
          <strong>Status:</strong> {{ selected?.status }}
          <span v-if="fileUrl(selected)" class="mx-2">•</span>
          <a v-if="fileUrl(selected)" :href="fileUrl(selected)" class="underline text-emerald-600" target="_blank">
            Download Drawing
          </a>
        </div>
      </div>
    </div>

    <!-- Delete confirm modal -->
    <div v-if="showDelete" class="fixed inset-0 z-[1000] bg-black/50 flex items-center justify-center">
      <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 w-full max-w-md">
        <h3 class="text-lg font-semibold mb-2 dark:text-white">Delete submission?</h3>
        <p class="text-sm text-gray-600 dark:text-gray-300">This action cannot be undone.</p>
        <div class="mt-5 flex justify-end gap-3">
          <button class="px-4 py-2 rounded border dark:border-gray-700" @click="showDelete = false">Cancel</button>
          <button class="px-4 py-2 rounded bg-red-600 text-white" @click="doDelete">Delete</button>
        </div>
      </div>
    </div>

    <!-- Status change confirm modal -->
    <div v-if="showStatusConfirm" class="fixed inset-0 z-[1000] bg-black/50 flex items-center justify-center">
      <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 w-full max-w-md">
        <h3 class="text-lg font-semibold mb-2 dark:text-white">Change status?</h3>
        <p class="text-sm text-gray-600 dark:text-gray-300">
          Are you sure you want to set
          <strong>{{ statusTarget?.item?.first_name }}</strong>’s story
          <span v-if="statusTarget?.item?.title">(<em>{{ statusTarget.item.title }}</em>)</span>
          from <strong>{{ pretty(statusTarget?.from) }}</strong> to
          <strong>{{ pretty(statusTarget?.newStatus) }}</strong>?
        </p>
        <div class="mt-5 flex justify-end gap-3">
          <button class="px-4 py-2 rounded border dark:border-gray-700" @click="cancelStatusChange">Cancel</button>
          <button
            class="px-4 py-2 rounded text-white"
            :class="statusTarget?.newStatus === 'approved' ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-red-600 hover:bg-red-700'"
            @click="confirmStatusChange"
          >
            Yes, change
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import html2pdf from 'html2pdf.js'
import { ref, onMounted, computed, watch } from 'vue'
import axios from 'axios'
import { useToast } from 'vue-toastification'

const toast = useToast()

/* ------------ State ------------ */
const status = ref('pending')
const statuses = [
  { value: 'pending', label: 'Pending' },
  { value: 'approved', label: 'Approved' },
  { value: 'rejected', label: 'Rejected' },
]
const search = ref('')
const stories = ref([])
const loading = ref(false)
const countsLoading = ref(false)
const counts = ref({ pending: 0, approved: 0, rejected: 0 })

// pagination
const page = ref(1)
const perPage = ref(20)
const meta = ref({
  current_page: 1, last_page: 1, per_page: 20, total: 0, from: 0, to: 0
})

const selected = ref(null)
const inlineStatus = ref('pending')
const showDrawer = ref(false)

const showDelete = ref(false)
const toDeleteId = ref(null)

const printRef = ref(null)

/* --- New: confirmation modal state --- */
const showStatusConfirm = ref(false)
const statusTarget = ref({ item: null, newStatus: null, from: null, context: 'list' })
const prevStatusBeforeConfirm = ref(null) // to revert <select> if cancelled

const pretty = (s) => ({ pending: 'Pending', approved: 'Approved', rejected: 'Rejected' }[s] || s)

/* ------------ Fetch: list ------------ */
async function fetchStories() {
  loading.value = true
  try {
    const { data } = await axios.get('/api/kids-stories', {
      params: { status: status.value, page: page.value, per_page: perPage.value }
    })

    if (Array.isArray(data)) {
      stories.value = data
      meta.value = {
        current_page: 1, last_page: 1, per_page: data.length,
        total: data.length, from: data.length ? 1 : 0, to: data.length
      }
      counts.value[status.value] = data.length
    } else {
      stories.value = Array.isArray(data.data) ? data.data : []
      meta.value = {
        current_page: data.current_page ?? page.value,
        last_page: data.last_page ?? 1,
        per_page: data.per_page ?? perPage.value,
        total: data.total ?? 0,
        from: data.from ?? 0,
        to: data.to ?? stories.value.length
      }
      counts.value[status.value] = meta.value.total
    }
  } catch (e) {
    toast.error('Failed to load stories.')
  } finally {
    loading.value = false
  }
}

/* ------------ Fetch: counts with fallback ------------ */
async function fetchCounts() {
  countsLoading.value = true
  try {
    const res = await axios.get('/api/kids-stories/counts')
    if (res?.data && (typeof res.data === 'object')) {
      counts.value = {
        pending: Number(res.data.pending ?? 0),
        approved: Number(res.data.approved ?? 0),
        rejected: Number(res.data.rejected ?? 0),
      }
      countsLoading.value = false
      return
    }
  } catch (_) {}

  try {
    const [p, a, r] = await Promise.all([
      axios.get('/api/kids-stories', { params: { status: 'pending', per_page: 1 } }),
      axios.get('/api/kids-stories', { params: { status: 'approved', per_page: 1 } }),
      axios.get('/api/kids-stories', { params: { status: 'rejected', per_page: 1 } }),
    ])
    const totalFrom = (resp) =>
      Array.isArray(resp.data) ? resp.data.length : Number(resp.data?.total ?? 0)
    counts.value = { pending: totalFrom(p), approved: totalFrom(a), rejected: totalFrom(r) }
  } catch (_) {
  } finally {
    countsLoading.value = false
  }
}

function changeStatus(s) {
  if (status.value === s) return
  status.value = s
  page.value = 1
  fetchStories()
  fetchCounts()
}

/* ------------ Derived ------------ */
const filteredStories = computed(() => {
  const q = search.value.trim().toLowerCase()
  if (!q) return stories.value
  return stories.value.filter(s =>
    (s.first_name || '').toLowerCase().includes(q) ||
    (s.location || '').toLowerCase().includes(q) ||
    (s.title || '').toLowerCase().includes(q) ||
    (s.guardian_name || '').toLowerCase().includes(q)
  )
})

const pageNumbers = computed(() => {
  const current = meta.value.current_page || 1
  const last = meta.value.last_page || 1
  const start = Math.max(1, current - 2)
  const end = Math.min(last, current + 2)
  const arr = []
  for (let i = start; i <= end; i++) arr.push(i)
  return arr
})

/* ------------ Pagination actions ------------ */
function goTo(n) {
  if (n < 1 || n > meta.value.last_page || n === page.value) return
  page.value = n
  fetchStories()
}
function goPrev() { goTo((page.value || 1) - 1) }
function goNext() { goTo((page.value || 1) + 1) }
function goFirst() { goTo(1) }
function goLast() { goTo(meta.value.last_page || 1) }

watch(perPage, () => {
  page.value = 1
  fetchStories()
})

/* ------------ Helpers ------------ */
function fileUrl(item) {
  if (!item) return ''
  if (item.drawing_url) return item.drawing_url
  if (item.drawing_path) return `/storage/${item.drawing_path}`
  return ''
}
function formatDate(d) {
  if (!d) return '—'
  const dt = new Date(d)
  if (isNaN(+dt)) return d
  return dt.toLocaleString()
}
function sanitizeHTML(html) {
  if (!html) return '<p class="text-gray-400">No story.</p>'
  return String(html)
    .replace(/<script[\s\S]*?<\/script>/gi, '')
    .replace(/<style[\s\S]*?<\/style>/gi, '')
    .replace(/background-color:\s*[^;"]+;?/gi, '')
}

/* ------------ Drawer ------------ */
function openDrawer(story) {
  selected.value = story
  inlineStatus.value = story.status
  showDrawer.value = true
}
function closeDrawer() {
  showDrawer.value = false
  selected.value = null
}

/* ------------ Status change (with confirmation) ------------ */
function askStatusChange(item, newStatus, context = 'list') {
  if (!item || !newStatus || item.status === newStatus) return
  prevStatusBeforeConfirm.value = context === 'drawer' ? item.status : null
  statusTarget.value = { item, newStatus, from: item.status, context }
  showStatusConfirm.value = true
}

async function confirmStatusChange() {
  const { item, newStatus, from, context } = statusTarget.value || {}
  showStatusConfirm.value = false
  await updateStatus(item, newStatus, from, context)
}

function cancelStatusChange() {
  // Revert the <select> if changed in drawer
  if (statusTarget.value?.context === 'drawer' && prevStatusBeforeConfirm.value) {
    inlineStatus.value = prevStatusBeforeConfirm.value
  }
  showStatusConfirm.value = false
  statusTarget.value = { item: null, newStatus: null, from: null, context: 'list' }
  prevStatusBeforeConfirm.value = null
}

async function updateStatus(item, newStatus, oldStatus = null, context = 'list') {
  if (!item || !newStatus || item.status === newStatus) return
  try {
    await axios.patch(`/api/kids-stories/${item.id}/status`, { status: newStatus })

    const wasInPage = stories.value.some(s => s.id === item.id)
    if (wasInPage && newStatus !== status.value) {
      stories.value = stories.value.filter(s => s.id !== item.id)
      if (!stories.value.length && page.value > 1) page.value--
      await fetchStories()
    } else {
      item.status = newStatus
      if (context === 'drawer') inlineStatus.value = newStatus
    }

    await fetchCounts()
    toast.success(`Status set to ${newStatus}.`)
  } catch (_) {
    // Revert if failed
    if (oldStatus) {
      item.status = oldStatus
      if (context === 'drawer') inlineStatus.value = oldStatus
    }
    toast.error('Failed to update status.')
  } finally {
    // clear temp
    prevStatusBeforeConfirm.value = null
  }
}

/* ------------ Delete ------------ */
function confirmDelete(item) {
  toDeleteId.value = item?.id ?? null
  showDelete.value = true
}
async function doDelete() {
  if (!toDeleteId.value) return
  try {
    await axios.delete(`/api/kids-stories/${toDeleteId.value}`)
    stories.value = stories.value.filter(s => s.id !== toDeleteId.value)
    if (!stories.value.length && page.value > 1) page.value--
    await fetchStories()
    await fetchCounts()
    toast.success('Deleted.')
  } catch (_) {
    toast.error('Delete failed.')
  } finally {
    showDelete.value = false
    toDeleteId.value = null
  }
}

/* ------------ Export ------------ */
function downloadPDF() {
  if (!printRef.value || !selected.value) return
  const element = printRef.value
  const opt = {
    margin: 0.5,
    filename: `${(selected.value.first_name || 'story').toString().replace(/\s+/g, '_')}-${(selected.value.title || 'submission').toString().replace(/\s+/g, '_')}.pdf`,
    image: { type: 'jpeg', quality: 0.98 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' },
    pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
  }
  html2pdf().set(opt).from(element).save()
}

/* ------------ Init ------------ */
onMounted(async () => {
  await Promise.all([fetchCounts(), fetchStories()])
})
</script>

<style>
.submission-content {
  font-size: 0.875rem;
  color: #374151;
  line-height: 1.75rem;
  overflow-wrap: break-word;
  word-break: break-word;
  padding: 1rem;
  box-sizing: border-box;
  width: 100%;
}
.submission-content * { max-width: 100%; box-sizing: border-box; }
.submission-content .ql-align-center,
.submission-content [style*="text-align: center"],
.submission-content [style*="text-align:center"] { text-align: center; display: block; }
.submission-content .ql-align-right,
.submission-content [style*="text-align: right"],
.submission-content [style*="text-align:right"] { text-align: right; display: block; }
.submission-content .ql-align-justify,
.submission-content [style*="text-align: justify"],
.submission-content [style*="text-align:justify"] { text-align: justify; display: block; }
.submission-content a { color: #3b82f6; text-decoration: underline; }
.submission-content img, .submission-content video {
  max-width: 100%; height: auto; display: block; margin-left: auto; margin-right: auto;
}
.submission-content blockquote {
  border-left: 4px solid #d1d5db; padding-left: 1rem; color: #6b7280; font-style: italic; margin: 1em 0;
}
.submission-content ul { list-style-type: disc; padding-left: 1.5rem; margin: 1em 0; }
.submission-content ol { list-style-type: decimal; padding-left: 1.5rem; margin: 1em 0; }
.dark .submission-content { color: #000000 !important; }
.dark .submission-content h1,
.dark .submission-content h2,
.dark .submission-content h3,
.dark .submission-content h4,
.dark .submission-content h5,
.dark .submission-content h6,
.dark .submission-content strong,
.dark .submission-content b { color: #000000 !important; }
.dark .submission-content blockquote { color: #000000 !important; border-left-color: #4b5563; }
.dark .submission-content a { color: #60a5fa; }
</style>
