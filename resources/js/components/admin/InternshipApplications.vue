<template>
  <div>
    <!-- Header -->
    <div class="justify-between flex w-full p-4 bg-white dark:shadow-soft-dark-xl shadow-soft-xl rounded-xl dark:bg-gray-800">
      <h4 class="dark:text-white text-lg">Internship Applications</h4>
    </div>

    <!-- Table Card -->
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow p-4 overflow-x-auto">
      <!-- Filters -->
      <div class="flex items-center gap-6 mb-4">
        <div>
          <select v-model="statusFilter" class="w-46 px-3 py-2 rounded border dark:bg-gray-800 dark:text-white">
            <option value="all">All</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
          </select>
        </div>
        <div>
          <input
            v-model.trim="search"
            type="text"
            placeholder="Type and press Enter…"
            @keyup.enter="fetchPage(1)"
            class="w-46 px-3 py-2 rounded border dark:bg-gray-800 dark:text-white"
          />
        </div>
      </div>

      <div v-if="loading" class="py-8 text-center text-sm text-gray-500 dark:text-gray-400">
        Loading…
      </div>

      <template v-else>
        <table class="min-w-[1000px] w-full text-sm">
          <thead>
            <tr class="bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
              <th class="text-left px-3 py-2">Applied</th>
              <th class="text-left px-3 py-2">Candidate</th>
              <th class="text-left px-3 py-2">Email</th>
              <th class="text-left px-3 py-2">Phone</th>
              <th class="text-left px-3 py-2">Country</th>
              <th class="text-left px-3 py-2">CV</th>
              <th class="text-left px-3 py-2">Status</th>
              <th class="text-right px-3 py-2">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="app in items"
              :key="app.id"
              class="border-b border-gray-100 dark:border-gray-700 align-top"
            >
              <td class="px-3 py-2 whitespace-nowrap">{{ formatDate(app.created_at) }}</td>
              <td class="px-3 py-2">
                <div class="font-medium">{{ app.first_name }} {{ app.last_name }}</div>
              </td>
              <td class="px-3 py-2">
                <a :href="`mailto:${app.email}`" class="text-blue-600 hover:underline">{{ app.email }}</a>
              </td>
              <td class="px-3 py-2">
                <span v-if="app.dial_code">{{ app.phone || '—' }}</span>
                <span v-else>—</span>
              </td>
              <td class="px-3 py-2">
                {{ app.phone_country_iso2 || '—' }}
              </td>
              <td class="px-3 py-2">
                <a
                  v-if="app.cv_path"
                  :href="cvUrl(app.id)"
                  class="text-lime-500 hover:underline"
                  target="_blank"
                  rel="noopener"
                  title="Download CV"
                >
                  <i class="fa-solid fa-download"></i>
                </a>
                <span v-else>—</span>
              </td>

              <td class="px-3 py-2">
                <span :class="chipClass(app.status)">
                  <span :class="chipDotClass(app.status)"></span>
                  {{ chipLabel(app.status) }}
                </span>
              </td>

              <td class="px-3 py-2 text-right gap-2 flex">
                <button
                  class="px-2 py-1 text-xs rounded bg-lime-600 font-semibold  disabled:opacity-50"
                  :disabled="savingId === app.id"
                  @click="setStatus(app, 'approved', app.status)"
                >
                  Approve
                </button>
                <button
                  class="px-2 py-1 text-xs rounded bg-rose-600 font-semibold disabled:opacity-50"
                  :disabled="savingId === app.id"
                  @click="setStatus(app, 'rejected', app.status)"
                >
                  Reject
                </button>

                <button
                  class="px-2 py-1 text-xs rounded bg-gray-700 text-white disabled:opacity-50"
                  :disabled="savingId === app.id"
                  @click="remove(app)"
                  title="Delete application"
                >
                  Delete
                </button>
              </td>
            </tr>

            <tr v-if="items.length === 0">
              <td colspan="8" class="px-3 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                No applications found.
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4 flex items-center justify-between">
          <div class="text-xs text-gray-600 dark:text-gray-300">
            Showing {{ meta.from || 0 }}–{{ meta.to || 0 }} of {{ meta.total || 0 }}
          </div>
          <div class="flex items-center gap-2">
            <button
              class="px-3 py-1 rounded border text-sm"
              :class="canPrev ? 'hover:bg-gray-50 dark:hover:bg-gray-700' : 'opacity-50 cursor-not-allowed'"
              :disabled="!canPrev"
              @click="goPrev"
            >
              Prev
            </button>
            <span class="text-xs text-gray-600 dark:text-gray-300">
              {{ meta.current_page || 1 }} / {{ meta.last_page || 1 }}
            </span>
            <button
              class="px-3 py-1 rounded border text-sm"
              :class="canNext ? 'hover:bg-gray-50 dark:hover:bg-gray-700' : 'opacity-50 cursor-not-allowed'"
              :disabled="!canNext"
              @click="goNext"
            >
              Next
            </button>
          </div>
        </div>
      </template>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch, h, nextTick } from 'vue'
import axios from 'axios'
import { useToast } from 'vue-toastification'

const toast = useToast()

const loading = ref(false)
const items = ref([])
const meta = ref({})
const perPage = ref(20)

const statusFilter = ref('all')
const search = ref('')

const savingId = ref(null)

const canPrev = computed(() => (meta.value.current_page || 1) > 1)
const canNext = computed(() => (meta.value.current_page || 1) < (meta.value.last_page || 1))

function formatDate(iso) {
  if (!iso) return '—'
  const d = new Date(iso)
  const y = d.getFullYear()
  const m = String(d.getMonth() + 1).padStart(2, '0')
  const day = String(d.getDate()).padStart(2, '0')
  const hh = String(d.getHours()).padStart(2, '0')
  const mm = String(d.getMinutes()).padStart(2, '0')
  return `${y}-${m}-${day} ${hh}:${mm}`
}

function cvUrl(id) {
  return `/api/internships/${id}/cv`
}

async function fetchPage(p = 1) {
  loading.value = true
  try {
    const params = { page: p, per_page: perPage.value }
    if (statusFilter.value !== 'all') params.status = statusFilter.value
    if (search.value) params.search = search.value

    const { data } = await axios.get('/api/internships', { params })
    items.value = data.data || []
    meta.value = {
      current_page: data.current_page,
      last_page: data.last_page,
      per_page: data.per_page,
      from: data.from,
      to: data.to,
      total: data.total,
    }
  } catch (e) {
    console.error(e)
    toast.error('Failed to load applications.')
  } finally {
    loading.value = false
  }
}

function goPrev() {
  if (!canPrev.value) return
  fetchPage((meta.value.current_page || 2) - 1)
}
function goNext() {
  if (!canNext.value) return
  fetchPage((meta.value.current_page || 0) + 1)
}

// Chip style map
const STATUS_VIEW = {
  pending: {
    label: 'pending',
    cls: 'bg-amber-100 text-amber-800 ring-1 ring-amber-300/60 dark:bg-amber-500/15 dark:text-amber-300',
    dot: 'bg-amber-500'
  },
  approved: {
    label: 'approved',
    cls: 'bg-emerald-100 text-emerald-800 ring-1 ring-emerald-300/60 dark:bg-emerald-500/15 dark:text-emerald-300',
    dot: 'bg-emerald-500'
  },
  rejected: {
    label: 'rejected',
    cls: 'bg-rose-100 text-rose-800 ring-1 ring-rose-300/60 dark:bg-rose-500/15 dark:text-rose-300',
    dot: 'bg-rose-500'
  },
  default: {
    label: 'unknown',
    cls: 'bg-slate-100 text-slate-800 ring-1 ring-slate-300/60 dark:bg-slate-700 dark:text-slate-200',
    dot: 'bg-slate-400'
  }
}

function chipClass(status) {
  const s = STATUS_VIEW[status] || STATUS_VIEW.default
  return `inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full text-xs font-medium ${s.cls}`
}
function chipDotClass(status) {
  const s = STATUS_VIEW[status] || STATUS_VIEW.default
  return `w-1.5 h-1.5 rounded-full ${s.dot}`
}
function chipLabel(status) {
  return (STATUS_VIEW[status] || STATUS_VIEW.default).label
}

function confirmToast(message, { variant = 'info' } = {}) {
  const cfg = {
    success: {
      toastClass: ['!bg-emerald-600', '!text-white', 'border', 'border-emerald-700', 'shadow-lg'],
      bodyClass: ['!text-white'],
      icon: h('i', { class: 'fa-solid fa-circle-check me-2' })
    },
    danger: {
      toastClass: ['!bg-rose-600', '!text-white', 'border', 'border-rose-700', 'shadow-lg'],
      bodyClass: ['!text-white'],
      icon: h('i', { class: 'fa-solid fa-triangle-exclamation me-2' })
    },
    info: {
      toastClass: ['!bg-gray-950', '!text-white', 'border', 'border-slate-600', 'shadow-lg'],
      bodyClass: ['!text-white'],
      icon: h('i', { class: 'fa-solid fa-gear me-2' })
    }
  }[variant] || {}

  return new Promise((resolve) => {
    let id
    const render = (props = {}) => {
      const close = typeof props.closeToast === 'function' ? props.closeToast : () => toast.dismiss(id)
      return h('div', { class: 'space-y-3' }, [
        h('div', { class: 'flex items-center font-medium' }, [cfg.icon || null, h('span', message)]),
        h('div', { class: 'flex gap-2 justify-end' }, [
          h('button', { class: 'px-3 py-1 rounded bg-white/20 hover:bg-white/30 text-white', onClick: () => { close(); resolve(false) } }, 'Cancel'),
          h('button', { class: 'px-3 py-1 rounded bg-white text-slate-900 hover:bg-gray-200', onClick: () => { close(); resolve(true) } }, 'Confirm'),
        ]),
      ])
    }
    id = toast(render, {
      timeout: false,
      closeOnClick: false,
      draggable: true,
      hideProgressBar: true,
      position: 'top-center',
      toastClassName: cfg.toastClass,
      bodyClassName: cfg.bodyClass,
      icon: false,
    })
  })
}

async function setStatus(app, next, prev = app.status) {
  if (next === prev) return
  const variant = next === 'approved' ? 'success' : next === 'rejected' ? 'danger' : 'info'
  const ok = await confirmToast(`Change status to "${next}" for ${app.first_name} ${app.last_name}?`, { variant })
  if (!ok) return
  await actuallyUpdateStatus(app, next, prev)
}

async function actuallyUpdateStatus(app, next, prev) {
  savingId.value = app.id
  app.status = next
  try {
    await axios.patch(`/api/internships/${app.id}/status`, { status: next })
    toast.success('Status updated.')
  } catch (e) {
    console.error(e)
    app.status = prev
    toast.error('Failed to update status.')
  } finally {
    savingId.value = null
  }
}

async function remove(app) {
  const ok = await confirmToast(`Delete application of ${app.first_name} ${app.last_name}?`, { variant: 'danger' })
  if (!ok) return
  const keep = [...items.value]
  items.value = keep.filter(r => r.id !== app.id)
  try {
    await axios.delete(`/api/internships/${app.id}`)
    toast.success('Application deleted.')
  } catch (e) {
    console.error(e)
    items.value = keep
    toast.error('Failed to delete.')
  }
}

// auto-refresh when status filter changes
watch([statusFilter], () => fetchPage(1))

onMounted(() => {
  fetchPage(1)
})
</script>
