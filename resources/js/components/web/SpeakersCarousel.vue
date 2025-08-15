<template>
  <div class="relative bg-transparent md:pt-6">
    <h1 class="lg:text-6xl text-3xl text-black font-extrabold tracking-widest uppercase text-center">
      Speakers
    </h1>

    <div class="py-8 w-full max-w-screen-2xl mx-auto">
      <div class="w-full bg-white -mt-10">
        <HexHoneyGrid
          v-if="imageUrls.length"
          :images="imageUrls"
          :radius="62"
          :stroke-width="6"
          stroke-color="#ffffff"
          class="h-[600px] mx-auto"
          :shuffle="true"
          :interval-ms="7000"   
          :fade-ms="600"
          :batch-size="1"
          :overlay-opacity="0.65"
          :avoid-duplicates="true"
          dedupe-key="exact"
        />
        <div v-else class="w-full h-full grid place-items-center text-gray-500">
          Loading…
        </div>
      </div>

      <div class="text-center mt-6">
        <a href="/speakers-list" class="px-6 py-3 bg-black text-white font-bold">VIEW MORE</a>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import HexHoneyGrid from './HexHoney.vue'

const speakers = ref([])

const imageUrls = computed(() =>
  speakers.value
    .filter(s => s.show_on_home)
    .map(s => `/storage/${s.image}`)
)

async function fetchHomeSpeakers() {
  const { data } = await axios.get('/api/speakers?ordered=true')
  speakers.value = data || []
}
onMounted(fetchHomeSpeakers)
</script>
