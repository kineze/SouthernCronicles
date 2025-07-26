<template>
    <div class="relative bg-white bg-transparent bg-opacity-30 md:pt-6 backdrop-blur-xl">
    <div>
        <h1 class="lg:text-6xl text-3xl text-black font-extrabold tracking-widest uppercase text-center">Speakers</h1>
    </div>
    <div class="py-8 w-full max-w-screen-2xl flex flex-col">
        <Carousel 
            :itemsToShow="4"
            :wrapAround="true"
            :itemsToScroll="1"
            :autoplay="2000"
            :pauseAutoplayOnHover="false"
            :mouseDrag="true"
            snapAlign="start"
            :breakpoints="{
                0: { itemsToShow: 1 },
                768: { itemsToShow: 2 },
                1024: { itemsToShow: 4 }
            }"

            v-model="currentSlide"
        >
            <Slide v-for="speaker in homeSpeakers" :key="speaker.id">
                <div class="p-3">
                    <a href="/speakers-list">
                        <div class="overflow-hidden  dark:bg-gray-800">
                            <img :src="`/storage/${speaker.image}`" :alt="speaker.name" class="w-full h-80 object-cover aspect-square" />
                            <div class="p-4 text-center">
                            <h3 class="font-semibold text-gray-800 dark:text-white uppercase">{{ speaker.name }}</h3>
                            <!-- <div class="flex justify-center mt-2 gap-4 text-lg text-gray-500">
                                <a v-if="speaker.facebook" :href="speaker.facebook" target="_blank" class="hover:text-blue-500"><i class="fab fa-facebook"></i></a>
                                <a v-if="speaker.instagram" :href="speaker.instagram" target="_blank" class="hover:text-pink-500"><i class="fab fa-instagram"></i></a>
                                <a v-if="speaker.linkedin" :href="speaker.linkedin" target="_blank" class="hover:text-blue-400"><i class="fab fa-linkedin"></i></a>
                            </div> -->
                            </div>
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
  const res = await axios.get('/api/speakers')
  homeSpeakers.value = res.data.filter(speaker => speaker.show_on_home)
}

onMounted(fetchHomeSpeakers)
</script>


