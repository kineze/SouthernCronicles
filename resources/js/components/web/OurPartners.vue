<template>
  <div class="max-w-screen-2xl mx-auto px-4 py-10">
    <h1 class="lg:text-6xl text-3xl text-primary-blue font-extrabold tracking-widest uppercase text-center mb-10">
      Our Partners
    </h1>

    <!-- Grid -->
    <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-10 gap-2">
      <div
        v-for="partner in visiblePartners"
        :key="partner.id"
        class="overflow-hidden rounded bg-white"
      >
        <a
          v-if="partner.site_url"
          :href="partner.site_url"
          target="_blank"
          rel="noopener"
        >
          <img
            :src="`/storage/${partner.image}`"
            :alt="partner.title"
            class="w-full h-36 object-contain p-2 hover:scale-105 transition-transform"
          />
        </a>
        <img
          v-else
          :src="`/storage/${partner.image}`"
          :alt="partner.title"
          class="w-full h-36 object-contain p-2"
        />
      </div>
    </div>

    <!-- Load More -->
    <div class="text-center mt-10" v-if="visiblePartners.length < allPartners.length">
      <button
        @click="loadMore"
        class="px-6 py-3 text-white bg-primary-blue hover:bg-gray-800 rounded-full font-bold transition"
      >
        Load More
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'

const allPartners = ref([])
const rowsToShow = ref(5)
const cols = 10

const fetchPartners = async () => {
  const { data } = await axios.get('/api/our-partners?ordered=true')
  allPartners.value = data || []
}

const visiblePartners = computed(() => {
  const max = rowsToShow.value * cols
  return allPartners.value.slice(0, max)
})

const loadMore = () => {
  rowsToShow.value += 10
}

onMounted(async () => {
  await fetchPartners()
})
</script>
