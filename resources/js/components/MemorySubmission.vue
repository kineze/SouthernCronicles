<template>
  <div class="p-4">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white dark:bg-gray-800 shadow rounded-xl p-4">
      <h4 class="text-lg font-semibold dark:text-white">Memory Submissions</h4>
    </div>

    <!-- Table -->
    <div class="relative overflow-x-auto shadow-md mt-7 sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th class="px-6 py-3 dark:text-white font-semibold">Given Name</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Family Name</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Country</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Copyright</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Copyright Holder</th>
            <th class="px-6 py-3 dark:text-white font-semibold">Copyright Holder Contact Info</th>
            <th class="px-6 py-3 dark:text-white font-semibold">File</th>
            <th class="px-6 py-3 dark:text-white font-semibold text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="submission in submissions" :key="submission.id" class="border-b dark:border-gray-700">
            <td class="px-6 py-4 dark:text-white">{{ submission.given_name }}</td>
            <td class="px-6 py-4 dark:text-white">{{ submission.family_name }}</td>
            <td class="px-6 py-4 dark:text-white">{{ submission.country }}</td>
            <td class="px-6 py-4 dark:text-white">
              {{ submission.is_copyright ? 'Yes' : 'No' }}
            </td>
            <td>
                <div v-if="submission.is_copyright" class="text-xs flex gap-6 text-gray-400">
                {{ submission.copyright_holder }}
              </div>
            </td>
            <td>
                <div v-if="submission.is_copyright" class="text-xs flex gap-6 text-gray-400">
                {{ submission.copyright_contact }}
              </div>
            </td>
            <td class="px-6 py-4 dark:text-white">
              <a
                v-if="submission.file_url"
                :href="submission.file_url"
                target="_blank"
                class="text-blue-600 underline"
              >
                Download
              </a>
              <span v-else>—</span>
            </td>
            <td class="px-6 py-4 flex justify-end gap-3 text-right">
              <button @click="openDrawer(submission)" class="text-blue-500" title="View">
                <i class="fa-solid fa-eye"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Drawer (View) -->
    <div
      class="fixed top-0 right-0 z-[990] h-screen w-[800px] p-4 overflow-y-auto transition-transform bg-white dark:bg-gray-800"
      :class="showDrawer ? 'translate-x-0' : 'translate-x-full'"
      tabindex="-1"
    >
      <h5 class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400">
        <i class="fa-solid fa-eye mr-2"></i> Submission Details
      </h5>
      <button
        type="button"
        @click="closeDrawer"
        class="text-gray-400 hover:text-gray-900 dark:hover:text-white absolute top-2.5 right-2.5 rounded-lg text-sm w-8 h-8 inline-flex items-center justify-center"
      >
        <i class="fa-solid fa-xmark"></i>
      </button>

      <div class="text-sm text-gray-700 dark:text-gray-200  grid grid-cols-2">
        <p class="mb-3"><strong>Given Name:</strong> <br> {{ selected?.given_name }}</p>
        <p class="mb-3"><strong>Family Name:</strong> <br> {{ selected?.family_name }}</p>
        <p class="mb-3"><strong>Country:</strong> {{ selected?.country }}</p>
        <p class="mb-3"><strong>Copyright:</strong> {{ selected?.is_copyright ? 'Yes' : 'No' }}</p>
        <p class="mb-3" v-if="selected?.is_copyright"><strong>Copyright Holder:</strong> {{ selected?.copyright_holder }}</p>
        <p class="mb-3" v-if="selected?.is_copyright"><strong>Copyright Holder Contact:</strong> {{ selected?.copyright_contact }}</p>
        
      </div>
      <div >
          <strong>Submission:</strong>
          <div
            class="p-4 border rounded mt-4 bg-gray-50 dark:bg-gray-900 prose prose-sm max-w-none dark:prose-invert"
            v-html="selected?.submission"
          />
        </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useToast } from 'vue-toastification'

const toast = useToast()
const submissions = ref([])
const selected = ref(null)
const showDrawer = ref(false)

const fetchSubmissions = async () => {
  try {
    const res = await axios.get('/api/memory-submissions')
    submissions.value = res.data
  } catch (err) {
    toast.error('Failed to load memory submissions.')
  }
}

const openDrawer = (submission) => {
  selected.value = submission
  showDrawer.value = true
}

const closeDrawer = () => {
  showDrawer.value = false
  selected.value = null
}

onMounted(fetchSubmissions)
</script>

<style scoped>
.prose a {
  color: #3b82f6;
  text-decoration: underline;
}
</style>
