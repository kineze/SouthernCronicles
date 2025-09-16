<template>
    <div class="relative bg-white bg-transparent bg-opacity-30 md:pt-6 backdrop-blur-xl">
    <div>
        <h1 class="lg:text-6xl text-3xl text-black font-extrabold tracking-widest uppercase text-center">Speakers</h1>
    </div>
    <div class="py-8 w-full max-w-screen-2xl flex flex-col">
        <Carousel 
            :itemsToShow="5"
            :wrapAround="true"
            :itemsToScroll="1"
            :autoplay="2000"
            :pauseAutoplayOnHover="false"
            :mouseDrag="true"
            snapAlign="start"
            :breakpoints="{
                0: { itemsToShow: 1 },
                768: { itemsToShow: 2 },
                1024: { itemsToShow: 5 }
            }"

            v-model="currentSlide"
        >
          <Slide v-for="speaker in homeSpeakers" :key="speaker.id" class="!flex !items-start h-full">
            <div class="p-3">
              <a href="/speakers-list">
                <div
                  class="relative overflow-hidden bg-white shadow-md flex justify-center items-center"
                  style="border-radius: 200px 200px 200px 200px / 100px 100px 100px 100px;"
                >
                  <!-- Speaker Image -->
                  <img
                    :src="`/storage/${speaker.image}`"
                    :alt="speaker.name"
                    class="w-full h-[420px] object-cover"
                  />

                  <!-- Optional overlay name (if you want) -->
                  <!--
                  <div class="absolute bottom-4 left-0 right-0 text-center">
                    <h3 class="font-semibold text-black uppercase text-lg bg-white/70 px-2 py-1 inline-block rounded">
                      {{ speaker.name }}
                    </h3>
                  </div>
                  -->
                </div>
              </a>
            </div>
          </Slide>

        </Carousel>

        <div class="mx-auto mt-7">
            <a href="/speakers-list" class="px-6 py-3 bg-black text-white foont-bold"> VIEW MORE </a>
        </div>

    </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { Carousel, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'

const homeSpeakers = ref([])
// const carousel = ref(null)
const currentSlide = ref(0)

const fetchHomeSpeakers = async () => {
  const res = await axios.get('/api/speakers?ordered=true')
  homeSpeakers.value = res.data.filter(speaker => speaker.show_on_home)
}

onMounted(fetchHomeSpeakers)
</script>


