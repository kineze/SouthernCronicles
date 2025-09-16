<template>
  <section class="relative w-full max-w-screen-xl mx-auto font-poppins" ref="wrap">
    <!-- Language switcher -->

    <!-- <div class="flex justify-start gap-2 mb-4">
      <button
        v-for="(lang, i) in langs"
        :key="lang.key"
        @click="go(i)"
        :aria-pressed="active === i"
        class="inline-flex items-center gap-2 px-3 py-1.5 rounded text-sm border transition"
        :class="active === i
          ? 'bg-black text-white border-gray-900'
          : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600'"
        :title="lang.title"
      >

        <span>{{ lang.label }}</span>
      </button>
    </div> -->

    <!-- Slider -->
    <div class="overflow-hidden">
      <div
        class="flex transition-transform duration-700 ease-out will-change-transform"
        :style="{ transform: `translateX(-${active * 100}%)` }"
      >
        <article
          v-for="(lang, i) in langs"
          :key="`slide-${lang.key}-${i}`"
          class="min-w-full"
        >
          <p class="text-gray-700 dark:text-gray-200 text-justify leading-7">
            {{ lang.text }}
          </p>
        </article>
      </div>
    </div>

  </section>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  englishText: {
    type: String,
    default:
      "Literature is the lifeblood of human understanding, the bridge between hearts and minds across all divides. The Asian Literary Festival Gampaha, the island's first free literary celebration, serves as the epicentre where writers, thinkers, and artists from across the globe converge with Sri Lanka's local literary voices, fostering dynamic cross-fertilisation. Set in Gampaha—birthplace of numerous Sri Lankan creative luminaries—this festival transforms literary engagement from privilege to public right, celebrating the power of storytelling to unite, inspire, and transform communities across cultural and linguistic boundaries."
  },
  sinhalaText: {
    type: String,
    default:
      "සාහිත්‍යය වූකලී මිනිස් අවබෝධය ජීවමාන කරවන රුධිරයයි, සෑම වර්ගීකරණයකටම අයත් හදවත් අතර පාලමයි. සෑම සාහිත්‍ය රසිකයකුටම නිදහසේ සහභාගී විය හැකි දිවයිනේ පළමු සාහිත්‍ය උළෙල වන ආසියානු සාහිත්‍ය උළෙල, ලෝකයේ නන් දෙසින් පැමිණෙන ලේඛකයන්, චින්තකයන් සහ කලාකරුවන් ශ්‍රී ලාංකේය සාහිත්‍ය ක්ෂේත්‍රය අස්වැද්දූවන් සමග මුසුවන, එනයින් සාහිත්‍යමය අන්තර්පෝෂණයක් සිදුවන කේන්ද්‍රීය අවකාශයකි. ශ්‍රී ලංකාවේ දීප්තිමත් නිර්මාණශීලී මනස් ගණනාවක නිජභූමිය වූ ගම්පහදී පැවැත්වෙන මේ උළෙල විසින් මෙතෙක් වරප්‍රසාද ලත් පන්තියකට සීමාවූ සාහිත්යික මැදිහත්වීම පරිවර්තනයකට ලක් කරමින්, එය පොදු මහජනයා අතරට රැගෙන එනු ලබයි.‍ ආසියානු සාහිත්‍ය උළෙල, සංස්කෘතික සහ භාෂාමය සීමාවලින් වෙන්ව සිටින ජනයා එකට එක් කරමින්, ඔවුනට අනුප්‍රාණය දෙමින්, ඔවුන් අලුත් මිනිසුන් බවට පරිවර්තනය කිරීමේ බලවේගයේ උත්කර්ශවත් සැමරුමකි."
  },
  tamilText: {
    type: String,
    default:
      `இலக்கியம் என்பது மனித உணர்வுகளை உயிர்ப்பிக்கும் இரத்தமாகும். அது அனைத்து வகைப்பாட்டினரின் இதயங்களை இணைக்கும் பாலமாகும்.
      
      தீவின் முதல் இலக்கிய விழாவாக, அனைவரும் சுதந்திரமாக பங்கேற்கக்கூடிய  ஆசிய இலக்கிய விழா, உலகின் பல பக்கங்களில் இருந்து வருகை தரும் எழுத்தாளர்கள், சிந்தனையாளர்கள் மற்றும் கலைஞர்கள் இலங்கை இலக்கிய துறையில் ஈடுபட்டவர்களுடன் சந்தித்து கலந்துரையாடும் மைய மேடையாக அமைகிறது.

      இலங்கையின் பலத்த சிறப்பான படைப்பாற்றல் மனங்களைப் பெற்ற கம்பஹாவில் நடைபெறும் இவ்விழா, இதுவரை சிலருக்கே மட்டுப்படுத்தப்பட்டிருந்த இலக்கிய தொடர்புகளை மாற்றி, அதை பொதுமக்களிடமும் கொண்டுவருகிறது.

      ஆசிய இலக்கிய விழா என்பது கலாசார மற்றும் மொழி எல்லைகளால் பிரிந்திருக்கும் மக்களை ஒன்றிணைத்து, அவர்களைத் தூண்டி, புதிய மனிதர்களாக மாற்றும் சக்தியின் சிறப்பான கொண்டாட்டமாகும்.`
  }
})

const active = ref(0) // 0: Sinhala, 1: English, 2: Tamil

const langs = computed(() => ([
  { key: 'en', label: 'En', title: 'English', text: props.englishText },
  { key: 'si', label: 'සිං', title: 'Sinhala', text: props.sinhalaText },
  { key: 'ta', label: 'த', title: 'Tamil',  text: props.tamilText }
]))

function go(i) {
  if (i < 0 || i >= langs.value.length) return
  active.value = i
}
</script>

<style scoped>
/* (Optional) tweak focus outlines for keyboard users */
button:focus-visible {
  outline: 2px solid #16a34a; /* Tailwind green-600 */
  outline-offset: 2px;
}
</style>
