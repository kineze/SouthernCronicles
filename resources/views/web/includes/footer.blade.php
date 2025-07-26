<footer class="bg-black text-white py-12">
  <div class="max-w-screen-2xl mx-auto px-6 flex flex-col items-start text-center md:text-left">

    <div class="flex flex-col mx-auto justify-center items-center">
       <register-now-modal></register-now-modal> 
      <h2 class="lg:text-6xl text-3xl font-serif text-center">Asian Literary Festival</h2>
      <p class="text-sm mt-2 tracking-widest uppercase">Brussels <span class="font-semibold">2025</span></p>
    </div>

    <div class="mt-6 text-sm space-x-6 mx-auto items-center flex justify-center flex-wrap">
        <p class=" text-gray-400 text-sm">©{{ now()->format('Y') }}</p>
        <a href="#" class="hover:underline">General Terms and Conditions</a>
        <a href="#" class="hover:underline">Privacy Policy</a>
        <a href="{{route('contactus')}}" class="hover:underline">Contact Us</a>
      </div>

  </div>
</footer>
