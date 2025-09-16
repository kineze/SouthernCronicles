@extends('layouts.web.app')

@section('content')

<section class="w-full max-w-screen-2xl  -mt-6 mx-auto p-3">
   
   <div class="w-full rounded-xl bg-cover bg-top">
      <div class='w-full rounded-xl rounded-bl-none  bg-transparent flex bg-cover items-start'>
        <div class="relative z-30 flex flex-col items-start justify-center  pt-12">
            <h2 class="font-semibold text-black uppercase text-7xl">2026</h2>
            <h1 class="tracking-[10px] text-4xl uppercase font-bold text-black leading-tight">
                Southern <br>Chronicles
            </h1>
            <h2 class="font-semibold tracking-[10px] text-black uppercase text-3xl">global summit</h2>
        </div>
    </div>


        <booking-now></booking-now>

    </div>


    <usefull-links></usefull-links>

    
</section>

@endsection