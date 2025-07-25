<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/logo.webp')}}" />
    <link rel="icon" type="image/png" href="{{asset('assets/img/logo.webp')}}">
    
    <title>Brussels - Asian Literary Festival</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

<script>
    window.addEventListener('scroll', function () {
        const layers = document.querySelectorAll('.parallax-layer');
        const scrollTop = window.scrollY;

        layers.forEach(layer => {
            const speed = parseFloat(layer.getAttribute('data-speed'));
            const yPos = scrollTop * speed;
            layer.style.transform = `translateY(${yPos}px)`;
        });
    });
</script>

<style>
    .parallax-layer {
        transition: transform 0.1s ease-out;
        will-change: transform;
    }
</style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>