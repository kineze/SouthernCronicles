<template>
  <div class="relative pt-6 backdrop-blur-xl overflow-hidden lg:py-16">
    <div class="bg-black px-4 py-2 mb-5">
      <h1 class="lg:text-6xl text-3xl text-white font-extrabold tracking-widest uppercase text-center">
        Our Ecosystem
      </h1>
    </div>

    <div class="w-full max-w-screen-2xl mx-auto py-10 overflow-hidden">
      <!-- Make sure container has enough width and no clipping -->
      <div class="marquee-wrapper">
        <div class="marquee-track">
          <div
            v-for="(logo, index) in duplicatedLogos"
            :key="index"
            class="flex justify-center items-center shrink-0 px-4"
          >
            <img
              :src="logo"
              alt="ecosystem-logo"
              class="w-40 h-24 object-contain transition duration-300"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
const logos = [
  'assets/img/asian-lit-festival.webp',
  'assets/img/asian-books.webp',
  'assets/img/asian-review-sinhala.webp',
  'assets/img/asianhomeoflit.webp',
  'assets/img/asianprizes.webp',
  'assets/img/asianreviews.webp',
  'assets/img/asian-journal.webp',
  'assets/img/TALA_LOGO.webp',
  'assets/img/trogon.webp'
]

// Duplicate for continuous scroll
const duplicatedLogos = [...logos, ...logos]
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

/* Wrapper ensures overflow is handled */
.marquee-wrapper {
  overflow: hidden;
  width: 100%;
  position: relative;
}

/* Track is long enough for full scroll */
.marquee-track {
  display: flex;
  width: max-content;
  animation: marquee 20s linear infinite;
}

@media (max-width: 768px) {
  .marquee-track {
    animation-duration: 14s;
  }
}
</style>


