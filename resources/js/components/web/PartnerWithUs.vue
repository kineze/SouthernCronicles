<template>
  <div class="max-w-screen-2xl mx-auto bg-white dark:bg-gray-900 shadow py-10">
    <h1 class="lg:text-6xl text-3xl mt-4 text-black dark:text-white font-extrabold tracking-widest uppercase text-center mb-8">
      Partner With Us
    </h1>

    <div class="flex flex-wrap">
      <!-- Left: Copy -->
      <div class="max-w-7xl lg:w-7/12 mt-10 lg:p-4 space-y-6 text-gray-700 dark:text-gray-300 text-base leading-relaxed">
        <h2 class="text-lg font-semibold text-black dark:text-white">Why Partner With Us?</h2>
        <p class="text-justify">
          Join us to champion cultural preservation and creative innovation. Your brand helps safeguard living heritage while connecting with engaged audiences through meaningful programs, performances, and education.
        </p>

        <h2 class="text-lg font-semibold text-black dark:text-white">Benefits</h2>
        <ul class="list-disc pl-6 space-y-2">
          <li>Brand visibility across festivals, stages, and digital channels.</li>
          <li>Community impact through preservation of living heritage.</li>
          <li>Co-created campaigns, showcases, and thought-leadership opportunities.</li>
          <li>Access to exclusive cultural experiences and VIP engagements.</li>
        </ul>

        <h2 class="text-lg font-semibold text-black dark:text-white">Let’s Build Together</h2>
        <p class="text-justify">
          Tell us about your brand and why you’d like to partner. We’ll get in touch with tailored collaboration options aligned with your goals.
        </p>
      </div>

      <!-- Right: Form -->
      <div class="mt-10 max-w-4xl lg:w-5/12 lg:p-4 mx-auto bg-white dark:bg-gray-800 rounded-lg shadow space-y-6 lg:sticky lg:top-4 lg:max-h-[100svh] lg:overflow-y-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- First Name -->
          <div class="relative">
            <input v-model.trim="form.first_name" type="text" id="first_name" placeholder=" "
                   class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer" required />
            <label for="first_name"
                   class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]">
              First Name
            </label>
          </div>

          <!-- Last Name -->
          <div class="relative">
            <input v-model.trim="form.last_name" type="text" id="last_name" placeholder=" "
                   class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer" required />
            <label for="last_name"
                   class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]">
              Last Name
            </label>
          </div>

          <!-- Brand Name -->
          <div class="relative md:col-span-2">
            <input v-model.trim="form.brand_name" type="text" id="brand_name" placeholder=" "
                   class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer" required />
            <label for="brand_name"
                   class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]">
              Brand Name
            </label>
          </div>

          <!-- Email -->
          <div class="relative md:col-span-2">
            <input v-model.trim="form.email" type="email" id="email" placeholder=" "
                   class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer" required />
            <label for="email"
                   class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]">
              Email Address
            </label>
          </div>

          <!-- Phone (vue3-tel-input) -->
          <div class="relative md:col-span-2">
            <VueTelInput
              ref="telRef"
              v-model="form.phoneRaw"
              :mode="'international'"
              :input-options="{ showDialCode: true, placeholder: 'Contact Number' }"
              :autoDefaultCountry="true"
              @country-changed="onCountry"
              @validate="onValidate"
              class="!text-sm !rounded-none pb-1.5"
            />
          </div>
        </div>

        <!-- Description -->
        <div class="relative">
          <textarea v-model.trim="form.description" id="description" rows="4" placeholder=" "
                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 dark:text-white bg-transparent border border-gray-500 dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-blue-500 peer"></textarea>
          <label for="description"
                 class="absolute text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 px-2 duration-300 transform scale-75 -translate-y-4 top-2 z-10 origin-[0]">
            Why partner with us? (optional)
          </label>
        </div>

        <!-- Submit -->
        <div class="text-start">
          <button @click="submitForm" :disabled="submitting"
                  class="px-6 py-2 bg-black text-white font-semibold hover:bg-gray-800 transition disabled:opacity-60">
            {{ submitting ? 'Submitting…' : 'Submit' }}
          </button>
        </div>
      </div>
    </div>

    <!-- Our Products -->
    <section class="mt-10">
      <h1 class="lg:text-4xl text-3xl mt-4 text-black dark:text-white font-extrabold tracking-widest uppercase text-center mb-8">
        Our Products
      </h1>

      <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <article
          v-for="p in products"
          :key="p.key"
          class="group rounded-lg overflow-hidden bg-white dark:bg-gray-800 shadow hover:shadow-xl transition"
        >
          <!-- Image with fixed aspect ratio (16:9) -->
          <div class="relative pt-[56.25%] bg-white">
            <a :href="p.url" target="_blank" rel="noopener" class="absolute inset-0 block">
              <img
                :src="coverImage(p)"
                :alt="p.title"
                class="w-full h-full object-contain"
                loading="lazy"
                decoding="async"
              />
            </a>
          </div>

          <div class="p-4">
            <a
              :href="p.url"
              target="_blank"
              rel="noopener noreferrer"
              class="hover:underline hover:text-blue-600 dark:hover:text-blue-400 transition"
            >
              <h3 class="font-semibold text-gray-900 dark:text-white text-lg">
                {{ p.title }}
              </h3>
            </a>

            <p class="mt-1 text-sm text-gray-700 text-justify dark:text-gray-200 whitespace-pre-line">
              {{ displayedDesc(p) }}
            </p>

            <button
              v-if="isLong(p)"
              @click="toggleExpanded(p.key)"
              class="mt-2 text-xs font-semibold underline text-blue-700 dark:text-blue-300 hover:opacity-80"
            >
              {{ isExpanded(p.key) ? 'Show less' : 'Read more' }}
            </button>
          </div>
        </article>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useToast } from 'vue-toastification'
import { VueTelInput } from 'vue3-tel-input'
import 'vue3-tel-input/dist/vue3-tel-input.css'

const toast = useToast()
const submitting = ref(false)
const telRef = ref(null)

/* --------- Product helpers (read-more) --------- */
const WORD_LIMIT = 50
const expanded = ref(new Set())

const normalizeDesc = (d) => (d ?? '').toString().replace(/\s+/g, ' ').trim()
const splitWords = (d) => normalizeDesc(d).split(' ').filter(Boolean)
const isLong = (p) => splitWords(p.description).length > WORD_LIMIT
const isExpanded = (key) => expanded.value.has(key)
const toggleExpanded = (key) => {
  const s = new Set(expanded.value)
  s.has(key) ? s.delete(key) : s.add(key)
  expanded.value = s
}
const displayedDesc = (p) => {
  const desc = normalizeDesc(p.description)
  if (!isLong(p) || isExpanded(p.key)) return desc
  return splitWords(desc).slice(0, WORD_LIMIT).join(' ') + '…'
}

/* --------- Products now using WEBP images --------- */
const coverImage = (p) => p.image || p.poster || '/images/placeholder.webp'

const products = ref([
  {
    key: 'writing-lab',
    title: 'The Asian Review',
    image: '/assets/img/productone.webp',     // <-- webp
    poster: '/images/products/writing-lab.jpg',
    description: `Do you dream of launching a prestigious literary magazine in your country and language? Partner with The Asian Review, ranked among the world's top 10 literary publications by Feedspot and read by over 75,000 daily readers globally. 
    We're more than just a magazine – we're part of a dynamic literary social enterprise network expanding worldwide. Our franchise model is tailored to your local scale, market size, population, and language reach, ensuring sustainable growth in your unique cultural context.

    Special Opportunity for Global Majority Nations  
    We offer accessible franchise packages specifically designed for partners from developing nations, making literary excellence achievable regardless of economic barriers.  

    Transform your literary passion into a thriving business venture. Connect with established writers, emerging voices, and engaged readers while building a sustainable cultural enterprise in your community.  

    Ready to become the literary voice of your nation?  
    Join the world's fastest-growing literary social enterprise network. Your story starts here.`,
    url: '/asian-group-of-literature'
  },
  {
    key: 'literary-hub',
    title: 'Transform Your City into a Global Literary Hub',
    image: '/assets/img/producttwo.webp',     // <-- webp
    poster: '/images/products/writing-lab.jpg',
    description: `You've been thinking of launching a literary festival in your city, your country—but nothing matched your expectations?
        Now you can partner with The Asian Literary Festival Network, the world's fastest-growing literary festival platform that connects cities, people, and cultures worldwide through our revolutionary global roadmap.
        Our proven network spans continents with thriving franchisees in Kenya, Sri Lanka, India, Belgium, and many more locations. Each partner festival becomes part of something extraordinary—a unified platform that culminates in The Global Summit in Abu Dhabi, where over 1,000 writers, thinkers, artists, and creative entrepreneurs compete for the prestigious Asian Prizes.
        Why start from scratch when you can join a network that ensures equitable access to creative expression while amplifying diverse voices globally? Our franchisees don't just host events—they become vital nodes in the world's most influential literary ecosystem.
        Ready to make your city the next destination for literary excellence?
        Join The Asian Literary Festival Network today.`,
    url: '#'
  },
  {
    key: 'kipenzi',
    title: 'The Children’s Fest, Kepenzi',
    image: '/assets/img/productthree.webp',    // <-- webp
    poster: '/images/products/kipenzi.jpg',
    description:
      `The Children’s Fest, Kepenzi
      You've been thinking of launching a children's literary festival in your city, your country—but nothing matched your expectations?
      Now you can partner with Kepenzy, The Asian Literary Festival's Children's Fest—the world's most innovative children's storytelling platform leading the digital age storytelling revolution.
      Kepenzy represents the ultimate innovation in storytelling for young minds, reimagining how children connect with narratives in our digital era. We're pioneering the refamiliarization of lost stories, bringing reading back to the epicenter of childhood growth and development. Our thriving franchisees in Kenya, Sri Lanka, India, Belgium, and beyond have discovered that Kepenzy doesn't just entertain—it revolutionizes how young minds engage with literature.
      Through cutting-edge storytelling techniques and immersive experiences, we're reversing the digital disconnect, making books and stories irresistible to the YouTube generation. Your Kepenzy festival becomes part of a global movement ensuring equitable access to transformative literary experiences for children worldwide.
      Why start from scratch when you can lead the storytelling revolution that's already proven worldwide?
      Franchise Kepenzy today and reignite young imaginations in your city.`,
    url: '#'
  },
  {
    key: 'climateaction',
    title: 'Creative Expression for Climate Action',
    image: '/assets/img/productfour.webp',        // <-- webp
    poster: '/images/products/kipenzi-toys-books.jpg',
    description:
      `
      You've been thinking of launching an impactful youth festival in your city, your country—but nothing matched your vision for meaningful change?
      Now you can partner with The Purple Umbrella Festival—India's largest multidisciplinary festival empowering young people to engage with the world's most pressing challenges through creativity and collective action.
      What began as a theatre festival has revolutionized into a dynamic platform where storytelling meets solutions, giving youth the stage, screen, and spotlight to express their hopes, fears, and climate solutions. Our proven model believes creativity isn't a luxury—it's a necessity for change.
      Through three transformative tracks, Purple Umbrella nurtures environmentally-conscious artists who inspire climate action through performance, purpose, and passion. We're building spaces where theatre sparks climate dialogue, incubates ideas, and builds collective voices for the future.
      Why start from scratch when you can join a movement that's already empowering communities to think critically, act collectively, and imagine courageously?
      Franchise Purple Umbrella Festival today and spark change in your community.`,
    url: '#'
  },
  {
    key: 'asian-writer',
    title: 'The Asian Writer Retreat and Residencies - Open Call',
    image: '/assets/img/productsix.webp',         // <-- webp
    poster: '/images/products/kipenzi-toys-books.jpg',
    description:
      `Transform Your Writing. Transform Your Future.
      Are you ready to elevate your craft to extraordinary heights?
      The Asian Writer Retreat and Residencies invite you to join one of the world's most iconic writing programs, hosted by the largest creative social enterprise from the Global South.
      Set against the inspiring landscapes of India and Sri Lanka, our exclusive retreats offer the ultimate refinement of your writing through cross-fertilization with the industry's most acclaimed individuals. This isn't just a workshop—it's a transformative journey where emerging and established writers converge to push creative boundaries.
      Experience intensive mentorship, collaborative workshops, and immersive cultural exchanges that will reshape your literary voice. Our residencies provide the perfect synthesis of focused writing time, expert guidance, and meaningful connections with fellow writers from around the globe.
      Whether you're crafting your first novel or refining your literary masterpiece, our program offers the space, support, and inspiration you need.
      Apply now and become part of writing history.`,
    url: '#'
  },
  {
    key: 'purple-umbrella',
    title: 'The ALF Curation Package - Festival Curation Services',
    image: '/assets/img/productfive.webp',       // <-- webp
    poster: '/images/products/purple-umbrella.jpg',
    description:
      `Your Vision. Our Expertise. Extraordinary Results.
      Have an idea for a literary and art festival but need world-class execution?
      The Asian Literary Festival Curation Package transforms your vision into an unforgettable cultural experience. Our top-tier curation team doesn't just manage and administer festivals—we elevate them to extraordinary heights that exceed every expectation.
      Backed by our proven global network spanning over 10 cities currently, with expansion to 15 cities next year, we bring unparalleled expertise in connecting cities, people, and cultures through transformative events. Our curators have mastered the art of creating festivals that resonate deeply with audiences while achieving measurable impact.
      From concept development to flawless execution, we handle every detail: programming, artist coordination, logistics, marketing, and audience engagement. Your festival becomes part of our prestigious network, gaining access to our international roster of writers, thinkers, artists, and creative entrepreneurs.
      Why settle for ordinary when you can create legendary?
      Choose The ALF Curation Package and watch your festival become extraordinary.`,
    url: '#'
  }
])

/* --------- Form state --------- */
const form = ref({
  first_name: '',
  last_name: '',
  brand_name: '',
  email: '',
  phoneRaw: '',
  phone_normalized: '',
  country_iso2: '',
  dial_code: '',
  description: ''
})

/* Phone helpers */
function normalizePhone(val) {
  if (typeof val === 'string') return val.replace(/\s+/g, '')
  if (val && typeof val === 'object') {
    const e164 = val.e164 || val.E164 || ''
    const intl = val.international || val.number || val.national || ''
    const best = e164 || intl
    return (best || '').toString().replace(/\s+/g, '')
  }
  return ''
}

function onCountry(c){
  form.value.country_iso2 = c?.iso2 ? String(c.iso2).toUpperCase() : ''
  form.value.dial_code = c?.dialCode ? `+${String(c.dialCode).replace(/^\+/, '')}` : ''
}

function onValidate(payload){
  if (payload && typeof payload === 'object') {
    const { country } = payload
    if (country?.iso2) form.value.country_iso2 = String(country.iso2).toUpperCase()
    if (country?.dialCode) form.value.dial_code = `+${String(country.dialCode).replace(/^\+/, '')}`
    form.value.phone_normalized =
      payload?.number?.e164 ??
      payload?.formattedNumber?.e164 ??
      payload?.number?.international ??
      payload?.number ??
      form.value.phoneRaw
    return
  }
  const [phone, , country] = arguments
  if (country?.iso2) form.value.country_iso2 = String(country.iso2).toUpperCase()
  if (country?.dialCode) form.value.dial_code = `+${String(country.dialCode).replace(/^\+/, '')}`
  form.value.phone_normalized = phone || form.value.phoneRaw
}

const clearForm = () => {
  form.value = {
    first_name: '',
    last_name: '',
    brand_name: '',
    email: '',
    phoneRaw: '',
    phone_normalized: '',
    country_iso2: '',
    dial_code: '',
    description: ''
  }
}

const submitForm = async () => {
  let phoneFull = (form.value.phone_normalized || normalizePhone(form.value.phoneRaw) || '').trim()
  try {
    const api = telRef.value
    if (api && typeof api.getNumber === 'function') {
      let n; try { n = api.getNumber('E164') } catch {}
      if (!n) { try { n = api.getNumber() } catch {} }
      if (n) phoneFull = String(n).trim()
    }
  } catch {}

  const first = form.value.first_name?.trim()
  const last  = form.value.last_name?.trim()
  const brand = form.value.brand_name?.trim()
  const email = form.value.email?.trim()
  const phoneDigits = (phoneFull || '').replace(/\D/g, '')

  if (!first || !last || !brand || !email || phoneDigits.length < 6) {
    toast.error('Please fill all required fields.')
    return
  }

  try {
    submitting.value = true
    await axios.post('/api/partner-inquiries', {
      first_name: first,
      last_name: last,
      brand_name: brand,
      email,
      phone: phoneFull,
      country_iso2: form.value.country_iso2 || '',
      dial_code: form.value.dial_code || '',
      description: form.value.description || ''
    })
    toast.success('✅ Thank you! We will contact you soon.')
    clearForm()
  } catch (e) {
    toast.error(e?.response?.data?.message || '❌ Submission failed. Please try again.')
  } finally {
    submitting.value = false
  }
}
</script>
