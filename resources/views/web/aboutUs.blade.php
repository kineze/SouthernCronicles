@extends('layouts.web.app')

@section('content')

<section class="w-full max-w-screen-2xl  -mt-6 mx-auto p-3">
   
   <div class="w-full rounded-xl bg-cover bg-top">
        <div class='w-full rounded-xl rounded-bl-none  bg-transparent flex bg-cover items-start'>
            <div class="relative z-30 flex flex-col items-start justify-center  pt-12">
                <h2 class="font-semibold text-black uppercase text-7xl">2026</h2>
                <h1 class="tracking-[10px] text-4xl uppercase font-bold text-black leading-tight">
                    The Asian Literary <br> Festival
                </h1>
                <h2 class="font-semibold tracking-[10px] text-black uppercase text-3xl">global summit</h2>
            </div>
        </div>
    </div>

 
    <div class="hidden md:block">
        <div  class=" relative flex mb-24 flex-wrap items-start  z-[1000] bg-opacity-30 backdrop-blur-xl rounded-3xl  bg-transparent  justify-end pt-12">
           <div class="w-full bg-black md:sticky py-6 top-5 lg:w-6/12">
               <div class="">
                    <div class=" mx-auto px-4 text-center py-6">
                            @if($nextFestival)
                                <h1 class="text-4xl md:text-5xl uppercase font-extrabold text-active-purple mb-4 animate-pulse">{{$nextFestival->title}}</h1>
                                <p class="text-xl md:text-xl uppercase font-extrabold text-active-purple mb-4 animate-pulse"></p>
                                <h2 class="font-semibold text-white uppercase text-3xl">
                                    {{ \Carbon\Carbon::parse($nextFestival->start_at)->format('jS F Y') }}
                                </h2>

                                <h1 class="tracking-[10px] text-3xl uppercase font-bold text-white leading-tight">
                                     {{ $nextFestival->location }}
                                </h1>
                                <div class="flex flex-wrap justify-center gap-4 py-12" id="countdown">
                                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                                        <span class="text-5xl font-bold text-white" id="days"></span>
                                        <p class="text-white mb-0">Days</p>
                                    </div>
                                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                                        <span class="text-5xl font-bold text-white" id="hours"></span>
                                        <p class="text-white mb-0">Hours</p>
                                    </div>
                                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                                        <span class="text-5xl font-bold text-white" id="minutes"></span>
                                        <p class="text-white mb-0">Minutes</p>
                                    </div>
                                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                                        <span class="text-5xl font-bold text-white" id="seconds"></span>
                                        <p class="text-white mb-0">Seconds</p>
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
           
            <div class="w-full px-6 lg:w-6/12">
             <h2 class="font-semibold text-black uppercase text-start text-8xl">Our Story</h2>
                <h1 class="tracking-[10px] text-4xl uppercase font-bold text-black leading-tight">
                    The Fastest Growing Global Network of Festivals
                </h1>
            <h2 class="font-semibold tracking-[10px] text-black uppercase text-3xl mt-5"></h2>
                <p class="text-gray-700 py-3">What began as a humble network of creative social enterprises has blossomed into something extraordinary—a literary revolution that transcends borders, cultures, and conventions. At the heart of this remarkable journey stands The Asian Review, a Sri Lankan literary magazine that dared to dream beyond the traditional confines of literature and culture as a luxury.</p>
                <p class="text-gray-700 py-3">From this foundation emerged The Asian Group of Literature, now recognized as Asia's largest creative enterprise network, comprising six distinct creative social enterprises. Each venture carries forward a singular vision: every voice matters.</p>
                <p class="text-gray-700 py-3">The transformation from magazine to movement crystallized through a partnership with Trogon Global, the UAE-based cultural curation enterprise. Together, they co-created The Asian Literary Festival—not merely as an event, but as a testament to the boundless power of collaborative creativity across continents.</p>
                <p class="text-gray-700 py-3">Three extraordinary minds converged to shepherd this vision into reality. Sabin Iqbal, a journalist-turned-literary curator and novelist, brought his experience creating South India's largest literary festival, the acclaimed Mathrubhumi International Festival of Letters. Pramudith D Rupasinghe, a humanitarian diplomat who turned a fiction writer after two decades of service across Africa, Asia, and Europe. MK Ajay, a celebrated poet with corporate leadership experience spanning East and South Asia, added the bridge between artistic expression and practical vision.</p>
                <p class="text-gray-700 py-3">United by purpose, these founders gathered thinkers, writers, artists and entrepreneurs from around the world, creating a counter-current to the notion that literature and culture belong only to privileged circles. The Asian Literary Festival became a movement extending far beyond like-minded communities—a global story birthed among the people of the global majority, open for the entire world.</p>
                <p class="text-gray-700 py-3">Today, this vision continues to expand, evolving into what promises to become the fastest-growing literary festival network worldwide. Each year, The Asian Literary Festival’s Global Summit is held in Abu-Dabhi concluding its annual roadmap in cities across Asia, Europe, Africa and Americas.</p>
            </div>
        </div>
    </div>
    
        <div class=" md:hidden">
         <div  class=" relative flex pb-24 flex-wrap bg-white z-[1000] bg-opacity-30 backdrop-blur-xl rounded-3xl  bg-transparent items-start justify-end lg:px-12 pt-12 lg:pt-36">
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
           </div>
           
            <div class="w-full lg:w-6/12">
             <h2 class="font-semibold text-black text-center uppercase md:text-start text-3xl md:text-8xl">About</h2>
                <h1 class="tracking-[5px] text-xl uppercase text-center md:text-start font-bold text-black leading-tight">
                   The Fastest Growing Global Network of Festivals
                </h1>
            <h2 class="font-semibold tracking-[10px] text-black text-center md:text-start uppercase text-xl">Gampaha.</h2>
                <p class="text-gray-700 py-3">The Asian Literary Festivals: Where Stories Unite the World Creative expression is humanity's most profound manifestation of diversity—a mirror reflecting our heritage, our souls, and the rich tapestry of human experience. The Asian Literary Festivals serve as the crucible where this diversity fuses into one shared humanity, creating a global stage that celebrates both our unity and our beautiful differences within the human race.</p>
                <p class="text-gray-700 py-3">Co-created by The Asian Group of Literature and Trogon Global, The Asian Literary Festivals represent an inclusive ecosystem anchored by our flagship festival in Abu Dhabi, with satellite festivals flourishing in major cultural centres worldwide. This network creates a year-round celebration of literary and cultural exchange.</p>
                <p class="text-gray-700 py-3">Whether you hail from East or West, North or South, this is your space.</p>
                <p class="text-gray-700 py-3">The Asian Literary Festivals don't just showcase literature—they celebrate the full spectrum of human creativity and connection, and each festival is proudly local in its international network.</p>
                <p class="text-gray-700 py-3">Join us in writing the next chapter of global literary dialogue, where every story matters and every voice contributes to our collective human narrative. The Asian Literary Festival, Gampaha Edition, co-created by The Asian/Trogon festival ecosystem and The Philippine Art and Culture Exchange (PACE), weaves creative expression from the global majority into this vibrant tapestry, transforming the European capital into an unparalleled sanctuary of cultural exchange and cross-fertilisation.</p>
                <p class="text-gray-700 py-3">This festival revives the historical exchanges between East and West, breathing new life into ancient dialogues as literary traditions converge and contemporary voices rise, creating a dynamic crossroads where stories transcend borders and new cultural conversations bloom in this remarkable intersection of civilisations.</p>
            </div>
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

{{-- <section class="w-full max-w-screen-2xl mt-10 mx-auto p-3">

    <div class="bg-white px-4 py-2 mb-5">
      <h1 class="lg:text-6xl text-3xl text-black font-extrabold tracking-widest uppercase text-center">
       Powered By
      </h1>
    </div>

    <read-more-text></read-more-text>
</section> --}}

{{-- <section class="w-full max-w-screen-2xl  mx-auto p-3">

    <teams-carousel></teams-carousel>

</section> --}}

<section class="w-full max-w-screen-2xl  mt-6 mx-auto">

    {{-- <div class=" px-4 py-2 mb-5">
      <h1 class="lg:text-6xl text-3xl text-black font-extrabold tracking-widest uppercase text-center">
        Our Ecosystem
      </h1>
    </div> --}}

    <advisor-carousel></advisor-carousel>
   
</section>



<section class="w-full max-w-screen-2xl  mt-6 mx-auto">

    <div class=" px-4 py-2 mb-5">
      <h1 class="lg:text-6xl text-3xl text-black font-extrabold tracking-widest uppercase text-center">
        Our Ecosystem
      </h1>
    </div>

    <our-ecosystem></our-ecosystem>
   
</section>

{{-- <section class="w-full max-w-screen-2xl  mx-auto p-3">

    <next-count-down></next-count-down>

</section> --}}

<section class="w-full max-w-screen-2xl -mt-10 mx-auto p-3">

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