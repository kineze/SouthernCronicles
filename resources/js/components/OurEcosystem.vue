<template>
  <div class="relative pt-6 backdrop-blur-xl overflow-hidden lg:py-16">
    <div class=" bg-black px-4 py-2 mb-5">
      <h1 class="lg:text-6xl text-3xl text-white font-extrabold tracking-widest uppercase text-center">
        Our Ecosystem
      </h1>
    </div>

    <div class="w-full max-w-screen-2xl mx-auto py-10 overflow-hidden">
      <div class="flex whitespace-nowrap animate-marquee gap-8">
        <div v-for="(logo, index) in duplicatedLogos" :key="index" class="flex justify-center items-center rounded-full shrink-0 -px-4">
          <img
            :src="logo"
            alt="ecosystem-logo"
            class="w-40 h-24 object-contain  transition duration-300"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
// Duplicate logos array to make it continuous
const logos = [
  'assets/img/asian-lit-festival.webp',
  'assets/img/asian-books.webp',
  'assets/img/asian-review-sinhala.webp',
  'assets/img/asianhomeoflit.webp',
  'assets/img/asianprizes.webp',
  'assets/img/asianreviews.webp',
  'assets/img/asian-journal.webp',
  'assets/img/TALA_LOGO.webp'
]

const duplicatedLogos = [...logos, ...logos] // Repeat for smoother loop
</script>

<style scoped>
@keyframes marquee {
  0% {
    transform: translateX(0%);
  }
  100% {
    transform: translateX(-50%);
  }
}

.animate-marquee {
  display: flex;
  animation: marquee 20s linear infinite;
}
</style>
