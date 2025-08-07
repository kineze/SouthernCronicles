<template>
  <section
    class="relative w-full py-20 flex justify-center items-center overflow-hidden bg-white"
  >
    <!-- ─── PARALLAX TREES (repeat-y backgrounds) ───────────────── -->
    <!-- Left trunk (moves ↓) -->
    <div
      class="tree-bg left-0"
      :style="{
        backgroundPositionY: `${parallax}px`
      }"
    />

    <!-- Right trunk (moves ↑) -->
    <div
      class="tree-bg right-0"
      :style="{
        backgroundPositionY: `-${parallax}px`
      }"
    />

    <!-- ─── ROTATING FLOWER + PETALS ────────────────────────────── -->
    <img
      :src="salFlower"
      alt="Sal flower"
      class="absolute w-[620px] h-[620px] object-contain z-20 select-none pointer-events-none"
      :style="{
        transform: `rotate(${BASE_TILT + rotationDeg}deg)`,
        transformOrigin: 'center center'
      }"
    />
    <div class="relative w-[620px] h-[620px] z-30">
      <div
        v-for="(logo, i) in petals"
        :key="i"
        class="absolute top-1/2 left-1/2 w-[100px] h-[100px] flex justify-center items-center"
        :style="getPetalStyle(i, petals.length)"
      >
        <a
          :href="logo.url"
          target="_blank"
          rel="noopener noreferrer"
          class="w-full h-full flex items-center justify-center"
        >
          <img
            :src="logo.src"
            alt="ecosystem logo"
            class="w-full h-full object-contain rounded-full shadow-xl hover:scale-110 transition duration-300"
          />
        </a>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

/* ── ASSETS ─────────────────────────────────────────────── */
import salFlower from '@/assets/img/sal-flower-001.webp'
import leftTree  from '@/assets/img/left-tree.webp'
import rightTree from '@/assets/img/right-tree.webp'

/* ── PETAL DATA (unchanged) ─────────────────────────────── */
const petals = [
  { src: '/assets/img/asian-review-sinhala.webp', url: 'https://theasianreviewsinhala.reviews/' },
  { src: '/assets/img/asianhomeoflit.webp',       url: 'https://www.facebook.com/profile.php?id=100089906924668&_rdc=2&_rdr#' },
  { src: '/assets/img/asianprizes.webp',          url: 'https://www.facebook.com/TheAsianPrizes/?_rdc=2&_rdr#' },
  { src: '/assets/img/asian-journal.webp',        url: 'https://theasianjournalofliterature.org/' },
  { src: '/assets/img/TALA_LOGO.webp',            url: 'https://theasianliteraryagency.com/' },
  { src: '/assets/img/asian-books.webp',          url: 'https://asian-reviews.com/' }
]

const getPetalStyle = (idx, total) => {
  const angle  = (360 / total) * idx
  const r      = 220
  return `
    transform:
      rotate(${angle}deg)
      translate(${r}px)
      rotate(-${angle}deg)
      translate(-50%, -50%);
  `
}

/* ── SCROLL-DRIVEN EFFECTS ──────────────────────────────── */
const rotationDeg   = ref(0)
const parallax      = ref(0)
const BASE_TILT     = -30
const FULL_TURNS    = 1
const PARALLAX_RATE = 0.35

const handleScroll = () => {
  const max = document.body.scrollHeight - window.innerHeight
  const y   = window.scrollY
  rotationDeg.value = max ? (y / max) * 360 * FULL_TURNS : 0
  parallax.value    = y * PARALLAX_RATE
}

onMounted(() => {
  handleScroll()
  window.addEventListener('scroll', handleScroll, { passive: true })
})
onUnmounted(() => window.removeEventListener('scroll', handleScroll))
</script>

<style scoped>
/* Repeating trunks */
.tree-bg {
  position: absolute;
  top: 0;
  bottom: 0;
  width: 240px;                 /* ≈ natural trunk width — adjust as needed */
  z-index: 10;
  pointer-events: none;
  background-repeat: repeat-y;
  background-size: auto 100%;
  background-position-x: center;
  backface-visibility: hidden;
}
.tree-bg.left-0  { left: 0;  background-image: url('../assets/img/left-tree.webp'); }
.tree-bg.right-0 { right: 0; background-image: url('../assets/img/right-tree.webp'); }

/* Shadow-flower ping */
@keyframes sal-ping {
  0%   { transform: rotate(-5deg) scale(1); opacity: 1; }
  75%  { transform: rotate(-5deg) scale(2); opacity: 0; }
  100% { transform: rotate(-5deg) scale(2); opacity: 0; }
}
.sal-ping { animation: sal-ping 3s cubic-bezier(0,0,0.2,1) infinite; }
</style>
