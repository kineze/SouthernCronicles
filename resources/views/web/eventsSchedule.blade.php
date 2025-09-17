@extends('layouts.web.app')

@section('content')

<section class="w-full max-w-screen-2xl  -mt-6 mx-auto px-3">
   
   <div class="w-full rounded-xl bg-cover bg-top">
        <div class="w-full rounded-xl bg-cover bg-top z-[200] py-9 px-4 lg:pl-10 ">
            <div class='w-full rounded-xl rounded-bl-none bg-transparent flex bg-cover items-start'>
                <div class="relative z-30 flex flex-col items-start justify-center pt-12">
                    <h2 class="font-bold text-black uppercase text-8xl">2026</h2>
                    <h1 class="tracking-[10px] lg:text-5xl text-4xl uppercase font-bold text-black leading-tight">
                        Southern <br>Chronicles
                    </h1>
                    <h2 class="font-semibold tracking-[10px] text-black uppercase text-3xl"></h2>
                </div>
            </div>
        </div>


        <event-schedule :count="10" :increment="5" show-filter="true"></event-schedule>


    </div>


    <div class="mt-6">
        <usefull-links></usefull-links>
    </div>

    
</section>

@endsection