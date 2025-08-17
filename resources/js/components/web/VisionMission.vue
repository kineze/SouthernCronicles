<!-- resources/js/components/web/VisionMission.vue -->
<template>
  <section
    class="relative w-full max-w-screen-2xl mx-auto px-4 sm:px-6 py-8"
    aria-labelledby="vm-title"
  >
    <!-- Subtle decorative backdrop -->
    <!-- <div class="pointer-events-none absolute inset-0 -z-10 opacity-60" aria-hidden="true">
      <div class="absolute -top-24 -right-16 w-72 h-72 rounded-full blur-3xl" :class="accentBgClass"></div>
      <div class="absolute -bottom-24 -left-10 w-72 h-72 rounded-full blur-3xl" :class="accentBgAltClass"></div>
    </div> -->

    <!-- Section heading -->
    <header class="text-center mb-10 lg:mb-14">
      <p class="text-sm tracking-[8px] uppercase font-semibold text-gray-600">
        {{ eyebrow }}
      </p>
      <h2 id="vm-title" class="mt-2 uppercase font-extrabold text-black tracking-widest" :class="titleSize">
        {{ title }}
      </h2>
      <p v-if="subtitle" class="mt-3 max-w-2xl mx-auto text-gray-700 text-base lg:text-lg">
        {{ subtitle }}
      </p>
    </header>

    <!-- Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
      <!-- Vision -->
      <article
        ref="visionRef"
        class="reveal group relative overflow-hidden rounded bg-white/70 backdrop-blur-xl border border-black/5 shadow-lg"
      >
        <div class="flex flex-col lg:flex-row">
          <!-- Media -->
          <div class="w-full lg:w-5/12">
            <div class="relative h-48 lg:h-full">
              <div class="aspect-w-1 aspect-h-1 w-full max-w-md">
                <video autoplay muted loop playsinline class="w-full p-6 h-full object-cover bg-white rounded-xl">
                    <source src="/public/assets/img/Idea_Bulb.webm" type="video/webm">
                    Your browser does not support the video tag.
                </video>
              </div>
            </div>
          </div>

          <!-- Copy -->
          <div class="w-full lg:w-7/12 p-6">
            <h3 class="uppercase text-3xl lg:text-4xl font-extrabold tracking-widest text-black flex items-center gap-3">
              <span class="inline-block">Vision</span>
            </h3>

            <p class="mt-4 text-gray-700 leading-relaxed">
              {{ visionText }}
            </p>
          </div>
        </div>
      </article>

      <article
        ref="missionRef"
        class="reveal group relative overflow-hidden rounded bg-white/70 backdrop-blur-xl border border-black/5 shadow-lg"
      >
        <div class="flex flex-col lg:flex-row">
          <!-- Media -->
          <div class="w-full lg:w-5/12">
            <div class="relative h-24 lg:h-full">
              <div class="aspect-w-1 aspect-h-1 w-full max-w-md">
                <video autoplay muted loop playsinline class="w-full h-full object-cover bg-white rounded-xl">
                    <source src="/public/assets/img/target-new.webm" type="video/webm">
                    Your browser does not support the video tag.
                </video>
              </div>
            </div>
          </div>

          <!-- Copy -->
          <div class="w-full lg:w-7/12 p-6 lg:p-8">
            <h3 class="uppercase text-3xl lg:text-4xl font-extrabold tracking-widest text-black flex items-center gap-3">
              <span class="inline-block">Vision</span>
              <span class="h-[10px] w-[10px] rounded-full" :class="accentDotClass"></span>
            </h3>

            <p class="mt-4 text-gray-700 leading-relaxed">
              {{ visionText }}
            </p>
          </div>
        </div>
      </article>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, computed } from 'vue'

const props = defineProps({
  eyebrow: { type: String, default: 'About' },
  title: { type: String, default: 'Our Vision & Mission' },
  subtitle: { type: String, default: '' },

  visionTitle: { type: String, default: 'Vision' },
  missionTitle: { type: String, default: 'Mission' },

  visionText: {
    type: String,
    default:
      'To elevate literature into a public right—bridging cultures, languages, and generations through stories that move, heal, and transform.'
  },
  missionText: {
    type: String,
    default:
      'To gather writers, thinkers, artists, and readers in an inclusive, free festival that nurtures creativity, celebrates diversity, and empowers communities.'
  },

  visionPoints: { type: Array, default: () => ['Celebrate free access to literature', 'Amplify local & global voices', 'Foster empathy across divides'] },
  missionPoints: { type: Array, default: () => ['Host inclusive programs & workshops', 'Champion multilingual engagement', 'Build sustaining literary communities'] },

  visionImage: { type: String, default: '' },
  missionImage: { type: String, default: '' },

  /** Accent classes (Tailwind). Use your existing `active-purple` color utilities. */
  accentBgClass: { type: String, default: 'bg-active-purple/20' },
  accentBgAltClass: { type: String, default: 'bg-active-purple/10' },
  accentDotClass: { type: String, default: 'bg-active-purple' },

  cta: { type: Object, default: null },
})

const titleSize = 'text-3xl sm:text-4xl lg:text-6xl'

/** Scroll-reveal (IntersectionObserver) */
const visionRef = ref(null)
const missionRef = ref(null)
let observer

onMounted(() => {
  if (typeof window === 'undefined') return
  observer = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('reveal-in')
        observer.unobserve(e.target)
      }
    })
  }, { threshold: 0.2 })

  ;[visionRef.value, missionRef.value].forEach(el => el && observer.observe(el))
})

onBeforeUnmount(() => { if (observer) observer.disconnect() })
</script>

<style scoped>
/* Reveal animation */
.reveal {
  opacity: 0;
  transform: translateY(16px) scale(0.98);
  transition: opacity .6s ease, transform .6s cubic-bezier(.22,.61,.36,1);
}
.reveal.reveal-in {
  opacity: 1;
  transform: translateY(0) scale(1);
}
</style>
