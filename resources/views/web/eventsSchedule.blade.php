@extends('layouts.web.app')

@section('content')

<section class="w-full max-w-screen-2xl  -mt-6 mx-auto px-3">
   
   <div class="w-full rounded-xl bg-cover bg-top">
        <div class='w-full rounded-xl rounded-bl-none  bg-transparent flex bg-cover items-start'>
            <div class="relative z-30 flex flex-col items-start justify-center  pt-24">
                <h2 class="font-semibold text-black uppercase text-7xl">2025</h2>
                <h1 class="tracking-[10px] text-4xl uppercase font-bold text-black leading-tight">
                    The Asian Literary <br> Festival
                </h1>
                <h2 class="font-semibold tracking-[10px] text-black uppercase text-2xl">Brussels</h2>
            </div>
        </div>


        <event-schedule></event-schedule>

    </div>


    <div class="mt-6">
        <usefull-links></usefull-links>
    </div>

    
</section>

@endsection