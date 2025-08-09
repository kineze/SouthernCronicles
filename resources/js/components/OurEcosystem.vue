<!-- SalFlowerOrbit.vue -->
<template>
  <section
    class="relative w-full min-h-[320px] py-16 md:py-20 flex justify-center items-center overflow-hidden bg-white"
  >
    <!-- ─── PARALLAX TREES (hidden on mobile) ───────────────── -->
    <div
      class="tree-bg left-0 hidden md:block"
      :style="{
        backgroundImage: `url(${leftTree})`,
        backgroundPositionY: `${parallax}px`
      }"
    />
    <div
      class="tree-bg right-0 hidden md:block"
      :style="{
        backgroundImage: `url(${rightTree})`,
        backgroundPositionY: `-${parallax}px`
      }"
    />

    <!-- ─── ROTATING FLOWER ─────────────────────────────────── -->
    <img
      :src="salFlower"
      alt="Sal flower"
      class="absolute object-contain z-20 select-none pointer-events-none"
      :style="{
        width: sizePx,
        height: sizePx,
        transform: `rotate(${BASE_TILT + rotationDeg}deg)`,
        transformOrigin: 'center center'
      }"
    />

    <!-- ─── PING GLOW ───────────────────────────────────────── -->
    <img
      :src="salFlower"
      alt=""
      class="sal-ping absolute object-contain z-0 select-none pointer-events-none"
      :style="{ width: sizePx, height: sizePx }"
    />

    <!-- ─── PETAL ORBIT ─────────────────────────────────────── -->
    <div class="relative z-30" :style="{ width: sizePx, height: sizePx }">
      <div
        v-for="(logo, i) in petals"
        :key="i"
        class="absolute top-1/2 left-1/2 flex justify-center items-center"
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
            :style="{ width: petalPx, height: petalPx }"
          />
        </a>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'

/* ── ASSETS ─────────────────────────────────────────────── */
import salFlower from '@/assets/img/sal-flower-001.webp'
import leftTree  from '@/assets/img/left-tree.webp'
import rightTree from '@/assets/img/right-tree.webp'

/* ── PETAL DATA ─────────────────────────────────────────── */
const petals = [
  { src: '/assets/img/asian-review-sinhala.webp', url: 'https://theasianreviewsinhala.reviews/' },
  { src: '/assets/img/asianhomeoflit.webp',       url: 'https://www.facebook.com/profile.php?id=100089906924668&_rdc=2&_rdr#' },
  { src: '/assets/img/asianprizes.webp',          url: 'https://www.facebook.com/TheAsianPrizes/?_rdc=2&_rdr#' },
  { src: '/assets/img/asian-journal.webp',        url: 'https://theasianjournalofliterature.org/' },
  { src: '/assets/img/TALA_LOGO.webp',            url: 'https://theasianliteraryagency.com/' },
  { src: '/assets/img/asian-books.webp',          url: 'https://asian-reviews.com/' }
]

/* ── SCROLL/PARALLAX ────────────────────────────────────── */
const rotationDeg   = ref(0)
const parallax      = ref(0)
const BASE_TILT     = -30
const PARALLAX_RATE = 0.35

const isMobile = () => window.innerWidth < 640

const handleScroll = () => {
  if (isMobile()) return // skip parallax on mobile for perf
  parallax.value = window.scrollY * PARALLAX_RATE
}

/* ── RESPONSIVE SIZING ──────────────────────────────────── */
/* size: flower & orbit diameter; radius: orbit radius; petal: each logo size */
const size   = ref(620)   // px
const radius = ref(220)   // px
const petal  = ref(100)   // px

const applyResponsive = () => {
  const w = window.innerWidth

  if (w < 640) {
    // mobile
    size.value   = 300
    radius.value = 100
    petal.value  = 64
  } else if (w < 1024) {
    // tablet
    size.value   = 480
    radius.value = 180
    petal.value  = 80
  } else {
    // desktop
    size.value   = 620
    radius.value = 220
    petal.value  = 100
  }
}

const sizePx  = computed(() => `${size.value}px`)
const petalPx = computed(() => `${petal.value}px`)

const getPetalStyle = (idx, total) => {
  const angle = (360 / total) * idx
  const r     = radius.value
  return `
    width:${petal.value}px;
    height:${petal.value}px;
    transform:
      rotate(${angle}deg)
      translate(${r}px)
      rotate(-${angle}deg)
      translate(-50%, -50%);
  `
}

onMounted(() => {
  applyResponsive()
  handleScroll()
  window.addEventListener('resize', applyResponsive, { passive: true })
  window.addEventListener('scroll', handleScroll, { passive: true })
})

onUnmounted(() => {
  window.removeEventListener('resize', applyResponsive)
  window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped>
/* Repeating trunks */
.tree-bg {
  position: absolute;
  top: 0;
  bottom: 0;
  width: 240px;               /* trunk width */
  z-index: 10;
  pointer-events: none;
  background-repeat: repeat-y;
  background-size: auto 100%;
  background-position-x: center;
  backface-visibility: hidden;
}
.tree-bg.left-0  { left: 0; }
.tree-bg.right-0 { right: 0; }

/* Ping/glow behind flower */
@keyframes sal-ping {
  0%   { transform: rotate(-5deg) scale(1); opacity: 1; }
  75%  { transform: rotate(-5deg) scale(2); opacity: 0; }
  100% { transform: rotate(-5deg) scale(2); opacity: 0; }
}
.sal-ping { animation: sal-ping 6s cubic-bezier(0,0,0.2,1) infinite; }
</style>
