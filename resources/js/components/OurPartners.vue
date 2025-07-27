<template>
  <div class="max-w-screen-2xl mx-auto px-4 py-10">
    <h1 class="lg:text-6xl text-3xl text-black font-extrabold tracking-widest uppercase text-center mb-10">
      Our Partners
    </h1>

    
    <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-10 gap-2">
      <div
        v-for="partner in visiblePartners"
        :key="partner.id"
        class="overflow-hidden rounded bg-white"
      >
        <img :src="`/storage/${partner.image}`" alt="Partner" class="w-full h-36 object-contain p-2" />
      </div>
    </div>


    <div class="text-center mt-10" v-if="visiblePartners.length < allPartners.length">
      <button
        @click="loadMore"
        class="px-6 py-3 text-white bg-black hover:bg-gray-800 rounded-full font-bold transition"
      >
        Load More
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const allPartners = ref([])
const visiblePartners = ref([])
const rowsToShow = ref(5)
const cols = 10

const fetchPartners = async () => {
  const { data } = await axios.get('/api/our-partners')
  allPartners.value = data
  visiblePartners.value = data.slice(0, rowsToShow.value * cols)
}

const loadMore = () => {
  rowsToShow.value += 10
  visiblePartners.value = allPartners.value.slice(0, rowsToShow.value * cols)
}

onMounted(fetchPartners)
</script>
