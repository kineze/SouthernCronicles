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
          <h1 class="tracking-[10px] lg:-mt-2 mt-6 lg:text-4xl text-2xl uppercase font-bold text-black leading-tight">
            Get Kipenzied @ ALF Kids
          </h1>

          <p class="text-gray-700 text-justify py-3">
            Today, more than ever, children are drifting away from books and towards screens, captivated by the endless distractions of devices. But instead of fighting technology, platforms like <span class="font-semibold">Kipenzi</span> are using it to reignite a love for literature.
          </p>

          <p class="text-gray-700 text-justify py-3">
            Through enchanting audiobooks, vibrant illustrations, and imaginative storytelling, <span class="font-semibold">Kipenzi</span> brings stories to life in a way that speaks directly to digital-native minds. By blending the magic of narrative with the appeal of technology, Kipenzi is not just keeping kids engaged—it’s bringing them back to the timeless joy of reading, one click, one listen, and one story at a time.
          </p>

          <p class="text-gray-700 text-justify py-3">
            This is the spirit that drives Kipenzi, our <span class="font-semibold">ALF-Kids</span> festival: embracing innovation whilst celebrating the enduring power of storytelling. We are reimagining a world where paper marries technology—where the crisp feel of turning pages remains part of our daily lives, enhanced rather than replaced by digital magic. Here, we explore how literature can flourish in the digital age, creating new pathways for young minds to discover wonder.
          </p>

          <p class="text-gray-700 text-justify py-3">
            We envision children growing into a world of enhanced creativity, where they are empowered to dream bigger and reach further than ever before. In this harmonious blend of tactile and digital experiences, every story becomes a doorway to imagination, every page a stepping stone to greater possibilities.
          </p>

          <p class="text-gray-700 text-justify py-3">
            Welcome to a celebration where tradition meets innovation, where the rustle of paper harmonises with the glow of screens, and where every child can find their gateway to the extraordinary world of books whilst never losing touch with the timeless magic of holding a story in their hands.
          </p>
        </div>

      </div>
    </div>



    <!-- <div class="lg:py-8 -mt-16 lg:mt-0" >
        <div class="px-4 py-3 bg-white">
            <h1 class="lg:text-4xl text-3xl mt-12 lg:mt-4 text-black font-extrabold tracking-widest uppercase text-center">Stage, Page, Revolution: The Future of Storytelling Starts Here</h1>
        </div>


    
        <div class="flex w-full justify-center flex-wrap py-12">

            <div class="lg:max-w-screen-2xl flex flex-col items-center md:items-start justify-center w-full lg:p-2">
                <img src="/public/assets/img/kipenzi-main-logo.webp" class="w-80 mx-auto" alt="">
                
                <div class="grid grid-cols-1 py-16 md:grid-cols-2 lg:grid-cols-3 md:gap-3">
            <div
              v-for="(item, index) in contentBlocks"
              :key="index"
              class="w-full items-center justify-between flex flex-col text-black dark:text-white px-4"
            >

            <div class=" flex flex-col items-center">
                
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
              <a
                :href="item.url || 'https://kipenzi.me/all-ebooks'"
                class="flex items-center mx-auto gap-3 py-3 px-5 mt-10 border w-fit border-main-blue/80 text-white bg-black hover:text-white hover:shadow-lg"
              >
                Connect
              </a>
            </div>
          </div>
                
            
              </div>
        </div>
    
    </div> -->

<!-- <div class="">
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
</div> -->



</template>

<script setup>
import { reactive } from 'vue'

// Helper: detect video
const isVideo = (src) => /\.webm($|\?)/i.test(src) || /\.mp4($|\?)/i.test(src)

// If files are in /public/assets/img, use root-absolute paths:
// const contentBlocks = [
//   {
//     src: '/assets/img/story.webp',
//     title: 'Stories',
//     limit: 500,
//      url: 'https://kipenzi.me/all-stories',
//     text: `Step into a world where tails wag with mystery, whiskers hold secrets, and tiny pawprints leave big marks on our hearts. At Kipenzi, we celebrate pets’ quirks, antics, and magical moments. Find heartwarming stories, fun pet care tips, and real-life adventures that remind you why animals are family. Kids and adults connect here through playful tales and expert advice.`
//   },
//   {
//     // This is a video
//     src: '/assets/img/animatedbook.webm',
//     title: 'Animated Books',
//     limit: 500,
//     url: 'https://kipenzi.me',
//     text: `Kipenzi’s animated books bring beloved tales to life with charming animations, gentle narration, and playful sound effects that captivate young minds. Perfect for bedtime, learning time, or cozy afternoons, these interactive stories spark imagination and nurture a love for reading. From brave little kittens to wise forest animals, each book is crafted to entertain, educate, and inspire kindness.`
//   },
//   {
//     // This is a video
//     src: '/assets/img/video.webm',
//     title: 'E Books',
//     limit: 500,
//     url: 'https://kipenzi.me/all-ebooks',
//     text: `Ever wondered what your pet would say if they could talk? At Kipenzi, we believe their stories are already written — in every wag, purr, and playful leap. Welcome to a place where animals aren’t just pets; they’re heroes, comedians, teachers, and magicians all rolled into one adorable package.`
//   }
// ]

const isExpanded = reactive(contentBlocks.map(() => false))
const toggleText = (i) => (isExpanded[i] = !isExpanded[i])
</script>
