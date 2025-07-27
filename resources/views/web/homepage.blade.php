@extends('layouts.web.app')

@section('content')

<section class="w-full hidden md:block max-w-screen-2xl -mt-6 mx-auto relative" >
    <!-- Container for layers -->
    <div class="relative w-full z-0 rounded-3 min-h-[120vh]">

        <!-- Layer 1: Background Skyline -->
        <div class="parallax-layer absolute z-10 bottom-32 overflow-hidden w-full" data-speed="0.6">
            <div class="loop-container animate-loop-x ">
                <img src="{{ asset('assets/img/skyline-final.webp') }}" alt="Skyline">
                <img src="{{ asset('assets/img/skyline-final.webp') }}" alt="Skyline">
                <img src="{{ asset('assets/img/skyline-final.webp') }}" alt="Skyline">
                <img src="{{ asset('assets/img/skyline-final.webp') }}" alt="Skyline">
            </div>
        </div>

         <div class="parallax-layer absolute z-20 w-full top-0" data-speed="0.3">
            <img src="{{ asset('assets/img/top-layer-new.webp') }}" class="w-full object-contain" alt="Buildings">
        </div>

        <!-- Layer 2: Mid layer -->
        <div class="parallax-layer absolute z-20 w-full bottom-44" data-speed="0.3">
            <img src="{{ asset('assets/img/layer-3-new.webp') }}" class="w-full object-contain" alt="Buildings">
        </div>

        <!-- Foreground Content -->
        <div class="relative z-30 flex flex-col items-start justify-center px-6  pt-28">
            <h2 class="font-semibold text-black uppercase text-8xl">2025</h2>
            <h1 class="tracking-[10px] text-5xl uppercase font-bold text-black leading-tight">
                The Asian Literary <br> Festival
            </h1>
            <h2 class="font-semibold tracking-[10px] text-black uppercase text-3xl">Brussels</h2>
        </div>
        
    </div>

      <div class="">
         <div  class=" relative flex pb-24 flex-wrap bg-white z-[1000] bg-opacity-30 backdrop-blur-xl rounded-3xl  bg-transparent items-start justify-end px-6 lg:px-12 pt-36">
           <div class="w-full lg:w-6/12">
               <div class="">
                    <div class=" mx-auto px-4 text-center py-6">
                            @if($nextFestival)
                                <h1 class="text-4xl md:text-5xl uppercase font-extrabold text-active-purple mb-4 animate-pulse">{{$nextFestival->title}}</h1>
                                <p class="text-xl md:text-xl uppercase font-extrabold text-active-purple mb-4 animate-pulse"></p>
                                <h2 class="font-semibold text-black uppercase text-3xl">
                                    {{ \Carbon\Carbon::parse($nextFestival->start_at)->format('jS') }}
                                    to
                                    {{ \Carbon\Carbon::parse($nextFestival->end_at)->format('jS F Y') }}
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
             <h2 class="font-semibold text-black uppercase text-start text-8xl">About</h2>
                <h1 class="tracking-[10px] text-4xl uppercase font-bold text-black leading-tight">
                    The Asian Literary <br> Festival - Brussels
                </h1>
            <h2 class="font-semibold tracking-[10px] text-black uppercase text-3xl mt-5"></h2>
            <p class="text-gray-700"> The Asian Literature Festival in Brussels is a vibrant celebration of the rich and diverse literary traditions from across Asia. Our mission is to bridge cultures, foster understanding, and showcase the incredible talent of Asian authors, poets, and storytellers. Through engaging readings, insightful discussions, and interactive workshops, we invite you to explore the captivating narratives and profound perspectives that define Asian literature. Join us in Brussels to connect with authors.</p>
           </div>
        </div>
    </div>
</section>

<section class="w-full md:hidden max-w-screen-2xl -mt-6 mx-auto relative" >
    <!-- Container for layers -->
    <div class="relative w-full z-0 rounded-3 min-h-screen md:min-h-[120vh]">

        <!-- Layer 1: Background Skyline -->
        <div class="parallax-layer absolute z-10 bottom-0 overflow-hidden w-full" data-speed="0.2">
            <div class="loop-container-mobile animate-loop-x ">
                <img src="{{ asset('assets/img/skyline-final.webp') }}" alt="Skyline">
                <img src="{{ asset('assets/img/skyline-final.webp') }}" alt="Skyline">
                <img src="{{ asset('assets/img/skyline-final.webp') }}" alt="Skyline">
                <img src="{{ asset('assets/img/skyline-final.webp') }}" alt="Skyline">
            </div>
        </div>

         <div class="parallax-layer absolute z-20 w-full top-24" data-speed="0.1">
            <img src="{{ asset('assets/img/top-layer-new.webp') }}" class="w-full object-contain" alt="Buildings">
        </div>

        <!-- Layer 2: Mid layer -->
        <div class="parallax-layer absolute z-20 w-full bottom-10" data-speed="0.1">
            <img src="{{ asset('assets/img/layer-3-new.webp') }}" class="w-full object-contain" alt="Buildings">
        </div>

        <!-- Foreground Content -->
        <div class="relative z-30 flex flex-col items-start justify-center p-3 pt-32 lg:pt-28">
            <h2 class="font-semibold text-black uppercase text-8xl">2025</h2>
            <h1 class="tracking-[5px] text-5xl uppercase font-bold text-black leading-tight">
                The Asian Literary <br> Festival
            </h1>
            <h2 class="font-semibold tracking-[10px] text-black uppercase text-3xl">Brussels.</h2>
        </div>
        
    </div>

      <div class="">
         <div  class=" relative flex pb-24 flex-wrap bg-white z-[1000] bg-opacity-30 backdrop-blur-xl rounded-3xl  bg-transparent items-start justify-end px-6 lg:px-12 pt-12 lg:pt-36">
           <div class="w-full lg:w-6/12">
               <div class="">
                    <div class=" mx-auto px-4 text-center py-6">
                            @if($nextFestival)
                                <h1 class="text-4xl md:text-5xl uppercase font-extrabold text-active-purple mb-4 animate-pulse">{{$nextFestival->title}}</h1>
                                <p class="text-xl md:text-xl uppercase font-extrabold text-active-purple mb-4 animate-pulse"></p>
                                <h2 class="font-semibold text-black uppercase text-3xl">
                                    {{ \Carbon\Carbon::parse($nextFestival->start_at)->format('jS') }}
                                    to
                                    {{ \Carbon\Carbon::parse($nextFestival->end_at)->format('jS F Y') }}
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
           </div>
           
            <div class="w-full lg:w-6/12">
             <h2 class="font-semibold text-black text-center uppercase md:text-start text-3xl md:text-8xl">About</h2>
                <h1 class="tracking-[5px] text-xl uppercase text-center md:text-start font-bold text-black leading-tight">
                    The Asian Literary <br> Festival 
                </h1>
            <h2 class="font-semibold tracking-[10px] text-black text-center md:text-start uppercase text-xl">Brussels.</h2>
            <p class="text-justify md:text-left"> The Asian Literature Festival in Brussels is a vibrant celebration of the rich and diverse literary traditions from across Asia. Our mission is to bridge cultures, foster understanding, and showcase the incredible talent of Asian authors, poets, and storytellers. Through engaging readings, insightful discussions, and interactive workshops, we invite you to explore the captivating narratives and profound perspectives that define Asian literature. Join us in Brussels to connect with authors.</p>
           </div>
        </div>
    </div>
</section>


<section class="relative w-full max-w-screen-2xl mx-auto">

    <speakers-carousel></speakers-carousel>

</section>

<section class="relative w-full max-w-screen-2xl mx-auto">

    <div class="w-full flex items-center flex-wrap">
        <div class="lg:w-2/12 w-full">
            <div class="aspect-w-1 aspect-h-1 w-full h-44">
                <video autoplay muted loop playsinline class="w-full h-full object-contain rounded-xl">
                    <source src="{{ asset('/assets/img/Dog walking.mp4') }}" type="video/webm">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
        <div class="lg:w-10/12 w-full">
            <p class="text-xl font-semibold">Our conference is proudly pet-friendly and family-friendly, creating a warm, inclusive space for everyone. Whether you're attending with children or furry companions, you're welcome here. We believe innovation thrives in joyful, supportive environments—so come as you are, bring your whole family, and feel at home.</p>
        </div>
    </div>

</section>

<section class="w-full max-w-screen-2xl  mt-6 mx-auto">

    <div class="bg-black px-4 py-2 mb-5">
      <h1 class="lg:text-6xl text-3xl text-white font-extrabold tracking-widest uppercase text-center">
        Our Ecosystem
      </h1>
    </div>

    <our-ecosystem></our-ecosystem>
   
</section>

<section class="w-full max-w-screen-2xl mx-auto">

    <our-partners></our-partners>

</section>

<section class="w-full max-w-screen-2xl  mt-6 mx-auto">

    <div class="w-full mb-10">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2519.268017319651!2d4.352317977181306!3d50.84472097167016!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c3c554d1953e11%3A0x2e24f524a97148fd!2sGalerie%20Bortier!5e0!3m2!1sen!2slk!4v1753439188989!5m2!1sen!2slk"
        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
      ></iframe>
    </div>

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