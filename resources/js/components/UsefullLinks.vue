<template>
  <section class="w-full max-w-screen-2xl mt-6 mx-auto p-3">
    <!-- Map -->


    <!-- Useful Links Grid -->
    <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
      <div
        v-for="link in links"
        :key="link.title"
        class="bg-white dark:bg-gray-800 overflow-hidden "
      >
        <a :href="link.url" target="_blank" rel="noopener noreferrer">
          <img :src="link.image" :alt="link.title" class="w-full h-40 object-contain" />
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
    image: 'https://bortier.be/wp-content/uploads/2025/01/Bortier-Gallery-Brussels-logo-Black.png'
  },
  {
    title: 'visit.brussels',
    url: 'https://www.visit.brussels/en/visitors',
    image: 'https://www.visit.brussels/content/dam/visitbrussels/logos/visit-brussels.svg/jcr:content/renditions/large-1920px.jpeg'
  },
  {
    title: 'Untold Asian Stories',
    url: 'https://untoldasianstories.be/',
    image: 'https://untoldasianstories.be/wp-content/uploads/2025/05/35A9783-2048x1365.jpg'
  },
  {
    title: 'Transport in Brussles',
    url: 'https://www.stib-mivb.be/home',
    image: 'https://www.stib-mivb.be/files/live/sites/STIBMIVB/files/Legal/Homepage/sitb-mivb-logo.svg'
  },
    {
    title: 'Brussels Musiums',
    url: 'https://www.brusselsmuseums.be/en/',
    image: 'https://brusselsmuseums-prod.imgix.net/images/MMRK_10STATION-1.jpg?auto=compress%2Cformat&crop=faces&faceindex=1&fit=crop&fp-x=0.5&fp-y=0.5&h=696&q=80&w=1198'
  },
  
]
</script>
