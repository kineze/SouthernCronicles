<template>
  <div class="max-w-screen-2xl mx-auto px-6 py-6 bg-black text-white text-center">
    <h1 class="text-3xl lg:text-6xl font-bold tracking-wide uppercase mt-6 mb-3">Coming Soon</h1>
    <h3 class="text-xl lg:text-3xl font-bold tracking-widest uppercase mb-3">Next Festival</h3>
    <h5 class="text-sm lg:text-lg font-bold tracking-wide">Gampaha - Sri Lanka</h5>

    <div class="lg:mt-10 mt-5">
      <p class="text-sm font-semibold uppercase">23rd DEC 2025</p>

      <div class="mt-6 mb-10 flex justify-center gap-4 flex-wrap">
        <div class="bg-white/20 text-white rounded-md w-20 h-20 flex flex-col justify-center items-center">
          <span class="text-xl font-bold">{{ countdown.days }}</span>
          <span class="text-xs font-semibold uppercase">Days</span>
        </div>
        <div class="bg-white/20 text-white rounded-md w-20 h-20 flex flex-col justify-center items-center">
          <span class="text-xl font-bold">{{ countdown.hours }}</span>
          <span class="text-xs font-semibold uppercase">Hours</span>
        </div>
        <div class="bg-white/20 text-white rounded-md w-20 h-20 flex flex-col justify-center items-center">
          <span class="text-xl font-bold">{{ countdown.minutes }}</span>
          <span class="text-xs font-semibold uppercase">Minutes</span>
        </div>
        <div class="bg-white/20 text-white rounded-md w-20 h-20 flex flex-col justify-center items-center">
          <span class="text-xl font-bold">{{ countdown.seconds }}</span>
          <span class="text-xs font-semibold uppercase">Seconds</span>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'

const countdown = ref({
  days: '00',
  hours: '00',
  minutes: '00',
  seconds: '00'
})

const targetDate = new Date('2025-12-23T00:00:00')

let interval = null

const updateCountdown = () => {
  const now = new Date()
  const distance = targetDate - now

  if (distance < 0) {
    clearInterval(interval)
    countdown.value = { days: '00', hours: '00', minutes: '00', seconds: '00' }
    return
  }

  const days = Math.floor(distance / (1000 * 60 * 60 * 24))
  const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
  const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))
  const seconds = Math.floor((distance % (1000 * 60)) / 1000)

  countdown.value = {
    days: String(days).padStart(2, '0'),
    hours: String(hours).padStart(2, '0'),
    minutes: String(minutes).padStart(2, '0'),
    seconds: String(seconds).padStart(2, '0')
  }
}

onMounted(() => {
  updateCountdown()
  interval = setInterval(updateCountdown, 1000)
})

onBeforeUnmount(() => {
  clearInterval(interval)
})
</script>
