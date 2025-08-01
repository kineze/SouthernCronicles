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
            <h2 class="font-semibold tracking-[10px] text-black uppercase text-2xl">Brussels</h2>
        </div>
    </div>
</div>

 
   <div class="">
         <div  class=" relative flex pb-12 h-full flex-wrap bg-white z-[1000] bg-opacity-30 backdrop-blur-xl rounded-3xl  bg-transparent items-start justify-end pt-12">
            <div class="w-full lg:w-5/12  justify-between p-6 flex bg-black text-white">
            <div class="flex w-full  mb-12 flex-col justify-start items-start ">
                <h2 class="font-normal h-full textstart text-6xl md:text-8xl ml-12">the</h2>
                <h2 class="font-bold h-full uppercase textstart text-6xl md:text-7xl">writing</h2>
                <div class="flex items-start"><h2 class="font-normal h-full textstart text-6xl md:text-8xl ml-24 lg:ml-36">lab </h2>
                <span class="p-0.5 border-white mt-3 border text-xs rounded-full">  <i class="fas fa-trademark"></i> </span></div>
            </div>
          </div>
            
            <div class="w-full  lg:w-7/12">
                <p class="text-gray-700 text-justify  lg:px-6 py-3 px-3 lg:py-3">The Asian Writing Lab forms the creative heart of our festivals, nurturing emerging writers
                to push beyond conventional boundaries and harness the transformative power of
                imagination. This dynamic incubator seamlessly blends stage and classroom into an
                infinite space of collaborative creation.</p>
                <p class="text-gray-700 p-3 text-justify lg:px-6">We offer diverse programmes designed to dismantle the barriers that constrain human
                creativity, addressing these challenges with the urgency they deserve. Our experimental
                approach encourages writers to explore uncharted territories of storytelling, discovering
                new forms and voices that challenge traditional frameworks.</p>
                <p class="text-gray-700 text-justify p-3 lg:px-6">The Asian Writing Lab is championed by a global network of authors, thinkers, and cultural
                strategists who share our unwavering belief in imagination as a force for change. Together,
                we cultivate a space where emerging voices can flourish and redefine what writing can be.</p>
                <p class="text-gray-700 text-justify p-3 lg:px-6">Through this unique fusion of performance and pedagogy, we're not just developing
                writers—we're fostering the next generation of creative revolutionaries who will reshape
                the literary landscape.</p>
           </div>
        </div>
    </div>


      <div >
    
        <div class="flex w-full flex-wrap justify-center py-6 px-3">
            <!-- Left: The Living Memory Vault -->
            <div class="w-full lg:w-6/12 text-gray-700 dark:text-gray-300 pr-3 space-y-5">

                <div class="aspect-w-1 aspect-h-1 w-[200px]  -mb-6 mx-auto">
                    <img src="{{ asset('/assets/img/livingmemory.gif') }}" alt="Rocket Animation" class="w-full h-full object-cover rounded-xl">
                </div>

                <h2 class="lg:text-4xl text-3xl mt-12 lg:mt-4 text-black font-extrabold tracking-widest uppercase text-left">The Living Memory Vault</h2>
                <p>
                    <strong class="text-lg text-black text-justify dark:text-white">A Global Initiative to Preserve Our Intangible Heritage</strong>
                </p>
                <p class=" text-justify">
                    As modernization accelerates, centuries of stories, rituals, and traditional knowledge are fading into silence. <strong>The Living Memory Vault</strong>, a collaborative initiative by The Asian Literary Festivals and The Purple Umbrella Theatre Festival, aims to safeguard these priceless cultural treasures. From ancient healing methods to folklore and community rituals, this digital archive honors the wisdom that shaped generations—ensuring it remains accessible and inspiring for those yet to come.
                </p>
                <p class="mb-10 text-justify">
                    We call upon storytellers, cultural custodians, scholars, and passionate individuals worldwide to contribute. By sharing your knowledge, you help ensure no story is lost and no tradition forgotten. Join us in building a living archive that celebrates our shared human heritage. <strong>Register today</strong> to become a contributor to The Living Memory Vault and help preserve humanity's greatest stories for tomorrow.
                </p>

                    

                <div class="mt-6">
                    <a href="{{route('livingMemoryVault')}}" class="px-4 py-2 bg-black text-white font-semibold ">Learn More</a>
                </div>
                    
            </div>

            <!-- Right: Launchpad 1000 -->
            <div class="w-full  lg:w-6/12 text-gray-700 dark:text-gray-300 space-y-5">

                <div class="aspect-w-1 aspect-h-1 w-40 flex items-end justify-center mx-auto mb-6">
                    <img src="{{ asset('/assets/img/rocket.gif') }}" alt="Rocket Animation" class="w-full h-full object-cover rounded-xl">
                </div>

                <h2 class="lg:text-4xl text-3xl mt-12 lg:mt-4 text-black font-extrabold tracking-widest uppercase text-center">Launchpad 1000</h2>
                 <p class="py-3">
                    <strong class="text-lg text-black text-justify  dark:text-white">Global Literary Pitching Platform</strong>
                </p>
                <p. class="  text-justify">Launchpad 1000 is The Asian Literary Festivals' live manuscript pitching platform, connecting writers worldwide with industry professionals. We seek fresh talent and welcome established authors across all genres.</p>
                <p  class="  text-justify">The Asian Literary Agency, our talent management wing, hosts live pitching sessions at festival locations. Our platform features two distinct tracks: an original manuscript submission desk for unpublished work and a translation pitching deck for published titles seeking international markets.</p>
                <p  class="  text-justify mb-6">Book your slot and present your work directly to agents actively seeking compelling narratives and market-ready content. Whether you're submitting debut manuscripts or published works for translation opportunities, Launchpad 1000 provides the essential gateway to advance your literary career on the global stage.</p>

                <div>
                    <a href="{{route('bookingNow')}}" class="px-4 py-2 bg-black text-white font-semibold">Learn More</a>
                </div>

            </div>
        </div>

    
    </div>

    <div class="py-8" >
        <h1 class="lg:text-4xl text-3xl mt-12 lg:mt-4 text-black font-extrabold tracking-widest uppercase text-center">Stage, Page, Revolution: The Future of Storytelling Starts Here</h1>
    
        <div class="flex w-full justify-center flex-wrap py-12">
            <div class="aspect-w-1 aspect-h-1 w-full max-w-md">
                <video autoplay muted loop playsinline class="w-full h-full object-cover rounded-xl">
                    <source src="{{ asset('/assets/img/video.webm') }}" type="video/webm">
                    Your browser does not support the video tag.
                </video>
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