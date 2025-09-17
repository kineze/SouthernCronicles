<template>
  <section class="relative w-full max-w-screen-xl mx-auto font-poppins" ref="wrap">
    <!-- Language buttons -->
    <!-- <div class="flex justify-start gap-2 mt-4 mb-1">
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
          :key="'slide-' + lang.key"
          class="min-w-full"
        >
          <p
            v-for="(para, idx) in lang.paragraphs"
            :key="lang.key + '-' + idx"
            class="text-gray-700 py-3 dark:text-gray-200 text-justify leading-7"
          >
            {{ para }}
          </p>
        </article>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  englishParagraphs: {
    type: Array,
    default: () => [
      "Creative expression is humanity's most profound manifestation of diversity—a mirror reflecting our heritage, our souls, and the rich tapestry of human experience. The Asian Literary Festival serves as the crucible where this diversity fuses into one shared humanity, creating a global stage that celebrates both our unity and our beautiful differences within the human race.",
      "Co-created by The Asian Group of Literature and Trogon Global, The Asian Literary Festivals represent an inclusive ecosystem anchored by our flagship festival in Abu Dhabi, with satellite festivals flourishing in major cultural centres worldwide. This network creates a year-round celebration of literary and cultural exchange.",
      "Whether you hail from East or West, North or South, this is your space.",
      "The Asian Literary Festivals don't just showcase literature—they celebrate the full spectrum of human creativity and connection, and each festival is proudly local within its international network.",
      "Join us in writing the next chapter of global literary dialogue, where every story matters and every voice contributes to our collective human narrative.",
      "The Asian Literary Festival, Gampaha Edition, powered by The Asian/Trogon festival ecosystem, Purple Umbrella Literary Festival and Pick a Book Sri Lanka, revolutionises the existing literary festivities and traditions in the island nation. Themed 'Not a Luxury', The Asian Literary Festival is the most inclusive trilingual international literary festival that demonstrates a commitment towards equitable access to literature and culture.",
      "The Asian Literary Festival, Gampaha edition welcomes internationally acclaimed thinkers, writers and creatives from around the world, transforming its host town 'Gampaha' into an unparalleled sanctuary of cultural exchange and cross-fertilisation."
    ]
  },
  sinhalaParagraphs: {
  type: Array,
  default: () => [
    "මනුෂ්‍ය විවිධත්වය වඩාත් ප්‍රබල ලෙස නිරූපනය වනුයේ නිර්මාණශීලී ප්‍රකාශනය තුළිනි—එය අපගේ උරුමය, ආත්මයන් සහ වඩාත් වෛවර්ණ වූ මානව අත්දැකීම් සමුදාය පරාවර්තනය කරන කැඩපතකි. ආසියානු සාහිත්‍ය උලෙළ මෙකී විවිධත්වයන් එකට මුසුවී එක් පොදු මනුෂ්‍යත්වයක් බවට පත්වන කෝවකි. එය මානව වර්ගයාගේ ඒකීයත්වය මෙන්ම ඒ තුළ පවතින නොයෙකුත් අලංකාර විවිධත්වයන්ගේ සැමරුමකි.",
    "ආසියානු සාහිත්‍ය සාමූහිකය සහ ට්‍රොගොන් ග්ලෝබල් එක්ව නිර්මාණය කළ ආසියානු සාහිත්‍ය උලෙළ වූකලී අබුඩාබි හි පැවැත්වෙන අපගේ ප්‍රධාන උත්සවය හා බැඳුනු ලෝකයේ විවිධ සංස්කෘතික මධ්‍යස්ථානවල උත්කර්ෂවත් ලෙස පැවැත්වෙන උත්සව රැසකි. සාහිත්‍ය සහ සංස්කෘතික හුවමාරුව මේ ජාලය හරහා වසර පුරාම සිදුකරන්නක් වන අතර, ඒ අතුරින් ආසියානු සාහිත්‍ය උලෙළ—ගම්පහ සංස්කරණය ගෝලීය සාහිත්‍ය සන්දර්භය තුළ ලාංකේය සලකුණ ඔසවා තබන ජාතික මට්ටමේ අවස්ථාව වෙයි.",
    "මෙය සතර දිග්භාගයෙන්ම පැමිණෙන සාහිත්‍ය සහ කලා රසික ඔබේ අවකාශයයි.",
    "ආසියානු සාහිත්‍ය උලෙළ හරහා කරළියට ගෙන එන්නේ සාහිත්‍යයම පමණක් නොවේ—මානව නිර්මාණශීලීත්වයේ සහ සම්බන්ධතාවන්හි මුළුමහත් පරාසයම ය. ආසියානු සාහිත්‍ය උලෙළ—ගම්පහ සංස්කරණය එහි ජාත්‍යන්තර උත්සව ජාලය තුළ අභිමානවත් ලාංකේය උලෙළ වන්නේය.",
    "සෑම කථාන්තරයකටම නිසි අවධානය යොමුවන, සෑම හඬක්ම පොදු මානව ආඛ්‍යානයට දායක වන ගෝලීය සාහිත්‍ය කතිකාවේ නව පරිච්ඡේදය ලියන්නට එක්වන්නැයි අපි ඔබට ඇරයුම් කරන්නෙමු. සාහිත්‍යය වරප්‍රසාදයක් නොව පොදුජනයාගේ අයිතියක් බව අපගේ විශ්වාසයයි. එමෙන්ම, ලාංකික සාහිත්‍යකාමී ප්‍රජාවට දෙස් විදෙස් සාහිත්‍යවේදීන්ගේ ඇසුර සමීප කරවීමත්, පෙර දවස පැවැති පරිද්දෙන් යළිත් වරක් සාහිත්‍යය ලාංකේය ජීවන රටාවට වෙන් නොකළහැකි ලෙස බද්ධ කරවීමට අවශ්‍ය සක්‍රියන ශක්තිය මුදාහැරීමත් ආසියානු සාහිත්‍ය උලෙළ—ගම්පහ සංස්කරණය හරහා මුදුන්පත් කරගැනීමට එක්වන ලෙසද අපි ඔබට ඇරයුම් කරමු.",
    "නන්විධ සාහිත්‍ය සම්ප්‍රදායයන් එකිනෙක මුසුවී අද්‍යතන ජන හඬ මතුවෙද්දී, පුරාණ කතිකාවත්වලට නව පණක් දෙමින්, නැගෙනහිර සහ බටහිර අතර ඓතිහාසික සංවාදයට පුනර්ජීවයක් දෙමින් ගතික සංධිස්ථාන බිහිකරන ආසියානු සාහිත්‍ය උත්සව මාලාවේ ගම්පහ සංස්කරණය වූකලී ජාති, ආගම්, කුල හා භෞමික සීමා මායිම් විනිවිද යන කථාන්තර සහ නව සංස්කෘතික කතිකාවත් පැනනගින්නාවූ ලාංකේය ශිෂ්ටාචාරයේ වැදගත් මංසන්ධියකි."
  ]
},

tamilParagraphs: {
  type: Array,
  default: () => [
    "ஆசிய இலக்கிய விழா – கம்பஹா பதிப்பு",
    "“கதைகளின் வழியே உலகை ஒன்றிணைக்கும் இடம்”",
    "மனித பல்வகைமையின் அழகு, படைப்பாற்றலின் வெளிச்சத்தில் மலர்கிறது. அது நமது பாரம்பரியம், ஆன்மாவின் குரல், வண்ணமயமான அனுபவங்களின் ஒளிப்படம்.",
    "இந்த விழா, ஆசியாவின் எண்ணற்ற கதைகளை ஒன்றிணைத்து, “ஒற்றுமை உள்ள மனித குலத்தின் கவிதையாக” வெளிப்படுத்துகிறது.",
    "அபுதாபியில் நடைபெறும் எங்கள் பிரதான விழாவுடன் இணைந்து, உலகின் பல்வேறு கலாச்சார மையங்களில் பிரகாசிக்கும் இவ்விழா, இலங்கை இலக்கியத்தின் குரலை உலக மேடையில் பெருமையுடன் உயர்த்தும் கம்பஹா பதிப்பாகும்.",
    "இது இலக்கியம் நேசிக்கும் உங்களுக்கான மேடை! கிழக்கு மண்ணிலிருந்து மேற்கு வரை, பண்டைய கதைகளில் புதிய உயிரை ஊட்டும் இந்த சந்திப்பு, எல்லைகளை தாண்டி, மனித குரல்களை ஒன்றிணைக்கிறது.",
    "ஆசிய இலக்கிய விழா – கம்பஹா பதிப்பு இலங்கை இலக்கிய நேசிகளையும், உலக எழுத்தாளர்களையும் அருகில் கொண்டு வந்து, எமது வாழ்வோடு பிரிக்க முடியாதவாறு இலக்கியத்தை மீண்டும் நம்மிடம் பிணைக்கிறது.",
    "ஒவ்வொரு கதைக்கும் குரல் தர, ஒவ்வொரு குரலும் மனித குலத்தின் பொதுக் கதையில் கலக்க, இந்த புதிய அத்தியாயத்தை எழுத நீங்கள் வரவேற்கப்படுகிறீர்கள்."
  ]
}

})

const active = ref(0) // 0: Sinhala, 1: English, 2: Tamil

const langs = computed(() => ([
  { key: 'en', label: 'En', title: 'English', paragraphs: props.englishParagraphs },
  { key: 'si', label: 'සිං', title: 'Sinhala', paragraphs: props.sinhalaParagraphs },
  { key: 'ta', label: 'த', title: 'Tamil',  paragraphs: props.tamilParagraphs }
]))

function go(i) {
  if (i < 0 || i >= langs.value.length) return
  active.value = i
}
</script>

<style scoped>
button:focus-visible {
  outline: 2px solid #16a34a; /* Tailwind green-600 */
  outline-offset: 2px;
}
</style>
