@extends('layouts.web.app')

@section('content')

<section class="w-full max-w-screen-2xl -mt-6 mx-auto relative" >
    <!-- Container for layers -->
    <div class="relative w-full z-0 rounded-3  min-h-[120vh]">

        <!-- Layer 1: Background Skyline -->
        <div class="parallax-layer absolute z-10 bottom-32 overflow-hidden w-full" data-speed="0.6">
            <div class="loop-container animate-loop-x">
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
        <div class="relative z-30 flex flex-col items-start justify-center px-6 lg:px-12 pt-28">
            <h2 class="font-semibold text-black uppercase text-8xl">2025</h2>
            <h1 class="tracking-[10px] text-5xl uppercase font-bold text-black leading-tight">
                Asian Literary <br> Festival
            </h1>
            <h2 class="font-semibold tracking-[10px] text-black uppercase text-3xl">Brussels.</h2>
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
                                    {{ \Carbon\Carbon::parse($nextFestival->start_at)->format('jS F Y') }} <br>     
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
                    
                                                document.getElementById("days").innerText = days;
                                                document.getElementById("hours").innerText = hours;
                                                document.getElementById("minutes").innerText = minutes;
                                                document.getElementById("seconds").innerText = seconds;
                                            } else {
                                                clearInterval(countdownFunction);
                                                document.getElementById("countdown").innerHTML = "<h2 class='text-white text-2xl'>Festival has started!</h2>";
                                            }
                                        }, 1000);
                                    });
                                </script>
                            @else
                                <h2 class="text-active-purple uppercase text-5xl">Coming Soon</h2>
                            @endif

                            <div class="flex justify-center items-center">
                                <a href="{{url('schoolRegister')}}" class="bg-black  text-center text-lg text-white font-semibold flex items-center justify-center py-3 px-3 rounded-lg hover:bg-gray-200 transition duration-300">
                                Register For Free
                                </a>
                            </div>
                            
                        </div>
               </div>
           </div>
           
            <div class="w-full lg:w-6/12">
             <h2 class="font-semibold text-black uppercase text-start text-8xl">About</h2>
                <h1 class="tracking-[10px] text-4xl uppercase font-bold text-black leading-tight">
                    Asian Literary <br> Festival - Brussels
                </h1>
            <h2 class="font-semibold tracking-[10px] text-black uppercase text-3xl">.</h2>
            <p> The Asian Literature Festival in Brussels is a vibrant celebration of the rich and diverse literary traditions from across Asia. Our mission is to bridge cultures, foster understanding, and showcase the incredible talent of Asian authors, poets, and storytellers. Through engaging readings, insightful discussions, and interactive workshops, we invite you to explore the captivating narratives and profound perspectives that define Asian literature. Join us in Brussels to connect with authors.</p>
           </div>
        </div>
    </div>
</section>


<section class="relative w-full max-w-screen-2xl mx-auto">

    <speakers-carousel></speakers-carousel>

</section>

<section class="w-full max-w-screen-2xl mx-auto p-3">

    <our-partners></our-partners>

</section>

<section class="w-full max-w-screen-2xl  mt-6 mx-auto p-3">

    <div class="w-full lg:px-2 mb-10">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2519.268017319651!2d4.352317977181306!3d50.84472097167016!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c3c554d1953e11%3A0x2e24f524a97148fd!2sGalerie%20Bortier!5e0!3m2!1sen!2slk!4v1753439188989!5m2!1sen!2slk"
        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
      ></iframe>
    </div>

    <usefull-links></usefull-links>
   
</section>


@endsection
