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
      <p class="text-sm tracking-[8px] uppercase font-semibold text-gray-900">
        {{ eyebrow }}
      </p>
      <h2 id="vm-title" class="mt-2 uppercase font-extrabold text-primary-blue tracking-widest" :class="titleSize">
        {{ title }}
      </h2>
      <p v-if="subtitle" class="mt-3 max-w-2xl mx-auto text-gray-900 text-base lg:text-lg">
        {{ subtitle }}
      </p>
    </header>

    <!-- Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">

      <article
        ref="visionRef"
        class=" group relative overflow-hidden flex items-center rounded bg-white/70 backdrop-blur-xl border border-black/5 shadow-lg"
      >
        <div class="flex flex-col lg:flex-row">
          <!-- Media -->
          <!-- <div class="w-full flex items-center lg:w-3/12">
            <div class="relative flex items-center">
              <div class="aspect-w-1 pl-6 flex justify-center items-center w-full max-w-md">
               <svg class="w-full h-full" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#EEA0B6;" d="M256,377.89l-148.91,27.02C127.952,467.151,186.736,512,256,512s128.048-44.849,148.91-107.09 L256,377.89z"></path> <path style="fill:#71CCCE;" d="M107.09,107.09C44.849,127.952,0,186.736,0,256s44.849,128.048,107.09,148.91L134.11,256 L107.09,107.09z"></path> <path style="fill:#EA4820;" d="M404.91,107.09L377.89,256l27.02,148.91C467.151,384.048,512,325.264,512,256 S467.151,127.952,404.91,107.09z"></path> <path style="fill:#F7AD3F;" d="M256,0c-69.264,0-128.048,44.849-148.91,107.09L256,134.11l148.91-27.021 C384.048,44.849,325.264,0,256,0z"></path> <path style="fill:#20AAB0;" d="M157.021,98.979c-17.456,0-34.244,2.853-49.931,8.11c-5.257,15.686-8.11,32.474-8.11,49.931 c0,37.525,13.17,71.969,35.131,98.979l121.89-49.931V134.11C228.99,112.151,194.545,98.979,157.021,98.979z"></path> <path style="fill:#F76720;" d="M404.91,107.09c-15.685-5.257-32.474-8.11-49.931-8.11c-37.525,0-71.969,13.17-98.979,35.131v71.959 L377.89,256c21.961-27.01,35.131-61.455,35.131-98.979C413.021,139.564,410.167,122.775,404.91,107.09z"></path> <path style="fill:#EA4820;" d="M256,134.11c-22.846,18.575-40.371,43.438-49.931,71.959h99.861 C296.372,177.549,278.846,152.685,256,134.11z"></path> <path style="fill:#DA5B82;" d="M256,305.931L134.11,256c-21.961,27.01-35.131,61.455-35.131,98.979 c0,17.456,2.853,34.244,8.11,49.931c15.686,5.257,32.474,8.11,49.931,8.11c37.525,0,71.969-13.17,98.979-35.131v-71.958H256z"></path> <path style="fill:#D92622;" d="M377.89,256L256,305.931v71.959c27.01,21.961,61.455,35.131,98.979,35.131 c17.456,0,34.244-2.853,49.931-8.11c5.257-15.686,8.111-32.474,8.111-49.931C413.021,317.455,399.85,283.01,377.89,256z"></path> <path style="fill:#BD0A3A;" d="M206.069,305.931c9.559,28.521,27.084,53.384,49.931,71.959 c22.846-18.575,40.372-43.438,49.931-71.959H206.069z"></path> <path style="fill:#FFFFFF;" d="M256,197.959c-49.195,0-93.098,22.63-121.89,58.041c28.79,35.411,72.694,58.041,121.89,58.041 c49.195,0,93.099-22.63,121.89-58.041C349.099,220.589,305.195,197.959,256,197.959z"></path> <circle style="fill:#41BBBE;" cx="256" cy="256" r="58.041"></circle> <path style="fill:#06484A;" d="M256,272.879c-9.307,0-16.879-7.572-16.879-16.879c0-9.307,7.572-16.879,16.879-16.879 c9.307,0,16.879,7.572,16.879,16.879C272.879,265.307,265.307,272.879,256,272.879z"></path> </g></svg>
              </div>
            </div>
          </div> -->

          <!-- Copy -->
          <div class="w-full flex  flex-col justify-start items-start p-6 lg:p-8 lg:mt-0 mt-6">
            <h3 class="uppercase text-3xl lg:text-4xl font-extrabold tracking-widest text-primary-blue gap-3">
              <span class="inline-block  lg:mx-0">Vision</span>
              <span class="h-[10px] w-[10px] rounded-full" :class="accentDotClass"></span>
            </h3>

            <p class="mt-4 text-black text-justify leading-relaxed">
              {{ visionText }}
            </p>
          </div>
        </div>
      </article>

      <article
        ref="missionRef"
        class=" group relative overflow-hidden rounded bg-white/70 backdrop-blur-xl border border-black/5 shadow-lg"
      >
        <div class="flex flex-col lg:flex-row">
          <!-- Media -->
          <!-- <div class="w-full flex items-center lg:w-3/12">
            <div class="relative flex items-center">
              <div class="aspect-w-1 pl-6 flex justify-center items-center w-full max-w-md">
               <svg class="w-full h-full" viewBox="0 -0.5 1025 1025" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M447.427363 576.572637m-431.447814 0a431.447814 431.447814 0 1 0 862.895628 0 431.447814 431.447814 0 1 0-862.895628 0Z" fill="#FFFFFF"></path><path d="M447.427363 1024c-246.884027 0-447.427363-200.543336-447.427363-447.427363s200.543336-447.427363 447.427363-447.427363 447.427363 200.543336 447.427363 447.427363-200.543336 447.427363-447.427363 447.427363z m0-862.895628c-229.306523 0-415.468266 186.161742-415.468266 415.468265s186.161742 415.468266 415.468266 415.468266 415.468266-186.161742 415.468265-415.468266-186.161742-415.468266-415.468265-415.468265z" fill="#191919"></path><path d="M447.427363 576.572637m-324.384838 0a324.384838 324.384838 0 1 0 648.769676 0 324.384838 324.384838 0 1 0-648.769676 0Z" fill="#F86C6C"></path><path d="M447.427363 917.736001c-187.759697 0-340.364387-152.60469-340.364387-340.364386S259.667666 237.007228 447.427363 237.007228s340.364387 152.60469 340.364387 340.364387-152.60469 340.364387-340.364387 340.364386z m0-649.568653c-170.182193 0-308.405289 138.223096-308.40529 308.405289s138.223096 308.405289 308.40529 308.40529 308.405289-138.223096 308.405289-308.40529S617.609556 268.167348 447.427363 268.167348z" fill="#191919"></path><path d="M447.427363 576.572637m-208.53311 0a208.53311 208.53311 0 1 0 417.06622 0 208.53311 208.53311 0 1 0-417.06622 0Z" fill="#FFFFFF"></path><path d="M447.427363 801.884273c-123.841502 0-224.512659-100.671157-224.512659-224.512658S323.585861 352.059978 447.427363 352.059978s224.512659 100.671157 224.512659 224.512659-100.671157 225.311636-224.512659 225.311636zM447.427363 384.019076c-106.263999 0-192.553562 86.289563-192.553562 192.553561S341.163364 769.126199 447.427363 769.126199s192.553562-86.289563 192.553561-192.553562S553.691362 384.019076 447.427363 384.019076z" fill="#191919"></path><path d="M447.427363 576.572637m-101.470134 0a101.470134 101.470134 0 1 0 202.940268 0 101.470134 101.470134 0 1 0-202.940268 0Z" fill="#F86C6C"></path><path d="M447.427363 694.02232c-64.717172 0-117.449683-52.732511-117.449683-117.449683S382.710191 459.122954 447.427363 459.122954 564.877046 511.855465 564.877046 576.572637c0 65.51615-52.732511 117.449683-117.449683 117.449683z m0-202.141291c-47.139669 0-85.490585 38.350917-85.490586 85.490586S400.287694 662.063223 447.427363 662.063223 532.917948 623.712306 532.917948 576.572637 494.567031 491.881029 447.427363 491.881029z" fill="#191919"></path><path d="M1008.309521 114.76368L878.875177 243.399047l-100.671157 2.396933 2.396933-100.671157L910.035297 16.489456l-3.994887 102.269112z" fill="#C2CDDC"></path><path d="M779.002998 261.775528c-3.994887 0-7.989774-1.597955-11.185684-4.793864-3.19591-3.19591-4.793865-7.190797-4.793865-11.984662l2.396933-100.671157c0-3.994887 1.597955-7.989774 4.793864-11.185684L899.64859 4.504795c4.793865-4.793865 11.984662-5.592842 17.577504-3.19591 6.391819 2.396932 9.587729 8.788752 9.587729 15.180571l-3.19591 84.691608 84.691608-3.19591c6.391819 0 12.783639 3.19591 15.180572 9.58773s1.597955 12.783639-3.19591 17.577503l-129.434344 128.635367c-3.19591 3.19591-7.190797 4.793865-11.185684 4.793864l-100.671157 3.19591zM796.580501 152.31562l-1.597954 77.500811 77.500811-1.597955 95.877292-95.877292-61.521263 2.396932c-4.793865 0-8.788752-1.597955-11.984661-4.793864s-4.793865-7.190797-4.793865-11.984662l2.396932-61.521262-95.877292 95.877292z" fill="#191919"></path><path d="M455.417137 580.567524c-3.994887 0-7.989774-1.597955-11.185684-4.793864-6.391819-6.391819-6.391819-15.979549 0-22.371368l525.727152-525.727152c6.391819-6.391819 15.979549-6.391819 22.371368 0s6.391819 15.979549 0 22.371368L466.602821 575.77366c-3.19591 3.19591-7.190797 4.793865-11.185684 4.793864z" fill="#191919"></path><path d="M942.793372 188.269604h-95.078315c-8.788752 0-15.979549-7.190797-15.979548-15.979548V78.809696c0-8.788752 7.190797-15.979549 15.979548-15.979549s15.979549 7.190797 15.979549 15.979549v77.500811h79.098766c8.788752 0 15.979549 7.190797 15.979548 15.979549s-7.190797 15.979549-15.979548 15.979548z" fill="#191919"></path></g></svg>
              </div>
            </div>
          </div> -->

          <!-- Copy -->
          <div class="w-full  flex  flex-col justify-start items-start p-6 lg:p-8 lg:mt-0 mt-6">
            <h3 class="uppercase text-3xl lg:text-4xl font-extrabold tracking-widest text-primary-blue gap-3">
              <span class="inline-block  lg:mx-0">Mission</span>
              <span class="h-[10px] w-[10px] rounded-full" :class="accentDotClass"></span>
            </h3>

            <p class="mt-4 text-black text-justify leading-relaxed">
              {{ missionText }}
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
      'To create a global network that ensures equitable access to creative expression worldwide, amplifying diverse voices from all communities and celebrating literary and artistic excellence across continents.'
  },
  missionText: {
    type: String,
    default:
      'Through our global roadmap of festivals, we connect cities, people, and cultures into one unified platform, bringing together writers, thinkers, artists, and creative entrepreneurs worldwide, culminating in The Global Summit in Abu Dhabi where we celebrate excellence through The Asian Prizes and foster transformative cross-cultural dialogue.'
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
