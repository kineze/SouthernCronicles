@extends('layouts.web.app')

@section('content')
<section class="w-full max-w-screen-2xl  -mt-6 mx-auto p-3 relative" >
    <!-- Container for layers -->
    <div class="relative w-full z-0 rounded-3   min-h-[120vh]">

        <!-- Layer 1: Background Skyline -->
    <div class="parallax-layer absolute z-10 bottom-32 overflow-hidden w-full" data-speed="0.6">
        <div class="loop-container flex w-max animate-loop-x">
            <img src="{{ asset('assets/img/skyline-final.webp') }}" class="w-[80vw] object-contain" alt="Skyline">
            <img src="{{ asset('assets/img/skyline-final.webp') }}" class="w-[80vw] object-contain" alt="Skyline">
            <img src="{{ asset('assets/img/skyline-final.webp') }}" class="w-[80vw] object-contain" alt="Skyline">
        </div>
    </div>

        <!-- Layer 2: Mid layer -->
        <div class="parallax-layer absolute z-20 w-full bottom-44" data-speed="0.3">
            <img src="{{ asset('assets/img/3rd-layer.webp') }}" class="w-full object-contain" alt="Buildings">
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

      <div class="h-[50vh] ">
         <div class=" relative flex flex-wrap bg-white z-[1000] bg-opacity-30 backdrop-blur-xl rounded-3xl  bg-transparent items-start justify-end px-6 lg:px-12 pt-28">
           <div class="w-full lg:w-6/12">
                vcv
           </div>
           
            <div class="w-full lg:w-6/12">
             <h2 class="font-semibold text-black uppercase text-end text-8xl">About</h2>
                <h1 class="tracking-[10px] text-5xl uppercase font-bold text-black leading-tight">
                    Asian Literary <br> Festival
                </h1>
            <h2 class="font-semibold tracking-[10px] text-black uppercase text-3xl">Brussels.</h2>
           </div>
        </div>
    </div>
</section>


<section class="w-full max-w-screen-2xl  mt-6 mx-auto p-3">

    <speakers-carousel></speakers-carousel>

</section>

<section class="w-full max-w-screen-2xl  mt-6 mx-auto p-3">

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
