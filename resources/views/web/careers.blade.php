@extends('layouts.web.app')

@section('content')

<section class="w-full max-w-screen-2xl  -mt-6 mx-auto px-3">
   
   <div class="w-full rounded-xl bg-cover bg-top">
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


        {{-- <event-schedule :count="10" :increment="5" show-filter="true"></event-schedule> --}}


    </div>


    <div class="mt-6">
        <careers></careers>
    </div>

    
</section>

@endsection