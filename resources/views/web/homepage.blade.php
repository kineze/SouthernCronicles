@extends('layouts.web.app')

@section('content')


<section class="w-full block max-w-screen-2xl top-0 mx-auto relative">

            <div class="relative w-full z-0 rounded-3 lg:min-h-[100vh] min-h-[70vh] bg-white">

                <div class="w-full rounded-xl bg-cover absolute bg-top z-[200] py-6 px-4 lg:pl-10">
                    <div class='w-full rounded-xl rounded-bl-none bg-transparent flex bg-cover items-start'>
                        <div class="relative z-30 flex flex-col items-start justify-center pt-12">
                            <h2 class="font-bold text-primary-blue uppercase text-8xl">2026</h2>
                            <h1 class="tracking-[10px] lg:text-5xl text-4xl uppercase font-semibold text-primary-blue leading-tight">
                            Southern <br>Chronicles
                            </h1>
                            <h2 class="font-semibold tracking-[10px] text-black uppercase text-3xl"></h2>
                            {{-- <img src="{{ asset('assets/img/sou-logo.webp')}}" alt="" class="w-48 lg:w-72 object-contain"> --}}
                        </div>
                    </div>
                </div>
                <!-- Color Splash Stage (background with video) -->
                <div id="splash-stage"
                    class="pointer-events-none absolute inset-0 z-[5] overflow-hidden">
                    
                    <video autoplay muted loop playsinline
                        class="absolute inset-0 w-full h-full object-cover">
                        <source src="{{ asset('assets/img/southern-hero-video.webm') }}" type="video/webm">
                        Your browser does not support the video tag.
                    </video>
                </div>
            
                <div class="parallax-layer absolute top-16  z-10 w-full" data-speed="0.2">
                    <img src="{{ asset('assets/img/hero-images-southern.webp') }}" 
                        class="w-full object-contain" alt="Layer 2">
                </div>

                <div class="parallax-layer absolute overflow-hidden z-[120] pl-40 -top-16 w-full" data-speed="0.4">
                    <div class="w-full"></div>
                </div>
            </div>

            <div class=" bg-gray-200/10 backdrop-blur-xl">
                <div  class=" relative flex pt-24 flex-wrap bg-black z-[1000] bg-opacity-50 backdrop-blur-xl bg-transparent items-start justify-end px-6 lg:px-12 ">
                    
                    <div class="z-[200] w-full lg:w-6/12 relative">
                        <next-countdown-desktop :next-festival='@json($nextFestival)'>
                            <template #action>
                                <register-now-modal></register-now-modal>
                            </template>
                        </next-countdown-desktop>
                    </div>

                    <div class="z-[200] w-full lg:w-6/12 relative mt-10 lg:mt-0">
                        <h2 class="font-semibold text-primary-blue uppercase text-start text-7xl">It Isn't a Luxury…</h2>
                        <h1 class="tracking-[10px] lg:text-4xl text-2xl mt-3 uppercase font-bold text-primary-blue leading-tight">
                            Bridging Worlds Through Words
                        </h1>
                        <h2 class="font-semibold tracking-[10px] text-black uppercase text-3xl mt-5"></h2>
                        <literature-blurb-slider></literature-blurb-slider>
                    </div>
                </div>
            </div>
            

</section>


<section class="w-full z-[200]  max-w-screen-2xl mx-auto">
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
</section>


{{-- <section class="relative w-full max-w-screen-2xl mx-auto">

    <festival-locations></festival-locations>

</section> --}}

<section class="w-full max-w-screen-2xl mx-auto">

    <up-coming-festivals></up-coming-festivals>

</section>


<section class="relative w-full max-w-screen-2xl flex flex-wrap mx-auto px-4">

    {{-- <div class=" overflow-hidden w-full lg:w-6/12">
        <div class="">
        <h2 class="lg:text-5xl text-3xl mb-10 text-center text-black font-extrabold tracking-widest uppercase">
            Festival Director’s Note
        </h2>

        <div class="text-gray-700 mt-4 leading-relaxed">

            <figure class=" float-left w-40 h-40 md:w-64 md:h-64 mr-6 md:mr-6 mb-4 rounded overflow-hidden shadow-md">
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
    </div> --}}

    <div class="w-full">
        <speakers-carousel></speakers-carousel>
    </div>

</section>






{{-- <section class="w-full max-w-screen-2xl  mt-6 mx-auto">

    <div class=" px-4 py-2 mb-5">
      <h1 class="lg:text-6xl text-3xl text-black font-extrabold tracking-widest uppercase text-center">
        Our Ecosystem
      </h1>
    </div>

    <advisor-carousel></advisor-carousel>
   
</section> --}}

<section class="w-full max-w-screen-2xl mx-auto">

    <our-partners></our-partners>

</section>

<section class="w-full max-w-screen-2xl  mt-6 mx-auto">

    <latest-news></latest-news>
   
</section>

{{-- <section class="w-full max-w-screen-2xl mx-auto">

    <our-partners></our-partners>

</section> --}}

{{-- <section class="relative w-full max-w-screen-2xl mx-auto">

    <div class="w-full bg-white border-black border p-3 flex items-center flex-wrap">
        <div class="lg:w-2/12 w-full">
            <div class="aspect-w-1 aspect-h-1  w-full h-56 p-6">
                <video autoplay muted loop playsinline class="w-full  h-full object-contain rounded-xl">
                    <source src="{{ asset('/assets/img/dog.webm') }}" type="video/webm">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
        <div class="lg:w-8/12 w-full">
            <p class="text-lg text-black font-semibold">Our conference is proudly pet-friendly and family-friendly, creating a warm, inclusive space for everyone. Whether you're attending with children or furry companions, you're welcome here. We believe innovation thrives in joyful, supportive environments—so come as you are, bring your whole family, and feel at home.</p>
        </div>
        <div class="lg:w-2/12 w-full">
            <div class="aspect-w-1 aspect-h-1  w-full h-56">
                <video autoplay muted loop playsinline class="w-full  h-full object-contain rounded-xl">
                    <source src="{{ asset('/assets/img/cat.webm') }}" type="video/webm">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>

</section> --}}

<section class="w-full max-w-screen-2xl  mt-6 mx-auto">

    {{-- <div class="w-full mb-10">

      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31675.06777531941!2d79.99171349917356!3d7.081464785533528!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2fb67a22e72d9%3A0x913a2c56a49c8d8e!2sGampaha!5e0!3m2!1sen!2slk!4v1754677061475!5m2!1sen!2slk" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div> --}}

    <usefull-links></usefull-links>
   
</section>

@endsection

{{-- @push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var countDownDate = new Date("{{ $nextFestival->start_at }}").getTime();

        var countdownFunction = setInterval(function () {
            var now = new Date().getTime();
            var timeLeft = countDownDate - now;

            if (timeLeft > 0) {
                var days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                var hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                const ids = ["days", "days-mobile"];
                const hoursIds = ["hours", "hours-mobile"];
                const minutesIds = ["minutes", "minutes-mobile"];
                const secondsIds = ["seconds", "seconds-mobile"];

                ids.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.innerText = days;
                });
                hoursIds.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.innerText = hours;
                });
                minutesIds.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.innerText = minutes;
                });
                secondsIds.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.innerText = seconds;
                });

            } else {
                clearInterval(countdownFunction);
                const cd1 = document.getElementById("countdown");
                const cd2 = document.getElementById("countdown-mobile");
                if (cd1) cd1.innerHTML = "<h2 class='text-white text-2xl'>Festival has started!</h2>";
                if (cd2) cd2.innerHTML = "<h2 class='text-white text-2xl'>Festival has started!</h2>";
            }
        }, 1000);
    });
</script>
@endpush --}}