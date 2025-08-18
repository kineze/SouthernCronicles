<template>
  <div>
    <!-- Header -->
    <div class="justify-between flex w-full p-4 bg-white dark:shadow-soft-dark-xl shadow-soft-xl rounded-xl dark:bg-gray-800">
      <h4 class="dark:text-white text-lg">Partner Inquiries</h4>
    </div>

    <!-- Filters -->
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow p-4">
      <div class="flex items-center gap-6 mb-2">
        <div>
          <select v-model="statusFilter" class="w-46 px-3 py-2 rounded border dark:bg-gray-800 dark:text-white">
            <option value="all">All</option>
            <option value="pending">Pending</option>
            <option value="contacted">Contacted</option>
            <option value="closed">Closed</option>
          </select>
        </div>

        <div>
          <input
            v-model.trim="search"
            type="text"
            placeholder="Search"
            @keyup.enter="fetchPage(1)"
            class="w-80 px-3 py-2 rounded border dark:bg-gray-800 dark:text-white"
          />
        </div>
      </div>

      <div class="mt-1 text-xs text-gray-600 dark:text-gray-300">
        Page {{ meta.current_page || 1 }} of {{ meta.last_page || 1 }} — Total {{ meta.total || 0 }}
      </div>
    </div>

    <!-- Table -->
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow p-4 overflow-x-auto">
      <div v-if="loading" class="py-8 text-center text-sm text-gray-500 dark:text-gray-400">Loading…</div>

      <template v-else>
        <table class="min-w-[1000px] w-full text-sm">
          <thead>
            <tr class="bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
              <th class="text-left px-3 py-2">Received</th>
              <th class="text-left px-3 py-2">Contact</th>
              <th class="text-left px-3 py-2">Brand</th>
              <th class="text-left px-3 py-2">Email</th>
              <th class="text-left px-3 py-2">Phone</th>
              <th class="text-left px-3 py-2">Country</th>
              <th class="text-left px-3 py-2">Notes</th>
              <th class="text-left px-3 py-2">Status</th>
              <th class="text-right px-3 py-2">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="inq in items" :key="inq.id" class="border-b border-gray-100 dark:border-gray-700 align-top">
              <td class="px-3 py-2 whitespace-nowrap">{{ formatDate(inq.created_at) }}</td>

              <td class="px-3 py-2">
                <div class="font-medium">
                  {{ inq.first_name }} {{ inq.last_name }}
                </div>
              </td>

              <td class="px-3 py-2">
                <div class="font-medium">{{ inq.brand_name || '—' }}</div>
              </td>

              <td class="px-3 py-2">
                <a :href="`mailto:${inq.email}`" class="text-blue-600 hover:underline">{{ inq.email }}</a>
              </td>

              <td class="px-3 py-2">
                <span>{{ formatPhone(inq) }}</span>
              </td>

              <td class="px-3 py-2">
                {{ inq.country_iso2 || '—' }}
              </td>

              <td class="px-3 py-2 max-w-[300px]">
                <p class="line-clamp-2" :title="inq.description || ''">
                  {{ inq.description || '—' }}
                </p>
              </td>

              <td class="px-3 py-2">
                <span :class="chipClass(inq.status)">
                  <span :class="chipDotClass(inq.status)"></span>
                  {{ chipLabel(inq.status) }}
                </span>
              </td>

              <td class="px-3 py-2">
                <div class="flex items-center justify-end gap-2">
                  <button
                    class="px-2 py-1 text-xs rounded bg-emerald-600 text-white font-semibold disabled:opacity-50"
                    :disabled="savingId === inq.id || inq.status === 'contacted'"
                    @click="setStatus(inq, 'contacted')"
                  >
                    Mark Contacted
                  </button>

                  <button
                    class="px-2 py-1 text-xs rounded bg-slate-700 text-white font-semibold disabled:opacity-50"
                    :disabled="savingId === inq.id || inq.status === 'closed'"
                    @click="setStatus(inq, 'closed')"
                  >
                    Close
                  </button>

                  <button
                    class="px-2 py-1 text-xs rounded bg-amber-600 text-white font-semibold disabled:opacity-50"
                    :disabled="savingId === inq.id || inq.status === 'pending'"
                    @click="setStatus(inq, 'pending')"
                  >
                    Reopen
                  </button>

                  <button
                    class="px-2 py-1 text-xs rounded bg-gray-700 text-white disabled:opacity-50"
                    :disabled="savingId === inq.id"
                    @click="remove(inq)"
                    title="Delete inquiry"
                  >
                    Delete
                  </button>
                </div>
              </td>
            </tr>

            <tr v-if="items.length === 0">
              <td colspan="9" class="px-3 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                No inquiries found.
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
import { ref, computed, onMounted, h, nextTick , watch} from 'vue'
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

function formatPhone(inq) {
  if (!inq?.phone) return '—'
  // already normalized E.164 from backend; just show it.
  return inq.phone
}

async function fetchPage(p = 1) {
  loading.value = true
  try {
    const params = { page: p, per_page: perPage.value }
    if (statusFilter.value !== 'all') params.status = statusFilter.value
    if (search.value) {
      // controller supports either 'q' or 'search'
      params.q = search.value
    }

    const { data } = await axios.get('/api/partner-inquiries', { params })
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
    toast.error('Failed to load inquiries')
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

/* ----- Chips ----- */
const STATUS_VIEW = {
  pending: {
    label: 'pending',
    cls: 'bg-amber-100 text-amber-800 ring-1 ring-amber-300/60 dark:bg-amber-500/15 dark:text-amber-300',
    dot: 'bg-amber-500'
  },
  contacted: {
    label: 'contacted',
    cls: 'bg-sky-100 text-sky-800 ring-1 ring-sky-300/60 dark:bg-sky-500/15 dark:text-sky-300',
    dot: 'bg-sky-500'
  },
  closed: {
    label: 'closed',
    cls: 'bg-slate-100 text-slate-800 ring-1 ring-slate-300/60 dark:bg-slate-700/40 dark:text-slate-200',
    dot: 'bg-slate-500'
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

/* ----- Fancy confirm toast (same pattern you used) ----- */
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
      const close =
        typeof props.closeToast === 'function'
          ? props.closeToast
          : () => toast.dismiss(id)
      return h('div', { class: 'space-y-3' }, [
        h('div', { class: 'flex items-center font-medium' }, [
          cfg.icon || null,
          h('span', message),
        ]),
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

/* ----- Status updates ----- */
async function setStatus(inq, next) {
  const prev = inq.status
  if (next === prev) return

  const variant = next === 'closed' ? 'info' : next === 'contacted' ? 'success' : 'info'
  const ok = await confirmToast(`Change status to "${next}" for ${inq.first_name} ${inq.last_name}?`, { variant })
  if (!ok) return

  await actuallyUpdateStatus(inq, next, prev)
}

async function actuallyUpdateStatus(inq, next, prev) {
  savingId.value = inq.id
  inq.status = next // optimistic
  try {
    await axios.patch(`/api/partner-inquiries/${inq.id}/status`, { status: next })
    toast.success('Status updated.')
  } catch (e) {
    console.error(e)
    inq.status = prev
    toast.error('Failed to update status.')
  } finally {
    savingId.value = null
  }
}

/* ----- Delete ----- */
async function remove(inq) {
  const ok = await confirmToast(`Delete inquiry from ${inq.first_name} ${inq.last_name}?`, { variant: 'danger' })
  if (!ok) return
  const keep = [...items.value]
  items.value = keep.filter(r => r.id !== inq.id)
  try {
    await axios.delete(`/api/partner-inquiries/${inq.id}`)
    toast.success('Inquiry deleted.')
  } catch (e) {
    console.error(e)
    items.value = keep
    toast.error('Failed to delete.')
  }
}

/* ----- Effects ----- */
onMounted(() => { fetchPage(1) })
watch([statusFilter], () => fetchPage(1))
</script>
