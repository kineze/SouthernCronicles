<template>
  <div class="max-w-screen-2xl mx-auto bg-white dark:bg-gray-900 focus:border-black shadow py-10">
    <h1 class="lg:text-6xl text-3xl mt-4 text-black dark:text-white font-extrabold tracking-widest uppercase text-center mb-8">
      The Living Memory Vault
    </h1>

    <div class="flex flex-wrap">
      <div class="max-w-7xl lg:w-7/12 mt-10 lg:p-4 space-y-6 text-gray-700 dark:text-gray-300 text-base leading-relaxed">
        <p>
          <strong class="text-black dark:text-white text-lg text-justify">A Global Initiative to Preserve Our Intangible Heritage</strong>
        </p>

        <p class="text-justify">
          In an age of rapid modernisation, countless threads of humanity's collective wisdom are quietly disappearing. Ancient stories that once shaped communities, traditional knowledge passed down through generations, and cultural practices that connect us to our ancestors—much of this invaluable folklore is now endangered or has already vanished forever.
        </p>

        <p class="text-justify">
          The Asian Literary Festivals and The Purple Umbrella Theatre Festival have joined forces to launch <strong>The Living Memory Vault</strong>—an ambitious global initiative dedicated to safeguarding and revitalising our world's endangered intangible heritage. This digital repository represents more than just preservation; it's a living, breathing archive that ensures these precious stories, traditions, and wisdom continue to inspire and educate future generations.
        </p>

        <p class="text-justify">
          We firmly believe that wisdom and science are inseparably interlinked—that there can be no true scientific progress without the foundational knowledge and understanding that folklore provides. From traditional ecological practices to ancient healing methods, from moral teachings embedded in folktales to community-building rituals, this heritage forms the bedrock of human knowledge and resilience.
        </p>

        <p class="text-justify">
          <strong>The Living Memory Vault</strong> calls upon storytellers, cultural practitioners, researchers, and community members worldwide to become guardians of this irreplaceable heritage. Whether you're a keeper of oral traditions, a scholar of cultural practices, or simply someone passionate about preserving the stories that make us human, your contribution can help ensure that no tale goes untold, no tradition disappears unrecorded.
        </p>

        <p class="text-justify">
          Together, we can build a comprehensive global archive that not only preserves these treasures but makes them accessible to communities, educators, and future generations worldwide. Join us in this vital mission to protect the stories that define who we are and where we come from.
        </p>

        <p class="font-medium text-justify">
          Register as a contributor to <strong>The Living Memory Vault</strong> today and help us preserve humanity's greatest stories for tomorrow.
        </p>

        


        <div class="mt-6 text-center">
          <!-- <button
            @click="showForm = !showForm"
            class="inline-block px-6 py-3 bg-black text-white text-sm font-semibold rounded hover:bg-gray-800 transition"
          >
            Register & View Submission Guidelines
          </button> -->
        </div>
      </div>

      <!-- Registration Form -->
      <div class="mt-10 max-w-4xl lg:w-5/12 lg:p-4 mx-auto bg-white dark:bg-gray-800 rounded-lg shadow space-y-6 lg:sticky lg:top-4 lg:max-h-[100svh] lg:overflow-y-auto">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="relative">
            <input
              v-model="form.given_name"
              type="text"
              placeholder=" "
               id="given_name"
              class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer"
            />
            <label  for="given_name" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]
                peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2
                peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
              Given Name
            </label>
          </div>

          <div class="relative">
            <input
              v-model="form.family_name"
              type="text"
              placeholder=" "
              id="family_name"
              class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer"
            />
            <label  for="family_name" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]
                peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2
                peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
              Family Name
            </label>
          </div>

          <div class="relative col-span-1 md:col-span-2">
            <input
              v-model="form.country"
              type="text"
              placeholder=" "
              id="title"
              class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer"
            />
            <label for="title" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]
                peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2
                peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
              Country
            </label>
          </div>
        </div>

        <!-- Submission Quill Editor -->
<!-- Inside your template -->
<div class="relative">
  <label class="block text-sm mb-2 text-gray-700 dark:text-gray-300">Submission</label>
  <QuillEditor
    theme="snow"
    v-model:content="form.submission"
    contentType="html"
    toolbar="essential"
    class="bg-white dark:bg-gray-900 text-black dark:text-white border border-gray-500 dark:border-gray-600 rounded"
  />
</div>


  <div
    class="relative border-2 border-dashed border-gray-400 dark:border-gray-600 rounded-lg p-6 text-center bg-white dark:bg-gray-800 hover:border-black transition"
  >
    <label
      v-if="!selectedFileName"
      for="file_upload"
      class="flex flex-col items-center justify-center space-y-2 text-sm text-gray-600 dark:text-gray-300 cursor-pointer"
    >
      <svg
        class="w-8 h-8 text-gray-400 dark:text-gray-500"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M7 16v-4m0 0V4m0 8H4m3 0h3m5 4v-4m0 0V4m0 8h-3m3 0h3"
        />
      </svg>
      <span class="font-medium">Drag & drop or click to upload a file</span>
      <span class="text-xs text-gray-400 dark:text-gray-500">(PDF, DOCX, JPG, PNG — optional)</span>
    </label>

    <div v-else class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-300">
      <span class="truncate max-w-[80%]">
        📎 {{ selectedFileName }}
      </span>
      <button
        @click="removeSelectedFile"
        type="button"
        class="ml-2 px-2 py-1 text-red-600 hover:text-white hover:bg-red-600 rounded text-xs transition"
      >
        ✕ Remove
      </button>
    </div>

    <input
      type="file"
      id="file_upload"
      @change="handleFileUpload"
      class="absolute inset-0 opacity-0 cursor-pointer"
    />
  </div>




        <!-- Copyright Section -->
        <div>
          <label class="inline-flex items-center text-sm dark:text-white">
            <input type="checkbox" v-model="form.is_copyright" class="mr-2" />
            Is this copyright material?
          </label>

          <div v-if="form.is_copyright" class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div class="relative">
              <input
                v-model="form.copyright_holder"
                type="text"
                placeholder=" "
                id="copy"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer"
              />
              <label for="copy" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]
                  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2
                  peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
                Copyright Holder
              </label>
            </div>

            <div class="relative">
              <input
                v-model="form.copyright_contact"
                type="text"
                placeholder=" "
                id="copyright_contact"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer"
              />
              <label for="copyright_contact" class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]
                  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2
                  peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
                Contact Email
              </label>
            </div>
          </div>
        </div>

        <!-- Declaration -->
        <div class="mt-4">
          <label class="inline-flex items-start text-sm dark:text-white">
            <input type="checkbox" v-model="form.declaration" required class="mt-1 mr-2" />
            <span>
              I hereby give my consent to The Asian Festivals and its affiliates to publish in the printed and online form and use for research,
              other educational purposes, adaptation and for anthologies/collections.
            </span>
          </label>
        </div>

        <!-- Submit -->
        <div class="text-start">
          <button
            @click="submitForm"
            class="px-6 py-2 bg-black text-white font-semibold rounded hover:bg-gray-800 transition"
          >
            Submit
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useToast } from 'vue-toastification'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'

const toast = useToast()
const showForm = ref(false)

const form = ref({
  given_name: '',
  family_name: '',
  country: '',
  submission: '', // bound to QuillEditor v-model
  is_copyright: false,
  copyright_holder: '',
  copyright_contact: '',
  declaration: false
})

const selectedFile = ref(null)
const selectedFileName = ref('')

const handleFileUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    selectedFile.value = file
    selectedFileName.value = file.name
  }
}

const removeSelectedFile = () => {
  selectedFile.value = null
  selectedFileName.value = ''
}

const clearForm = () => {
  form.value = {
    given_name: '',
    family_name: '',
    country: '',
    submission: '',
    is_copyright: false,
    copyright_holder: '',
    copyright_contact: '',
    declaration: false
  }
  selectedFile.value = null
  selectedFileName.value = ''
}

const submitForm = async () => {
  if (!form.value.declaration) {
    toast.error('❗ Please accept the declaration before submitting.')
    return
  }

  try {
    const formData = new FormData()
    formData.append('given_name', form.value.given_name)
    formData.append('family_name', form.value.family_name)
    formData.append('country', form.value.country)
    formData.append('submission', form.value.submission)
    formData.append('is_copyright', form.value.is_copyright ? '1' : '0')
    formData.append('copyright_holder', form.value.copyright_holder)
    formData.append('copyright_contact', form.value.copyright_contact)
    if (selectedFile.value) {
      formData.append('file', selectedFile.value)
    }

    const response = await fetch('/api/memory-submissions', {
      method: 'POST',
      body: formData
    })

    const data = await response.json()

    if (!response.ok) {
      toast.error(`❌ Submission failed: ${data.message || 'Unknown error'}`)
      return
    }

    toast.success('✅ Your submission has been received!')
    clearForm()
    showForm.value = false
  } catch (error) {
    console.error('Submission error:', error)
    toast.error('❌ An error occurred while submitting. Please try again.')
  }
}
</script>



