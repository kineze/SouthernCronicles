@extends('layouts.web.app')

@section('content')

<!-- ====== HERO ====== -->
<section class="relative w-full">
  <div class="relative h-[35vh] md:h-[80vh] w-full overflow-hidden ">
    <img
      src="{{ asset('assets/img/about_hero_new_update.webp') }}"
      alt="Festival crowd and literature ambience"
      class="absolute w-full bottom-10 lg:bottom-auto md:px-40 object-contain"  {{-- was object-cover --}}
    />

    <!-- overlay spans the whole hero area, not just the image pixels -->
    {{-- <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/50 to-transparent pointer-events-none"></div> --}}

    <div class="relative z-10 h-full max-w-screen-2xl mx-auto px-4 flex items-center justify-center text-center">
      <div class="text-black">
        <p class="uppercase lg:tracking-[0.4em] hidden lg:block tracking-[0.28rem] text-[10px] sm:text-sm mb-2 opacity-90">
          Odisha Art & Literature Festival
        </p>
        <h1 class="text-3xl md:text-6xl font-extrabold tracking-widest uppercase">About Us</h1>
        <p class="mt-4 max-w-2xl mx-auto text-sm hidden lg:block text-black/80">Where the world comes together as one family</p>
      </div>
    </div>
  </div>
</section>

{{-- 
<next-countdown-desktop>
  <template #action>
    <register-now-modal></register-now-modal>
  </template>
</next-countdown-desktop> --}}

<!-- ====== INTRO ====== -->
<section class="w-full hidden lg:block max-w-screen-2xl mx-auto  py-6 ">
  <div class="grid md:grid-cols-2 gap-8 items-center">
    <div class="order-2 md:order-1 mt-6 p-4 md:p-4">
      <h2 class="tracking-[0.8rem] text-2xl md:text-5xl uppercase font-bold text-black leading-tight">
        Welcome to OALF 2025
      </h2>
      <h3 class="font-semibold tracking-[0.35em] text-black uppercase text-xl md:text-2xl mt-5">
        where the world comes together as one family!
        
      </h3>

      <div class="text-gray-700 space-y-4 mt-4 leading-relaxed">
        <p class="font-semibold">
          Celebrating a Decade of Cultural Excellence
        </p>
        <p>
          The Odisha Art & Literature Festival (OALF) 2025 marks a momentous milestone as we celebrate our 10th edition—a testament to our unwavering commitment to fostering cultural dialogue and artistic exchange. What began as a regional initiative has evolved into an internationally acclaimed platform that bridges local heritage with global perspectives.
        </p>
        <p>
          OALF stands apart through its deeply community-based approach, creating an inclusive ecosystem where voices from every stratum of society find expression and resonance. We’ve become everyone’s place for cultural exchange—a space where established luminaries engage alongside emerging talents, and where academic discourse meets grassroots creativity.
        </p>
        <p>
          This community-centric philosophy has redefined the literary festival as a nurturing ground for cultural democracy, where every participant is both audience and contributor to the shared narrative of human expression.
        </p>
      </div>
    </div>

    <div class="order-1 md:order-2">
      <div class="relative rounded overflow-hidden">
        <img
          src="{{asset('assets/img/about-two.webp')}}"
          alt="Books and conversations"
          class="w-full object-cover"
        />
        <!-- <img src="{{ asset('assets/images/about/intro.webp') }}" alt="Intro" class="w-full h-[360px] object-cover" /> -->
        {{-- <div class="absolute inset-0 bg-gradient-to-tr from-black/30 to-transparent"></div> --}}
      </div>
    </div>
  </div>
</section>

<section class="w-full lg:hidden max-w-screen-2xl mx-auto px-4 -mt-10 ">
  <div class=" gap-8 items-center">
    <div class="order-2 md:order-1 mt-6 p-4 md:p-4">
      <h2 class="tracking-[0.8rem] text-2xl md:text-5xl uppercase font-bold text-black leading-tight">
        Welcome to OALF 2026
      </h2>

      <h3 class="font-semibold tracking-[0.35em] text-black uppercase text-xl md:text-2xl mt-5">
        where the world comes together as one family!
      </h3>

      <div class="text-gray-700 space-y-4 mt-4 leading-relaxed">
        <p class="font-semibold">
          Celebrating a Decade of Cultural Excellence
        </p>
        <p>
          The Odisha Art & Literature Festival (OALF) 2025 marks a momentous milestone as we celebrate our 10th edition—a testament to our unwavering commitment to fostering cultural dialogue and artistic exchange. What began as a regional initiative has evolved into an internationally acclaimed platform that bridges local heritage with global perspectives.
        </p>
        <p>
          OALF stands apart through its deeply community-based approach, creating an inclusive ecosystem where voices from every stratum of society find expression and resonance. We’ve become everyone’s place for cultural exchange—a space where established luminaries engage alongside emerging talents, and where academic discourse meets grassroots creativity.
        </p>
        <p>
          This community-centric philosophy has redefined the literary festival as a nurturing ground for cultural democracy, where every participant is both audience and contributor to the shared narrative of human expression.
        </p>
      </div>
    </div>

    <div class="order-1 md:order-2">
      <div class="relative rounded overflow-hidden">
        <img
          src="{{asset('assets/img/about-two-new.webp')}}"
          alt="Books and conversations"
          class="w-full object-cover"
        />
        <!-- <img src="{{ asset('assets/images/about/intro.webp') }}" alt="Intro" class="w-full h-[360px] object-cover" /> -->
        {{-- <div class="absolute inset-0 bg-gradient-to-tr from-black/30 to-transparent"></div> --}}
      </div>
    </div>
  </div>
</section>

{{-- <section class="w-full max-w-screen-2xl mx-auto ">
  <vision-mission
    eyebrow="Who We Are"
    title="Our Vision & Philosophy"
    subtitle="Bridging worlds through words."
    vision-image="{{ asset('assets/img/kipenzi-art.webp') }}"
    mission-image="{{ asset('assets/img/story.webp') }}"
    :vision-points="['Champion free access', 'Inspire cross-cultural dialogue', 'Nurture future storytellers']"
    :mission-points="['Inclusive programs & workshops', 'Multilingual participation', 'Community-driven initiatives']"
    accent="active-purple"
  ></vision-mission>
</section> --}}

<section class="w-full max-w-screen-2xl mx-auto px-4 sm:px-6 py-8 ">

  <header class="text-center mb-10 lg:mb-14">

    <h2 class="mt-2 uppercase font-extrabold text-black tracking-widest text-3xl sm:text-4xl lg:text-5xl">
      Our Setting & Commitment
    </h2>

  </header>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
    {{-- Card 1: Our Setting --}}
    <article class="group relative overflow-hidden rounded bg-white/70 backdrop-blur-xl border border-black/5 shadow-lg">
      <div class="flex flex-col lg:flex-row">
        {{-- Copy --}}
        <div class="w-full flex flex-col justify-start items-start p-6 lg:p-8">
          <h3 class="uppercase text-3xl lg:text-4xl font-extrabold tracking-widest text-black flex items-center gap-3">
            <span>Our Setting</span>
            <span class="h-[10px] w-[10px] rounded-full bg-active-purple"></span>
          </h3>
          <p class="mt-4 text-gray-700 text-justify leading-relaxed">
            OALF takes place annually in Bhubaneswar, the capital of Odisha—a historically majestic, peace-loving, and serene state situated on India’s eastern coast. This setting provides the perfect backdrop for our festival, where ancient wisdom meets contemporary discourse.
          </p>
        </div>
        {{-- Media (right) --}}
        {{-- <div class="w-full lg:w-[46%]">
          <div class="relative h-full min-h-[260px]">
            <img
              src="https://images.unsplash.com/photo-1598575954732-70f82a34c49f?q=80&w=1600&auto=format&fit=crop"
              alt="Konark Sun Temple / Odisha architecture"
              class="w-full h-full object-cover"
              loading="lazy"
            />
            <img src="{{ asset('assets/images/about/setting.webp') }}" alt="Setting" class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-gradient-to-tr from-black/20 to-transparent"></div>
          </div>
        </div> --}}
      </div>
    </article>

    {{-- Card 2: Our Commitment --}}
    <article class="group relative overflow-hidden rounded bg-white/70 backdrop-blur-xl border border-black/5 shadow-lg">
      <div class="flex flex-col lg:flex-row">
        {{-- Media (left to alternate layout) --}}
        {{-- <div class="w-full lg:w-[46%]">
          <div class="relative h-full min-h-[260px]">
            <img
              src="https://images.unsplash.com/photo-1517841905240-472988babdf9?q=80&w=1600&auto=format&fit=crop"
              alt="Community and celebration"
              class="w-full h-full object-cover"
              loading="lazy"
            />
            <img src="{{ asset('assets/images/about/commitment.webp') }}" alt="Commitment" class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-gradient-to-tr from-black/25 to-transparent"></div>
          </div>
        </div> --}}
        {{-- Copy --}}
        <div class="w-full flex flex-col justify-start items-start p-6 lg:p-8">
          <h3 class="uppercase text-3xl lg:text-4xl font-extrabold tracking-widest text-black flex items-center gap-3">
            <span>Our Commitment</span>
            <span class="h-[10px] w-[10px] rounded-full bg-active-purple"></span>
          </h3>
          <div class="mt-4 text-gray-700 space-y-4 leading-relaxed text-justify">
            <p>
              OALF 2025 continues our mission to create meaningful dialogue between traditions and innovations, local and global perspectives, established voices and emerging talents. 
            </p>
            <p>
              We invite you to join us in this celebration of human creativity and cultural exchange—a festival where every story matters, every voice is heard, and every culture is celebrated.
              Welcome to OALF 2025—where the world comes together as one family.
            </p>

          </div>
        </div>
      </div>
    </article>
  </div>
</section>

<section class="w-full max-w-screen-2xl mx-auto py-10 ">
  <div class="overflow-hidden">
    <div class="grid md:grid-cols-2">
        <div class="relative">
        <img
          src="{{asset('/assets/img/about-3.webp')}}"
          alt="Stage lights and audience"
          class="w-full h-[450px] rounded object-cover"
        />
        
       
      </div>
      <div class="p-4 md:p-4">
        <h2 class="lg:text-5xl text-3xl text-black font-extrabold lg:tracking-widest tracking-wide uppercase">A Decade of Transformation</h2>
        <div class="text-gray-700 space-y-4 mt-4 leading-relaxed">
          <p>
            Over the past ten years, OALF has transformed from a cherished regional gathering into an epicenter of international cultural exchange. Our global outreach has successfully integrated local culture and literary arts into the worldwide cultural landscape, positioning Odisha as a vital hub for cross-cultural dialogue.
          </p>
          <p>
            The 2025 edition represents our most ambitious undertaking yet, featuring unprecedented global outreach and diversity. With increased local involvement across all social layers, we have evolved into a truly intercultural and international forum for dialogue and exchange about subjects that matter to today’s world.
          </p>
        </div>
      </div>
    
    </div>
  </div>
</section>


{{-- <section class="w-full max-w-screen-2xl mx-auto px-4 py-10">
  <div class="grid md:grid-cols-2 gap-8 items-center">
    <div>
      <h2 class="lg:text-5xl text-3xl text-black font-extrabold tracking-widest uppercase">Our Setting</h2>
      <p class="text-gray-700 py-3 leading-relaxed">
        OALF takes place annually in Bhubaneswar, the capital of Odisha—a historically majestic, peace-loving, and serene state on India’s eastern coast. This setting provides the perfect backdrop for our festival, where ancient wisdom meets contemporary discourse.
      </p>
    </div>
    <div>
      <div class="relative rounded-2xl overflow-hidden shadow-xl">
        <img
          src="https://images.unsplash.com/photo-1598575954732-70f82a34c49f?q=80&w=1600&auto=format&fit=crop"
          alt="Konark Sun Temple / Odisha architecture"
          class="w-full h-[340px] object-cover"
        />
        <!-- <img src="{{ asset('assets/images/about/setting.webp') }}" alt="Setting" class="w-full h-[340px] object-cover" /> -->
        <div class="absolute inset-0 bg-gradient-to-tr from-black/20 to-transparent"></div>
      </div>
    </div>
  </div>
</section> --}}

<!-- ====== THE 2025 EDITION ====== -->
<section class="w-full max-w-screen-2xl mx-auto py-10 ">
  <div class="overflow-hidden">
    <div class="grid md:grid-cols-1">
      <div class="p-6 md:p-10 order-1 md:order-2">
        <h2 class="lg:text-5xl text-3xl text-center text-black font-extrabold tracking-widest uppercase">The 2025 Edition</h2>
        <div class="text-gray-700 space-y-4 mt-4 text-center leading-relaxed">
          <p>
            This landmark 10th edition features an extraordinary amalgamation of international and local voices, transforming the festival into a unique cultural destination. For the first time, our programme is curated by three globally acclaimed curators, Sabin Iqbal (UAE), Pramudith D Rupasinghe (Belgium) MK Ajay (Hong Kong), ensuring a truly diverse and enriching experience.
          </p>
          <p>
            The festival remains committed to taking literature and culture to the next higher level, shunning all forms of compartmentalisation and taking every recourse to propagate our rich cultural legacy whilst embracing the voices and visions of our global community.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ====== OUR COMMITMENT ====== -->
{{-- <section class="w-full max-w-screen-2xl mx-auto px-4 py-10">
  <div class="grid md:grid-cols-2 gap-8 items-center">
    <div>
      <div class="relative rounded-2xl overflow-hidden shadow-xl">
        <img
          src="https://images.unsplash.com/photo-1517841905240-472988babdf9?q=80&w=1600&auto=format&fit=crop"
          alt="Community and celebration"
          class="w-full h-[340px] object-cover"
        />
        <!-- <img src="{{ asset('assets/images/about/commitment.webp') }}" alt="Commitment" class="w-full h-[340px] object-cover" /> -->
        <div class="absolute inset-0 bg-gradient-to-tr from-black/25 to-transparent"></div>
      </div>
    </div>
    <div>
      <h2 class="lg:text-5xl text-3xl text-black font-extrabold tracking-widest uppercase">Our Commitment</h2>
      <div class="text-gray-700 space-y-4 mt-4 leading-relaxed">
        <p>
          OALF 2025 continues our mission to create meaningful dialogue between traditions and innovations, local and global perspectives, established voices and emerging talents.
        </p>
        <p>
          Join us in this celebration of human creativity and cultural exchange—a festival where every story matters, every voice is heard, and every culture is celebrated.
        </p>
        <p class="font-semibold">Welcome to OALF 2025—where the world comes together as one family.</p>
      </div>
    </div>
  </div>
</section> --}}

<!-- ====== PHOTO MOSAIC ====== -->
{{-- <section class="w-full max-w-screen-2xl mx-auto px-4 pb-10">
  <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
    <img src="https://images.unsplash.com/photo-1523580846011-d3a5bc25702b?q=80&w=1200&auto=format&fit=crop" class="w-full h-40 object-cover rounded-xl" alt="Books and art" />
    <img src="https://images.unsplash.com/photo-1496302662116-85c60b6d1395?q=80&w=1200&auto=format&fit=crop" class="w-full h-40 object-cover rounded-xl" alt="Audience" />
    <img src="https://images.unsplash.com/photo-1516259762381-22954d7d3ad2?q=80&w=1200&auto=format&fit=crop" class="w-full h-40 object-cover rounded-xl" alt="Creative writing" />
    <img src="https://images.unsplash.com/photo-1520697222861-4f3b9d0d3b83?q=80&w=1200&auto=format&fit=crop" class="w-full h-40 object-cover rounded-xl" alt="Performance" />
  </div>
</section> --}}

{{-- <section class="w-full max-w-screen-2xl mx-auto px-4 pb-16">
  <div class=" overflow-hidden">
    <div class="px-6 md:px-10 md:py-10">
      <h2 class="lg:text-5xl text-3xl mb-10 text-center text-black font-extrabold tracking-widest uppercase">
        Festival Director’s Note
      </h2>

      <div class="text-gray-700 mt-4 leading-relaxed">

        <figure class="float-none md:float-left w-40 h-40 md:w-64 md:h-64 mr-0 md:mr-6 mb-4 rounded overflow-hidden shadow-md">
          <img
            src="{{asset('assets/img/director.webp')}}"
            alt="Festival Director portrait"
            class="w-full h-full object-cover"
            loading="lazy"
          />
        </figure>

        <div class="space-y-4 text-justify">
          <p>
            As we stand at the door of our 10th edition, I am filled with immense gratitude for the extraordinary journey that has brought us here. What began as a dream to celebrate Odia literature and culture has blossomed into a global confluence of minds, hearts, and creative spirits.
          </p>
          <p>
            This milestone edition represents more than just a numerical achievement—it embodies a decade of unwavering belief in the transformative power of art and literature. We have witnessed OALF evolve from intimate gatherings in Bhubaneswar’s cultural spaces to becoming an international beacon that draws voices from across continents. Yet, through this remarkable growth, we have never forgotten our roots or abandoned our commitment to being a festival of the people, by the people, and for the people.
          </p>
          <p>
            The 2025 edition is particularly special as we welcome three distinguished international curators who bring perspectives from East Asia, Europe, and the Middle East. This curatorial diversity reflects our core belief that literature and art know no boundaries, and that the most profound conversations emerge when different worldviews converge in mutual respect and understanding.
          </p>
          <p>
            What moves me most deeply is how OALF has become a second home for so many—established authors finding new inspiration, emerging writers discovering their voices, students engaging with ideas that will shape their futures, and communities coming together to celebrate the rich tapestry of human expression. We have created something rare: a space where academic rigour meets popular accessibility, where tradition dialogues with innovation, and where local stories find global resonance.
          </p>
          <p>
            As we celebrate this decade of cultural exchange, I invite you to be part of this continuing story. Together, we shall write the next chapter of OALF, ensuring it remains a festival that truly embodies the spirit of <em>vasudhaiva kutumbakam</em>.
          </p>
          <p class="font-semibold">
            Manu Dash<br>
            Festival Director, OALF 2025
          </p>
        </div>

        <div class="clear-both"></div>
      </div>
    </div>
  </div>
</section> --}}


{{-- <section class="w-full max-w-screen-2xl  mt-6 mx-auto ">

  <usefull-links></usefull-links>
   
</section> --}}



@endsection
