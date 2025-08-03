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
     <div v-if="showDrawer" class="fixed inset-0 z-[990] bg-black bg-opacity-40" @click="closeDrawer"></div>
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
      <div class="mt-6">
        <h5 class="font-semibold mb-2 text-gray-800 dark:text-white">Submission</h5>
        <div class="p-4 border rounded bg-gray-50 dark:bg-white">
          <div ref="printRef" class="submission-content" v-html="sanitizeSubmission(selected?.submission)"></div>
                
        </div>
<button
              @click="downloadPDF"
              class="mt-3 mb-2 px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded"
            >
              <i class="fa-solid fa-download mr-1"></i> Export as PDF
            </button>
      </div>


    </div>
  </div>
</template>

<script setup>
import html2pdf from 'html2pdf.js'
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useToast } from 'vue-toastification'

const toast = useToast()
const submissions = ref([])
const selected = ref(null)
const showDrawer = ref(false)

const printRef = ref(null)

const downloadPDF = () => {
  if (!printRef.value) return

  const element = printRef.value

  const opt = {
    margin:       0.5,
    filename:     `${selected.value?.given_name || 'submission'}-memory.pdf`,
    image:        { type: 'jpeg', quality: 0.98 },
    html2canvas:  { scale: 2 },
    jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' },
    pagebreak:    { mode: ['avoid-all', 'css', 'legacy'] }
  }

  html2pdf().set(opt).from(element).save()
}

const sanitizeSubmission = (html) => {
  if (!html) return '<p class="text-gray-400">No submission provided.</p>'
  return html.replace(/background-color:\s*[^;"]+;?/gi, '') // Remove inline backgrounds
}

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

<style >
.submission-content {
  font-size: 0.875rem; /* same as text-sm */
  color: #374151; /* gray-700 */
}

/* Alignment from Quill */
.submission-content .ql-align-center,
.submission-content [style*="text-align: center"],
.submission-content [style*="text-align:center"] {
  text-align: center;
  display: block;
}
.submission-content .ql-align-right,
.submission-content [style*="text-align: right"],
.submission-content [style*="text-align:right"] {
  text-align: right;
  display: block;
}
.submission-content .ql-align-justify,
.submission-content [style*="text-align: justify"],
.submission-content [style*="text-align:justify"] {
  text-align: justify;
  display: block;
}

/* Links */
.submission-content a {
  color: #3b82f6;
  text-decoration: underline;
}

/* Media */
.submission-content img,
.submission-content video {
  max-width: 100%;
  height: auto;
  display: block;
  margin-left: auto;
  margin-right: auto;
}

/* Optional: blockquote and lists */
.submission-content blockquote {
  border-left: 4px solid #d1d5db; /* gray-300 */
  padding-left: 1rem;
  color: #6b7280; /* gray-500 */
  font-style: italic;
  margin: 1em 0;
}
.submission-content ul {
  list-style-type: disc;
  padding-left: 1.5rem;
  margin: 1em 0;
}
.submission-content ol {
  list-style-type: decimal;
  padding-left: 1.5rem;
  margin: 1em 0;
}

.dark .submission-content {
  color: #f9fafb;
}

.dark .submission-content h1,
.dark .submission-content h2,
.dark .submission-content h3,
.dark .submission-content h4,
.dark .submission-content h5,
.dark .submission-content h6,
.dark .submission-content strong,
.dark .submission-content b {
  color: #f9fafb !important; /* ensure bold/heading text is white too */
}

.dark .submission-content blockquote {
  color: #e5e7eb; /* gray-200 for blockquotes */
  border-left-color: #4b5563; /* gray-600 */
}

.dark .submission-content a {
  color: #60a5fa; /* blue-400 */
}

</style>

