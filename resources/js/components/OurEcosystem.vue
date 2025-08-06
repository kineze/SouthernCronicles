<script setup>
import salFlower from '@/assets/img/sal-flower.webp' // put file at resources/js/assets/img/sal-flower.webp

const petals = [
  { src: '/assets/img/asian-review-sinhala.webp', url: 'https://theasianreviewsinhala.reviews/' },
  { src: '/assets/img/asianhomeoflit.webp',       url: 'https://www.facebook.com/profile.php?id=100089906924668&_rdc=2&_rdr#' },
  { src: '/assets/img/asianprizes.webp',          url: 'https://www.facebook.com/TheAsianPrizes/?_rdc=2&_rdr#' },
  { src: '/assets/img/asianreviews.webp',         url: 'https://asian-reviews.com/' },
  { src: '/assets/img/asian-journal.webp',        url: 'https://theasianjournalofliterature.org/' },
  { src: '/assets/img/TALA_LOGO.webp',            url: 'https://theasianliteraryagency.com/' },
  { src: '/assets/img/asian-books.webp',          url: 'https://asian-reviews.com/' }
]

const getPetalStyle = (index, total) => {
  const angle = (360 / total) * index
  const radius = 220
  return `
    transform:
      rotate(${angle}deg)
      translate(${radius}px)
      rotate(-${angle}deg)
      translate(-50%, -50%);
  `
}
</script>

<template>
  <div class="relative w-full py-20 flex justify-center items-center bg-white overflow-hidden">
    <!-- Foreground -->
    <img
      :src="salFlower"
      alt="Sal flower"
      class="absolute w-[620px] h-[620px] object-contain z-20 opacity-45 rotate-[-5deg]"
    />

    <!-- Background with custom ping -->
    <img
      :src="salFlower"
      alt="Sal flower"
      class="absolute w-[620px] h-[620px] object-contain opacity-45 z-10 sal-ping"
    />

    <!-- Circular petal layout -->
    <div class="relative w-[620px] h-[620px] z-30">
      <div
        v-for="(logo, index) in petals"
        :key="index"
        class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex justify-center items-center"
        :style="getPetalStyle(index, petals.length)"
      >
        <a :href="logo.url" target="_blank" rel="noopener noreferrer" class="w-full h-full flex items-center justify-center">
          <img :src="logo.src" alt="ecosystem-logo" class="w-full h-full object-contain rounded-full shadow-xl hover:scale-110 transition duration-300" />
        </a>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Custom keyframes; not purged */
@keyframes sal-ping {
  0%   { transform: rotate(-5deg) scale(1); opacity: 1; }
  75%  { transform: rotate(-5deg) scale(2); opacity: 0; }
  100% { transform: rotate(-5deg) scale(2); opacity: 0; }
}
.sal-ping {
  /* keep rotation inside the animation so transform isn’t overridden */
  animation: sal-ping 3s cubic-bezier(0, 0, 0.2, 1) infinite;
}
</style>
