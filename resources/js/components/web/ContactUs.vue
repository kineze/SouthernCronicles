<template>
  <div class="max-w-screen-2xl mx-auto px-4 py-10">
    <h1 class="lg:text-6xl text-3xl text-primary-blue font-extrabold tracking-widest uppercase text-center mb-10">
      Contact Us
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        
        <div class="w-full h-full lg:px-2">
            <!-- <iframe
                class="w-full h-full"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.873008833078!2d79.99318437499782!3d7.089728115005731!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2f8a178f8f4c3%3A0x123456789abcdef!2sThe%20Asian%20Literary%20Agency%2C%2016%20Vishaka%20Road%2C%20Medagama%2C%!5e0!3m2!1sen!2slk!4v1753439188989!5m2!1sen!2slk"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe> -->

            <iframe class="w-full h-full" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d465130.67125403904!2d54.22896150671022!3d24.387099420441903!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5e440f723ef2b9%3A0xc7cc2e9341971108!2sAbu%20Dhabi%20-%20United%20Arab%20Emirates!5e0!3m2!1sen!2slk!4v1755593295795!5m2!1sen!2slk" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>


        <div class="lg:px2 lg:pt-2 bg-white border border-gray-300">

            <div class="p-4">
                <div class="uppercase text-primary-blue font-semibold lg:text-4xl text-2xl text-center mb-4">
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
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-black bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
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
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-black bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
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
                                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-black bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
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
                                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-black bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
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
                        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-black bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
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
                        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-black bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
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
                    class="bg-primary-blue text-blac px-6 py-3 rounded-lg font-semibold text-white mx-auto flex"
                    >
                    Send Message
                    </button>
                </form>
            </div>

            <div class="bg-primary-blue p-2 w-full"></div>
        </div>
    </div>

    <div class="mt-8 text-center text-base text-black dark:text-gray-300 leading-relaxed">
        <p class="font-semibold text-lg">The Asian Literary Festival</p>
        <p>The Asian Literary Agency,</p>
        <p>16 Vishaka Road, Medagama, </p>
        <p>+94 77 556 4255</p>
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

