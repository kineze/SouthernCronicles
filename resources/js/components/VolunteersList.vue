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
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      volunteers: { data: [], current_page: 1, last_page: 1 },
      search: '',
      perPage: 15,
      loading: false,
      debounceId: null,
    }
  },
  mounted() {
    this.fetchVolunteers()
  },
  methods: {
    async fetchVolunteers(page = 1) {
      // simple debounce on input
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
        } finally {
          this.loading = false
        }
      }, 250)
    },
    changePage(page) {
      this.fetchVolunteers(page)
    },
  },
}
</script>

<style scoped>
/* optional: clamp description to two lines if you use tailwind line-clamp plugin */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
