@extends('layouts.web.app')

@section('content')
    
<section class="w-full max-w-screen-2xl  -mt-6 mx-auto p-3">
   
   <div class="w-full rounded-xl bg-cover bg-top"  style="background-image: url({{asset('assets/img/brussels-skyline.webp')}})">
    <div class='w-full rounded-xl rounded-bl-none  bg-transparent flex bg-cover items-start min-h-[90vh]'>
        <div class="relative w-full lg:px-6 px-3 flex items-ceter justify-start">
            
            <div class="w-full py-6 mt-12">
                <h2 class=" font-semibold text-black uppercase text-8xl">2025</h2>
                <h1 class="w-full tracking-[10px] text-5xl uppercase font-bold text-black">Asian Literary <br> Festival</h1>
                <h2 class=" font-semibold tracking-[10px] text-black uppercase text-3xl">Brussels.</h2>
            
            </div>
            
            <div class="absolute z-10 bottom-0 w-full">
                <img src="{{asset('assets/img/')}}" alt="">
            </div>
        </div>
    </div>

    <div class="w-full flex  bg-transparent justify-between">

        <div class="w-full flex justify-center  items-end px-6 lg:w-6/12">

                {{-- <div class="w-full bg-white bg-opacity-30 backdrop-blur-2xl text- shadow-2xl h-96 -mb-24  p-6 rounded-2xl">
                    <h1 class="text-5xl text-center text-black font-bold uppercase">Asian Literary Festival</h1>
                    <h2 class="text-3xl text-center text-black font-bold uppercase">- Brussels -</h2>
                    
                </div> --}}

        </div>

        <div class="  rounded-ss-3xl w-full flex justify-end p-6 lg:w-6/12">
            {{-- <h1 class='text-8xl text-black font-bold'>2025</h1> --}}
        </div>
    </div>
    </div>
</section>

@endsection