<template>
  <div>
    <!-- Header -->
    <div class="justify-between flex w-full p-4 bg-white dark:shadow-soft-dark-xl shadow-soft-xl rounded-xl dark:bg-gray-800">
      <h4 class="dark:text-white text-lg">Galaxy Applications</h4>
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
              <th class="text-left px-3 py-2">Description</th>
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
                {{ app.phone || '—' }}
              </td>

              <td class="px-3 py-2">
                <span v-if="app.phone_country_iso2">
                  {{ app.phone_country_iso2.toUpperCase() }}
                  <template v-if="app.dial_code"> ({{ app.dial_code }})</template>
                </span>
                <span v-else>—</span>
              </td>

              <td class="px-3 py-2">
                <button
                  class="px-2 py-1 text-xs rounded border hover:bg-gray-50 dark:hover:bg-gray-700"
                  @click="openDesc(app)"
                  title="View applicant description"
                >
                  View Description
                </button>
              </td>

              <td class="px-3 py-2">
                <span :class="chipClass(app.status)">
                  <span :class="chipDotClass(app.status)"></span>
                  {{ chipLabel(app.status) }}
                </span>
              </td>

              <td class="px-3 py-2 text-right flex gap-2 justify-end">
                <button
                  class="px-2 py-1 text-xs rounded bg-lime-600 font-semibold disabled:opacity-50"
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
                <!-- Optional: to set back to pending -->
                <button
                  class="px-2 py-1 text-xs rounded bg-gray-300 font-semibold disabled:opacity-50 text-gray-900"
                  :disabled="savingId === app.id"
                  @click="setStatus(app, 'pending', app.status)"
                  title="Mark as pending"
                >
                  Pending
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

    <!-- Description Modal -->
    <div
      v-if="descModal.open"
      class="fixed inset-0 bg-black/40 z-50 flex items-center justify-center px-3"
      @click.self="closeDesc"
    >
      <div class="bg-white dark:bg-gray-900 rounded-xl shadow-xl max-w-2xl w-full p-5">
        <div class="flex items-center justify-between mb-3">
          <h3 class="text-lg font-semibold dark:text-white">
            Description — {{ descModal.app?.first_name }} {{ descModal.app?.last_name }}
          </h3>
          <button class="text-gray-500 hover:text-gray-800 dark:hover:text-gray-200" @click="closeDesc">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
        <div class="prose max-w-none dark:prose-invert whitespace-pre-wrap">
          {{ descModal.app?.description || '—' }}
        </div>
        <div class="text-right mt-5">
          <button class="px-4 py-2 rounded border hover:bg-gray-50 dark:hover:bg-gray-800" @click="closeDesc">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, h, watch, onMounted } from 'vue'
import axios from 'axios'
import { useToast } from 'vue-toastification'

/* Toast */
const toast = useToast()

/* Table state */
const loading = ref(false)
const items   = ref([])
const meta    = ref({})
const statusFilter = ref('all')
const search  = ref('') // NOTE: backend expects ?q=..., not ?search=...
const savingId = ref(null)

/* Pagination helpers */
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

async function fetchPage(p = 1) {
  loading.value = true
  try {
    const params = { page: p }
    if (statusFilter.value !== 'all') params.status = statusFilter.value
    if (search.value) params.q = search.value   // controller reads 'q'

    const { data } = await axios.get('/api/galaxy-applications', { params })
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
    toast.error('Failed to load galaxy applications.')
  } finally {
    loading.value = false
  }
}

function goPrev(){ if (canPrev.value) fetchPage((meta.value.current_page || 2) - 1) }
function goNext(){ if (canNext.value) fetchPage((meta.value.current_page || 0) + 1) }


const STATUS_VIEW = {
  pending:  { label:'pending',  cls:'bg-amber-100 text-amber-800 ring-1 ring-amber-300/60 dark:bg-amber-500/15 dark:text-amber-300',   dot:'bg-amber-500' },
  approved: { label:'approved', cls:'bg-emerald-100 text-emerald-800 ring-1 ring-emerald-300/60 dark:bg-emerald-500/15 dark:text-emerald-300', dot:'bg-emerald-500' },
  rejected: { label:'rejected', cls:'bg-rose-100 text-rose-800 ring-1 ring-rose-300/60 dark:bg-rose-500/15 dark:text-rose-300',       dot:'bg-rose-500' },
  default:  { label:'unknown',  cls:'bg-slate-100 text-slate-800 ring-1 ring-slate-300/60 dark:bg-slate-700 dark:text-slate-200',     dot:'bg-slate-400' },
}
function chipClass(s){ const v=STATUS_VIEW[s]||STATUS_VIEW.default; return `inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full text-xs font-medium ${v.cls}` }
function chipDotClass(s){ const v=STATUS_VIEW[s]||STATUS_VIEW.default; return `w-1.5 h-1.5 rounded-full ${v.dot}` }
function chipLabel(s){ return (STATUS_VIEW[s]||STATUS_VIEW.default).label }


function confirmToast(message, { variant = 'info' } = {}) {
  const cfg = {
    success: { toastClass: ['!bg-emerald-600','!text-white','border','border-emerald-700','shadow-lg'], bodyClass: ['!text-white'], icon: h('i',{ class:'fa-solid fa-circle-check me-2' }) },
    danger:  { toastClass: ['!bg-rose-600','!text-white','border','border-rose-700','shadow-lg'],       bodyClass: ['!text-white'], icon: h('i',{ class:'fa-solid fa-triangle-exclamation me-2' }) },
    info:    { toastClass: ['!bg-gray-950','!text-white','border','border-slate-600','shadow-lg'],      bodyClass: ['!text-white'], icon: h('i',{ class:'fa-solid fa-gear me-2' }) }
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
    id = toast(render, { timeout:false, closeOnClick:false, draggable:true, hideProgressBar:true, position:'top-center', toastClassName: cfg.toastClass, bodyClassName: cfg.bodyClass, icon:false })
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
  const old = app.status
  app.status = next
  try {
    await axios.patch(`/api/galaxy-applications/${app.id}/status`, { status: next })
    toast.success('Status updated.')
  } catch (e) {
    console.error(e)
    app.status = old ?? prev
    toast.error('Failed to update status.')
  } finally {
    savingId.value = null
  }
}


const descModal = ref({ open:false, app:null })
function openDesc(app){ descModal.value = { open:true, app } }
function closeDesc(){ descModal.value = { open:false, app:null } }


watch([statusFilter], () => fetchPage(1))

onMounted(() => { fetchPage(1) })
</script>
