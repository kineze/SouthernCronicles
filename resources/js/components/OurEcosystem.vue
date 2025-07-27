<template>
  <div class="relative pt-6 backdrop-blur-xl overflow-hidden lg:py-16">


    <div class="w-full max-w-screen-2xl mx-auto py-10 overflow-hidden">
      <!-- Make sure container has enough width and no clipping -->
      <div class="marquee-wrapper">
        <div class="marquee-track">
          <div
            v-for="(logo, index) in duplicatedLogos"
            :key="index"
            class="flex justify-center items-center shrink-0 px-4"
          >
          <a
            :href="logo.url"
            target="_blank"
            rel="noopener noreferrer"
            class="flex justify-center items-center shrink-0 px-4"
          >
            <img
              :src="logo.src"
              alt="ecosystem-logo"
              class="w-40 h-24 object-contain transition duration-300"
            />
          </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>

const logos = [
  { src: 'assets/img/asian-lit-festival.webp', url: 'https://www.facebook.com/profile.php?id=61573846436965' },
  { src: 'assets/img/asian-books.webp', url: 'https://asian-reviews.com/' },
  { src: 'assets/img/asian-review-sinhala.webp', url: 'https://theasianreviewsinhala.reviews/' },
  { src: 'assets/img/asianhomeoflit.webp', url: 'https://www.facebook.com/profile.php?id=100089906924668&_rdc=2&_rdr#' },
  { src: 'assets/img/asianprizes.webp', url: 'https://www.facebook.com/TheAsianPrizes/?_rdc=2&_rdr#' },
  { src: 'assets/img/asianreviews.webp', url: 'https://asian-reviews.com/' },
  { src: 'assets/img/asian-journal.webp', url: 'https://theasianjournalofliterature.org/' },
  { src: 'assets/img/TALA_LOGO.webp', url: 'https://theasianliteraryagency.com/' },
  { src: 'assets/img/trogon.webp', url: '#' }
]

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


