<template>
  <div class="max-w-screen-2xl mx-auto bg-white dark:bg-gray-900 shadow py-10">
    <h1 class="lg:text-6xl text-3xl mt-4 text-black dark:text-white font-extrabold tracking-widest uppercase text-center mb-8">
      Volunteer With Us
    </h1>

    <div class="flex flex-wrap">
      <!-- Left content -->
      <div class="max-w-7xl lg:w-7/12 mt-10 lg:p-4 space-y-6 text-gray-700 dark:text-gray-300 text-base leading-relaxed">

        <p class="text-justify">
          Volunteers help us collect, organize, and share endangered intangible heritage—stories, songs, rituals, and the knowledge that binds communities together.
        </p>
        <p class="text-justify">
          Whether you’re great at outreach, documentation, translation, or editing, your skills can preserve wisdom for future generations.
        </p>
        <p class="font-medium text-justify">
          Fill the form to register as a volunteer. We’ll reach out with next steps.
        </p>
      </div>

      <!-- Right column: Form -->
      <div class="mt-10 max-w-4xl lg:w-5/12 lg:p-4 mx-auto bg-white dark:bg-gray-800 rounded-lg shadow space-y-6 lg:sticky lg:top-4 lg:max-h-[100svh] lg:overflow-y-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- First Name -->
          <div class="relative">
            <input v-model="form.first_name" type="text" id="first_name" placeholder=" "
                   class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer" required />
            <label for="first_name" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]">
              First Name
            </label>
          </div>

          <!-- Last Name -->
          <div class="relative">
            <input v-model="form.last_name" type="text" id="last_name" placeholder=" "
                   class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer" required />
            <label for="last_name" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]">
              Last Name
            </label>
          </div>

          <!-- Email -->
          <div class="relative md:col-span-2">
            <input v-model="form.email" type="email" id="email" placeholder=" "
                   class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer" required />
            <label for="email" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]">
              Email
            </label>
          </div>

          <!-- Contact Number -->
          <div class="relative md:col-span-2">
            <input v-model="form.contact_number" type="text" id="contact_number" placeholder=" "
                   class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer" required />
            <label for="contact_number" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]">
              Contact Number
            </label>
          </div>
        </div>

        <!-- Description (optional) -->
        <div class="relative">
          <textarea v-model="form.description" id="description" rows="4" placeholder=" "
                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer"></textarea>
          <label for="description" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]">
            Tell us about your skills / interests (optional)
          </label>
        </div>

        <!-- Submit -->
        <div class="text-start">
          <button @click="submitForm" :disabled="submitting"
                  class="px-6 py-2 bg-black text-white font-semibold rounded hover:bg-gray-800 transition disabled:opacity-60">
            {{ submitting ? 'Submitting…' : 'Submit' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { useToast } from 'vue-toastification'

const toast = useToast()

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
          toast.error('Failed to fetch volunteers.')
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
      const meta = map[type]
      this.confirm = {
        show: true,
        type,
        row,
        ...meta,
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
          toast.success('Volunteer deleted successfully.')
        }

        await this.fetchVolunteers(this.volunteers.current_page || 1)
        this.closeConfirm()
      } catch (e) {
        console.error('Action failed', e)
        toast.error('Action failed. Please try again.')
        this.confirm.loading = false
      }
    },
  },
}
</script>

