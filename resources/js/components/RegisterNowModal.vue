<template>
  <div>
    <button @click="showModal = true" class="text-black bg-white px-4 py-2 mb-4  font-semibold">Register Now</button>


    <teleport to="body">
    <div v-if="showModal" class="fixed inset-0 z-[1001] flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white  w-full max-w-md">
        <!-- <div class="bg-black p-2 w-full"></div> -->
       <div class="p-6 relative">
         <h2 class="text-xl text-black text-center font-bold mb-4">Register Now</h2>
         <button @click="showModal = false" class="absolute top-2 right-3 text-gray-600 hover:text-black text-lg">&times;</button>
            <form @submit.prevent="submitForm">
            <input v-model="form.first_name" type="text" placeholder="First Name" class="input" required />
            <input v-model="form.last_name" type="text" placeholder="Last Name" class="input" required />
            <input v-model="form.email" type="email" placeholder="Email Address" class="input" required />
            <input v-model="form.contact_number" type="text" placeholder="Contact Number" class="input" required />
            <input v-model="form.country" type="text" placeholder="Country" class="input" required />
            <input v-model="form.postal_code" type="text" placeholder="Postal Code" class="input" required />
            <input v-model="form.address_line_1" type="text" placeholder="Address Line 1" class="input" required />
            <input v-model="form.address_line_2" type="text" placeholder="Address Line 2 (optional)" class="input" />
            <div class="mt-4 flex justify-end gap-2">
                <button @click="showModal = false" type="button" class="px-4 py-2 bg-gray-300 font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 font-semibold bg-black text-white">Submit</button>
            </div>
            </form>
       </div>

       <div class="bg-black p-2 w-full"></div>

      </div>
    </div>
    </teleport>
  </div>
</template>

<script>
import { useToast } from 'vue-toastification';

export default {
  data() {
    return {
      showModal: false,
      form: {
        first_name: '',
        last_name: '',
        email: '',
        contact_number: '',
        country: '',
        postal_code: '',
        address_line_1: '',
        address_line_2: '',
      },
    };
  },
  setup() {
    const toast = useToast();
    return { toast };
  },
  methods: {
    async submitForm() {
      try {
        const res = await fetch('/api/register', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(this.form),
        });
        const data = await res.json();
        if (res.ok) {
          this.toast.success(data.message || 'Registration successful!');
          this.showModal = false;
        } else {
          this.toast.error(data.message || 'Registration failed.');
        }
      } catch (error) {
        this.toast.error('Something went wrong!');
      }
    },
  },
};
</script>


<style>
.input {
  display: block;
  width: 100%;
  padding: 0.5rem;
  margin-bottom: 0.75rem;
  border: 1px solid #ccc;
  border-radius: 0.375rem;
}
</style>
