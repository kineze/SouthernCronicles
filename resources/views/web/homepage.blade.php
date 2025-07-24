@extends('layouts.web.app')

@section('content')
    
<section class="w-full max-w-screen-2xl  -mt-6 mx-auto p-3">
   
   <div class="w-full rounded-xl bg-contain" style="background-image: url({{asset('/assets/img/bg-image.png')}})">
    <div class='w-full rounded-xl rounded-bl-none bg-transparent flex bg-cover items-end min-h-[70vh]'>
        <div class="w-full lg:px-6 px-3 flex items-center justify-start">
            
            

        </div>
    </div>

    <div class="w-full flex  bg-transparent justify-between">

        <div class="w-full flex justify-center  -mt-80 items-end px-6 lg:w-6/12">

                {{-- <div class="w-full bg-white bg-opacity-30 backdrop-blur-2xl text- shadow-2xl h-96 -mb-24  p-6 rounded-2xl">
                    <h1 class="text-5xl text-center text-black font-bold uppercase">Asian Literary Festival</h1>
                    <h2 class="text-3xl text-center text-black font-bold uppercase">- Brussels -</h2>
                    
                </div> --}}

        </div>

        <div class=" bg-white rounded-ss-3xl w-full flex justify-end p-6 lg:w-6/12">
            <h1 class='text-8xl text-black font-bold'>2025</h1>
        </div>
    </div>
    </div>
</section>

@endsection