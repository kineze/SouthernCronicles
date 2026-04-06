<template>
  <section class="relative w-full max-w-screen-xl mx-auto font-poppins" ref="wrap">
    <!-- Language switcher -->

    <div v-if="enableLanguageTabs" class="flex justify-start gap-2 mb-4">
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
    </div>

    <!-- Slider -->
    <div class="overflow-hidden">
      <div
        class="flex transition-transform duration-700 ease-out will-change-transform"
        :style="{ transform: `translateX(-${currentSlideIndex * 100}%)` }"
      >
        <article
          v-for="(lang, i) in langs"
          :key="`slide-${lang.key}-${i}`"
          class="min-w-full"
        >
          <p class="dark:text-gray-200 text-black text-justify leading-7">
            {{ displayText(lang) }}
          </p>
          <button
            v-if="isLongText(lang.text)"
            @click="toggleReadMore(lang.key)"
            class="mt-3 text-sm font-semibold text-primary-blue hover:underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-blue"
            type="button"
          >
            {{ expanded[lang.key] ? 'Read less' : 'Read more' }}
          </button>
        </article>
      </div>
    </div>

  </section>
</template>

<script setup>
import { ref, computed } from 'vue'
const WORD_LIMIT =130

const props = defineProps({
  enableLanguageTabs: {
    type: Boolean,
    default: true
  },
  englishText: {
    type: String,
    default:
      "At the northern tip of the island, where the Palk Strait meets millennia of memory, Jaffna has long been a civilisation unto itself — ancient, resilient, and luminous with creative life. For all its richness, it has remained one of South Asia's most quietly kept secrets: a city of extraordinary temples, layered histories, living folklore, and a culinary tradition of uncommon refinement, known intimately to those who have found their way here, yet still to be discovered by much of the world. The Asian Literary Festival arrives in Jaffna not merely to celebrate what already exists, but to announce what has always been true — that this peninsula is a cultural destination of the first order, and that its time as a gathering place for the world is long overdue. Over two immersive days, the festival brings storytelling, music, dance, folklore, culinary art, and visual creation to this storied city, with sessions unfolding in Tamil, Sinhala, and English. International authors and artists from across the subcontinent and beyond join local voices shaped by one of the world's oldest living literary traditions. Jaffna is not a destination at the edge of the map. It is an inseparable thread in the larger fabric of Sri Lanka's civilisational legacy — and ALF Jaffna 2026 is its formal introduction to the world."
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
const expanded = ref({
  en: false,
  si: false,
  ta: false
})

const langs = computed(() => ([
  { key: 'en', label: 'En', title: 'English', text: props.englishText },
  { key: 'si', label: 'සිං', title: 'Sinhala', text: props.sinhalaText },
  { key: 'ta', label: 'த', title: 'Tamil',  text: props.tamilText }
]))

const currentSlideIndex = computed(() => (props.enableLanguageTabs ? active.value : 0))

function normalizedWords(text = '') {
  return text.trim().split(/\s+/).filter(Boolean)
}

function getPreviewText(text = '') {
  const words = normalizedWords(text)
  if (words.length <= WORD_LIMIT) return text
  return `${words.slice(0, WORD_LIMIT).join(' ')}...`
}

function isLongText(text = '') {
  return normalizedWords(text).length > WORD_LIMIT
}

function displayText(lang) {
  if (expanded.value[lang.key]) return lang.text
  return getPreviewText(lang.text)
}

function toggleReadMore(langKey) {
  expanded.value[langKey] = !expanded.value[langKey]
}

function go(i) {
  if (!props.enableLanguageTabs) return
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
