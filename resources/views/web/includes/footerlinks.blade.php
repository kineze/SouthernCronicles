<script>
    document.addEventListener('DOMContentLoaded', () => {
        const layers = document.querySelectorAll('.parallax-layer');
        let latestScrollY = window.scrollY;
        let ticking = false;

        function updateParallax() {
            layers.forEach(layer => {
                const speed = parseFloat(layer.dataset.speed || 0.3);
                const yOffset = latestScrollY * speed;
                layer.style.transform = `translate3d(0, ${yOffset}px, 0)`;
            });
            ticking = false;
        }

        function onScroll() {
            latestScrollY = window.scrollY;
            if (!ticking) {
                requestAnimationFrame(updateParallax);
                ticking = true;
            }
        }

        window.addEventListener('scroll', onScroll, { passive: true });
    });
</script>


