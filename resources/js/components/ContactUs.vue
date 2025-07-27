<template>
  <div class="max-w-screen-2xl mx-auto px-4 py-10">
    <h1 class="lg:text-6xl text-3xl text-black font-extrabold tracking-widest uppercase text-center mb-10">
      Contact Us
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

        <div class="w-full h-full lg:px-2">
            <iframe
            class="w-full h-full "
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2519.268017319651!2d4.352317977181306!3d50.84472097167016!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c3c554d1953e11%3A0x2e24f524a97148fd!2sGalerie%20Bortier!5e0!3m2!1sen!2slk!4v1753439188989!5m2!1sen!2slk"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
        </div>

        <div class="lg:px2 lg:pt-2 bg-white border border-gray-300">

            <div class="p-4">
                <div class="uppercase text-black font-semibold lg:text-4xl text-2xl text-center mb-4">
                    Get In Touch With Us
                </div>
                <form @submit.prevent="submitForm" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                        <div class="relative">
                            <input
                            type="text"
                            id="first_name"
                            v-model="form.first_name"
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" "
                            />
                            <label
                            for="first_name"
                            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
                            >First Name</label
                            >
                        </div>

                        <!-- Last Name -->
                        <div class="relative">
                            <input
                            type="text"
                            id="last_name"
                            v-model="form.last_name"
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" "
                            />
                            <label
                            for="last_name"
                            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
                            >Last Name</label
                            >
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="relative">
                            <input
                                type="email"
                                id="email"
                                v-model="form.email"
                                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" "
                            />
                            <label
                                for="email"
                                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
                                >Email Address</label
                            >
                        </div>

                        <!-- Mobile -->
                        <div class="relative">
                            <input
                                type="text"
                                id="mobile"
                                v-model="form.mobile"
                                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" "
                            />
                            <label
                                for="mobile"
                                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
                                >Mobile Number</label
                            >
                        </div>
                    </div>

                    <!-- Subject -->
                    <div class="relative">
                    <input
                        type="text"
                        id="subject"
                        v-model="form.subject"
                        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                    />
                    <label
                        for="subject"
                        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
                        >Subject</label
                    >
                    </div>

                    <!-- Description -->
                    <div class="relative">
                    <textarea
                        id="description"
                        rows="4"
                        v-model="form.description"
                        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                    ></textarea>
                    <label
                        for="description"
                        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-6 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
                        >Description</label
                    >
                    </div>

                    <button
                    type="submit"
                    class="bg-black text-blac px-6 py-3 rounded-lg font-semibold text-white mx-auto flex"
                    >
                    Send Message
                    </button>
                </form>
            </div>

            <div class="bg-black p-2 w-full"></div>
        </div>
    </div>

    <div class="mt-16 text-center text-gray-900 dark:text-gray-300 text-base">
        <p class="font-semibold">The Asian Literary Festival, Brussels</p>
        <p>Philippine Art & Culture Exchange</p>
        <p>Chée de Roodebeek 148, 1200 Woluwe-Saint-Lambert</p>
        <p>+32 496 06 81 86</p>
        <p>info@theasianliteraryfestival.com</p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useToast } from 'vue-toastification'

const toast = useToast()

const form = ref({
  first_name: '',
  last_name: '',
  email: '',
  mobile: '',
  subject: '',
  description: '',
})

const submitForm = async () => {
  try {
    const response = await fetch('/api/contact', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(form.value),
    })

    if (!response.ok) throw new Error('Message failed')

    toast.success('Message sent successfully!')

    form.value = {
      first_name: '',
      last_name: '',
      email: '',
      mobile: '',
      subject: '',
      description: '',
    }
  } catch (error) {
    toast.error('Something went wrong. Please try again.')
  }
}
</script>

