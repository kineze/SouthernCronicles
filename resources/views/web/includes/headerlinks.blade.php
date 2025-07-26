<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/logo.webp')}}" />
    <link rel="icon" type="image/png" href="{{asset('assets/img/logo.webp')}}">
    
    <title>Brussels - Asian Literary Festival</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />


<style>
    .parallax-layer {
        will-change: transform;
        transition: transform 0.1s ease-out;
        pointer-events: none;
    }

    @keyframes loop-x {
  0%   { transform: translateX(0); }
  100% { transform: translateX(-160vw); } /* 2 images worth */
}

.loop-container {
  display: flex;
  width: calc(80vw * 4); /* Ensure at least 2 full loops */
}

.loop-container img {
  width: 80vw;
  flex-shrink: 0;
  object-fit: contain;
}

.loop-container-mobile img {
  width: 100vw;
  flex-shrink: 0;
  object-fit: contain;
}

.loop-container-mobile {
  display: flex;
  width: calc(100vw * 4); /* Ensure at least 2 full loops */
}

.animate-loop-x {
  animation: loop-x 60s linear infinite;
}



.parallax-layer img {
    pointer-events: none;
    flex-shrink: 0;
}
</style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>