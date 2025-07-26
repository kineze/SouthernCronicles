@extends('layouts.web.app')

@section('content')

<section class="w-full max-w-screen-2xl  -mt-6 mx-auto p-3">
   
<div class="w-full rounded-xl bg-cover bg-top">
      <div class='w-full rounded-xl rounded-bl-none  bg-transparent flex bg-cover items-start'>
        <div class="relative z-30 flex flex-col items-start justify-center  pt-24">
            <h2 class="font-semibold text-black uppercase text-7xl">2025</h2>
            <h1 class="tracking-[10px] text-4xl uppercase font-bold text-black leading-tight">
                The Asian Literary <br> Festival
            </h1>
            <h2 class="font-semibold tracking-[10px] text-black uppercase text-2xl">Brussels.</h2>
        </div>
    </div>
</div>

 
   <div class="">
         <div  class=" relative flex pb-12 h-full flex-wrap bg-white z-[1000] bg-opacity-30 backdrop-blur-xl rounded-3xl  bg-transparent items-start justify-end pt-12">
            <div class="w-full lg:w-6/12 p-6 flex bg-black text-white">
             <h2 class="font-semibold h-full  uppercase textstart text-6xl md:text-8xl">The Asian Writing <br> Lab <br><br></h2>

            </div>
            
            <div class="w-full  lg:w-6/12">
                <p class="text-gray-700 py-3 p-6">The Asian Writing Lab forms the creative heart of our festivals, nurturing emerging writers
                to push beyond conventional boundaries and harness the transformative power of
                imagination. This dynamic incubator seamlessly blends stage and classroom into an
                infinite space of collaborative creation.</p>
                <p class="text-gray-700 py-3 px-6">We offer diverse programmes designed to dismantle the barriers that constrain human
                creativity, addressing these challenges with the urgency they deserve. Our experimental
                approach encourages writers to explore uncharted territories of storytelling, discovering
                new forms and voices that challenge traditional frameworks.</p>
                <p class="text-gray-700 py-3 px-6">The Asian Writing Lab is championed by a global network of authors, thinkers, and cultural
                strategists who share our unwavering belief in imagination as a force for change. Together,
                we cultivate a space where emerging voices can flourish and redefine what writing can be.</p>
                <p class="text-gray-700 py-3 px-6">Through this unique fusion of performance and pedagogy, we're not just developing
                writers—we're fostering the next generation of creative revolutionaries who will reshape
                the literary landscape.</p>
           </div>
        </div>
    </div>

    <div >
        <h1 class="lg:text-4xl text-3xl mt-12 lg:mt-4 text-black font-extrabold tracking-widest uppercase text-center">Voices Unbound: Liberating the Next Wave of Asian Writers</h1>
    
        <div class="flex w-full justify-center flex-wrap py-12">
            <div class="lg:w-4/12 w-full">
                <img src="{{asset('/assets/img/kipenzi-art.webp')}}" alt="">
            </div>

            <div class="lg:w-6/12 flex flex-col items-center md:items-start justify-center w-full">
                <img src="{{asset('assets/img/kipenzi-main-logo.webp')}}" class="w-80 p-3" alt="">
                <p class="text-gray-700 text-justify py-3 p-3">Kipenzi reimagines storytelling from the ground up—breaking rules, shattering norms, and daring to explore what lies beyond the expected. Kipenzi’s work defies convention, stretching the very limits of narrative and reshaping how stories can be told. Kipenzi doesn’t just challenge the norms—it reinvents them, opening bold, uncharted paths in literature. This isn’t just innovation—it’s a literary revolution.</p>
                <a href="https://kipenzi.me/all-ebooks" class="flex items-center gap-3 py-3 px-5 border w-fit border-main-blue/80 text-white rounded-full bg-black hover:text-white hover:shadow-lg">Kipenzi Connect</a>

            </div>
        </div>
    
    </div>
</section>

@endsection