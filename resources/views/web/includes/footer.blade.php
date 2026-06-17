<footer class="bg-primary-blue text-white py-12">
  <div class="max-w-screen-2xl mx-auto px-6 flex flex-col items-start text-center md:text-left">

    <div class="flex flex-col mx-auto justify-center items-center"> 
      <h2 class="lg:text-6xl trscking-[5px] text-3xl font-serif text-center">The Asian Literary <br> Festival</h2>
      <p class="text-sm mt-2 tracking-widest uppercase">- jaffna <span class="font-semibold">2027</span></p>
    </div>




    <div class="mt-6 text-sm space-x-6 mx-auto items-center flex justify-center flex-wrap">
      <p class=" text-gray-400 text-sm">©{{ now()->format('Y') }}</p>
      <a href="{{url('/terms-&-conditions')}}" class="hover:underline">General Terms and Conditions</a>
      <a href="{{url('/privacy-policy')}}" class="hover:underline">Privacy Policy</a>
      <a href="{{route('contactus')}}" class="hover:underline">Contact Us</a>
    </div>

    <div class=" mx-auto flex flex-col items-center space-y-3 text-center">
      <p class="text-xs text-gray-500 mt-3 italic">Empowering the digital backbone of the festival</p>
      <a href="https://tridentlabs.me/" target="_blank" class="flex items-center gap-2 hover:opacity-80 transition">
        <img src="{{ asset('assets/img/trident-light-icon.webp') }}" alt="Trident Labs Logo" class="h-6 w-auto">
        <div class="flex flex-col items-start">
          <span class="font-semibold text-sm">Trident Labs</span>
          {{-- <p class="text-xs text-gray-400">Innovate. Integrate. Motivate.</p> --}}
        </div>
      </a>
    </div>

  </div>
</footer>
