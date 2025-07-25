@extends('layouts.web.app')

@section('content')
<section class="w-full max-w-screen-2xl  -mt-6 mx-auto p-3 relative">
    <!-- Container for layers -->
    <div class="relative w-full z-0 rounded-3  min-h-[120vh]">

        <!-- Layer 1: Background Skyline -->
        <div class="parallax-layer absolute z-10 w-full bottom-32" data-speed="0.6">
            <img src="{{ asset('assets/img/skyline-final.webp') }}" class="w-full object-contain" alt="Skyline">
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

      <div class="h-screen bg-transparent">
         <div class="relative z-30 flex flex-col bg-transparent items-start justify-end px-6 lg:mx-12 mt-28">
            <h2 class="font-semibold text-black uppercase text-end text-8xl">About</h2>
            <h1 class="tracking-[10px] text-5xl uppercase font-bold text-black leading-tight">
                Asian Literary <br> Festival
            </h1>
            <h2 class="font-semibold tracking-[10px] text-black uppercase text-3xl">Brussels.</h2>
        </div>
    </div>
</section>


<section class="w-full max-w-screen-2xl  -mt-6 mx-auto p-3">

    <speakers-carousel></speakers-carousel>

</section>

@endsection
