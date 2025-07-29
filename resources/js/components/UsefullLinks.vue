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
            <h3 class="text-sm font-semibold text-gray-800 dark:text-white ">
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
    title: 'Galerie Bortier',
    url: 'https://bortier.be/en/',
    image: 'assets/img/Bortier-logo.webp'
  },
  {
    title: 'visit.brussels',
    url: 'https://www.visit.brussels/en/visitors',
    image: 'assets/img/visitbrussels.webp'
    
  },
  {
    title: 'UNIVERSITÉ LIBRE DE BRUXELLES',
    url: 'https://www.ulb.be/en',
    image: 'assets/img/Logo-ULB.svg'
  },
  {
    title: 'Transport in Brussels',
    url: 'https://www.stib-mivb.be/home',
    image: 'assets/img/sitb-logo.webp'
  },
    {
    title: 'Brussels Museums',
    url: 'https://www.brusselsmuseums.be/en/',
    image: 'assets/img/museum-logo.webp'
  },
  
]
</script>
