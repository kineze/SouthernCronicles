@extends('layouts.web.app')

@section('content')

<section class="w-full max-w-screen-2xl  -mt-6 mx-auto p-3">
   
<div class="w-full rounded-xl bg-cover bg-top">
    <div class="w-full rounded-xl bg-cover font-nordique bg-top z-[200] py-8 px-4 lg:pl-5">
        <div class='w-full rounded-xl rounded-bl-none bg-transparent flex bg-cover items-start'>
            <div class="relative z-30 flex flex-col items-start justify-center ">
                <h2 class="font-bold text-primary-blue uppercase text-8xl">2026</h2>
                <h1 class="tracking-[8px] lg:text-5xl text-4xl  font-bold pt-6 text-primary-blue leading-tight">
                    Southern <br>Chronicles
                </h1>
                <h2 class="font-semibold tracking-[10px] text-primary-blue uppercase text-3xl"></h2>
                            {{-- <img src="{{ asset('assets/img/sou-logo.webp')}}" alt="" class="w-48 lg:w-72 object-contain"> --}}
            </div>
        </div>
    </div>
 
   <div class="">
         <div  class=" relative flex pb-12 h-full flex-wrap bg-white z-[1000] bg-opacity-30 backdrop-blur-xl rounded-3xl  bg-transparent items-start justify-end pt-12">
            <div class="w-full lg:w-5/12  justify-between p-6 flex bg-primary-blue text-white">
            <div class="flex w-full  mb-12 flex-col justify-start items-start ">
                <h2 class="font-normal h-full textstart text-6xl md:text-8xl ml-12">the</h2>
                <h2 class="font-bold h-full uppercase textstart text-6xl md:text-7xl">writing</h2>
                <div class="flex items-start"><h2 class="font-normal h-full textstart text-6xl md:text-8xl ml-24 lg:ml-36">lab </h2>
                <span class="p-0.5 border-white mt-3 border text-xs rounded-full">  <i class="fas fa-trademark"></i> </span></div>
            </div>
          </div>
            
            <div class="w-full  lg:w-7/12">
                <p class="text-black text-justify  lg:px-6 py-3 px-3 lg:py-3">The Asian Writing Lab forms the creative heart of our festivals, nurturing emerging writers
                to push beyond conventional boundaries and harness the transformative power of
                imagination. This dynamic incubator seamlessly blends stage and classroom into an
                infinite space of collaborative creation.</p>
                <p class="text-black p-3 text-justify lg:px-6">We offer diverse programmes designed to dismantle the barriers that constrain human
                creativity, addressing these challenges with the urgency they deserve. Our experimental
                approach encourages writers to explore uncharted territories of storytelling, discovering
                new forms and voices that challenge traditional frameworks.</p>
                <p class="text-black text-justify p-3 lg:px-6">The Asian Writing Lab is championed by a global network of authors, thinkers, and cultural
                strategists who share our unwavering belief in imagination as a force for change. Together,
                we cultivate a space where emerging voices can flourish and redefine what writing can be.</p>
                <p class="text-black text-justify p-3 lg:px-6">Through this unique fusion of performance and pedagogy, we're not just developing
                writers—we're fostering the next generation of creative revolutionaries who will reshape
                the literary landscape.</p>
           </div>
        </div>
    </div>


      <div >

         <div class="flex w-full flex-wrap justify-center py-12 px-3">
            <!-- Left: The Living Memory Vault -->
            <div class="w-full lg:w-6/12 text-gray-700 dark:text-gray-300 pr-6 space-y-5">

                <div class="w-[150px] h-[150px] lg:-mb-6 mx-auto">
                    <video
                        src="{{ asset('/assets/img/padura.webm') }}"
                        autoplay
                        muted
                        loop
                        playsinline
                        class="w-full h-full object-cover aspect-square rounded-lg"
                    ></video>
                </div>

                <h2 class="lg:text-5xl text-3xl mt-12 lg:mt-4 text-primary-blue font-extrabold tracking-widest uppercase text-left">පැදුර</h2>
                <p>
                    <strong class="text-xl text-primary-blue text-justify dark:text-white">සාහිත්‍යය පිළිබඳ ගැඹුරු සාකච්ඡා</strong>
                </p>
                <p class=" text-justify text-black">
                    පැදුර සාහිත්‍යය පිළිබඳ ගැඹුරු සාකච්ඡා සඳහා නිර්මාණය කරන ලද ජාතික මට්ටමේ සජීවී සංවාද මණ්ඩපයක් ලෙස පවතී. දේශීය හා ජාත්‍යන්තර සාහිත්‍යය, කාව්‍ය, නවකතා, නාට්‍ය සහ දාර්ශනික චින්තනය පිළිබඳ විවිධාකාර සාකච්ඡා මෙහිදී පවත්වනු ලැබේ. ලේඛකයින්, පාඨකයින්, අධ්‍යාපනඥයින් සහ සාහිත්‍ය රසිකයින් එක්ව නව අදහස්, විචාර සහ න්‍යායන් ඔස්සේ සාහිත්‍ය දැනුම ප්‍රචාරය කිරීම සහ එය ජීවිතයට ආවේණික වන ආකාරය අවබෝධ කර ගැනීම පැදුරේ අරමුණ වේ. 
                </p>
                <p class="mb-10 text-justify text-black">
                    සාහිත්‍යය සමාජය, සංස්කෘතිය සහ මානව චර්යාව පිළිබඳ ගැඹුරු අවබෝධයක් ලබා දෙන බව මෙම වේදිකාව නිරන්තරයෙන් අවධාරණය කරයි. සාහිත්‍යය සරලව විනෝදයක් ලෙස නොසැලකී, එය ජීවිතයේ ගැඹුරු සත්‍යයන් අවබෝධ කර ගැනීමේ මාධ්‍යයක් ලෙස ඉස්මතු කරයි. පදුර සාහිත්‍යය සමාජය සමඟ සංවාද කිරීමට අවකාශයක් සැලසීම හරහා සාහිත්‍ය රසිකයින් සඳහා අගේ ස්ථානයක් ගොඩනංවයි. මෙම මණ්ඩපය සාහිත්‍යයේ ශක්තිය හා සෞන්දර්යය ජීවිතයට ගෙන ඒමේ අත්දැකීමක් ලෙස පවතී.
                </p>
                    
            </div>


            <div class="w-full  lg:w-6/12 text-gray-700 dark:text-gray-300 space-y-5 mt-5 lg:mt-0">

                <div class="w-[150px] h-[150px] lg:-mb-6 mx-auto">
                    <video
                        src="{{ asset('/assets/img/kavipala.webm') }}"
                        autoplay
                        muted
                        loop
                        playsinline
                        class="w-full h-full aspect-square object-cover rounded-lg"
                    ></video>
                </div>

                <h2 class="lg:text-5xl text-3xl mt-12 lg:mt-4 text-primary-blue font-extrabold tracking-widest uppercase text-left">කවි පැල</h2>
                 <p class="py-3">
                    <strong class="text-xl text-primary-blue text-justify  dark:text-white">ජන කවිය සහ පැරණි සාහිත්‍යය</strong>
                </p>
                <p. class="  text-justify mb-10 text-black">කවි පැල සිංහල ජන කවිය සහ පැරණි සාහිත්‍යය ජීවමානව පවත්වා ගෙන යාමට නිර්මාණය කරන ලද අගේ සංස්කෘතික වේදිකාවකි. ජන කවියේ සරල භාෂාව, ගැඹුරු අර්ථය සහ සමාජයට ඇති සබැඳියාව මෙම වේදිකාව හරහා නව පරපුරට ගෙන යාම ප්‍රධාන අරමුණ වේ. ගැමි ගී, වීර ගී, රූපක ගී සහ පැරණි කාව්‍ය රචනා නැවත ජීවමාන කරමින්, ඒවායේ සෞන්දර්යය හා අගය අද ළමුන් සහ තරුණ පරපුර වෙත හුවමාරු කරයි. සාහිත්‍යය සරලව කියවීමක් ලෙස නොසැලකී, එය ජීවිතයේ කොටසක් ලෙස අවබෝධ කර දෙයි. ගීතිකා, කාව්‍ය පාඨ සහ සංවාද මගින් සිංහල භාෂාවේ රසය හා බලය ජීවමාන කරයි. <br><br></p>
                <p  class="  text-justify text-black">කවි පැල සාහිත්‍යය සමාජය සමඟ සංවාද කිරීමට දෙන අවකාශයක් ලෙස ක්‍රියා කරයි. පැරණි ජ්ඤානය සහ අදීන අගයන් අතර සේතුවක් ගොඩනංවමින්, සාහිත්‍යය ජීවිතයට ගෙන ඒම මෙහි සාරය වේ. මෙමගින් සිංහල සංස්කෘතියේ අභිමානය හා අභිලාෂය නව පරපුර තුළ ජාගරුක කරයි. මෙම වේදිකාව සාහිත්‍යය සමාජය සමඟ සංවාද කිරීමට අවකාශයක් සැලසීම හරහා සාහිත්‍ය රසිකයින් සඳහා අගේ ස්ථානයක් ගොඩනංවයි. සාහිත්‍යය සමාජය සහ සංස්කෘතිය පිළිබඳ අවබෝධය ගැඹුරු කරන බව මෙම වේදිකාව නිරන්තරයෙන් අවධාරණය කරයි.</p>

            </div>
        </div>
    
        <div class="flex w-full flex-wrap justify-center py-6 px-3">


            <div class="w-full lg:w-6/12 text-black dark:text-gray-300 pr-6 space-y-5">

                <div class="aspect-w-1 aspect-h-1 w-[200px]  -mb-6 mx-auto">
                    <img src="{{ asset('/assets/img/livingmemory.gif') }}" alt="Rocket Animation" class="w-full h-full object-cover rounded-xl">
                </div>

                <h2 class="lg:text-4xl text-3xl mt-12 lg:mt-4 text-primary-blue font-extrabold tracking-widest uppercase text-left">The Living Memory Vault</h2>
                <p>
                    <strong class="text-lg text-primary-blue text-justify dark:text-white">A Global Initiative to Preserve Our Intangible Heritage</strong>
                </p>
                <p class=" text-justify">
                    As modernization accelerates, centuries of stories, rituals, and traditional knowledge are fading into silence. <strong>The Living Memory Vault</strong>, a collaborative initiative by Southern Chronicless and The Purple Umbrella Theatre Festival, aims to safeguard these priceless cultural treasures. From ancient healing methods to folklore and community rituals, this digital archive honors the wisdom that shaped generations—ensuring it remains accessible and inspiring for those yet to come.
                </p>
                <p class="mb-10 text-justify">
                    We call upon storytellers, cultural custodians, scholars, and passionate individuals worldwide to contribute. By sharing your knowledge, you help ensure no story is lost and no tradition forgotten. Join us in building a living archive that celebrates our shared human heritage. <strong>Register today</strong> to become a contributor to The Living Memory Vault and help preserve humanity's greatest stories for tomorrow.
                </p>

                    

                <div class="mt-6">
                    <a href="{{route('livingMemoryVault')}}" class="px-4 py-2 bg-primary-blue text-white font-semibold ">Learn More</a>
                </div>
                    
            </div>


            <div class="w-full  lg:w-6/12 text-black dark:text-gray-300 space-y-5">

                <div class="aspect-w-1 aspect-h-1 w-40 flex items-end justify-center mx-auto mb-6">
                    <img src="{{ asset('/assets/img/rocket.gif') }}" alt="Rocket Animation" class="w-full h-full object-cover rounded-xl">
                </div>

                <h2 class="lg:text-4xl text-3xl mt-12 lg:mt-4 text-primary-blue font-extrabold tracking-widest uppercase text-center">Launchpad 1000</h2>
                 <p class="py-3">
                    <strong class="text-lg text-primary-blue text-justify  dark:text-white">Global Literary Pitching Platform</strong>
                </p>
                <p. class="  text-justify">Launchpad 1000 is Southern Chronicless' live manuscript pitching platform, connecting writers worldwide with industry professionals. We seek fresh talent and welcome established authors across all genres.</p>
                <p  class="  text-justify">The Asian Literary Agency, our talent management wing, hosts live pitching sessions at festival locations. Our platform features two distinct tracks: an original manuscript submission desk for unpublished work and a translation pitching deck for published titles seeking international markets.</p>
                <p  class="  text-justify mb-6">Book your slot and present your work directly to agents actively seeking compelling narratives and market-ready content. Whether you're submitting debut manuscripts or published works for translation opportunities, Launchpad 1000 provides the essential gateway to advance your literary career on the global stage.</p>

                <div>
                    <a href="{{route('bookingNow')}}" class="px-4 py-2 bg-primary-blue text-white font-semibold">Learn More</a>
                </div>

            </div>
        </div>

    
    </div>

</section>

@endsection