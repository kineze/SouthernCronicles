<template>
    <div class="py-8" >
        <div class="px-4 py-3 bg-black">
            <h1 class="lg:text-4xl text-3xl mt-12 lg:mt-4 text-white font-extrabold tracking-widest uppercase text-center">Stage, Page, Revolution: The Future of Storytelling Starts Here</h1>
        </div>
    
        <div class="flex w-full justify-center flex-wrap py-12">
            <!-- <div class="aspect-w-1 aspect-h-1 w-full max-w-md lg:p-2">

                <video autoplay muted loop playsinline class="w-full h-full object-cover rounded-xl">
                    <source src="/public/assets/img/video.webm" type="video/webm">
                    Your browser does not support the video tag.
                </video>

            </div> -->


            <div class="lg:max-w-screen-2xl flex flex-col items-center md:items-start justify-center w-full lg:p-2">
                <img src="/public/assets/img/kipenzi-main-logo.webp" class="w-80 mx-auto" alt="">
                <!-- <p class="text-gray-700 text-justify py-3">Kipenzi reimagines storytelling from the ground up—breaking rules, shattering norms, and daring to explore what lies beyond the expected. Kipenzi’s work defies convention, stretching the very limits of narrative and reshaping how stories can be told. Kipenzi doesn’t just challenge the norms—it reinvents them, opening bold, uncharted paths in literature. This isn’t just innovation—it’s a literary revolution.</p> -->
                <!--  -->
                <div class="grid grid-cols-1 py-16 md:grid-cols-2 lg:grid-cols-3 md:gap-3">
  <div
    v-for="(item, index) in contentBlocks"
    :key="index"
    class="w-full items-center flex flex-col text-black dark:text-white px-4"
  >
    <!-- Image or Video -->
    <template v-if="isVideo(item.src)">
      <video
        :src="item.src"
        autoplay
        muted
        loop
        playsinline
        class="w-64 h-64 object-contain rounded"
      ></video>
    </template>
    <template v-else>
      <img
        :src="item.src"
        class="w-64 h-64 object-contain rounded"
        :alt="'Media ' + (index + 1)"
      />
    </template>

    <h1 class="text-center font-bold text-lg mt-3">{{ item.title }}</h1>

    <p class="text-justify mt-4">
      {{ isExpanded[index] ? item.text : item.text.slice(0, item.limit) + '...' }}
      <span
        v-if="item.text.length > item.limit"
        class="text-blue-600 cursor-pointer ml-1"
        @click="toggleText(index)"
      >
        {{ isExpanded[index] ? 'Read less' : 'Read more' }}
      </span>
    </p>
  </div>
</div>



<p class="text-gray-700 text-justify py-3">
                  Kipenzi reimagines storytelling from the ground up—breaking rules, shattering norms, and daring to explore what lies beyond the expected. Kipenzi’s work defies convention, stretching the very limits of narrative and reshaping how stories can be told. Kipenzi doesn’t just challenge the norms—it reinvents them, opening bold, uncharted paths in literature. This isn’t just innovation—it’s a literary revolution. 
                  With every project, Kipenzi invites readers to experience stories in new dimensions, blending art, technology, and imagination. From immersive digital tales to interactive books and animated adventures, Kipenzi’s creations spark curiosity and inspire wonder. Join us as we transform the way stories are shared, making every moment a journey into the extraordinary.
                </p>
                <a href="https://kipenzi.me/all-ebooks" class="flex items-center mx-auto gap-3 py-3 px-5 mt-10 border w-fit border-main-blue/80 text-white  bg-black hover:text-white hover:shadow-lg">Kipenzi Connect</a>
            
              </div>
        </div>
    
    </div>



</template>

<script setup>
import { reactive } from 'vue'

// Helper: detect video
const isVideo = (src) => /\.webm($|\?)/i.test(src) || /\.mp4($|\?)/i.test(src)

// If files are in /public/assets/img, use root-absolute paths:
const contentBlocks = [
  {
    src: '/assets/img/story.webp',
    title: 'Stories',
    limit: 500,
    text: `Step into a world where tails wag with mystery, whiskers hold secrets, and tiny pawprints leave big marks on our hearts. At Kipenzi, we celebrate pets’ quirks, antics, and magical moments. Find heartwarming stories, fun pet care tips, and real-life adventures that remind you why animals are family. Kids and adults connect here through playful tales and expert advice.`
  },
  {
    // This is a video
    src: '/assets/img/animatedbook.webm',
    title: 'Animated Books',
    limit: 500,
    text: `Kipenzi’s animated books bring beloved tales to life with charming animations, gentle narration, and playful sound effects that captivate young minds. Perfect for bedtime, learning time, or cozy afternoons, these interactive stories spark imagination and nurture a love for reading. From brave little kittens to wise forest animals, each book is crafted to entertain, educate, and inspire kindness.`
  },
  {
    // This is a video
    src: '/assets/img/video.webm',
    title: 'E Books',
    limit: 500,
    text: `Ever wondered what your pet would say if they could talk? At Kipenzi, we believe their stories are already written — in every wag, purr, and playful leap. Welcome to a place where animals aren’t just pets; they’re heroes, comedians, teachers, and magicians all rolled into one adorable package.`
  }
]

const isExpanded = reactive(contentBlocks.map(() => false))
const toggleText = (i) => (isExpanded[i] = !isExpanded[i])
</script>
