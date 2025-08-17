<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="gmaps-key" content="{{ config('services.google_maps.key') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/logo.webp')}}" />
    <link rel="icon" type="image/png" href="{{asset('assets/img/logo.webp')}}">


    <meta property="og:title" content="ALF - 2025" />
    <meta property="og:description" content="Bridging Worlds Through Words" />
    <meta property="og:image" content="{{ asset('assets/img/og-image.webp') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    
    <title>gampaha - Asian Literary Festival</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    
<style>
/* ===========================
   Parallax base (keep as-is)
   =========================== */
.parallax-layer {
  will-change: transform;
  transition: transform 0.1s ease-out;
  pointer-events: none;
  backface-visibility: hidden;
}
.parallax-layer img {
  display: block;
  width: 100%;
  pointer-events: none;
  user-select: none;
}

/* =========================================
   Layer 3: left → right infinite marquee
   Starts with first slide fully on screen
   ========================================= */
:root{
  /* Tweak these to taste */
  --marquee-speed: 120s;                 /* total time for one cycle  */
  --l3-height: clamp(140px, 22vw, 320px);/* visible height for layer 3 */
}

/* The visible window for the loop */
.loop-viewport{
  position: relative;
  overflow: hidden;
  width: 100%;
  height: var(--l3-height);
  pointer-events: none;                 /* ensure it doesn't catch clicks */
}

/* The moving track that contains two identical groups */
.loop-track{
  display: flex;
  width: max-content;
  will-change: transform;
  animation: marquee-ltr var(--marquee-speed) linear infinite;
  backface-visibility: hidden;
}

/* One group = your sequence once (duplicate it twice for seamless loop) */
.loop-group{
  display: flex;
}

/* Each slide fills the viewport width so it “pages” across smoothly */
.loop-group img{
  width: 100vw;        /* one full viewport width per slide */
  height: 100%;        /* match the viewport height */
  flex: 0 0 auto;
  object-fit: contain; /* keep artwork proportions */
  user-select: none;
  pointer-events: none;
}

/* Move the track exactly one group width (50% of the double track) */
@keyframes marquee-ltr{
  100%   { transform: translateX(-50%); } /* show Group B (bridge fully visible) */
  0% { transform: translateX(0%); }   /* end aligned to Group A; loops seamlessly */
}

/* Optional: smaller devices can run slower/faster or change height */
@media (max-width: 768px){
  :root{ --l3-height: clamp(120px, 28vw, 260px); }
}

/* Respect users who prefer reduced motion */
@media (prefers-reduced-motion: reduce){
  .loop-track{
    animation: none;
    transform: translateX(-50%); /* keep the bridge visible statically */
  }
}

:root{
  --bob-amp: 10px;   /* how far it moves up (px) */
  --bob-dur: 1s;     /* one up–down cycle duration */
}

/* Generic vertical bob */
.bob-y{
  animation: bobY var(--bob-dur) ease-in-out infinite;
  will-change: transform;
}

@keyframes bobY{
  0%,100% { transform: translate3d(0,0,0); }
  50%     { transform: translate3d(0, calc(-1 * var(--bob-amp)), 0); }
}

/* Respect reduced motion */
@media (prefers-reduced-motion: reduce){
  .bob-y{ animation: none; }
}

.slow-ping { animation: ping 6s cubic-bezier(0, 0, 0.2, 1) infinite; }


/* Keyframes for smooth looping through colors */
@keyframes hiveColorCycle {
  0%   { fill: #a0d4e0; }  /* light blue */
  14%  { fill: #8fbaa0; }  /* soft green */
  28%  { fill: #c5a1c6; }  /* lavender */
  42%  { fill: #f58e81; }  /* coral */
  57%  { fill: #fabea5; }  /* peach */
  71%  { fill: #8ac1a3; }  /* mint */
  85%  { fill: #f27c88; }  /* pink/red */
  100% { fill: #a0d4e0; }  /* back to start */
}

svg path {
  fill: #a0d4e0; /* default start */
  animation: hiveColorCycle 8s infinite ease-in-out;
}}

</style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>