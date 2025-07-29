<template>
  <section class="w-full max-w-screen-2xl mt-6 mx-auto p-3 ">
    <!-- Map -->


    <!-- Useful Links Grid -->
    <div class="grid gap-6 grid-cols-1 md:grid-cols-3 lg:grid-cols-5">
      <div
        v-for="link in links"
        :key="link.title"
        class="bg-white dark:bg-gray-800 overflow-hidden "
      >
        <a :href="link.url" target="_blank" rel="noopener noreferrer">
          <img :src="link.image" :alt="link.title" class="w-full h-16 object-contain" />
          <div class="p-4 text-center">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
              {{ link.title }}
            </h3>
          </div>
        </a>
      </div>
    </div>
  </section>
</template>

<script setup>
const links = [
  {
    title: 'Gallery Bortier',
    url: 'https://bortier.be/en/',
    image: 'assets/img/Bortier-logo.webp'
  },
  {
    title: 'visit.brussels',
    url: 'https://www.visit.brussels/en/visitors',
    image: 'assets/img/visitbrussels.webp'
    
  },
  {
    title: 'Civitatis Brussels',
    url: 'https://www.introducingbrussels.com/',
    image: 'assets/img/civitails.webp'
  },
  {
    title: 'Transport in Brussles',
    url: 'https://www.stib-mivb.be/home',
    image: 'assets/img/sitb-logo.webp'
  },
    {
    title: 'Brussels Musiums',
    url: 'https://www.brusselsmuseums.be/en/',
    image: 'assets/img/museum-logo.webp'
  },
  
]
</script>
