<script>
    window.addEventListener('scroll', () => {
        const layers = document.querySelectorAll('.parallax-layer');
        const scrollY = window.scrollY;

        layers.forEach(layer => {
            const speed = layer.dataset.speed;
            layer.style.transform = `translateY(${scrollY * speed}px)`;
        });
    });
</script>

