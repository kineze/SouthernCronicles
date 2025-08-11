<template>
  <div>
    <div class="flex justify-between p-4 bg-white dark:bg-gray-800 shadow mb-6 rounded-xl">
      <h4 class="text-lg font-semibold dark:text-white">Volunteers</h4>
    </div>

    <!-- Search -->
    <div class="relative mb-4">
      <input
        v-model="search"
        @input="fetchVolunteers()"
        type="text"
        id="search_volunteers"
        placeholder=" "
        class="block px-2.5 pb-2.5 pt-4 w-6/12 text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"
      />
      <label
        for="search_volunteers"
        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-slate-900 px-2 peer-focus:px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
      >
        Search by name, email or contact
      </label>
    </div>

    <!-- Table -->
    <div class="relative overflow-x-auto shadow-md mt-7 sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th class="px-6 py-3 dark:text-white font-semibold">First Name</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Last Name</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Email</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Contact</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Description</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Status</th>
            <th class="px-6 py-3 dark:text-white font-semibold text-end">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="v in volunteers.data" :key="v.id" class="border-b dark:border-gray-700">
            <td class="px-6 py-4 dark:text-white font-medium">{{ v.first_name }}</td>
            <td class="px-6 py-4 dark:text-white font-medium">{{ v.last_name }}</td>
            <td class="px-6 py-4 dark:text-white font-medium">{{ v.email }}</td>
            <td class="px-6 py-4 dark:text-white font-medium">{{ v.contact_number }}</td>
            <td class="px-6 py-4 dark:text-white font-medium">
              <span class="line-clamp-2">{{ v.description }}</span>
            </td>
            <td class="px-6 py-4 dark:text-white font-medium capitalize">
                {{ v.status }}
            </td>
            <td class="px-6 py-4 flex gap-4 justify-end dark:text-white font-medium">
                <button class="px-4 py-1 bg-lime-600 rounded-full" @click="confirmAction('accept', v)">Accept</button>
                <button class="px-4 py-1 bg-amber-500 rounded-full" @click="confirmAction('reject', v)">Reject</button>
                <button class="px-4 py-1 rounded-full" @click="confirmAction('delete', v)">
                    <i class="fa-solid fa-trash text-rose-500"></i>
                </button>
            </td>
          </tr>

          <tr v-if="!loading && (!volunteers.data || volunteers.data.length === 0)">
            <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
              No volunteers found.
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-end space-x-6 items-center mt-4">
      <button
        :disabled="!volunteers.prev_page_url"
        @click="changePage(volunteers.current_page - 1)"
        class="px-4 py-2 bg-gray-800 text-white rounded disabled:opacity-50"
      >
        Previous
      </button>
      <span>Page {{ volunteers.current_page || 1 }} of {{ volunteers.last_page || 1 }}</span>
      <button
        :disabled="!volunteers.next_page_url"
        @click="changePage(volunteers.current_page + 1)"
        class="px-4 py-2 bg-gray-800 text-white rounded disabled:opacity-50"
      >
        Next
      </button>
    </div>
  </div>


  <!-- Confirm Modal -->
<div v-if="confirm.show" class="fixed inset-0 z-[1001] bg-black/50 flex items-center justify-center px-3">
  <div class="bg-white dark:bg-gray-900 w-full max-w-md rounded-lg shadow-lg relative">
    <button class="absolute top-3 right-3 text-gray-500 hover:text-red-600" @click="closeConfirm">
      <i class="fa-solid fa-xmark text-xl"></i>
    </button>

    <div class="p-6">
      <h3 class="text-lg font-bold mb-2 dark:text-white capitalize">
        {{ confirm.title }}
      </h3>
      <p class="text-gray-700 dark:text-gray-300 mb-6">
        {{ confirm.message }}
      </p>
      <div class="flex justify-end gap-3">
        <button @click="closeConfirm" class="px-4 py-2 rounded bg-gray-200 dark:bg-gray-700 dark:text-white">Cancel</button>
        <button
          :disabled="confirm.loading"
          @click="doConfirm"
          class="px-4 py-2 rounded bg-black text-white disabled:opacity-50"
        >
          {{ confirm.loading ? 'Please wait...' : confirm.confirmLabel }}
        </button>
      </div>
    </div>
  </div>
</div>

</template>

<script>
import axios from 'axios'
import { useToast } from 'vue-toastification'

export default {
  setup() {
    const toast = useToast()
    return { toast }
  },
  data() {
    return {
      volunteers: { data: [], current_page: 1, last_page: 1 },
      search: '',
      perPage: 15,
      loading: false,
      debounceId: null,
      submitting: false,
      form: {
        first_name: '',
        last_name: '',
        email: '',
        contact_number: '',
        description: '',
      },
      confirm: {
        show: false,
        type: null,
        row: null,
        title: '',
        message: '',
        confirmLabel: '',
        loading: false,
      },
    }
  },
  mounted() {
    this.fetchVolunteers()
  },
  methods: {
    async submitForm() {
      if (this.submitting) return
      this.submitting = true

      try {
        await axios.post('/api/volunteers', this.form)
        this.toast.success('Thanks! Your volunteer application was submitted.')
        this.form = {
          first_name: '',
          last_name: '',
          email: '',
          contact_number: '',
          description: '',
        }
      } catch (e) {
        const msg =
          e?.response?.data?.message ||
          Object.values(e?.response?.data?.errors || {})[0]?.[0] ||
          'Submission failed. Please try again.'
        this.toast.error(msg)
      } finally {
        this.submitting = false
      }
    },

    async fetchVolunteers(page = 1) {
      if (this.debounceId) clearTimeout(this.debounceId)
      this.debounceId = setTimeout(async () => {
        this.loading = true
        try {
          const { data } = await axios.get('/api/volunteers', {
            params: { search: this.search, page, per_page: this.perPage },
          })
          this.volunteers = data
        } catch (e) {
          console.error('Error fetching volunteers', e)
          this.toast.error('Failed to fetch volunteers.')
        } finally {
          this.loading = false
        }
      }, 250)
    },

    changePage(page) {
      this.fetchVolunteers(page)
    },

    confirmAction(type, row) {
      const map = {
        accept: {
          title: 'Accept Volunteer',
          message: `Accept ${row.first_name} ${row.last_name}? This will email the volunteer.`,
          confirmLabel: 'Accept',
        },
        reject: {
          title: 'Reject Volunteer',
          message: `Reject ${row.first_name} ${row.last_name}? This will email the volunteer.`,
          confirmLabel: 'Reject',
        },
        delete: {
          title: 'Delete Volunteer',
          message: `Delete ${row.first_name} ${row.last_name}? This cannot be undone.`,
          confirmLabel: 'Delete',
        },
      }
      this.confirm = {
        show: true,
        type,
        row,
        ...map[type],
        loading: false,
      }
    },

    closeConfirm() {
      this.confirm.show = false
      this.confirm.type = null
      this.confirm.row = null
    },

    async doConfirm() {
      this.confirm.loading = true
      try {
        if (this.confirm.type === 'accept' || this.confirm.type === 'reject') {
          const status = this.confirm.type === 'accept' ? 'accepted' : 'rejected'
          await axios.post(`/api/volunteers/${this.confirm.row.id}/status`, { status })
          this.toast.success(`Volunteer ${this.confirm.type}ed successfully.`)
        } else if (this.confirm.type === 'delete') {
          await axios.delete(`/api/volunteers/${this.confirm.row.id}`)
          this.toast.success('Volunteer deleted successfully.')
        }
        await this.fetchVolunteers(this.volunteers.current_page || 1)
        this.closeConfirm()
      } catch (e) {
        console.error('Action failed', e)
        this.toast.error('Action failed. Please try again.')
        this.confirm.loading = false
      }
    },
  },
}
</script>


<!-- <style scoped>
/* optional: clamp description to two lines if you use tailwind line-clamp plugin */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style> -->
