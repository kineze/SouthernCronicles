<template>
  <div >
    <div class="flex justify-between p-4 bg-white dark:bg-gray-800 shadow mb-6 rounded-xl">
      <h4 class="text-lg font-semibold dark:text-white">Registered List</h4>
      <!-- <button @click="openDrawer"  class="px-4 py-1.5 bg-gray-800 text-white dark:bg-green-500 rounded-full text-sm font-semibold">Add Partner</button> -->
    </div>

        <div class="relative mb-4">
        <input
            v-model="search"
            @input="fetchRegistrations"
            type="text"
            id="search_contact"
            placeholder=" "
            class="block px-2.5 pb-2.5 pt-4 w-6/12 text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer"
        />
        <label
            for="search_contact"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-slate-950 px-2 peer-focus:px-2 peer-focus:text-green-600 peer-focus:dark:text-green-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1"
        >
            Search by contact number
        </label>
        </div>

    <div class="relative overflow-x-auto shadow-md mt-7 sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th class="px-6 py-3 dark:text-white font-semibold">First Name</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Last Name</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Email</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Contact</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Country</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Postal Code</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Address Line 1</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Address Line 2</th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="item in registrations.data"
            :key="item.id"
            class="border-b dark:border-gray-700"
        >
            <td class="px-6 py-4 dark:text-white font-medium">{{ item.first_name }}</td>
            <td class="px-6 py-4 dark:text-white font-medium">{{ item.last_name }}</td>
            <td class="px-6 py-4 dark:text-white font-medium">{{ item.email }}</td>
            <td class="px-6 py-4 dark:text-white font-medium">{{ item.contact_number }}</td>
            <td class="px-6 py-4 dark:text-white font-medium">{{ item.country }}</td>
            <td class="px-6 py-4 dark:text-white font-medium">{{ item.postal_code }}</td>
            <td class="px-6 py-4 dark:text-white font-medium">{{ item.address_line_1 }}</td>
            <td class="px-6 py-4 dark:text-white font-medium">{{ item.address_line_2 }}</td>
        </tr>
        </tbody>
    </table>
    </div>


    <!-- Pagination -->
    <div class="flex justify-end space-x-6 items-center mt-4">
      <button
        :disabled="!registrations.prev_page_url"
        @click="changePage(registrations.current_page - 1)"
        class="px-4 py-2 bg-gray-800 text-white rounded disabled:opacity-50"
      >
        Previous
      </button>
      <span>Page {{ registrations.current_page }} of {{ registrations.last_page }}</span>
      <button
        :disabled="!registrations.next_page_url"
        @click="changePage(registrations.current_page + 1)"
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
      registrations: {
        data: [],
        current_page: 1,
        last_page: 1,
      },
      search: '',
    }
  },
  mounted() {
    this.fetchRegistrations()
  },
  methods: {
    async fetchRegistrations(page = 1) {
      try {
        const response = await axios.get('/api/registrations', {
          params: {
            search: this.search,
            page,
          },
        })
        this.registrations = response.data
      } catch (error) {
        console.error('Error fetching registrations:', error)
      }
    },
    changePage(page) {
      this.fetchRegistrations(page)
    },
  },
}
</script>

<style scoped>
/* Optional: custom styles */
</style>
