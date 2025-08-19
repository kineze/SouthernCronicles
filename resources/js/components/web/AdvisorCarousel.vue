<template>
  <div class="relative bg-transparent bg-opacity-30 md:pt-6 backdrop-blur-xl">
    <div>
      <h1 class="lg:text-6xl text-3xl text-black font-extrabold tracking-widest uppercase text-center">
        Advisors
      </h1>
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
        <Slide v-for="adv in visibleAdvisors" :key="adv.id">
          <div class="p-3">
            <a href="/advisors-list" aria-label="View all advisors">
              <div class="overflow-hidden dark:bg-gray-800">
                <img
                  :src="imageSrc(adv.image)"
                  :alt="adv.name"
                  class="w-full h-80 object-cover aspect-square"
                  @error="onImgError"
                />
                <div class="p-4 text-center">
                  <h3 class="font-semibold text-gray-800 dark:text-white uppercase">
                    {{ adv.name }}
                  </h3>
                  <p v-if="adv.type?.name" class="mt-1 text-xs text-gray-500 uppercase tracking-wide">
                    {{ adv.type.name }}
                  </p>
                  <div class="flex justify-center mt-2 gap-4 text-lg text-gray-500">
                    <a v-if="adv.facebook" :href="adv.facebook" target="_blank" rel="noopener" class="hover:text-blue-500" aria-label="Facebook">
                      <i class="fab fa-facebook"></i>
                    </a>
                    <a v-if="adv.instagram" :href="adv.instagram" target="_blank" rel="noopener" class="hover:text-pink-500" aria-label="Instagram">
                      <i class="fab fa-instagram"></i>
                    </a>
                    <a v-if="adv.linkedin" :href="adv.linkedin" target="_blank" rel="noopener" class="hover:text-blue-400" aria-label="LinkedIn">
                      <i class="fab fa-linkedin"></i>
                    </a>
                  </div>
                </div>
              </div>
            </a>
          </div>
        </Slide>
      </Carousel>

      <div class="mx-auto mt-7">
        <a href="/advisors-list" class="px-6 py-3 bg-black text-white font-bold">VIEW MORE</a>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import { Carousel, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'

/**
 * Optional prop: show only a specific advisor type id
 * (e.g., <AdvisorsCarousel :type-id="3" /> )
 */
const props = defineProps({
  typeId: { type: [Number, String], default: null }
})

const advisors = ref([])
const currentSlide = ref(0)

// Stable image helper (fallback placeholder if missing/broken)
const placeholder = '/assets/img/placeholder-portrait.webp'
const imageSrc = (path) => (path ? `/storage/${path}` : placeholder)
const onImgError = (e) => { e.target.src = placeholder }

const visibleAdvisors = computed(() => {
  let list = advisors.value.filter(a => a.show_on_home)
  if (props.typeId) list = list.filter(a => String(a.advisor_type_id) === String(props.typeId))
  // position first (if provided), then id for stability
  return list.sort((a, b) => (a.position ?? 0) - (b.position ?? 0) || a.id - b.id)
})

const fetchAdvisors = async () => {
  // Prefer an ordered home endpoint if you add it (see backend notes below)
  // Fallback: query all ordered and filter on client.
  const res = await axios.get('/api/advisors', { params: { ordered: 1 } })
  advisors.value = res.data
}

onMounted(fetchAdvisors)
</script>
