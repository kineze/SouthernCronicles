<template>


    <div class="">
      <div class="relative flex mb-10 flex-wrap items-start z-[1000] bg-opacity-30 backdrop-blur-xl rounded-3xl bg-transparent justify-end pt-12">

      <div class="w-full md:sticky top-5 lg:w-5/12">

        
        <div class="relative lg:h-[850px] h-[400px] w-full overflow-hidden rounded-3xl ring-1 ring-black/10">
          <video
            src="/public/assets/img/alfkids.webm"
            autoplay
            muted
            loop
            playsinline
            class="absolute inset-0 w-full h-full object-cover aspect-auto bg-black"
          ></video>

         

          <!-- Optional overlay + caption (remove if you want only the video) -->

        </div>

          <div class=" bg-white text-end p-2 z-50 text-white font-bold w-full absolute bottom-0 bg-opacity-20 backdrop-blur-2xl -mt-12">KIPENZI™</div>
        


      </div>

            <!-- Right (content) -->
        <div class="w-full px-6 lg:w-7/12 sticky top-5">
          <h1 class="tracking-[10px] lg:-mt-2 mt-6 lg:text-4xl text-2xl uppercase font-bold text-primary-blue leading-tight">
            Get Kipenzied @ ALF Kids
          </h1>

          <p class="text-black text-justify py-3">
            Today, more than ever, children are drifting away from books and towards screens, captivated by the endless distractions of devices. But instead of fighting technology, platforms like <span class="font-semibold">Kipenzi</span> are using it to reignite a love for literature.
          </p>

          <p class="text-black text-justify py-3">
            Through enchanting audiobooks, vibrant illustrations, and imaginative storytelling, <span class="font-semibold">Kipenzi</span> brings stories to life in a way that speaks directly to digital-native minds. By blending the magic of narrative with the appeal of technology, Kipenzi is not just keeping kids engaged—it’s bringing them back to the timeless joy of reading, one click, one listen, and one story at a time.
          </p>

          <p class="text-black text-justify py-3">
            This is the spirit that drives Kipenzi, our <span class="font-semibold">ALF-Kids</span> festival: embracing innovation whilst celebrating the enduring power of storytelling. We are reimagining a world where paper marries technology—where the crisp feel of turning pages remains part of our daily lives, enhanced rather than replaced by digital magic. Here, we explore how literature can flourish in the digital age, creating new pathways for young minds to discover wonder.
          </p>

          <p class="text-black text-justify py-3">
            We envision children growing into a world of enhanced creativity, where they are empowered to dream bigger and reach further than ever before. In this harmonious blend of tactile and digital experiences, every story becomes a doorway to imagination, every page a stepping stone to greater possibilities.
          </p>

          <p class="text-black text-justify py-3">
            Welcome to a celebration where tradition meets innovation, where the rustle of paper harmonises with the glow of screens, and where every child can find their gateway to the extraordinary world of books whilst never losing touch with the timeless magic of holding a story in their hands.
          </p>
        </div>

      </div>
    </div>


</template>

<script setup>
import { reactive } from 'vue'

const toggleText = (i) => (isExpanded[i] = !isExpanded[i])
</script>
