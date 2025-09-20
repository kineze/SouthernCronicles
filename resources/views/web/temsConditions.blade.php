@extends('layouts.web.app')

@section('content')

<section class="w-full max-w-screen-2xl  -mt-6 mx-auto p-3">
   
   <div class="w-full rounded-xl bg-cover bg-top">
      <div class="w-full rounded-xl bg-cover  bg-top z-[200] py-8 px-4 lg:pl-5">
        <div class='w-full rounded-xl rounded-bl-none bg-transparent flex bg-cover items-start'>
            <div class="relative z-30 flex flex-col items-start justify-center pt-12">
                <h2 class="font-bold text-primary-blue uppercase text-8xl">2026</h2>
                <h1 class="tracking-[8px] lg:text-5xl text-4xl uppercase font-bold pt-3 text-primary-blue leading-tight">
                    Southern <br>Chronicles
                </h1>
                <h2 class="font-semibold tracking-[10px] text-primary-blue uppercase text-3xl"></h2>
                            {{-- <img src="{{ asset('assets/img/sou-logo.webp')}}" alt="" class="w-48 lg:w-72 object-contain"> --}}
            </div>
        </div>
    </div>


        <terms-conditions></terms-conditions>

    </div>
</section>

@endsection