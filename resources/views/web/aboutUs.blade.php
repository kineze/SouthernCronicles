@extends('layouts.web.app')

@section('content')

<section class="w-full max-w-screen-2xl mx-auto p-3">
   
    <div class="w-full rounded-xl bg-cover  bg-top z-[200] py-8 px-4 lg:pl-5">
        <div class='w-full rounded-xl rounded-bl-none bg-transparent flex bg-cover items-start'>
            <div class="relative z-60 flex flex-col items-start justify-center p-3 pt-32 lg:pt-14">
      <h2 class="font-semibold uppercase text-8xl">
        <span class="text-[#F2C39A]">வா</span><span class="text-[#C48A3A]">ன</span><span class="text-[#4F6C9B]">ம்</span>
      </h2>
      <h1 class="tracking-[5px] text-primary-blue text-3xl lg:text-5xl uppercase font-bold  leading-tight">
        The Asian Literary <br> Festival - Jaffna
      </h1>
      <h2 class="font-semibold tracking-[10px]  text-primary-blue uppercase text-xl lg:text-3xl">2026</h2>
      
    </div>
        </div>
    </div>

 
    <div class="">
        <div  class=" relative flex mb-24 flex-wrap items-start  z-[1000] bg-opacity-30 backdrop-blur-xl rounded-3xl  bg-transparent  justify-end pt-12">
           <div class="w-full bg-primary-blue md:sticky py-6 top-5 lg:w-6/12">
               <div class="">
                    <div class=" mx-auto px-4 text-center py-6">

                            <next-count-down :next-festival='@json($nextFestival)'>
                                <template #action>
                                    <register-now-modal></register-now-modal>
                                </template>
                            </next-count-down>
                            
                        </div>
               </div>
           </div>
           
            <div class="w-full px-6 lg:w-6/12">
                <h2 class="font-semibold text-primary-blue uppercase text-start text-8xl">Our Story</h2>
                <h1 class="tracking-[10px] text-4xl uppercase font-bold text-primary-blue leading-tight">
                    The Fastest Growing Global Network of Festivals
                </h1>

                <div class="mt-6 space-y-5 text-gray-800 leading-7 text-justify">
                    <p>
                        Founded by Sri Lankan writer Pramudith D Rupasinghe - a humanitarian diplomat who transitioned into fiction writing after two decades of service across Africa, Asia, and Europe - this movement began with a deep desire to democratise literature and culture.
                    </p>
                    <p>
                        What started as a magazine gradually transformed into a larger collective force through strategic vision and unwavering commitment. From this evolution emerged The Asian Literary Festival - not simply as an event, but as a powerful testament to collaborative creativity transcending borders.
                    </p>
                    <p>
                        At the heart of this journey stands The Asian Review, a Sri Lankan literary magazine that challenged the belief that literature and culture are limited luxuries. From this foundation arose The Asian Group of Literature - now recognised as Asia's largest creative enterprise network, bringing together six distinct creative social enterprises under one shared purpose: every voice matters.
                    </p>
                    <p>
                        Gathering thinkers, writers, artists, activists, and entrepreneurs from across the world, Rupasinghe built a counter-current to the elitist construct that literature belongs only to privileged circles. The Asian Literary Festival became a global people's movement - birthed from the global majority, yet open to the entire world.
                    </p>
                    <p>
                        This vision continues to expand rapidly - evolving into what is poised to become the fastest-growing literary festival network worldwide. Each year, The Asian Literary Festival selects a host city through The Asian Committee - an independent body formed to preserve the festival's democratic ethos and global reach.
                    </p>
                    <p>
                        Today, this rotating celebration travels across Asia, Europe, Africa, and the Americas - concluding annually with interconnected literary gatherings that illuminate continents and cultures through shared creative expression.
                    </p>
                </div>
            </div>
        </div>
    </div>

    </div>
</section>

<section class="w-full max-w-screen-2xl mt-10 mx-auto p-3">

    <div class="bg-white px-4 py-2 mb-5">
      <h1 class="lg:text-6xl text-3xl text-primary-blue font-extrabold tracking-widest uppercase text-center">
       Powered By
      </h1>
    </div>

    <read-more-text></read-more-text>
</section>

{{-- <section class="w-full max-w-screen-2xl  mx-auto p-3">

    <teams-carousel></teams-carousel>

</section> --}}

{{-- <section class="w-full max-w-screen-2xl  mx-auto p-3">

    <next-count-down></next-count-down>

</section> --}}

<section class="w-full max-w-screen-2xl -mt-10 mx-auto p-3">

    <usefull-links></usefull-links>

</section>




@endsection

{{-- @push('scripts')
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
@endpush --}}
