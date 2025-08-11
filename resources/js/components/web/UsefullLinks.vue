<template>
  <section class="w-full max-w-screen-2xl mt-6 mx-auto p-3">
    <!-- Useful Links Grid -->
    <div class="grid gap-6 grid-cols-1 md:grid-cols-3 lg:grid-cols-6">
      <div
        v-for="(link, index) in displayLinks"
        :key="index"
        class="bg-white dark:bg-gray-800 overflow-hidden"
      >
        <a
          v-if="link.url"
          :href="link.url"
          target="_blank"
          rel="noopener noreferrer"
        >
          <img :src="link.image" :alt="link.title" class="w-full h-16 object-contain" />
          <div class="p-4 text-center">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-white">
              {{ link.title }}
            </h3>
          </div>
        </a>
        <!-- Placeholder slot -->
        <div v-else>
          <img
            :src="placeholderImage"
            alt="Advertisement Space"
            class="w-full h-16 object-contain"
          />
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

const links = ref([])
const placeholderImage = '/assets/img/adspace.webp' // path to your uploaded image

// Fetch from backend
const fetchLinks = async () => {
  const { data } = await axios.get('/api/useful-links')
  links.value = data.map(link => ({
    title: link.title,
    url: link.url,
    image: `/storage/${link.image}`
  }))
}

// Always show exactly 6 slots
const displayLinks = computed(() => {
  const totalCols = 6
  const filled = [...links.value]
  const remaining = totalCols - filled.length
  if (remaining > 0) {
    // Push placeholder objects
    for (let i = 0; i < remaining; i++) {
      filled.push({ title: '', url: '', image: '' })
    }
  }
  return filled
})

onMounted(fetchLinks)
</script>
