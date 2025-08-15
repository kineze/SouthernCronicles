<!-- resources/js/components/web/VisionMission.vue -->
<template>
  <section
    class="relative w-full max-w-screen-2xl mx-auto px-4 -mt-5 sm:px-6 py-10 lg:py-20"
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
        class="reveal group relative overflow-hidden rounded-2xl bg-white/70 backdrop-blur-xl border border-black/5 shadow-lg"
      >
        <div class="flex flex-col lg:flex-row">
          <!-- Media -->
          <div class="w-full lg:w-5/12">
            <div class="relative h-48 lg:h-full">
              <img
                v-if="visionImage"
                :src="visionImage"
                alt="Vision illustration"
                class="absolute inset-0 h-full w-full object-cover"
              />
              <div v-else class="absolute inset-0 grid place-items-center">
                <!-- inline SVG (no JSX) -->
                <svg class="w-20 h-20 text-black/30" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z" />
                  <circle cx="12" cy="12" r="3.5" stroke-width="1.5"/>
                </svg>
              </div>
              <!-- subtle overlay -->
              <div class="absolute inset-0 bg-gradient-to-tr from-white/30 to-transparent"></div>
            </div>
          </div>

          <!-- Copy -->
          <div class="w-full lg:w-7/12 p-6 lg:p-8">
            <h3 class="uppercase text-3xl lg:text-4xl font-extrabold tracking-widest text-black flex items-center gap-3">
              <span class="inline-block">{{ visionTitle }}</span>
              <span class="h-[10px] w-[10px] rounded-full" :class="accentDotClass"></span>
            </h3>

            <p class="mt-4 text-gray-700 leading-relaxed">
              {{ visionText }}
            </p>

            <ul v-if="visionPoints && visionPoints.length" class="mt-5 space-y-2">
              <li v-for="(pt, idx) in visionPoints" :key="'v-'+idx" class="flex items-start gap-3">
                <span class="mt-1 h-2 w-2 rounded-full" :class="accentDotClass"></span>
                <span class="text-gray-800">{{ pt }}</span>
              </li>
            </ul>
          </div>
        </div>
      </article>

      <!-- Mission -->
      <article
        ref="missionRef"
        class="reveal group relative overflow-hidden rounded-2xl bg-white/70 backdrop-blur-xl border border-black/5 shadow-lg"
      >
        <div class="flex flex-col lg:flex-row-reverse">
          <!-- Media -->
          <div class="w-full lg:w-5/12">
            <div class="relative h-48 lg:h-full">
              <img
                v-if="missionImage"
                :src="missionImage"
                alt="Mission illustration"
                class="absolute inset-0 h-full w-full object-cover"
              />
              <div v-else class="absolute inset-0 grid place-items-center">
                <!-- inline SVG (no JSX) -->
                <svg class="w-20 h-20 text-black/30" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 21V5m0 0c2-1 4-1 6 0s4 1 6 0 4-1 4-1v9s-2 1-4 1-4-1-6 0-4 1-6 0" />
                </svg>
              </div>
              <div class="absolute inset-0 bg-gradient-to-tl from-white/30 to-transparent"></div>
            </div>
          </div>

          <!-- Copy -->
          <div class="w-full lg:w-7/12 p-6 lg:p-8">
            <h3 class="uppercase text-3xl lg:text-4xl font-extrabold tracking-widest text-black flex items-center gap-3">
              <span class="inline-block">{{ missionTitle }}</span>
              <span class="h-[10px] w-[10px] rounded-full" :class="accentDotClass"></span>
            </h3>

            <p class="mt-4 text-gray-700 leading-relaxed">
              {{ missionText }}
            </p>

            <ul v-if="missionPoints && missionPoints.length" class="mt-5 space-y-2">
              <li v-for="(pt, idx) in missionPoints" :key="'m-'+idx" class="flex items-start gap-3">
                <span class="mt-1 h-2 w-2 rounded-full" :class="accentDotClass"></span>
                <span class="text-gray-800">{{ pt }}</span>
              </li>
            </ul>

            <div v-if="cta && cta.label" class="mt-6">
              <a :href="cta.href || '#'"
                 class="inline-flex items-center gap-2 px-5 py-3 rounded-xl font-bold uppercase tracking-widest text-white bg-black hover:bg-black/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                {{ cta.label }}
              </a>
            </div>
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
