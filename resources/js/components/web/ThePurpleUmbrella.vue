<template>

<div class="">
  <div class="relative flex mb-24 flex-wrap items-start z-[1000] bg-opacity-30 backdrop-blur-xl rounded-3xl bg-transparent justify-end pt-12">

<div class="w-full px-6 lg:w-6/12 sticky items-start top-5">
  <h1 class="tracking-[10px] lg:-mt-2 mt-6 lg:text-4xl text-2xl uppercase font-bold text-black leading-tight">
    The Purple Umbrella Festival
  </h1>

  <p class="text-gray-700 text-justify py-3">
    The Purple Umbrella Festival emerges as a beacon of hope and creativity, where children's voices take centre stage in addressing one of our most pressing global challenges. Founded on the unwavering belief that young minds possess extraordinary power to inspire change, <span class="font-semibold">PUTF</span> transforms theatre into a vehicle for environmental advocacy and social action.
  </p>

  <p class="text-gray-700 text-justify  py-3">
    Under the protective canopy of the purple umbrella—a symbol of nurturing creativity and bold expression—children from diverse backgrounds come together to tell stories that matter. Through compelling performances, they share their unique perspectives on climate change, weaving together comedy, drama, and music to create powerful calls to action that resonate far beyond the stage.
  </p>

  <p class="text-gray-700 text-justify  py-3">
    <span class="font-semibold">PUTF 2025</span> brings together an inspiring coalition of schools, environmental organisations, UN agencies, and artists, all united in supporting young storytellers. Each performance represents more than entertainment; it's a testament to the belief that creativity can drive meaningful change. These young advocates don't simply perform—they challenge audiences to see the world through fresh eyes and embrace their responsibility towards a sustainable future.
  </p>

  <p class="text-gray-700 mb-6 text-justify  py-3">
    At its heart, the Purple Umbrella Festival proves that when we listen to children's stories, we discover not just their fears and hopes, but also innovative solutions and the courage to act.
  </p>

   <a
      :href="'https://purplefest.in/'"
      class=" gap-3 py-3 px-5 mt-10 border  border-main-blue/80 text-white bg-black hover:text-white hover:shadow-lg"
    >
      Connect
    </a>
</div>


  <div class="w-full md:sticky top-5 lg:w-6/12">
    <div class="relative lg:h-[610px] h-[400px] w-full overflow-hidden rounded-3xl ring-1 ring-black/10">
      <video
        src="/public/assets/img/purpleumbrella.webm"
        autoplay
        muted
        loop
        playsinline
        class="absolute inset-0 w-full h-full object-cover bg-black"
      ></video>

          <div class=" bg-white text-end p-3 z-50 text-white font-bold w-full absolute bottom-0 bg-opacity-20 backdrop-blur-2xl -mt-12">PurpleUmbrella™</div>


    </div>
  </div>

  </div>
</div>



</template>

<script setup>
import { reactive } from 'vue'

// Helper: detect video
const isVideo = (src) => /\.webm($|\?)/i.test(src) || /\.mp4($|\?)/i.test(src)


const toggleText = (i) => (isExpanded[i] = !isExpanded[i])
</script>
