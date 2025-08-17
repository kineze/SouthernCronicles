@extends('layouts.web.app')

@section('content')

<section class="w-full hidden md:block max-w-screen-2xl -mt-6 mx-auto relative">
  <!-- Container for layers -->
  <div class="relative w-full z-0 mb-12 overflow-hidden rounded-3 min-h-[150vh]">

    <!-- Layer 5: Farthest Background -->
    <div class="parallax- overflow-hidden absolute z-50 w-full -bottom-20" data-speed="0.1">
      <img src="{{ asset('assets/img/light-blue-waves.webp') }}" class="w-full bob-y -mb-9  object-contain" alt="Layer 5">
    </div>
    
    <!-- Layer 4 -->
    <div class="parallax-layer absolute z-40 w-full bottom-28" data-speed="0.2">
      <div class="loop-viewport " style="--bob-amp:12px; --bob-dur:5s">
        <div class="loop-track">
          <div class="loop-group">
            <img src="{{ asset('assets/img/text-mrqeuu.webp') }}" alt="Layer 3">
            <img src="{{ asset('assets/img/text-mrqeuu.webp') }}" alt="Layer 3">
            <img src="{{ asset('assets/img/text-mrqeuu.webp') }}" alt="Layer 3">
            <img src="{{ asset('assets/img/text-mrqeuu.webp') }}" alt="Layer 3">
          </div>
          <div class="loop-group" aria-hidden="true">
            <img src="{{ asset('assets/img/text-mrqeuu.webp') }}" alt="Layer 3">
            <img src="{{ asset('assets/img/text-mrqeuu.webp') }}" alt="Layer 3">
            <img src="{{ asset('assets/img/text-mrqeuu.webp') }}" alt="Layer 3">
            <img src="{{ asset('assets/img/text-mrqeuu.webp') }}" alt="Layer 3">
          </div>
        </div>
      </div>
    </div>

    <!-- Layer 3: Looping layer -->
    <div class="parallax-layer absolute z-30 bottom-0 w-full overflow-hidden" data-speed="0.3">
      <img src="{{ asset('assets/img/uae-skyline.webp') }}" class="w-full  object-contain" alt="Layer 2">

      <img src="{{ asset('assets/img/skyline-shadow.webp') }}" class="w-full object-contain" alt="Layer 2">
    </div>

    <!-- Layer 1: Foreground -->
    <div class="parallax-layer absolute  overflow-hidden z-0 w-full top-0 -right-56"  data-speed="0.4">
       <div class="w-full">
         <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1080" zoomAndPan="magnify" viewBox="0 0 810 1012.49997" height="1350" preserveAspectRatio="xMidYMid meet" version="1.2">
              <defs>
                  <clipPath id="717d2231e0"><path d="M 341.132812 133 L 409 133 L 409 211 L 341.132812 211 Z M 341.132812 133 " /></clipPath>
                  <clipPath id="e64a9e9d83"><path d="M 598 22 L 664.972656 22 L 664.972656 100 L 598 100 Z M 598 22 " /></clipPath>
              </defs>
              <g id="db3e97c938">
                  <path
                      
                      d="M 406.726562 265.785156 L 373.277344 246.476562 L 373.277344 207.859375 L 406.726562 188.550781 L 440.175781 207.859375 L 440.175781 246.476562 Z M 376.003906 244.898438 L 406.726562 262.625 L 437.445312 244.898438 L 437.445312 209.367188 L 406.726562 191.636719 L 376.003906 209.367188 Z M 376.003906 244.898438 "
                  />
                  <path
                      
                      d="M 438.8125 210.371094 L 405.363281 191.0625 L 405.363281 152.445312 L 438.8125 133.140625 L 472.257812 152.445312 L 472.257812 191.0625 Z M 408.089844 189.554688 L 438.8125 207.285156 L 469.53125 189.554688 L 469.53125 154.027344 L 438.8125 136.296875 L 408.089844 154.027344 Z M 408.089844 189.554688 "
                  />
                  <path
                      
                      d="M 470.96875 155.03125 L 437.519531 135.722656 L 437.519531 97.105469 L 470.96875 77.796875 L 504.414062 97.105469 L 504.414062 135.722656 Z M 440.175781 134.144531 L 470.894531 151.871094 L 501.617188 134.144531 L 501.617188 98.613281 L 470.894531 80.882812 L 440.175781 98.613281 Z M 440.175781 134.144531 "
                  />
                  <path
                      
                      d="M 503.050781 99.617188 L 469.601562 80.308594 L 469.601562 41.695312 L 503.050781 22.386719 L 536.5 41.695312 L 536.5 80.308594 Z M 472.257812 78.804688 L 502.980469 96.53125 L 533.699219 78.804688 L 533.699219 43.273438 L 502.980469 25.542969 L 472.257812 43.273438 Z M 472.257812 78.804688 "
                  />
                  <path
                      
                      d="M 535.136719 44.277344 L 501.6875 24.96875 L 501.6875 -13.648438 L 535.136719 -32.953125 L 568.585938 -13.648438 L 568.585938 24.96875 Z M 504.34375 23.390625 L 535.066406 41.121094 L 565.855469 23.390625 L 565.855469 -12.066406 L 535.136719 -29.867188 L 504.414062 -12.140625 L 504.414062 23.390625 Z M 504.34375 23.390625 "
                  />
                  <g clip-rule="nonzero" clip-path="url(#717d2231e0)">
                      <path
                          
                          d="M 374.640625 210.371094 L 341.191406 191.0625 L 341.191406 152.445312 L 374.640625 133.140625 L 408.089844 152.445312 L 408.089844 191.0625 Z M 343.847656 189.554688 L 374.570312 207.285156 L 405.363281 189.554688 L 405.363281 154.027344 L 374.640625 136.296875 L 343.847656 154.027344 Z M 343.847656 189.554688 "
                      />
                  </g>
                  <path
                      
                      d="M 438.8125 99.617188 L 405.363281 80.308594 L 405.363281 41.695312 L 438.8125 22.386719 L 472.257812 41.695312 L 472.257812 80.308594 Z M 408.089844 78.804688 L 438.8125 96.53125 L 469.53125 78.804688 L 469.53125 43.273438 L 438.8125 25.542969 L 408.089844 43.273438 Z M 408.089844 78.804688 "
                  />
                  <path
                      
                      d="M 470.96875 265.785156 L 437.519531 246.476562 L 437.519531 207.859375 L 470.96875 188.550781 L 504.414062 207.859375 L 504.414062 246.476562 Z M 440.175781 244.898438 L 470.894531 262.625 L 501.617188 244.898438 L 501.617188 209.367188 L 470.894531 191.636719 L 440.175781 209.367188 Z M 440.175781 244.898438 "
                  />
                  <path
                      
                      d="M 503.050781 210.371094 L 469.601562 191.0625 L 469.601562 152.445312 L 503.050781 133.140625 L 536.5 152.445312 L 536.5 191.0625 Z M 472.257812 189.554688 L 502.980469 207.285156 L 533.699219 189.554688 L 533.699219 154.027344 L 502.980469 136.296875 L 472.257812 154.027344 Z M 472.257812 189.554688 "
                  />
                  <path
                      
                      d="M 535.136719 155.03125 L 501.6875 135.722656 L 501.6875 97.105469 L 535.136719 77.796875 L 568.585938 97.105469 L 568.585938 135.722656 Z M 504.34375 134.144531 L 535.066406 151.871094 L 565.785156 134.144531 L 565.785156 98.613281 L 535.066406 80.882812 L 504.34375 98.613281 Z M 504.34375 134.144531 "
                  />
                  <path
                      
                      d="M 567.222656 99.617188 L 533.773438 80.308594 L 533.773438 41.695312 L 567.222656 22.386719 L 600.667969 41.695312 L 600.667969 80.308594 Z M 536.5 78.804688 L 567.222656 96.53125 L 597.941406 78.804688 L 597.941406 43.273438 L 567.222656 25.542969 L 536.5 43.273438 Z M 536.5 78.804688 "
                  />
                  <path
                      
                      d="M 599.304688 44.277344 L 565.855469 24.96875 L 565.855469 -13.648438 L 599.304688 -32.953125 L 632.753906 -13.648438 L 632.753906 24.96875 Z M 568.585938 23.390625 L 599.304688 41.121094 L 630.027344 23.390625 L 630.027344 -12.066406 L 599.304688 -29.867188 L 568.585938 -12.140625 Z M 568.585938 23.390625 "
                  />
                  <path
                      
                      d="M 567.222656 210.371094 L 533.773438 191.0625 L 533.773438 152.445312 L 567.222656 133.140625 L 600.667969 152.445312 L 600.667969 191.0625 Z M 536.5 189.554688 L 567.222656 207.285156 L 597.941406 189.554688 L 597.941406 154.027344 L 567.222656 136.296875 L 536.5 154.027344 Z M 536.5 189.554688 "
                  />
                  <g clip-rule="nonzero" clip-path="url(#e64a9e9d83)">
                      <path
                          
                          d="M 631.460938 99.617188 L 598.015625 80.308594 L 598.015625 41.695312 L 631.460938 22.386719 L 664.910156 41.695312 L 664.910156 80.308594 Z M 600.667969 78.804688 L 631.390625 96.53125 L 662.109375 78.804688 L 662.109375 43.273438 L 631.390625 25.542969 L 600.667969 43.273438 Z M 600.667969 78.804688 "
                      />
                  </g>
              </g>
          </svg>
        </div>
    </div>

       <!-- Bob the entire marquee vertically -->
     

    <!-- Foreground Content -->
    <div class="relative z-60 flex flex-col items-start justify-center p-3 pt-32 lg:pt-20">
      <h2 class="font-semibold text-black uppercase text-8xl">2025</h2>
      <h1 class="tracking-[5px] text-5xl uppercase font-bold text-black leading-tight">
        The Asian Literary <br> Festival
      </h1>
      {{-- <h2 class="font-semibold tracking-[10px] text-black uppercase text-3xl">Gampaha</h2> --}}
    </div>

  </div>
  
   <div class="bg-transparent">
        <div  class=" relative flex pb-24 flex-wrap bg-white z-[1000] bg-opacity-50 backdrop-blur-xl bg-transparent items-start justify-end px-6 ">
          <div class="w-full lg:w-6/12">
              <div class="">
                  <div class=" mx-auto px-4 text-center py-6">
                          @if($nextFestival)
                              <h1 class="text-4xl md:text-5xl uppercase font-extrabold text-active-purple mb-4 animate-pulse">{{$nextFestival->title}}</h1>
                              <p class="text-xl md:text-xl uppercase font-extrabold text-active-purple mb-4 animate-pulse"></p>
                              <h2 class="font-semibold text-black uppercase text-3xl">
                                  {{ \Carbon\Carbon::parse($nextFestival->start_at)->format('jS F Y') }}
                              </h2>

                              <h1 class="tracking-[10px] text-3xl uppercase font-bold text-black leading-tight">
                                    {{ $nextFestival->location }}
                              </h1>
                              <div class="flex flex-wrap justify-center gap-4 py-12" id="countdown">
                                  <div class="bg-white/50 backdrop-blur-sm rounded-xl p-4">
                                      <span class="text-5xl font-bold text-black" id="days"></span>
                                      <p class="text-black mb-0">Days</p>
                                  </div>
                                  <div class="bg-white/50 backdrop-blur-sm rounded-xl p-4">
                                      <span class="text-5xl font-bold text-black" id="hours"></span>
                                      <p class="text-black mb-0">Hours</p>
                                  </div>
                                  <div class="bg-white/50 backdrop-blur-sm rounded-xl p-4">
                                      <span class="text-5xl font-bold text-black" id="minutes"></span>
                                      <p class="text-black mb-0">Minutes</p>
                                  </div>
                                  <div class="bg-white/50 backdrop-blur-sm rounded-xl p-4">
                                      <span class="text-5xl font-bold text-black" id="seconds"></span>
                                      <p class="text-black mb-0">Seconds</p>
                                  </div>
                              </div>
                          @else
                              <h2 class="text-active-purple uppercase text-5xl">Coming Soon</h2>
                          @endif

                          <div class="flex justify-center items-center lg:mt-6">
                              <register-now-modal></register-now-modal>
                          </div>
                          
                      </div>
              </div>
          </div>
          
          <div class="w-full lg:w-6/12">
            <h2 class="font-semibold text-black uppercase text-start text-7xl">It Isn't a Luxury…</h2>
              <h1 class="tracking-[10px] text-4xl uppercase font-bold text-black leading-tight">
                  Bridging Worlds Through Words
              </h1>
          <h2 class="font-semibold tracking-[10px] text-black uppercase text-3xl mt-5"></h2>
          <p class="text-gray-700 text-justify">Literature is the lifeblood of human understanding, the bridge between hearts and minds across all divides. The Asian Literary Festival Gampaha, the island's first free literary celebration, serves as the epicentre where writers, thinkers, and artists from across the globe converge with Sri Lanka's local literary voices, fostering dynamic cross-fertilisation.
            Set in Gampaha—birthplace of numerous Sri Lankan creative luminaries—this festival transforms literary engagement from privilege to public right, celebrating the power of storytelling to unite, inspire, and transform communities across cultural and linguistic boundaries.
        </p>
          </div>
      </div>
    </div>

</section>

<section class="w-full md:hidden max-w-screen-2xl -mt-6 mx-auto relative">
  <!-- Container for layers -->
  <div class="relative w-full z-0 rounded-3 min-h-[100vh]">

    <!-- Layer 5: Farthest Background -->
    <div class="parallax-layer absolute z-50 w-full bottom-0" data-speed="0.2">
      <img src="{{ asset('assets/img/layer-005.webp') }}" class="w-full object-contain" alt="Layer 5">
    </div>
    
    <!-- Layer 4 -->
    <div class="parallax-layer absolute z-40 w-full bottom-0" data-speed="0.3">
      <img src="{{ asset('assets/img/layer-004.webp') }}" class="w-full object-contain" alt="Layer 4">
    </div>

    <!-- Layer 3: Looping layer -->
    <div class="parallax-layer absolute z-30 -bottom-5 w-full overflow-hidden" data-speed="0.3">
      <img src="{{ asset('assets/img/layer-002.webp') }}" class="w-full bob-y -mb-2 object-contain" alt="Layer 2">

      <!-- Bob the entire marquee vertically -->
      <div class="loop-viewport " style="--bob-amp:12px; --bob-dur:5s">
        <div class="loop-track">
          <div class="loop-group">
            <img src="{{ asset('assets/img/layer-003.webp') }}" alt="Layer 3">
            <img src="{{ asset('assets/img/layer-003.webp') }}" alt="Layer 3">
            <img src="{{ asset('assets/img/layer-003.webp') }}" alt="Layer 3">
            <img src="{{ asset('assets/img/layer-003.webp') }}" alt="Layer 3">
          </div>
          <div class="loop-group" aria-hidden="true">
            <img src="{{ asset('assets/img/layer-003.webp') }}" alt="Layer 3">
            <img src="{{ asset('assets/img/layer-003.webp') }}" alt="Layer 3">
            <img src="{{ asset('assets/img/layer-003.webp') }}" alt="Layer 3">
            <img src="{{ asset('assets/img/layer-003.webp') }}" alt="Layer 3">
          </div>
        </div>
      </div>
    </div>

    <!-- Layer 1: Foreground -->
    <div class="parallax-layer absolute z-10 w-full bottom-12" data-speed="0.3">
      <img src="{{ asset('assets/img/layer-001.webp') }}" class="w-full object-contain" alt="Layer 1">
    </div>

    <div class="parallax-layer absolute z-20 w-full top-20" data-speed="0.3">
        <img src="{{ asset('assets/img/top-layer-new.webp') }}" class="w-full object-contain" alt="Buildings">
    </div>

    <!-- Foreground Content -->
    <div class="relative z-60 flex flex-col items-start justify-center p-3 pt-32 lg:pt-28">
      <h2 class="font-semibold text-black uppercase text-8xl">2025</h2>
      <h1 class="tracking-[5px] text-5xl uppercase font-bold text-black leading-tight">
        The Asian Literary <br> Festival
      </h1>
      {{-- <h2 class="font-semibold tracking-[10px] text-black uppercase text-3xl">Gampaha</h2> --}}
    </div>

  </div>
  
   <div class="bg-transparent">
        <div  class=" relative flex pb-24 flex-wrap bg-white z-[1000] bg-opacity-50 backdrop-blur-xl bg-transparent items-start justify-end px-6 lg:px-12 pt-36">
          <div class="w-full lg:w-6/12">
               <div class="">
                    <div class=" mx-auto px-4 text-center py-6">
                            @if($nextFestival)
                                <h1 class="text-4xl md:text-5xl uppercase font-extrabold text-active-purple mb-4 animate-pulse">{{$nextFestival->title}}</h1>
                                <p class="text-xl md:text-xl uppercase font-extrabold text-active-purple mb-4 animate-pulse"></p>
                                <h2 class="font-semibold text-black uppercase text-3xl">
                                    {{ \Carbon\Carbon::parse($nextFestival->start_at)->format('jS F Y') }}
                                </h2>

                                <h1 class="tracking-[5px] text-xl uppercase font-bold text-black leading-tight">
                                     {{ $nextFestival->location }}
                                </h1>
                                <div class="flex flex-wrap justify-center gap-2 py-6 lg:py-12" id="countdown-mobile">
                                    <div class="bg-white/50 backdrop-blur-sm rounded-xl p-2">
                                        <span class="text-xl font-bold text-black" id="days-mobile"></span>
                                        <p class="text-black text-sm mb-0">Days</p>
                                    </div>
                                    <div class="bg-white/50 backdrop-blur-sm rounded-xl p-2">
                                        <span class="text-xl font-bold text-black" id="hours-mobile"></span>
                                        <p class="text-black text-sm mb-0">Hours</p>
                                    </div>
                                    <div class="bg-white/50 backdrop-blur-sm rounded-xl p-2">
                                        <span class="text-xl  font-bold text-black" id="minutes-mobile"></span>
                                        <p class="text-black text-sm mb-0">Mins</p>
                                    </div>
                                    <div class="bg-white/50 backdrop-blur-sm rounded-xl p-2">
                                        <span class="text-xl font-bold text-black" id="seconds-mobile"></span>
                                        <p class="text-black text-sm mb-0">Secs</p>
                                    </div>
                                </div>
                            @else
                                <h2 class="text-active-purple uppercase text-5xl">Coming Soon</h2>
                            @endif

                            <div class="flex justify-center items-center mt-6">
                                <register-now-modal></register-now-modal>
                            </div>
                            
                        </div>
               </div>
          
          <div class="w-full lg:w-6/12">
            <h2 class="font-semibold text-black uppercase text-start lg:text-7xl mb-3 text-5xl">It Isn't a Luxury…</h2>
              <h1 class="lg:tracking-[10px] tracking-[6px] lg:text-4xl text-xl uppercase font-bold text-black leading-tight">
                  Bridging Worlds Through Words
              </h1>
          <h2 class="font-semibold tracking-[10px] text-black uppercase text-3xl mt-5"></h2>
          <p class="text-gray-700 text-justify">Literature is the lifeblood of human understanding, the bridge between hearts and minds across all divides. The Asian Literary Festival Gampaha, the island's first free literary celebration, serves as the epicentre where writers, thinkers, and artists from across the globe converge with Sri Lanka's local literary voices, fostering dynamic cross-fertilisation.
            Set in Gampaha—birthplace of numerous Sri Lankan creative luminaries—this festival transforms literary engagement from privilege to public right, celebrating the power of storytelling to unite, inspire, and transform communities across cultural and linguistic boundaries.
        </p>
          </div>
      </div>
    </div>

</section>


<section class="w-full max-w-screen-2xl mx-auto">
  <vision-mission
    eyebrow="Who We Are"
    title="Our Vision & Mission"
    subtitle="Bridging worlds through words."
    vision-image="{{ asset('assets/img/kipenzi-art.webp') }}"
    mission-image="{{ asset('assets/img/story.webp') }}"
    :vision-points="['Champion free access', 'Inspire cross-cultural dialogue', 'Nurture future storytellers']"
    :mission-points="['Inclusive programs & workshops', 'Multilingual participation', 'Community-driven initiatives']"
    accent="active-purple"
  ></vision-mission>
</section>




<section class="relative w-full max-w-screen-2xl mx-auto">

    <festival-locations></festival-locations>

</section>

<section class="relative w-full max-w-screen-2xl mx-auto">

    <speakers-carousel></speakers-carousel>

</section>

<section class="relative w-full max-w-screen-2xl mx-auto">

    <div class="w-full bg-yellow-50 p-3 flex items-center flex-wrap">
        <div class="lg:w-2/12 w-full">
            <div class="aspect-w-1 aspect-h-1  w-full h-56">
                <video autoplay muted loop playsinline class="w-full  h-full object-contain rounded-xl">
                    <source src="{{ asset('/assets/img/gog-big.webm') }}" type="video/webm">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
        <div class="lg:w-10/12 w-full">
            <p class="text-lg text-black font-semibold">Our conference is proudly pet-friendly and family-friendly, creating a warm, inclusive space for everyone. Whether you're attending with children or furry companions, you're welcome here. We believe innovation thrives in joyful, supportive environments—so come as you are, bring your whole family, and feel at home.</p>
        </div>
    </div>

</section>

<section class="w-full max-w-screen-2xl  mt-6 mx-auto">

    <div class=" px-4 py-2 mb-5">
      <h1 class="lg:text-6xl text-3xl text-black font-extrabold tracking-widest uppercase text-center">
        Our Ecosystem
      </h1>
    </div>

    <our-ecosystem></our-ecosystem>
   
</section>





<section class="w-full max-w-screen-2xl mx-auto">

    <our-partners></our-partners>

</section>

<section class="w-full max-w-screen-2xl mx-auto">

    <up-coming-festivals></up-coming-festivals>

</section>

<section class="w-full max-w-screen-2xl  mt-6 mx-auto">

    <latest-news></latest-news>
   
</section>


<section class="w-full max-w-screen-2xl  mt-6 mx-auto">

    {{-- <div class="w-full mb-10">

      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31675.06777531941!2d79.99171349917356!3d7.081464785533528!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2fb67a22e72d9%3A0x913a2c56a49c8d8e!2sGampaha!5e0!3m2!1sen!2slk!4v1754677061475!5m2!1sen!2slk" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div> --}}

    <usefull-links></usefull-links>
   
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var countDownDate = new Date("{{ $nextFestival->start_at }}").getTime();

        var countdownFunction = setInterval(function () {
            var now = new Date().getTime();
            var timeLeft = countDownDate - now;

            if (timeLeft > 0) {
                var days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                var hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                const ids = ["days", "days-mobile"];
                const hoursIds = ["hours", "hours-mobile"];
                const minutesIds = ["minutes", "minutes-mobile"];
                const secondsIds = ["seconds", "seconds-mobile"];

                ids.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.innerText = days;
                });
                hoursIds.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.innerText = hours;
                });
                minutesIds.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.innerText = minutes;
                });
                secondsIds.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.innerText = seconds;
                });

            } else {
                clearInterval(countdownFunction);
                const cd1 = document.getElementById("countdown");
                const cd2 = document.getElementById("countdown-mobile");
                if (cd1) cd1.innerHTML = "<h2 class='text-white text-2xl'>Festival has started!</h2>";
                if (cd2) cd2.innerHTML = "<h2 class='text-white text-2xl'>Festival has started!</h2>";
            }
        }, 1000);
    });
</script>
@endpush