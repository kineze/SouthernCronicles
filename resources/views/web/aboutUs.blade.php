@extends('layouts.web.app')

@section('content')

<section class="w-full max-w-screen-2xl mx-auto p-3">
   
    <div class="w-full rounded-xl bg-cover font-nordique bg-top z-[200] py-8 px-4 lg:pl-5">
        <div class='w-full rounded-xl rounded-bl-none bg-transparent flex bg-cover items-start'>
            <div class="relative z-30 flex flex-col items-start justify-center pt-3">
                <h2 class="font-bold text-primary-blue uppercase text-8xl">2026</h2>
                <h1 class="tracking-[8px] lg:text-5xl text-4xl  font-bold pt-3 text-primary-blue leading-tight">
                    Southern <br>Chronicles
                </h1>
                <h2 class="font-semibold tracking-[10px] text-primary-blue uppercase text-3xl"></h2>
                            {{-- <img src="{{ asset('assets/img/sou-logo.webp')}}" alt="" class="w-48 lg:w-72 object-contain"> --}}
            </div>
        </div>
    </div>

 
    <div class="">
        <div  class=" relative flex mb-24 flex-wrap items-start  z-[1000] bg-opacity-30 backdrop-blur-xl rounded-3xl  bg-transparent  justify-end pt-12">
           <div class="w-full bg-primary-blue md:sticky py-6 top-5 lg:w-6/12">
               <div class="">
                    <div class=" mx-auto px-4 text-center py-6">

                            <next-count-down :next-festival='@json($nextFestival)'>
                                <template #action>
                                    <register-now-modal></register-now-modal>
                                </template>
                            </next-count-down>
                            
                        </div>
               </div>
           </div>
           
            <div class="w-full px-6 lg:w-6/12">
                <h2 class="font-semibold text-primary-blue uppercase text-start text-8xl">About</h2>
                <h1 class="tracking-[10px] text-4xl uppercase font-bold text-primary-blue leading-tight">
                    The Fastest Growing Global Network of Festivals
                </h1>

                <about-us-paragraph-slider></about-us-paragraph-slider>
            </div>
        </div>
    </div>

    </div>
</section>

<section class="w-full max-w-screen-2xl mt-10 mx-auto p-3">

    <div class="bg-white px-4 py-2 mb-5">
      <h1 class="lg:text-6xl text-3xl text-primary-blue font-extrabold tracking-widest uppercase text-center">
       Powered By
      </h1>
    </div>

    <read-more-text></read-more-text>
</section>

{{-- <section class="w-full max-w-screen-2xl  mx-auto p-3">

    <teams-carousel></teams-carousel>

</section> --}}

{{-- <section class="w-full max-w-screen-2xl  mx-auto p-3">

    <next-count-down></next-count-down>

</section> --}}

<section class="w-full max-w-screen-2xl -mt-10 mx-auto p-3">

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