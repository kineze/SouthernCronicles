<template>
  <div class="relative w-full py-20 flex justify-center items-center bg-white overflow-hidden">
    <!-- Rotated Sal flower background -->
    <img
      src="/public/assets/img/sal-flower.webp"
      alt="Sal flower"
      class="absolute w-[620px] h-[620px] object-contain z-20"
      style="transform: rotate(-5deg);"
    />

    <!-- Background flower with slow ping -->
    <img
      src="/public/assets/img/sal-flower.webp"
      alt="Sal flower"
      class="absolute w-[620px] h-[620px] object-contain z-10 slow-ping"
      style="transform: rotate(-5deg);"
    />



    <!-- Circular petal layout -->
    <div class="relative w-[620px] h-[620px] z-30">
      <div
        v-for="(logo, index) in petals"
        :key="index"
        class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex justify-center items-center"
        :style="getPetalStyle(index, petals.length)"
      >
        <a
          :href="logo.url"
          target="_blank"
          rel="noopener noreferrer"
          class="w-full h-full flex items-center justify-center"
        >
          <img
            :src="logo.src"
            alt="ecosystem-logo"
            class="w-full h-full object-contain rounded-full shadow-xl hover:scale-110 transition duration-300"
          />
        </a>
      </div>
    </div>
  </div>
</template>

<script setup>
// 7 logos — 6 original + 1 duplicate
const petals = [
  { src: 'assets/img/asian-books.webp', url: 'https://asian-reviews.com/' },
  { src: 'assets/img/asianhomeoflit.webp', url: 'https://www.facebook.com/profile.php?id=100089906924668&_rdc=2&_rdr#' },
  { src: 'assets/img/asianprizes.webp', url: 'https://www.facebook.com/TheAsianPrizes/?_rdc=2&_rdr#' },
  { src: 'assets/img/asianreviews.webp', url: 'https://asian-reviews.com/' },
  { src: 'assets/img/asian-journal.webp', url: 'https://theasianjournalofliterature.org/' },
  { src: 'assets/img/TALA_LOGO.webp', url: 'https://theasianliteraryagency.com/' },
  { src: 'assets/img/asian-books.webp', url: 'https://asian-reviews.com/' } // duplicated one
]

// Logo positions for 7-petal symmetry
const getPetalStyle = (index, total) => {
  const angle = (360 / total) * index
  const radius = 220
  return `
    transform: rotate(${angle}deg)
               translate(${radius}px)
               rotate(-${angle}deg)
               translate(-50%, -50%);
  `
}
</script>

<style scoped>

@keyframes slow-rotate {
  0% {
    transform: rotate(-5deg);
  }
  100% {
    transform: rotate(355deg);
  }
}

.slow-spin {
  animation: slow-rotate 60s linear infinite;
}

.slow-pulse {
  animation: pulse 5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.slow-ping {
  animation: ping 6s cubic-bezier(0, 0, 0.2, 1) infinite;
}

</style>
